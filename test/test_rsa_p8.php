<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-22
 * Annotation:
 */

use Chanlly\Encryption\Constants\Openssl;
use Chanlly\Encryption\Exceptions\IoException;
use Chanlly\Encryption\Exceptions\RsaException;
use Chanlly\Encryption\Providers\RSA\PkcsPem;

require '../vendor/autoload.php';

$pubFile = __DIR__.'/resources/public.pem';
$priFile = __DIR__.'/resources/private_p8.pem';

$rsa = new PkcsPem($pubFile, $priFile);

// 设置编码格式，默认为 Openssl::CODING_BASE64 base64
$rsa->setCodingMode(Openssl::CODING_HEX_BIN);

$str = "test rsa encryption with pkcs8.";


try {
    printf("原文: ".$str);
    echo PHP_EOL . '</br>';
    
    $encrypted = $rsa->encrypt($str);
    printf("密文: " . $encrypted);
    echo PHP_EOL . '</br>';
    
    printf("解密: " . $rsa->decrypt($encrypted));
    echo PHP_EOL . '</br>';
    echo PHP_EOL . '</br>';
    
    $sign = $rsa->sign($str);
    printf("签名: " . $sign);
    echo PHP_EOL . '</br>';
    
    printf("验签: " . ($rsa->verify($str, $sign) ? '通过' : '未通过'));
    echo PHP_EOL . '</br>';
    echo PHP_EOL . '</br>';
    
} catch (IoException | RsaException $e) {
    echo "<pre>";
    printf($e);
}



