<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-23
 * Annotation:
 */

namespace CalJect\Encryption\Contracts;


interface IDigest
{
    /**
     * @param string $str
     * @return string
     */
    public function digest(string $str): string;
}