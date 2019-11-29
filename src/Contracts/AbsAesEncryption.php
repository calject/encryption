<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-23
 * Annotation:
 */

namespace CalJect\Encryption\Contracts;

use CalJect\Encryption\Components\OptMatch;
use CalJect\Encryption\Components\Padding\NoDigest;
use CalJect\Encryption\Config\OpensslMap;
use CalJect\Encryption\Constants\Openssl;

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
     * @var IDigest
     */
    protected $padding;
    
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
    
    /**
     * @param int $opts
     * @return $this
     */
    public function setOpts(int $opts)
    {
        return $this->optsHandle($opts, function (OptMatch $optMatch) {
            $optMatch->binds(OpensslMap::LISTS[OpensslMap::OPT_PADDING], function (int $mode) {
                $this->digestMode = $mode;
            });
        });
    }
    
    /**
     * @return IDigest
     */
    final protected function digest(): IDigest
    {
        if (!$padding = &$this->padding) {
            $class = OpensslMap::CONTACTS[$this->digestMode] ?? NoDigest::class;
            $padding = new $class;
        }
        return $padding;
    }
    
    /**
     * @param int $paddingMode
     * @return $this
     */
    public function setPaddingMode(int $paddingMode)
    {
        $this->digestMode = $paddingMode;
        return $this;
    }
    
    
    /**
     * @param IDigest $padding
     * @return $this
     */
    public function setPadding(IDigest $padding)
    {
        $this->padding = $padding;
        return $this;
    }
    
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