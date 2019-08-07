<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-23
 * Annotation:
 */

use CalJect\Encryption\Encryption;
use CalJect\Encryption\Exceptions\IoException;
use CalJect\Encryption\Exceptions\RsaException;
use CalJect\Encryption\Factories\RsaFactory;

require '../vendor/autoload.php';

$pubFile = __DIR__.'/resources/public.pem';
$priFile = __DIR__.'/resources/private_p12.pfx';
$password = '123456';

// $rsa = RsaFactory::createPkcs12($pubFile, $priFile, $password);
// $rsa = Encryption::$rsa::createPkcs12($pubFile, $priFile, $password);
$rsa = Encryption::rsaFactory()::createPkcs12($pubFile, $priFile, $password);

// 设置编码格式，默认为 Openssl::CODING_BASE64 base64
// $rsa->setCodingMode(Openssl::CODING_HEX_BIN);

$str = "test rsa encryption with pkcs12.";


try {
    printf("原文: ".$str);
    echo PHP_EOL . '</br>';
    
    $encrypted = $rsa->encrypt($str);
    printf("密文: " . $encrypted);
    echo PHP_EOL . '</br>';
    
    printf("解密: " . $rsa->decrypt($encrypted));
    echo PHP_EOL . '</br>';
    echo PHP_EOL . '</br>';
    
    $sign = $rsa->sign($encrypted);
    printf("签名: " . $sign);
    echo PHP_EOL . '</br>';
    
    printf("验签: " . ($rsa->verify($encrypted, $sign) ? '通过' : '未通过'));
    echo PHP_EOL . '</br>';
    echo PHP_EOL . '</br>';
    
} catch (IoException | RsaException $e) {
    echo "<pre>";
    printf($e);
}