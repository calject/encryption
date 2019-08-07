<?php
/**
 * Author: 沧澜
 * Date: 2019-08-07
 */

namespace CalJect\Encryption\Contracts;


use CalJect\Encryption\Exceptions\IoException;

interface IPriFileRead
{
    /**
     * @param string $priFilePath
     * @return string
     * @throws IoException
     */
    public function readPriFile(string $priFilePath): string;
}