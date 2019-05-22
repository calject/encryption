<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-22
 * Annotation:
 */

namespace Chanlly\Encryption\Contracts;


interface IAesEncryption
{
    /**
     * @param string $str
     * @param mixed|null $opts
     * @return string
     */
    public function encrypt(string $str, $opts = null): string;
    
    /**
     * @param string $str
     * @param mixed|null $opts
     * @return string
     */
    public function decrypt(string $str, $opts = null): string;
    
}