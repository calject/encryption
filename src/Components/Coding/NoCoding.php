<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-22
 * Annotation:
 */

namespace Chanlly\Encryption\Components\Coding;


use Chanlly\Encryption\Contracts\ICoding;

class NoCoding implements ICoding
{
    
    /**
     * @param string $str
     * @return string
     */
    public function encode(string $str): string
    {
        return $str;
    }
    
    /**
     * @param string $str
     * @return string
     */
    public function decode(string $str): string
    {
        return $str;
    }
}