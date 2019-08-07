<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-22
 * Annotation:
 */

namespace CalJect\Encryption\Factories;


use CalJect\Encryption\Constants\Openssl;
use CalJect\Encryption\Contracts\AbsAesFactory;
use CalJect\Encryption\Providers\AES\AES;

class AesFactory extends AbsAesFactory
{
    
    /**
     * create the aes object in AES_HMAC
     * @param string $key
     * @param int $opts
     * @param string $cipherMode
     * @param string $iv
     * @return AES
     */
    public static function createAes(string $key, int $opts, string $cipherMode, string $iv = "")
    {
        return new AES($key, $opts, $cipherMode, $iv);
    }
    
    /**
     * @param string $key
     * @param int $opts
     * @return AES
     */
    final public static function createAesEcb128(string $key, int $opts = Openssl::CODING_BASE64)
    {
        return static::createAes($key, $opts, Openssl::AES_MODE_ECB_128);
    }
    
    /**
     * @param $key
     * @param int $opts
     * @return AES
     */
    final public static function createAesEcb256(string $key, int $opts = Openssl::CODING_BASE64)
    {
        return static::createAes($key, $opts, Openssl::AES_MODE_ECB_256);
    }
    
}