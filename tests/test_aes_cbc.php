<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-23
 * Annotation:
 */

use CalJect\Encryption\Constants\Openssl;
use CalJect\Encryption\Encryption;
use CalJect\Encryption\Factories\AesFactory;

require "../vendor/autoload.php";

$key = 'R09w0jmo';
$iv = '1234567890123456';

/* ======== coding with Base64 ======== */
// $aes = AesFactory::createAesCbc128($key, $iv);
// $aes = Encryption::$aes::createAesCbc128($key, $iv);
$aes = Encryption::aesFactory()::createAesCbc128($key, $iv);
$str = 'test aes cbc encryption, coding with base64.';
$encrypted = $aes->encrypt($str);
printf("encrypt str: " . $encrypted);
echo PHP_EOL . '</br>';
printf("decrypt str: " . $aes->decrypt($encrypted));
echo PHP_EOL . '</br>';
echo PHP_EOL . '</br>';


/* ======== coding with HexBin ======== */
$aes = Encryption::aesFactory()::createAesCbc128($key, $iv, Openssl::CODING_HEX_BIN);
$str = 'test aes cbc encryption, coding with hexbin.';
$encrypted = $aes->encrypt($str);
printf("encrypt str: " . $encrypted);
echo PHP_EOL . '</br>';
printf("decrypt str: " . $aes->decrypt($encrypted));
echo PHP_EOL . '</br>';
echo PHP_EOL . '</br>';


/* ======== with padding Aes加密模式padding主要是对密钥的填充-适配其他语言(java/c等), 默认为Openssl::NO_PADDING ======== */
/* ======== 如：java中Pkcs7Padding模式的Aes需要使用Openssl::PKCS7_PADDING ======== */

/* ======== coding with Base64 ======== */
Encryption::aesFactory()::createAesCbc128($key, $iv, Openssl::PKCS7_PADDING | Openssl::CODING_BASE64);
$str = 'test aes cbc encryption, coding with base64, key padding with pkcs7 padding.';
$encrypted = $aes->encrypt($str);
printf("encrypt str: " . $encrypted);
echo PHP_EOL . '</br>';
printf("decrypt str: " . $aes->decrypt($encrypted));
echo PHP_EOL . '</br>';
echo PHP_EOL . '</br>';

