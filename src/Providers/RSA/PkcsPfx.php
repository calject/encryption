<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-22
 * Annotation:
 */

namespace CalJect\Encryption\Providers\RSA;

use CalJect\Encryption\Constants\Openssl;
use CalJect\Encryption\Contracts\AbsRsaEncryption;
use CalJect\Encryption\Exceptions\IoException;
use CalJect\Encryption\Exceptions\RsaException;

/**
 * Class PkcsPfx
 * 基于pkcs12标准的加解密 密钥文件一般为pfx、p12等为后缀
 * @package CalJect\Encryption\Providers\RSA
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
        $key = $this->getRsaCryptKey(self::KEY_ENCRYPT, Openssl::FILE_PKCS12);
        $encryptFunc = $this->getRsaCryptFunc(self::KEY_ENCRYPT);
        $maxlength = $this->getMaxEncryptBlockSize($key);
        $strLen = strlen($str); $encryptPos = 0; $output = ''; $encrypted = '';
        while ($encryptPos < $strLen) {
            $encryptFunc(substr($str, $encryptPos, $maxlength), $encrypted, $key);
            $output .= $this->encryptCoding()->encode($encrypted);
            $encryptPos += $maxlength;
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
        $key = $this->getRsaCryptKey(self::KEY_DECRYPT, Openssl::FILE_PKCS12);
        $decryptFunc = $this->getRsaCryptFunc(self::KEY_DECRYPT);
        $str = $this->coding()->decode($str);
        $strLen = strlen($str); $decryptPos = 0; $output = ''; $decrypted = '';
        while ($decryptPos < $strLen) {
            $decryptFunc($this->encryptCoding()->decode(substr($str, $decryptPos, 256)), $decrypted, $key);
            $output .= $decrypted;
            $decryptPos += 256;
        }
        return $output;
    }
}