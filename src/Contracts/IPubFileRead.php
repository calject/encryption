<?php
/**
 * Author: 沧澜
 * Date: 2019-08-07
 */

namespace CalJect\Encryption\Contracts;


use CalJect\Encryption\Exceptions\IoException;

interface IPubFileRead
{
    /**
     * @param string $pubFilePath
     * @return string
     * @throws IoException
     */
    public function readPubFile(string $pubFilePath): string;
}