<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-22
 * Annotation:
 */

namespace CalJect\Encryption\Components\Reading;

use CalJect\Encryption\Components\RSADeclare;
use CalJect\Encryption\Contracts\IReadRead;
use CalJect\Encryption\Exceptions\IoException;
use CalJect\Encryption\Helpers\FileGetContentHelper;

class X509CerReading implements IReadRead
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