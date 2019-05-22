<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-22
 * Annotation:
 */

namespace Chanlly\Encryption\Constants;


interface Constant
{
    /* ======== openssl key读取类型 ======== */
    const FILE_KEY = 'Key';
    const FILE_PKEY = 'PKey';
    const FILE_PKCS12 = 'Pkcs12';
}