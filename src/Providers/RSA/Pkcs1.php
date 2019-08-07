<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-22
 * Annotation:
 */

namespace CalJect\Encryption\Providers\RSA;


use CalJect\Encryption\Components\Reading\Pkcs1Reading;

/**
 * Class Pkcs1
 * @package CalJect\Encryption\Providers\RSA
 */
class Pkcs1 extends PkcsPem
{
    
    /**
     * init
     */
    protected function init()
    {
        $this->reading = new Pkcs1Reading();
    }
    
}