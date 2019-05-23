<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-23
 * Annotation:
 */

require "../vendor/autoload.php";

/* ======== 获得可用的摘要生成方法列表 ======== */
$md_methods = openssl_get_md_methods();
/* ======== 获取可用的加密算法列表 ======== */
$ci_methods = openssl_get_cipher_methods();

echo "<pre>";
var_dump($md_methods);
var_dump($ci_methods);




