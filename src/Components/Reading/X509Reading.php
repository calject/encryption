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

class X509Reading implements IReading
{
    
    /**
     * @param string $pubFilePath
     * @return string
     * @throws IoException
     */
    public function readPubFile(string $pubFilePath): string
    {
        $pubKey = FileGetContentHelper::fileFetContent($pubFilePath);
        $pubKey = chunk_split(base64_encode($pubKey), 64, "\n");
        $pubKey = rtrim($pubKey, "\n");
        return RSADeclare::declarePubKeyX509($pubKey);
    }
    
    /**
     * @param string $priFilePath
     * @return string
     * @throws IoException
     */
    public function readPriFile(string $priFilePath): string
    {
        return FileGetContentHelper::fileFetContent($priFilePath);
    }
}