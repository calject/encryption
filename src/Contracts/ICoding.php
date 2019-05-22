<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-22
 * Annotation:
 */

namespace Chanlly\Encryption\Contracts;


interface ICoding
{
    /**
     * @param string $str
     * @return string
     */
    public function encode(string $str): string;
    
    /**
     * @param string $str
     * @return string
     */
    public function decode(string $str): string;
    
    
}