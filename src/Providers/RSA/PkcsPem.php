<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-22
 * Annotation:
 */

namespace Chanlly\Encryption\Providers\RSA;

use Chanlly\Encryption\Contracts\AbsRsaEncryption;
use Chanlly\Encryption\Exceptions\IoException;
use Chanlly\Encryption\Exceptions\RsaException;

/**
 * Class PkcsPem
 * 基于pkcs1/8标准的加解密 密钥文件一般为pem、cer等为后缀
 * @package Chanlly\Encryption\Providers\RSA
 */
class PkcsPem extends AbsRsaEncryption
{
    
    /**
     * @param string $str
     * @return string
     * @throws IoException
     * @throws RsaException
     */
    public function encrypt(string $str): string
    {
        $key = $this->getRsaCryptKey(self::KEY_ENCRYPT);
        $encryptFunc = $this->getRsaCryptFunc(self::KEY_ENCRYPT);
        $maxlength = $this->getMaxEncryptBlockSize($key);
        $output = ''; $encrypted = '';
        while ($str) {
            $str = substr($str, $maxlength);
            $encryptFunc(substr($str, 0, $maxlength), $encrypted, $key);
            $output .= $encrypted;
        }
        return $this->coding()->encode($output);
    }
    
    /**
     * @param string $str
     * @return string
     * @throws IoException
     * @throws RsaException
     */
    public function decrypt(string $str): string
    {
        $key = $this->getRsaCryptKey(self::KEY_DECRYPT);
        $decryptFunc = $this->getRsaCryptFunc(self::KEY_DECRYPT);
        $maxlength = $this->getMaxDecryptBlockSize($key);
        $str = $this->coding()->decode($str);
        $output = ''; $decrypted = '';
        while ($str) {
            $str = substr($str, $maxlength);
            $decryptFunc(substr($str, 0, $maxlength), $decrypted, $key);
            $output .= $decrypted;
        }
        return $output;
    }
    
}