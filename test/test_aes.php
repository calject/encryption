<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-23
 * Annotation:
 */

use Chanlly\Encryption\Constants\Openssl;
use Chanlly\Encryption\Encryption;
use Chanlly\Encryption\Factories\AesFactory;

require "../vendor/autoload.php";

/**
 * 使用其他加密模式
 * @see Openssl
 * @see openssl_get_cipher_methods()
 */

$key = 'R09w0jmo';

/* ======== coding with Base64 ======== */
// $aes = AesFactory::createAesEcb128($key);
$aes = Encryption::aesFactory()::createAes($key, Openssl::CODING_BASE64, 'AES-256-ECB');

$str = 'test aes ecb encryption, coding with base64.';
$encrypted = $aes->encrypt($str);
printf("encrypt str: " . $encrypted);
echo PHP_EOL . '</br>';
printf("decrypt str: " . $aes->decrypt($encrypted));
echo PHP_EOL . '</br>';
echo PHP_EOL . '</br>';


/* ======== coding with HexBin ======== */
$aes = Encryption::aesFactory()::createAes($key, Openssl::CODING_HEX_BIN, 'AES-256-ECB');
$str = 'test aes ecb encryption, coding with hexbin.';
$encrypted = $aes->encrypt($str);
printf("encrypt str: " . $encrypted);
echo PHP_EOL . '</br>';
printf("decrypt str: " . $aes->decrypt($encrypted));
echo PHP_EOL . '</br>';
echo PHP_EOL . '</br>';

/* ======== with padding Aes加密模式padding主要是对密钥的填充-适配其他语言(java/c等), 默认为Openssl::NO_PADDING ======== */
/* ======== 如：java中Pkcs7Padding模式的Aes需要使用Openssl::PKCS7_PADDING ======== */

/* ======== coding with Base64 ======== */
$aes = Encryption::aesFactory()::createAes($key, Openssl::PKCS7_PADDING | Openssl::CODING_BASE64, 'AES-256-ECB');
$str = 'test aes ecb encryption, coding with base64, key padding with pkcs7 padding.';
$encrypted = $aes->encrypt($str);
printf("encrypt str: " . $encrypted);
echo PHP_EOL . '</br>';
printf("decrypt str: " . $aes->decrypt($encrypted));
echo PHP_EOL . '</br>';
echo PHP_EOL . '</br>';


