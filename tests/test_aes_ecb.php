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

/* ======== coding with Base64 ======== */
// $aes = AesFactory::createAesEcb128($key);
// $aes = Encryption::$aes::createAesEcb128($key);
$aes = Encryption::aesFactory()::createAesEcb128($key);
$str = 'test aes ecb encryption, coding with base64.';
$encrypted = $aes->encrypt($str);
printf("encrypt str: " . $encrypted);
echo PHP_EOL . '</br>';
printf("decrypt str: " . $aes->decrypt($encrypted));
echo PHP_EOL . '</br>';
echo PHP_EOL . '</br>';


/* ======== coding with HexBin ======== */
$aes = Encryption::aesFactory()::createAesEcb128($key, Openssl::CODING_HEX_BIN);
$str = 'test aes ecb encryption, coding with hexbin.';
$encrypted = $aes->encrypt($str);
printf("encrypt str: " . $encrypted);
echo PHP_EOL . '</br>';
printf("decrypt str: " . $aes->decrypt($encrypted));
echo PHP_EOL . '</br>';
echo PHP_EOL . '</br>';


/* ======== coding with Base64 ======== */
$aes = Encryption::aesFactory()::createAesEcb128($key, Openssl::SHA1_DIGEST | Openssl::CODING_BASE64);
$str = 'test aes ecb encryption, coding with base64, key digest with sha1.';
$encrypted = $aes->encrypt($str);
printf("encrypt str: " . $encrypted);
echo PHP_EOL . '</br>';
printf("decrypt str: " . $aes->decrypt($encrypted));
echo PHP_EOL . '</br>';
echo PHP_EOL . '</br>';