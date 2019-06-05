<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-22
 * Annotation:
 */

namespace Chanlly\Encryption;

use Chanlly\Encryption\Factories\AesFactory;
use Chanlly\Encryption\Factories\AesHmacFactory;
use Chanlly\Encryption\Factories\RsaFactory;

class Encryption
{
    /**
     * @return RsaFactory|string
     */
    public static function rsaFactory()
    {
        return RsaFactory::class;
    }
    
    /**
     * @return AesFactory|string
     */
    public static function aesFactory()
    {
        return AesFactory::class;
    }
    
    /**
     * @return AesHmacFactory|string
     */
    public static function aesHmacFactory()
    {
        return AesHmacFactory::class;
    }
    
}