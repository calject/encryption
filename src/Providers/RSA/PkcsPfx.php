<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-22
 * Annotation:
 */

namespace Chanlly\Encryption\Providers\RSA;

use Chanlly\Encryption\Constants\Constant;
use Chanlly\Encryption\Contracts\AbsRsaEncryption;
use Chanlly\Encryption\Exceptions\IoException;
use Chanlly\Encryption\Exceptions\RsaException;

/**
 * Class PkcsPfx
 * 基于pkcs12标准的加解密 密钥文件一般为pfx、p12等为后缀
 * @package Chanlly\Encryption\Providers\RSA
 */
class PkcsPfx extends AbsRsaEncryption
{
    
    /**
     * @param string $str
     * @return string
     * @throws IoException
     * @throws RsaException
     */
    public function encrypt(string $str): string
    {
        $key = $this->getRsaCryptKey(self::KEY_ENCRYPT, Constant::FILE_PKCS12);
        $encryptFunc = $this->getRsaCryptFunc(self::KEY_ENCRYPT);
        $maxlength = $this->getMaxEncryptBlockSize($key);
        $str = $this->coding()->encode($str);
        $strLen = strlen($str); $encryptPos = 0; $output = ''; $encrypted = '';
        while ($encryptPos < $strLen) {
            $encryptFunc(substr($str, $encryptPos, $maxlength), $encrypted, $this->getPubKey());
            $output .= bin2hex($encrypted);
            $encryptPos += $maxlength;
        }
        return $output;
    }
    
    /**
     * @param string $str
     * @return string
     * @throws IoException
     * @throws RsaException
     */
    public function decrypt(string $str): string
    {
        $key = $this->getRsaCryptKey(self::KEY_DECRYPT, Constant::FILE_PKCS12);
        $decryptFunc = $this->getRsaCryptFunc(self::KEY_DECRYPT);
        $maxlength = $this->getMaxDecryptBlockSize($key);
        $strLen = strlen($str); $decryptPos = 0; $output = ''; $decrypted = '';
        while ($decryptPos < $strLen) {
            $decryptFunc(hex2bin(substr($str, $decryptPos, $maxlength)), $decrypted, $this->getPriKey());
            $output .= $decrypted;
            $decryptPos += $maxlength;
        }
        return $this->coding()->decode($output);
    }
}