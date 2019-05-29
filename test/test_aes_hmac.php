<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-29
 * Annotation:
 */

use Chanlly\Encryption\Constants\Openssl;
use Chanlly\Encryption\Providers\AES\AES_HMAC;

require "../vendor/autoload.php";


$key = 'as9d8ajsd9asjdas';
$iv = '1234567890123456';

$aes = new AES_HMAC($key, Openssl::CODING_BASE64, Openssl::AES_MODE_CBC_128, $iv);

$data = 'test aes cbc 128 hmac .';

try {
    $encrypt = $aes->encrypt($data);
    dump($encrypt);
    $decrypt = $aes->decrypt($encrypt);
    dump($decrypt);
    
} catch (Exception $e) {
    dump($e);
}



