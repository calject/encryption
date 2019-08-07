<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-22
 * Annotation:
 */

namespace CalJect\Encryption\Contracts;


use CalJect\Encryption\Components\OptMatch;
use CalJect\Encryption\Components\Reading\FileReading;
use CalJect\Encryption\Config\OpensslMap;
use CalJect\Encryption\Constants\Openssl;
use CalJect\Encryption\Exceptions\IoException;
use CalJect\Encryption\Exceptions\RsaException;
use Closure;

abstract class AbsRsaEncryption extends AbsEncryption implements IRsaEncryption
{
    /* ======== 加解密模式参数 ======== */
    /**
     * 默认模式: 公钥加密、私钥解密
     */
    const MODEL_DEFAULT = 1;
    /**
     * 反向模式: 私钥加密、公钥解密(不推荐)
     */
    const MODEL_OPPOSITE = 2;
    
    /**
     * key by encrypt
     */
    const KEY_ENCRYPT = 'encrypt';
    /**
     * key by decrypt
     */
    const KEY_DECRYPT = 'decrypt';
    
    /**
     * @var IPubFileRead
     */
    protected $pubFileRead;
    
    /**
     * @var IPriFileRead
     */
    protected $priFileRead;
    
    /**
     * pub/pri key file path
     * @var string
     */
    protected $pubFilePath, $priFilePath;
    
    /**
     * pub/pri key
     * @var resource
     */
    protected $pubKey, $priKey;
    
    /**
     * pri key file password
     * @var string
     */
    protected $priPassword;
    
    /**
     * @var IReadRead
     */
    protected $reading;
    
    /**
     * @var ICoding
     */
    protected $signCoding;
    
    /**
     * model
     * @var int
     */
    protected $mode;
    
    /***
     * AbsRsaEncryption constructor.
     * @param string $pubFilePath
     * @param string $priFilePath
     * @param string $priPassword
     */
    public function __construct(string $pubFilePath = '', string $priFilePath = '', string $priPassword = '')
    {
        $this->pubFilePath = $pubFilePath;
        $this->priFilePath = $priFilePath;
        $this->priPassword = $priPassword;
        $this->mode = self::MODEL_DEFAULT;
        $this->init();
    }
    
    /**
     * init
     * @return void
     */
    protected function init() {}
    
    /**
     * @param mixed $data
     * @param mixed|null $opts
     * @return string
     * @throws IoException
     * @throws RsaException
     */
    public function sign($data, $opts = null): string
    {
        openssl_sign($data, $sign, $this->getPriKey(), $opts ?? OPENSSL_ALGO_SHA1);
        return $this->signCoding()->encode($sign);
    }
    
    /**
     * @param mixed $data
     * @param string $sign
     * @param mixed|null $opts
     * @return bool
     * @throws IoException
     * @throws RsaException
     */
    public function verify($data, string $sign, $opts = null): bool
    {
        return (bool)openssl_verify($data, $this->signCoding()->decode($sign), $this->getPubKey(), $opts ?? OPENSSL_ALGO_SHA1);
    }
    
    /**
     * bind opt handle
     * @param int $opts
     * @return $this
     */
    public function setOpts(int $opts)
    {
        return $this->optsHandle($opts, function(OptMatch $optMatch) {
            $optMatch->binds(OpensslMap::LISTS[OpensslMap::OPT_PUB_FILE_READ], function (int $mode) {
                $this->pubFileRead = OpensslMap::FILE_READ_CONTACTS[$mode] ?? FileReading::class;
            })->binds(OpensslMap::LISTS[OpensslMap::OPT_PRI_FILE_READ], function (int $mode) {
                $this->priFileRead = OpensslMap::FILE_READ_CONTACTS[$mode] ?? FileReading::class;
            });
        });
    }
    
    /*---------------------------------------------- protected handle ----------------------------------------------*/
    
    /**
     * get is model opposite
     * @return bool
     */
    final protected function isModelOpposite(): bool
    {
        return $this->mode === self::MODEL_OPPOSITE;
    }
    
    /**
     * @param string $key self::KEY_ENCRYPT or self::KEY_DECRYPT
     * @param string $opt
     * @return resource
     * @throws IoException
     * @throws RsaException
     */
    protected function getRsaCryptKey(string $key, $opt = Openssl::FILE_KEY)
    {
        if ($key === self::KEY_ENCRYPT) {
            return $this->isModelOpposite() ? $this->getPriKey($opt) : $this->getPubKey($opt);
        } else {
            return $this->isModelOpposite() ? $this->getPubKey($opt) : $this->getPriKey($opt);
        }
    }
    
    /**
     * @param string $key self::KEY_ENCRYPT or self::KEY_DECRYPT
     * @return string
     */
    final protected function getRsaCryptFunc(string $key): string
    {
        if ($key === self::KEY_ENCRYPT) {
            return $this->isModelOpposite() ? 'openssl_private_encrypt' : 'openssl_public_encrypt';
        } else {
            return $this->isModelOpposite() ? 'openssl_public_decrypt' : 'openssl_private_decrypt';
        }
    }
    
    /*---------------------------------------------- protected get ----------------------------------------------*/
    
    /**
     * @return IReadRead
     */
    final protected function reading(): IReadRead
    {
        if (!$this->reading) {
            $this->reading = new FileReading();
        }
        return $this->reading;
    }
    
