<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-22
 * Annotation:
 */

namespace Chanlly\Encryption\Providers\RSA;

use Chanlly\Encryption\Components\Reading\X509Reading;
use Chanlly\Encryption\Constants\Openssl;
use Chanlly\Encryption\Exceptions\IoException;
use Chanlly\Encryption\Exceptions\RsaException;

class X509 extends PkcsPem
{
    
    /**
     * init
     */
    protected function init()
    {
        // change reading with X509Reading
        $this->reading = new X509Reading();
    }
    
    /**
     * rewrite getCryptKey function
     * @param string $key self::KEY_ENCRYPT or self::KEY_DECRYPT
     * @param string $opt
     * @return resource
     * @throws IoException
     * @throws RsaException
     */
    protected function getRsaCryptKey(string $key, $opt = Openssl::FILE_KEY)
    {
        if ($key === self::KEY_ENCRYPT) {
            return $this->isModelOpposite() ? $this->getPriKey($opt) : $this->getPubKey(Openssl::FILE_PKEY);
        } else {
            return $this->isModelOpposite() ? $this->getPubKey(Openssl::FILE_PKEY) : $this->getPriKey($opt);
        }
    }
    
}