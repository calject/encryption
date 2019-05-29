<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-29
 * Annotation:
 */

namespace Chanlly\Encryption\Providers\AES;

use Chanlly\Encryption\Constants\Openssl;
use Chanlly\Encryption\Contracts\AbsAesEncryption;
use Chanlly\Encryption\Exceptions\AesException;
use Chanlly\Encryption\Helpers\AESEncryptHelper;
use Exception;
use RuntimeException;

class AES_HMAC extends AbsAesEncryption
{
    /**
     * @var bool
     */
    protected $serialize = false;
    
    /**
     * AES_HMAC constructor.
     * @param string $key
     * @param int $opts
     * @param string $cipherMode
     * @param string $iv
     * @param mixed ...$expand
     */
    public function __construct(string $key, int $opts = Openssl::CODING_BASE64, $cipherMode = Openssl::AES_MODE_CBC_128, string $iv = "", ...$expand)
    {
        parent::__construct($key, $opts, $cipherMode, $iv, $expand);
    }
    
    /**
     * init
     */
    protected function init()
    {
        $key = (string) $this->key;
        if (!AESEncryptHelper::supported($key, $this->cipherMode)) {
            throw new RuntimeException('The only supported ciphers are AES-128-CBC or -x? and AES-256-CBC or -x? with the correct key lengths.');
        }
        $this->key = $this->padding()->padding($this->key);
    }
    
    /**
     * @param string $str
     * @param mixed|null $opts
     * @return string
     * @throws AesException
     * @throws Exception
     */
    public function encrypt(string $str, $opts = null): string
    {
        $iv = $this->iv ?: random_bytes(openssl_cipher_iv_length($this->cipherMode));
        $value = openssl_encrypt($this->serialize ? serialize($str) : $str, $this->cipherMode, $this->key, $opts ?? 0, $iv);
    
        if ($value === false) {
            throw new AesException('Could not encrypt the data.');
        }
    
        $mac = $this->hash($iv = base64_encode($iv), $value);
        $json = json_encode(compact('iv', 'value', 'mac'));
    
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new AesException('Could not encrypt the data.');
        }
    
        return $this->coding()->encode($json);
    }
    
    /**
     * @param string $str
     * @param mixed|null $opts
     * @return string
     * @throws AesException
     * @throws Exception
     */
    public function decrypt(string $str, $opts = null): string
    {
        $payload = $this->getJsonPayload($str);
        $iv = base64_decode($payload['iv']);
        $decrypted = openssl_decrypt(
            $payload['value'], $this->cipherMode, $this->key, 0, $iv
        );
        ($decrypted === false) && AesException::throw('Could not decrypt the data.');
        return $this->serialize ? unserialize($decrypted) : $decrypted;
    }
    
    /**
     * @param bool $serialize
     * @return $this
     */
    public function setSerialize(bool $serialize)
    {
        $this->serialize = $serialize;
        return $this;
    }
    
    /*---------------------------------------------- protected function ----------------------------------------------*/
    
    /**
     * Create a MAC for the given value.
     *
     * @param  string  $iv
     * @param  mixed  $value
     * @return string
     */
    protected function hash($iv, $value)
    {
        return hash_hmac('sha256', $iv . $value, $this->key);
    }
    
    /**
     * Get the JSON array from the given payload.
     *
     * @param string $payload
     * @return array
     * @throws AesException
     * @throws Exception
     */
    protected function getJsonPayload($payload)
    {
        $payload = json_decode($this->coding()->decode($payload), true);
        $this->validPayload($payload) || AesException::throw('The payload is invalid.');
        $this->validMac($payload) || AesException::throw('The MAC is invalid.');
        return $payload;
    }
    
    /**
     * Verify that the encryption payload is valid.
     *
     * @param  mixed  $payload
     * @return bool
     */
    protected function validPayload($payload)
    {
        return is_array($payload) && isset($payload['iv'], $payload['value'], $payload['mac']) &&
            strlen(base64_decode($payload['iv'], true)) === openssl_cipher_iv_length($this->cipherMode);
    }
    
    /**
     * Determine if the MAC for the given payload is valid.
     *
     * @param array $payload
     * @return bool
     * @throws Exception
     */
    protected function validMac(array $payload)
    {
        $calculated = $this->calculateMac($payload, $bytes = random_bytes(16));
        
        return hash_equals(
            hash_hmac('sha256', $payload['mac'], $bytes, true), $calculated
        );
    }
    
    /**
     * Calculate the hash of the given payload.
     *
     * @param  array  $payload
     * @param  string  $bytes
     * @return string
     */
    protected function calculateMac($payload, $bytes)
    {
        return hash_hmac(
            'sha256', $this->hash($payload['iv'], $payload['value']), $bytes, true
        );
    }
    
}