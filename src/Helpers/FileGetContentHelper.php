<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-22
 * Annotation:
 */

namespace Chanlly\Encryption\Helpers;

use Chanlly\Encryption\Exceptions\IoException;
use Closure;

class FileGetContentHelper
{
    /**
     * @param string $filePath
     * @param bool $isThrowException
     * @param Closure|null $error
     * @return string
     * @throws IoException
     */
    public static function fileFetContent(string $filePath, bool $isThrowException = true, Closure $error = null): string
    {
        if (!file_exists($filePath)) {
            $error && $res = call_user_func($error, $filePath);
            $isThrowException && IoException::throw("the $filePath file does not exist.");
            return $res ?? false;
        } else {
            return file_get_contents($filePath);
        }
    }
    
}