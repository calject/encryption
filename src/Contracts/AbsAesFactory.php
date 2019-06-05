<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-06-05
 * Annotation:
 */

namespace Chanlly\Encryption\Contracts;

use Chanlly\Encryption\Constants\Openssl;

abstract class AbsAesFactory
{
    
    /**
     * @param string $key
     * @param int $opts
     * @param string $cipherMode
     * @param string $iv
     * @return mixed
     */
    abstract public static function createAes(string $key, int $opts, string $cipherMode, string $iv = "");
    
    /**
     * @param string $key
     * @param string $iv
     * @param int $opts
     * @return mixed
     */
    final public static function createAesCbc128(string $key, string $iv, int $opts = Openssl::CODING_BASE64)
    {
        return static::createAes($key, $opts, Openssl::AES_MODE_CBC_128, $iv);
    }
    
    /**
     * @param string $key
     * @param string $iv
     * @param int $opts
     * @return mixed
     */
    final public static function createAesCbc256(string $key, string $iv, int $opts = Openssl::CODING_BASE64)
    {
        return static::createAes($key, $opts, Openssl::AES_MODE_CBC_256, $iv);
    }
    
    
}