    /**
     * @return IPubFileRead
     */
    protected function pubFileRead(): IPubFileRead
    {
        if (is_object($this->pubFileRead)) {
            return $this->pubFileRead;
        } else if (isset($this->pubFileRead) && class_exists($this->pubFileRead)) {
            return $this->pubFileRead = new $this->pubFileRead;
        } else {
            return $this->reading();
        }
    }
    
    /**
     * @return IPriFileRead
     */
    protected function priFileRead(): IPriFileRead
    {
        if (is_object($this->priFileRead)) {
            return $this->priFileRead;
        } else if (isset($this->priFileRead) && class_exists($this->priFileRead)) {
            return $this->priFileRead = new $this->priFileRead;
        } else {
            return $this->reading();
        }
    }
    
    /**
     * @return ICoding
     */
    final protected function signCoding(): ICoding
    {
        if (!$this->signCoding) {
            $this->signCoding = $this->coding();
        }
        return $this->signCoding;
    }
    
    /**
     * get the pub key in file
     * @param string $type
     * @param Closure|null $getKey function($pubContent) {}
     * @return resource
     * @throws IoException
     * @throws RsaException
     */
    final protected function getPubKey($type = Openssl::FILE_KEY, Closure $getKey = null)
    {
        if (!$pubKey = &$this->pubKey) {
            $pubContent = $this->pubFileRead()->readPubFile($this->pubFilePath);
            if ($type == Openssl::FILE_PKEY) {
                $pubKey = openssl_pkey_get_public($pubContent);
            } else {
                $getKey && $resGetKey = call_user_func($getKey, $pubContent);
                $pubKey = $resGetKey ?? openssl_get_publickey($pubContent);
            }
        }
        $pubKey || RsaException::throw("get public key error.");
        return $pubKey;
    }
    
    /**
     * get the pri key in file
     * @param string $type
     * @param Closure|null $getKey function($priContent) {}
     * @return resource
     * @throws IoException
     * @throws RsaException
     */
    final protected function getPriKey($type = Openssl::FILE_KEY, Closure $getKey = null)
    {
        if (!$priKey = &$this->priKey) {
            $priContent = $this->priFileRead()->readPriFile($this->priFilePath);
            if ($type == Openssl::FILE_PKEY) {
                $priKey = openssl_pkey_get_private($priContent);
            } else if ($type == Openssl::FILE_PKCS12) {
                $priKeys = [];
                openssl_pkcs12_read($priContent, $priKeys, $this->priPassword);
                if (isset($priKeys) && isset($priKeys["pkey"])) {
                    $pKey = $priKeys["pkey"];
                    $getKey && $resGetKey = call_user_func($getKey, $pKey);
                    $priKey = $resGetKey ?? openssl_get_privatekey($pKey);
                }
            } else {
                $getKey && $resGetKey = call_user_func($getKey, $priContent);
                $priKey = $resGetKey ?? openssl_get_privatekey($priContent);
            }
        }
        $priKey || RsaException::throw("get private key error.");
        return $priKey;
    }
    
    /**
     * 根据key的内容获取最大加密lock的大小，兼容各种长度的rsa keysize（比如1024,2048）
     * 对于1024长度的RSA Key，返回值为117
     * @param resource $keyRes
     * @return float
     */
    final protected function getMaxEncryptBlockSize($keyRes)
    {
        $keyDetail = openssl_pkey_get_details($keyRes);
        return $keyDetail['bits'] / 8 - 11;
    }
    
    /**
     * 根据key的内容获取最大解密block的大小，兼容各种长度的rsa keysize（比如1024,2048）
     * 对于1024长度的RSA Key，返回值为128
     * @param resource $keyRes
     * @return float
     */
    final protected function getMaxDecryptBlockSize($keyRes)
    {
        $keyDetail = openssl_pkey_get_details($keyRes);
        return $keyDetail['bits'] / 8;
    }
    
    /*---------------------------------------------- set ----------------------------------------------*/
    
    /**
     * @param int $mode self::MODEL_DEFAULT or self::MODEL_OPPOSITE
     * @return $this
     */
    public function setMode(int $mode)
    {
        $this->mode = $mode;
        return $this;
    }
    
    /**
     * @param ICoding $signCoding
     * @return $this
     */
    public function setSignCoding(ICoding $signCoding)
    {
        $this->signCoding = $signCoding;
        return $this;
    }
    
    /**
     * @param string $pubFilePath
     * @return $this
     */
    public function setPubFilePath(string $pubFilePath)
    {
        $this->pubFilePath = $pubFilePath;
        return $this;
    }
    
    /**
     * @param string $priFilePath
     * @return $this
     */
    public function setPriFilePath(string $priFilePath)
    {
        $this->priFilePath = $priFilePath;
        return $this;
    }
    
    /**
     * @param string $priPassword
     * @return $this
     */
    public function setPriPassword(string $priPassword)
    {
        $this->priPassword = $priPassword;
        return $this;
    }
    
    /**
     * __destruct to free
     */
    public function __destruct()
    {
        is_resource($this->pubKey) && openssl_free_key($this->pubKey);
        is_resource($this->priKey) && openssl_free_key($this->priKey);
    }
    
    
}