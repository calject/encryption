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
use CalJect\Encryption\Components\Padding\NoDigest;
use CalJect\Encryption\Components\Padding\SHA1Digest;
use CalJect\Encryption\Components\Reading\FileReading;
use CalJect\Encryption\Components\Reading\Pkcs1Reading;
use CalJect\Encryption\Components\Reading\X509CerReading;
use CalJect\Encryption\Components\Reading\X509PemReading;
use CalJect\Encryption\Constants\Openssl;

interface OpensslMap
{
    
    const OPT_KEY_READ          = 'key_read';
    const OPT_CODING            = 'coding';
    const OPT_PADDING           = 'padding';
    const OPT_ENCRYPT_CODING    = 'encrypt_coding';
    const OPT_PUB_FILE_READ     = 'pub_file_read';
    const OPT_PRI_FILE_READ     = 'pri_file_read';
    
    const LISTS = [
        self::OPT_KEY_READ          => [Openssl::FILE_KEY, Openssl::FILE_PKEY, Openssl::FILE_PKCS12],
        self::OPT_CODING            => [Openssl::CODING_NO, Openssl::CODING_BASE64, Openssl::CODING_HEX_BIN],
        self::OPT_PADDING           => [Openssl::NO_DIGEST, Openssl::SHA1_DIGEST],
        self::OPT_ENCRYPT_CODING    => [Openssl::ENCRYPT_CODING_NO, Openssl::ENCRYPT_CODING_HEX_BIN],
        self::OPT_PUB_FILE_READ     => [Openssl::FILE_READ_PUB_PKCS1, Openssl::FILE_READ_PUB_PKCS8, Openssl::FILE_READ_PUB_X509_CER, Openssl::FILE_READ_PUB_X509_PEM],
        self::OPT_PRI_FILE_READ     => [Openssl::FILE_READ_PRI_PKCS1, Openssl::FILE_READ_PRI_PKCS8, Openssl::FILE_READ_PRI_PKCS12],
    ];
    
    const CONTACTS = [
        
        /* ======== coding map ======== */
        Openssl::CODING_NO              => NoCoding::class,
        Openssl::CODING_BASE64          => Base64Coding::class,
        Openssl::CODING_HEX_BIN         => HexBinCoding::class,
        
        /* ======== digest map ======== */
        Openssl::NO_DIGEST              => NoDigest::class,
        Openssl::SHA1_DIGEST            => SHA1Digest::class,
        
        /* ======== encrypt coding map ======== */
        Openssl::ENCRYPT_CODING_NO      => NoCoding::class,
        Openssl::ENCRYPT_CODING_HEX_BIN => HexBinCoding::class,
        
    ];
    
    const FILE_READ_CONTACTS = [
        Openssl::FILE_READ_PUB_PKCS1        => Pkcs1Reading::class,
        Openssl::FILE_READ_PUB_PKCS8        => FileReading::class,
        Openssl::FILE_READ_PUB_X509_CER     => X509CerReading::class,
        Openssl::FILE_READ_PUB_X509_PEM     => X509PemReading::class,
        
        Openssl::FILE_READ_PRI_PKCS1        => Pkcs1Reading::class,
        Openssl::FILE_READ_PRI_PKCS8        => FileReading::class,
        Openssl::FILE_READ_PRI_PKCS12       => FileReading::class,
    ];
}