<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-22
 * Annotation:
 */

namespace Chanlly\Encryption\Providers\RSA;


use Chanlly\Encryption\Components\Reading\Pkcs1Reading;

class Pkcs1 extends PkcsPem
{
    
    /**
     * init
     */
    protected function init()
    {
        // change reading with Pkcs1Reading
        $this->reading = new Pkcs1Reading();
    }
    
    
}