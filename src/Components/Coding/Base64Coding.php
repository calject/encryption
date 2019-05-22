<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-22
 * Annotation:
 */

namespace Chanlly\Encryption\Components\Coding;


use Chanlly\Encryption\Contracts\ICoding;

class Base64Coding implements ICoding
{
    /**
     * @param string $str
     * @return string
     */
    public function encode(string $str): string
    {
        return base64_encode($str);
    }
    
    /**
     * @param string $str
     * @return string
     */
    public function decode(string $str): string
    {
        return base64_decode($str);
    }
}