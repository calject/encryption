<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-22
 * Annotation:
 */

namespace Chanlly\Encryption\Providers\AES;


use Chanlly\Encryption\Contracts\AbsEncryption;
use Chanlly\Encryption\Contracts\IAesEncryption;

class AES_ECB extends AbsEncryption implements IAesEncryption
{
    /**
     * encrypt key
     * @var string
     */
    private $key;
    
    /**
     * AES constructor.
     * @param string $key
     * @param int $codingMode
     */
    public function __construct(string $key, int $codingMode = self::CODING_BASE64)
    {
        $this->key = $key;
        $this->codingMode = $codingMode;
        $this->init();
    }
    
    /**
     * init
     */
    protected function init() {}
    
    /**
     * @param string $str
     * @param mixed $opts
     * @return string
     */
    public function encrypt(string $str, $opts = null): string
    {
        return $this->coding()->encode(
            openssl_encrypt($str, 'AES-128-ECB', $this->key, $opts ?? OPENSSL_RAW_DATA)
        );
    }
    
    /**
     * @param string $str
     * @param mixed $opts
     * @return string
     */
    public function decrypt(string $str, $opts = null): string
    {
        return openssl_decrypt($this->coding()->decode($str), 'AES-128-ECB', $this->key, $opts ?? OPENSSL_RAW_DATA);
    }
    
    /*---------------------------------------------- set ----------------------------------------------*/
    
    /**
     * @param string $key
     * @return $this
     */
    public function setKey(string $key)
    {
        $this->key = $key;
        return $this;
    }
    
}