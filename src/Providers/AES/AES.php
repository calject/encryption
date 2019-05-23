<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-22
 * Annotation:
 */

namespace Chanlly\Encryption\Providers\AES;

use Chanlly\Encryption\Contracts\AbsAesEncryption;

class AES extends AbsAesEncryption
{
    /**
     * init
     */
    protected function init() {}
    
    /**
     * @param string $str
     * @param mixed $opts
     * @return string
     */
    public function encrypt(string $str, $opts = OPENSSL_RAW_DATA): string
    {
        return $this->coding()->encode(openssl_encrypt($str, $this->cipherMode, $this->padding()->padding($this->key), $opts, $this->iv));
    }
    
    /**
     * @param string $str
     * @param mixed $opts
     * @return string
     */
    public function decrypt(string $str, $opts = OPENSSL_RAW_DATA): string
    {
        return openssl_decrypt($this->coding()->decode($str), $this->cipherMode, $this->padding()->padding($this->key), $opts, $this->iv);
    }
    
}