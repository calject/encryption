<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-29
 * Annotation:
 */

namespace Chanlly\Encryption\Helpers;


use Exception;

class AESEncryptHelper
{
    
    /**
     * @param $cipher
     * @return bool
     */
    public static function isAesCbc128($cipher)
    {
        return in_array($cipher, ['AES-128-CBC', 'AES-128-CBC-HMAC-SHA1', 'AES-128-CBC-HMAC-SHA256'], true);
    }
    
    /**
     * @param $cipher
     * @return bool
     */
    public static function isAesCbc256($cipher)
    {
        return in_array($cipher, ['AES-256-CBC', 'AES-256-CBC-HMAC-SHA1', 'AES-256-CBC-HMAC-SHA256'], true);
    }
    
    
    /**
     * Determine if the given key and cipher combination is valid.
     *
     * @param  string  $key
     * @param  string  $cipher
     * @return bool
     */
    public static function supported($key, $cipher)
    {
        $length = mb_strlen($key, '8bit');
        
        return (static::isAesCbc128($cipher) && $length === 16) ||
            (static::isAesCbc256($cipher) && $length === 32);
    }
    
    /**
     * Create a new encryption key for the given cipher.
     * @param string $cipher
     * @return string
     * @throws Exception
     */
    public static function generateKey($cipher)
    {
        return random_bytes(self::isAesCbc128($cipher) ? 16 : 32);
    }
}