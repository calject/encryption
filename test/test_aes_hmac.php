<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-29
 * Annotation:
 */

use Chanlly\Encryption\Encryption;
use Chanlly\Encryption\Exceptions\AesException;
use Chanlly\Encryption\Factories\AesHmacFactory;

require "../vendor/autoload.php";


$key = 'as9d8ajsd9asjdas';
$iv = '1234567890123456';

// $aes = AesHmacFactory::createAesCbc128($key, $iv);
// $aes = Encryption::$aesHmac::createAesCbc128($key, $iv);
$aes = Encryption::aesHmacFactory()::createAesCbc128($key, $iv);

$data = 'test aes cbc 128 hmac .';

try {
    $encrypt = $aes->encrypt($data);
    printf('encrypt: '.$encrypt);
    echo PHP_EOL . '</br>';
    $decrypt = $aes->decrypt($encrypt);
    printf('decrypt: '.$decrypt);
    echo PHP_EOL . '</br>';
    
} catch (AesException $e) {
    printf('AesException:');
    var_dump($e);
} catch (Exception $e) {
    var_dump($e);
}



