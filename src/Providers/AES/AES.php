<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-22
 * Annotation:
 */

namespace CalJect\Encryption\Providers\AES;

use CalJect\Encryption\Contracts\AbsAesEncryption;

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
    public function encrypt(string $str, $opts = null): string
    {
        return $this->coding()->encode(openssl_encrypt($str, $this->cipherMode, $this->padding()->padding($this->key), $opts ?? OPENSSL_RAW_DATA, $this->iv));
    }
    
    /**
     * @param string $str
     * @param mixed $opts
     * @return string
     */
    public function decrypt(string $str, $opts = null): string
    {
        return openssl_decrypt($this->coding()->decode($str), $this->cipherMode, $this->padding()->padding($this->key), $opts ?? OPENSSL_RAW_DATA, $this->iv);
    }
    
}