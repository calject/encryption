# encryption

**Table of Contents**

* [一、介绍](#一介绍-top)
* [二、安装教程](#二安装教程-top)
* [三、使用](#三使用-top)
    * [AES](#31-AES)
    * [RSA](#32-RSA)
* [四、拓展](#expand)


### <span id="introduce">一、介绍</span> [top](#encryption)

一个php基于openssl的加解密简单封装实现，仅做常用的 AES/RSA 加解密封装，支持PHP版本>=7.0且安装了openssl拓展的程序

若程序版本<7.0或者有其它算法需求或需要源码实现的，请使用php的加密库 [phpseclib/phpseclib](https://github.com/phpseclib/phpseclib)


[示例代码](https://github.com/calject/encryption/tree/master/test)

### <span id="install">二、安装教程</span> [top](#encryption)

执行`composer require "calject/encryption"`


### <span id="usage">三、使用</span> [top](#encryption)

* `Calject\Encryption\Encryption`
    * `method`
        * `rsaFactory`
        * `aesFactory`
        * `aesHmacFatory`
    * `get`
        * `Calject\Encryption\Encryption::rsaFactory()`
        * `Calject\Encryption\Encryption::aesFactory()`
        * `Calject\Encryption\Encryption::aesHmacFatory()`

* `Calject\Encryption\Factories\RsaFactory`
    * `method`
        * `createPkcs1`
        * `createPkcs8`
        * `createPkcs12`
        * `createX509`
* `Calject\Encryption\Factories\AesFactory`
    * `method`
        * `createAes`
        * `createAesCbc128`
        * `createAesCbc256`
        * `createAesEcb128`
        * `createAesEcb256`
* `Calject\Encryption\Factories\AesHmacFactory`
    * `method`
        * `createAes`
        * `createAesCbc128`
        * `createAesCbc256`

* examples
```php
# create aes encryption
$aes = AesFactory::createAesEcb128($key);
$aes = Encryption::$aes::createAes($key, Openssl::CODING_BASE64, 'AES-256-ECB');
$aes = Encryption::aesFactory()::createAes($key, Openssl::CODING_BASE64, 'AES-256-ECB');

# create rsa encryption
// 设置编码格式，默认为 Openssl::CODING_BASE64 base64
$rsa = RsaFactory::createPkcs8($pubFile, $priFile, Openssl::CODING_HEX_BIN);
$rsa = Encryption::$rsa::createPkcs8($pubFile, $priFile, Openssl::CODING_HEX_BIN);
$rsa = Encryption::rsaFactory()::createPkcs8($pubFile, $priFile, Openssl::CODING_HEX_BIN);
```

* [代码示例及说明](https://github.com/calject/encryption/blob/master/test/test_rsa_mix.php)
```php
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
|   可选: NO_PADDING、PKCS5_PADDING、PKCS7_PADDING
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

```

#### <span id="usage-4.1">3.1 AES</span>
* 使用示例
1. [test_aes](https://github.com/calject/encryption/blob/master/test/test_aes.php)
2. [test_aes_ecb](https://github.com/calject/encryption/blob/master/test/test_aes_ecb.php)
3. [test_aes_cbc](https://github.com/calject/encryption/blob/master/test/test_aes_cbc.php)
4. [test_aes_hmac](https://github.com/calject/encryption/blob/master/test/test_aes_hmac.php)

#### <span id="usage-4.1">3.2 RSA</span>

* 使用示例
1. [test_rsa_pkcs8](https://github.com/calject/encryption/blob/master/test/test_rsa_p8.php)
2. [test_rsa_pkcs12](https://github.com/calject/encryption/blob/master/test/test_rsa_p12.php)
3. [test_rsa_x509](https://github.com/calject/encryption/blob/master/test/test_rsa_x509.php)

### <span id="expand">四、拓展</span> [top](#encryption)

* 查看`openssl`可用加密算法及支持的摘要算法
    * [test_encrypt_list](https://github.com/calject/encryption/blob/master/test/test_encrypt_list.php)
* aes算法拓展,通过AesFactory::createAes() 输入算法参数，参考
    * [test_aes](https://github.com/calject/encryption/blob/master/test/test_aes.php)

* 拓展aes实现
    * 继承`Calject\Encryption\Contracts\AbsAesEncryption`抽象类并实现其方法

* 拓展rsa实现
    * 继承`Calject\Encryption\Contracts\AbsRsaEncryption`抽象类并实现其方法

* 拓展其他算法
    * 继承`Calject\Encryption\Contracts\AbsEncryption`抽象类并实现其方法





