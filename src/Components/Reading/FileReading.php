<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-22
 * Annotation:
 */

namespace CalJect\Encryption\Components\Reading;

use CalJect\Encryption\Contracts\IReadRead;
use CalJect\Encryption\Exceptions\IoException;
use CalJect\Encryption\Helpers\FileGetContentHelper;

class FileReading implements IReadRead
{
    
    /**
     * @param string $pubFilePath
     * @return string
     * @throws IoException
     */
    public function readPubFile(string $pubFilePath): string
    {
        return FileGetContentHelper::fileFetContent($pubFilePath);
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