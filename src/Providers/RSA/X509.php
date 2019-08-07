<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-22
 * Annotation:
 */

namespace CalJect\Encryption\Providers\RSA;

use CalJect\Encryption\Components\Reading\X509CerReading;
use CalJect\Encryption\Constants\Openssl;
use CalJect\Encryption\Exceptions\IoException;
use CalJect\Encryption\Exceptions\RsaException;

/**
 * Class X509
 * X509格式密钥读取，一般为公钥为该格式(由对方提供)，私钥可用自生成的pcks8(pem/cer)格式
 * @package CalJect\Encryption\Providers\RSA
 */
class X509 extends PkcsPem
{
    
    /**
     * init
     */
    protected function init()
    {
        $this->reading = new X509CerReading();
    }
    
    /**
     * rewrite getCryptKey function
     * @param string $key self::KEY_ENCRYPT or self::KEY_DECRYPT
     * @param string $opt
     * @return resource
     * @throws IoException
     * @throws RsaException
     */
    protected function getRsaCryptKey(string $key, $opt = Openssl::FILE_KEY)
    {
        if ($key === self::KEY_ENCRYPT) {
            return $this->isModelOpposite() ? $this->getPriKey($opt) : $this->getPubKey(Openssl::FILE_KEY);
        } else {
            return $this->isModelOpposite() ? $this->getPubKey(Openssl::FILE_KEY) : $this->getPriKey($opt);
        }
    }
    
}