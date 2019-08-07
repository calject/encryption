<?php
/**
 * Author: 沧澜
 * Date: 2019-08-07
 */

namespace CalJect\Encryption\Utils;


use CalJect\Encryption\Exceptions\RsaException;

class RsaKeyConvert
{
    /**
     * x509格式转换
     * @param mixed $content 文件路径|文件内容
     * @param bool $is_file_path 是否为文件路径
     * @return string
     */
    public static function x509PubToCer($content, $is_file_path = false)
    {
        $file_content = self::getFileContent($content, $is_file_path);
        return "-----BEGIN CERTIFICATE-----\n" . trim(chunk_split(base64_encode($file_content), 64, "\n"), "\n") . "\n-----END CERTIFICATE-----";
    }
    
    /**
     * x509密钥格式转换
     * @param mixed $content 文件路径|文件内容
     * @param bool $is_file_path 是否为文件路径
     * @return string
     */
    public static function x509PubToPem($content, $is_file_path = false)
    {
        $file_content = self::getFileContent($content, $is_file_path);
        return "-----BEGIN PUBLIC KEY-----\n" . wordwrap(base64_encode($file_content), 64, "\n", true) . "\n-----END PUBLIC KEY-----";
    }
    
    /**
     * x509密钥格式转换
     * @param $content
     * @param bool $is_file_path
     * @return bool|string
     */
    public static function cerToX509($content, $is_file_path = false)
    {
        $file_content = self::getFileContent($content, $is_file_path);
        $file_content = str_replace("-----BEGIN CERTIFICATE-----\n", '', $file_content);
        $file_content = str_replace("\n-----END CERTIFICATE-----", '', $file_content);
        $file_content = str_replace("\n", '', $file_content);
        return base64_decode($file_content);
    }
    
    /**
     * x509密钥格式转换
     * @param $content
     * @param bool $is_file_path
     * @return bool|string
     */
    public static function pemToX509($content, $is_file_path = false)
    {
        $file_content = self::getFileContent($content, $is_file_path);
        $file_content = str_replace("-----BEGIN PUBLIC KEY-----\n", '', $file_content);
        $file_content = str_replace("\n-----END PUBLIC KEY-----", '', $file_content);
        $file_content = str_replace("\n", '', $file_content);
        return base64_decode($file_content);
    }
    
    /**
     * p12格式秘钥转换
     * @param $file_content
     * @param string $password
     * @return mixed
     */
    public static function p12ToPubKey($file_content, string $password)
    {
        $keys = self::p12GetKeys($file_content, $password);
        return $keys['cert'];
    }
    
    /**
     * p12格式密钥格式转换
     * @param mixed $file_content
     * @param string $password 密钥密码
     * @return string
     */
    public static function p12ToPriKey($file_content, string $password)
    {
        $keys = self::p12GetKeys($file_content, $password);
        return $keys['pkey'];
    }
    
    /**
     * @param $file_content
     * @param string $password
     * @return array
     * array: [
     *      "cert" => "
     *          -----BEGIN CERTIFICATE-----\n
     *          *****
     *          -----END CERTIFICATE-----\n
     *      ",
     *      "pkey" => "
     *          -----BEGIN PRIVATE KEY-----\n
     *          *****
     *          -----END PRIVATE KEY-----\n
     *      ",
     *      "extracerts" => [
     *          0 => "
     *              -----BEGIN CERTIFICATE-----\n
     *              *****
     *              -----END CERTIFICATE-----\n
     *          "
     *      ]
     *
     * ]
     */
    public static function p12GetKeys($file_content, string $password)
    {
        openssl_pkcs12_read($file_content, $keys, $password) || (function() use($file_content) {
            RsaException::throw('can not read rsa key in ' . $file_content);
        })();
        return $keys;
    }
    
    /**
     * 获取内容文本
     * @param mixed $file
     * @param bool $is_file_path 是否为文件路径
     * @return string
     */
    protected static function getFileContent($file, $is_file_path)
    {
        if ($is_file_path && file_exists($file)) {
            return file_get_contents($file);
        } else {
            return $file;
        }
    }
}