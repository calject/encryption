<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-22
 * Annotation:
 */

namespace CalJect\Encryption\Constants;


interface Openssl
{
    /* ======== openssl key读取类型 ======== */
    const FILE_KEY = 'Key';
    const FILE_PKEY = 'PKey';
    const FILE_PKCS12 = 'Pkcs12';
    
    /* ======== 编码格式常量定义 ======== */
    const CODING_NO = 1;
    const CODING_BASE64 = 1 << 1;
    const CODING_HEX_BIN = 1 << 2;
    
    /* ======== Pkcs padding ======== */
    const NO_PADDING = 1 << 6;
    const PKCS5_PADDING = 1 << 7;
    const PKCS7_PADDING = 1 << 8;
    
    
    /* ======== declare list ======== */
    const FILE_LIST = [Openssl::FILE_KEY, Openssl::FILE_PKEY, Openssl::FILE_PKCS12];
    const CODING_LIST = [Openssl::CODING_NO, Openssl::CODING_BASE64, Openssl::CODING_HEX_BIN];
    const PKCS_LIST = [Openssl::NO_PADDING, Openssl::PKCS5_PADDING, Openssl::PKCS7_PADDING];
    
    
    
    /**
     * 支持AES模式定义 LIST
     * @see openssl_get_cipher_methods()
     * AES-128-CBC
     * AES-128-CBC-HMAC-SHA1
     * AES-128-CBC-HMAC-SHA256
     * AES-128-CFB
     * AES-128-CFB1
     * AES-128-CFB8
     * AES-128-CTR
     * AES-128-ECB
     * AES-128-OFB
     * AES-128-XTS
     * AES-192-CBC
     * AES-192-CFB
     * AES-192-CFB1
     * AES-192-CFB8
     * AES-192-CTR
     * AES-192-ECB
     * AES-192-OFB
     * AES-256-CBC
     * AES-256-CBC-HMAC-SHA1
     * AES-256-CBC-HMAC-SHA256
     * AES-256-CFB
     * AES-256-CFB1
     * AES-256-CFB8
     * AES-256-CTR
     * AES-256-ECB
     * AES-256-OFB
     * AES-256-XTS
     */
    /* ======== 默认常用模式定义 ======== */
    const AES_MODE_ECB_128 = 'AES-128-ECB';
    const AES_MODE_ECB_256 = 'AES-256-ECB';
    const AES_MODE_CBC_128 = 'AES-128-CBC';
    const AES_MODE_CBC_256 = 'AES-256-CBC';
    
    
}