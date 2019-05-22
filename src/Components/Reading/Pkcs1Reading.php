<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-22
 * Annotation:
 */

namespace Chanlly\Encryption\Components\Reading;


use Chanlly\Encryption\Components\RSADeclare;
use Chanlly\Encryption\Contracts\IReading;
use Chanlly\Encryption\Exceptions\IoException;
use Chanlly\Encryption\Helpers\FileGetContentHelper;

class Pkcs1Reading implements IReading
{
    
    /**
     * @param string $pubFilePath
     * @return string
     * @throws IoException
     */
    public function readPubFile(string $pubFilePath): string
    {
        return RSADeclare::declarePubKeyPkcs1(FileGetContentHelper::fileFetContent($pubFilePath));
    }
    
    /**
     * @param string $priFilePath
     * @return string
     * @throws IoException
     */
    public function readPriFile(string $priFilePath): string
    {
        return RSADeclare::declarePriKeyPkcs1(FileGetContentHelper::fileFetContent($priFilePath));
    }
}