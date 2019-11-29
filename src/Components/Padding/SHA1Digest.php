<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-23
 * Annotation:
 */

namespace CalJect\Encryption\Components\Padding;


use CalJect\Encryption\Contracts\IDigest;

class SHA1Digest implements IDigest
{
    
    /**
     * @param string $str
     * @return string
     */
    public function digest(string $str): string
    {
        return substr(openssl_digest(openssl_digest($str, 'sha1', true), 'sha1', true), 0, 16);
    }
}