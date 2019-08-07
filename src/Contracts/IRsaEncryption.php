<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-22
 * Annotation:
 */

namespace CalJect\Encryption\Contracts;


interface IRsaEncryption
{
    /**
     * @param string $str
     * @return string
     */
    public function encrypt(string $str): string;
    
    /**
     * @param string $str
     * @return string
     */
    public function decrypt(string $str): string;
    
    /**
     * @param mixed $data
     * @param mixed|null $opts
     * @return string
     */
    public function sign($data, $opts = null): string;
    
    /**
     * @param mixed $data
     * @param string $sign
     * @param mixed|null $opts
     * @return bool
     */
    public function verify($data, string $sign, $opts = null): bool ;
    
}