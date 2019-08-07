<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-22
 * Annotation:
 */

namespace CalJect\Encryption\Contracts;

use Exception;
use Throwable;

abstract class AbsException extends Exception
{
    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @throws static
     */
    public static function throw($message = "", $code = 0, Throwable $previous = null)
    {
        throw new static($message, $code, $previous);
    }
    
    /**
     * @param string $exceptionClass
     * @return mixed
     */
    public function convert(string $exceptionClass)
    {
        return new $exceptionClass($this->message, $this->code, $this->getPrevious());
    }
    
    /**
     * @param string $exceptionClass
     * @throws Exception
     */
    public function throwConvert(string $exceptionClass)
    {
        throw $this->convert($exceptionClass);
    }
    
}