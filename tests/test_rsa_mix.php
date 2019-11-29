<?php
/**
 * Author: 沧澜
 * Date: 2019-08-07
 */

use CalJect\Encryption\Constants\Openssl;
use CalJect\Encryption\Encryption;

require '../vendor/autoload.php';

$pubFile = __DIR__.'/resources/public.x509';
$priFile = __DIR__.'/resources/private_p12.pfx';
$password = '123456';

/*
|--------------------------------------------------------------------------
| RSA 混合密钥创建示例
|--------------------------------------------------------------------------
|
*/

/* ======== 私钥(p12)、公钥(x509-pem) ======== */
// 添加 Openssl::FILE_READ_PUB_X509_PEM 配置参数
$rsa = Encryption::rsaFactory()::createPkcs12($pubFile, $priFile, $password, Openssl::ENCRYPT_CODING_NO | Openssl::FILE_READ_PUB_X509_PEM);

/* ======== 私钥(p12)、公钥(x509-cer) ======== */
// 添加 Openssl::FILE_READ_PUB_X509_CER 配置参数
$rsa = Encryption::rsaFactory()::createPkcs12($pubFile, $priFile, $password, Openssl::ENCRYPT_CODING_NO | Openssl::FILE_READ_PUB_X509_CER);

/* ======== 私钥(p12)、公钥(pkcs8-pem) ======== */
$rsa = Encryption::rsaFactory()::createPkcs12($pubFile, $priFile, $password, Openssl::ENCRYPT_CODING_NO);

$rsa->setOpts(Openssl::FILE_READ_PUB_PKCS1 | Openssl::CODING_NO | Openssl::ENCRYPT_CODING_NO);

/*
|--------------------------------------------------------------------------
| RSA 可选参数列表 参考CalJect\Encryption\Constants\Openssl 接口类定义
|--------------------------------------------------------------------------
| 1.编码格式
|   1. 常用编码格式
|   CODING_NO         : 不进行任何编码，可以在方法外部自行进行编码操作
|   CODING_BASE64     : Base64编码
|   CODING_HEX_BIN    : HexBin 编码
|   此类参数可通过 `$rsa->setCodingMode(Openssl::CODING_HEX_BIN)` 设置编码格式为HexBin (默认为Base64编码)
|
| 1.2 自定义编码格式
|   可通过实现 CalJect\Encryption\Contracts\ICoding 接口自定义编码操作, 然后通过`$rsa->setCoding(XXX)`方法设置编码
|
| 2.padding配置(适用于AES加密)
|   同样可以通过`$rsa->setPaddingMode()` 设置，或者实现`CalJect\Encryption\Contracts\IPadding`接口并通过`$rsa->setPadding()`设置
|   可选: NO_DIGEST、SHA1_DIGEST
|
| 3.加密模式(默认为公钥加密-私钥解密)
|   可通过设置$rsa->setMode($rsa::MODEL_OPPOSITE / Pkcs12::MODEL_OPPOSITE / Pkcs8::MODEL_OPPOSITE ...);
|   设置加密模式为反向模式(即使用私钥加密-公钥解密模式 不推荐使用该模式,仅保留该功能)
|
| 4.加签/验签数据编码
| 通过`$rsa->setSignCoding(ICoding)`方法设置，或者自行在外部设置
|
| 5. pkcs12加密编码设置(通过$rsa->setOpts()设置) [一般不作修改，默认使用HexBin对加密内容进行分段编码]
|   Openssl::ENCRYPT_CODING_NO      : 不编码 (一般与其它语言交互是可能需要设置该参数，具体看加密模式及双方编码约定)
|   Openssl::ENCRYPT_CODING_HEX_BIN : 使用HexBin 编码
|
| 6. 通用参数设置`$rsa->setOpts(int xxx)`
| 可通过该参数设置rsa的私钥读取、编码等参数配置
| 例: 需要配置Pkcs12的公钥读取为x509格式、编码格式为HexBin
|     `$rsa->setOpts(Openssl::FILE_READ_PUB_X509_CER | Openssl::CODING_HEX_BIN)`
| 例: 设置Pkcs12公钥读取为Pkcs1、不进行编码、字段解析不编码
|     `$rsa->setOpts(Openssl::FILE_READ_PUB_PKCS1 | Openssl::CODING_NO | Openssl::ENCRYPT_CODING_NO)`
*/


/*
|--------------------------------------------------------------------------
| AES 参考各示例文件,使用与RSA基本一致
|--------------------------------------------------------------------------
|
*/
