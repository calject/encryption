<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-22
 * Annotation:
 */

namespace Chanlly\Encryption\Contracts;


use Chanlly\Encryption\Components\Reading\FileReading;
use Chanlly\Encryption\Constants\Constant;
use Chanlly\Encryption\Exceptions\IoException;
use Chanlly\Encryption\Exceptions\RsaException;
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
     * @var IReading
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
     * @throws AbsException
     * @throws IoException
     */
    public function sign($data, $opts = OPENSSL_ALGO_SHA1): string
    {
        return $this->signCoding()->encode(openssl_sign($data, $sign, $this->getPriKey(), $opts));
    }
    
    /**
     * @param mixed $data
     * @param string $sign
     * @param mixed|null $opts
     * @return bool
     * @throws IoException
     * @throws RsaException
     */
    public function verify($data, string $sign, $opts = OPENSSL_ALGO_SHA1): bool
    {
        return (bool)openssl_verify($data, $this->signCoding()->decode($sign), $this->getPubKey(), $opts);
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
    protected function getRsaCryptKey(string $key, $opt = Constant::FILE_KEY)
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
            return $this->isModelOpposite() ? 'openssl_public_encrypt' : 'openssl_private_encrypt';
        } else {
            return $this->isModelOpposite() ? 'openssl_private_decrypt' : 'openssl_public_decrypt';
        }
    }
    
    
    
    /*---------------------------------------------- protected get ----------------------------------------------*/
    
    /**
     * @return IReading
     */
    final protected function reading(): IReading
    {
        if (!$this->reading) {
            $this->reading = new FileReading();
        }
        return $this->reading;
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
    final protected function getPubKey($type = Constant::FILE_KEY, Closure $getKey = null): string
    {
        if (!$pubKey = &$this->pubKey) {
            $pubContent = $this->reading()->readPubFile($this->pubFilePath);
            if ($type == Constant::FILE_PKEY) {
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
    final protected function getPriKey($type = Constant::FILE_KEY, Closure $getKey = null)
    {
        if (!$priKey = &$this->priKey) {
            $priContent = $this->reading()->readPriFile($this->pubFilePath);
            if ($type == Constant::FILE_PKEY) {
                $priKey = openssl_pkey_get_private($priContent);
            } else if ($type == Constant::FILE_PKCS12) {
                $priKeys = [];
                openssl_pkcs12_read($priContent, $priKeys, $this->priPassword);
                if (isset($priKeys) && isset($priKeys["pkey"])) {
                    $priKey = $priKeys["pkey"];
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
        openssl_free_key($this->pubKey);
        openssl_free_key($this->priKey);
    }
    
    
}