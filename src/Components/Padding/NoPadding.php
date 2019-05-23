<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-23
 * Annotation:
 */

namespace Chanlly\Encryption\Components\Padding;


use Chanlly\Encryption\Contracts\IPadding;

class NoPadding implements IPadding
{
    
    /**
     * @param string $str
     * @return string
     */
    public function padding(string $str): string
    {
        return $str;
    }
}