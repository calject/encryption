# encryption
easy php encryption with RSA and AES in openssl

[示例](https://github.com/calject/encryption/tree/master/test)

**Table of Contents**

* [一、介绍](#一介绍-top)
* [二、安装教程](#二安装教程-top)
* [三、使用](#三使用-top)
    * [AES](#31-AES)
    * [RSA](#32-RSA)
* [四、拓展](#expand)


### <span id="introduce">一、介绍</span> [top](#encryption)

> 一个php基于openssl的加解密简单封装实现，仅做常用的 AES/RSA 加解密封装，支持PHP版本>=7.0且安装了openssl拓展的程序

> 若程序版本<7.0或者有其它算法需求或需要源码实现的，请使用php的加密库 `phpseclib/phpseclib` [传送门](https://github.com/phpseclib/phpseclib)


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
```$xslt
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





