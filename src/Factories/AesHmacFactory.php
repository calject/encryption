<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-06-05
 * Annotation:
 */

namespace CalJect\Encryption\Factories;

use CalJect\Encryption\Contracts\AbsAesFactory;
use CalJect\Encryption\Providers\AES\AES_HMAC;

class AesHmacFactory extends AbsAesFactory
{
    
    /**
     * create the aes object in AES_HMAC
     * @param string $key
     * @param int $opts
     * @param string $cipherMode
     * @param string $iv
     * @return AES_HMAC
     */
    final public static function createAes(string $key, int $opts, string $cipherMode, string $iv = "")
    {
        return new AES_HMAC($key, $opts, $cipherMode, $iv);
    }
    
}