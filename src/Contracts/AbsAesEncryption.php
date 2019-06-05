<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-23
 * Annotation:
 */

namespace Chanlly\Encryption\Contracts;

use Chanlly\Encryption\Constants\Openssl;

abstract class AbsAesEncryption extends AbsEncryption implements IAesEncryption
{
    
    /**
     * @var int
     */
    protected $opts;
    
    /**
     * @var string
     */
    protected $key;
    
    /**
     * @var string
     */
    protected $iv;
    
    /**
     * @var string
     */
    protected $cipherMode;
    
    /**
     * @var array
     */
    protected $expand;
    
    /**
     * AbsAesEncryption constructor.
     * @param string $key
     * @param int $opts
     * @param string $cipherMode
     * @param string $iv
     * @param array $expand
     */
    public function __construct(string $key, int $opts = Openssl::CODING_BASE64, $cipherMode = Openssl::AES_MODE_ECB_128, string $iv = "", ... $expand)
    {
        $this->key = $key;
        $this->opts = $opts;
        $this->iv = $iv;
        $this->cipherMode = $cipherMode;
        $this->expand = $expand;
        $this->setOpts($opts);
        $this->init();
    }
    
    /**
     * init
     */
    protected function init() {}
    
    /*---------------------------------------------- set ----------------------------------------------*/
    
    /**
     * @param string $cipherMode
     * @return $this
     */
    public function setCipherMode(string $cipherMode)
    {
        $this->cipherMode = $cipherMode;
        return $this;
    }
    
    /**
     * @param string $key
     * @return $this
     */
    public function setKey(string $key)
    {
        $this->key = $key;
        return $this;
    }
    
    /**
     * @param string $iv
     * @return $this
     */
    public function setIv(string $iv)
    {
        $this->iv = $iv;
        return $this;
    }
    
}