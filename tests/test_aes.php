<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-23
 * Annotation:
 */

use CalJect\Encryption\Constants\Openssl;
use CalJect\Encryption\Encryption;

require "../vendor/autoload.php";

/**
 * 使用其他加密模式
 * @see Openssl
 * @see openssl_get_cipher_methods()
 */

$key = 'R09w0jmo';

/* ======== coding with Base64 ======== */
// $aes = AesFactory::createAesEcb128($key);
// $aes = Encryption::$aes::createAes($key, Openssl::CODING_BASE64, 'AES-256-ECB');
$aes = Encryption::aesFactory()::createAes($key, Openssl::CODING_BASE64, 'AES-256-ECB');

$str = 'test aes ecb encryption, coding with base64.';
$encrypted = $aes->encrypt($str);
printf("encrypt str: " . $encrypted);
echo PHP_EOL . '</br>';
printf("decrypt str: " . $aes->decrypt($encrypted));
echo PHP_EOL . '</br>';
echo PHP_EOL . '</br>';


/* ======== coding with HexBin ======== */
// $aes = AesFactory::createAes($key, Openssl::CODING_HEX_BIN, 'AES-256-ECB');
// $aes = Encryption::$aes::createAes($key, Openssl::CODING_HEX_BIN, 'AES-256-ECB');
$aes = Encryption::aesFactory()::createAes($key, Openssl::CODING_HEX_BIN, 'AES-256-ECB');
$str = 'test aes ecb encryption, coding with hexbin.';
$encrypted = $aes->encrypt($str);
printf("encrypt str: " . $encrypted);
echo PHP_EOL . '</br>';
printf("decrypt str: " . $aes->decrypt($encrypted));
echo PHP_EOL . '</br>';
echo PHP_EOL . '</br>';

/* ======== coding with Base64 ======== */
$aes = Encryption::aesFactory()::createAes($key, Openssl::SHA1_DIGEST | Openssl::CODING_BASE64, 'AES-256-ECB');
$str = 'test aes ecb encryption, coding with base64, key digest with sha1.';
$encrypted = $aes->encrypt($str);
printf("encrypt str: " . $encrypted);
echo PHP_EOL . '</br>';
printf("decrypt str: " . $aes->decrypt($encrypted));
echo PHP_EOL . '</br>';
echo PHP_EOL . '</br>';


