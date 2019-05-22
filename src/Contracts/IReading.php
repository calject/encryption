<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-22
 * Annotation:
 */

namespace Chanlly\Encryption\Contracts;


use Chanlly\Encryption\Exceptions\IoException;

interface IReading
{
    /**
     * @param string $pubFilePath
     * @return string
     * @throws IoException
     */
    public function readPubFile(string $pubFilePath): string;
    
    /**
     * @param string $priFilePath
     * @return string
     * @throws IoException
     */
    public function readPriFile(string $priFilePath): string;
    
}