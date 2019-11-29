<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-23
 * Annotation:
 */

namespace CalJect\Encryption\Components\Padding;


use CalJect\Encryption\Contracts\IDigest;

class NoDigest implements IDigest
{
    
    /**
     * @param string $str
     * @return string
     */
    public function digest(string $str): string
    {
        return $str;
    }
}