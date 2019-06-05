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
     * @var RsaFactory|string
     */
    public static $rsa = RsaFactory::class;
    
    /**
     * @var AesFactory|string
     */
    public static $aes = AesFactory::class;
    
    /**
     * @var AesHmacFactory|string
     */
    public static $aesHmac = AesHmacFactory::class;
    
    /**
     * @return RsaFactory|string
     */
    public static function rsaFactory()
    {
        return static::$rsa;
    }
    
    /**
     * @return AesFactory|string
     */
    public static function aesFactory()
    {
        return static::$aes;
    }
    
    /**
     * @return AesHmacFactory|string
     */
    public static function aesHmacFactory()
    {
        return static::$aesHmac;
    }
    
}