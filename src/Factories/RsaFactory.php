<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-22
 * Annotation:
 */

namespace Chanlly\Encryption\Factories;

use Chanlly\Encryption\Constants\Openssl;
use Chanlly\Encryption\Providers\RSA\Pkcs1;
use Chanlly\Encryption\Providers\RSA\PkcsPem;
use Chanlly\Encryption\Providers\RSA\PkcsPfx;
use Chanlly\Encryption\Providers\RSA\X509;

class RsaFactory
{
    /**
     * crate Pkcs1 encryption obj
     * @param string $pubPath
     * @param string $priPath
     * @param int $opts
     * @return Pkcs1
     */
    public static function createPkcs1(string $pubPath, string $priPath, int $opts = Openssl::CODING_BASE64)
    {
        return (new Pkcs1($pubPath, $priPath))->setOpts($opts);
    }
    
    /**
     * crate Pkcs8 encryption obj
     * @param string $pubPath
     * @param string $priPath
     * @param int $opts
     * @return PkcsPem
     */
    public static function createPkcs8(string $pubPath, string $priPath, int $opts = Openssl::CODING_BASE64)
    {
        return (new PkcsPem($pubPath, $priPath))->setOpts($opts);
    }
    
    /**
     * crate Pkcs12 encryption obj
     * @param string $pubPath
     * @param string $priPath
     * @param string $password
     * @param int $opts
     * @return PkcsPfx
     */
    public static function createPkcs12(string $pubPath, string $priPath, string $password, int $opts = Openssl::CODING_BASE64)
    {
        return (new PkcsPfx($pubPath, $priPath, $password))->setOpts($opts);
    }
    
    /**
     * crate X509 encryption obj
     * @param string $pubPath
     * @param string $priPath
     * @param int $opts
     * @return PkcsPem
     */
    public static function createX509(string $pubPath, string $priPath, int $opts = Openssl::CODING_BASE64)
    {
        return (new X509($pubPath, $priPath))->setOpts($opts);
    }
    
}