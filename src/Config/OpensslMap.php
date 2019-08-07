<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-23
 * Annotation:
 */

namespace CalJect\Encryption\Config;


use CalJect\Encryption\Components\Coding\Base64Coding;
use CalJect\Encryption\Components\Coding\HexBinCoding;
use CalJect\Encryption\Components\Coding\NoCoding;
use CalJect\Encryption\Components\Padding\NoPadding;
use CalJect\Encryption\Components\Padding\Pkcs5Padding;
use CalJect\Encryption\Components\Padding\Pkcs7Padding;
use CalJect\Encryption\Constants\Openssl;

interface OpensslMap
{
    /* ======== declare list ======== */
    const FILE_LIST = [Openssl::FILE_KEY, Openssl::FILE_PKEY, Openssl::FILE_PKCS12];
    const CODING_LIST= [Openssl::CODING_NO, Openssl::CODING_BASE64, Openssl::CODING_HEX_BIN];
    const PKCS_LIST = [Openssl::NO_PADDING, Openssl::PKCS5_PADDING, Openssl::PKCS7_PADDING];
    const ENCRYPT_LIST = [Openssl::ENCRYPT_CODING_NO, Openssl::ENCRYPT_CODING_HEX_BIN];
    
    /* ======== map ======== */
    const CODING_MAP = [
        Openssl::CODING_NO => NoCoding::class,
        Openssl::CODING_BASE64 => Base64Coding::class,
        Openssl::CODING_HEX_BIN => HexBinCoding::class
    ];
    
    const PADDING_MAP = [
        Openssl::NO_PADDING => NoPadding::class,
        Openssl::PKCS5_PADDING => Pkcs5Padding::class,
        Openssl::PKCS7_PADDING => Pkcs7Padding::class
    ];
    
    const ENCRYPT_CODING_MAP = [
        Openssl::ENCRYPT_CODING_NO => NoCoding::class,
        Openssl::ENCRYPT_CODING_HEX_BIN => HexBinCoding::class
    ];
    
    
}