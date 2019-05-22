<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-22
 * Annotation:
 */

namespace Chanlly\Encryption\Components;


class RSADeclare
{
    
    /*------------------- PKCS#1 密钥声明 -------------------*/
    const RSA_PRI_HEAD_PKCS1 = '-----BEGIN RSA PRIVATE KEY-----';
    const RSA_PRI_FOOT_PKCS1 = '-----END RSA PRIVATE KEY-----';
    
    const RSA_PUB_HEAD_PKCS1 = '-----BEGIN RSA PUBLIC KEY-----';
    const RSA_PUB_FOOT_PKCS1 = '-----END RSA PUBLIC KEY-----';
    
    /*------------------- PKCS#8 密钥声明 -------------------*/
    const RSA_PRI_HEAD_PKCS8 = '-----BEGIN PRIVATE KEY-----';
    const RSA_PRI_FOOT_PKCS8 = '-----END PRIVATE KEY-----';
    
    const RSA_PUB_HEAD_PKCS8 = '-----BEGIN PUBLIC KEY-----';
    const RSA_PUB_FOOT_PKCS8 = '-----END PUBLIC KEY-----';
    
    /*------------------- X509 密钥公钥声明 -------------------*/
    const RSA_PUB_HEAD_X509 = '-----BEGIN CERTIFICATE-----';
    const RSA_PUB_FOOT_X509 = '-----END CERTIFICATE-----';
    
    
    const EOL = "\n";
    
    /**
     * @param string $key
     * @param string $head
     * @param string $foot
     * @return string
     */
    public static function declareRSA(string $key, string $head, string $foot): string
    {
        return $head . self::EOL . $key . self::EOL . $foot;
    }
    
    /**
     * @param string $key
     * @return string
     */
    public static function declarePriKeyPkcs1(string $key): string
    {
        return self::declareRSA($key, self::RSA_PRI_HEAD_PKCS1, self::RSA_PRI_FOOT_PKCS1);
    }
    
    /**
     * @param string $key
     * @return string
     */
    public static function declarePubKeyPkcs1(string $key): string
    {
        return self::declareRSA($key, self::RSA_PUB_HEAD_PKCS1, self::RSA_PUB_FOOT_PKCS1);
    }
    
    /**
     * @param string $key
     * @return string
     */
    public static function declarePriKeyPkcs8(string $key): string
    {
        return self::declareRSA($key, self::RSA_PRI_HEAD_PKCS8, self::RSA_PRI_FOOT_PKCS8);
    }
    
    /**
     * @param string $key
     * @return string
     */
    public static function declarePubKeyPkcs8(string $key): string
    {
        return self::declareRSA($key, self::RSA_PUB_HEAD_PKCS8, self::RSA_PUB_FOOT_PKCS8);
    }
    
    /**
     * @param string $key
     * @return string
     */
    public static function declarePubKeyX509(string $key): string
    {
        return self::declareRSA($key, self::RSA_PUB_HEAD_X509, self::RSA_PUB_FOOT_X509);
    }
    
}