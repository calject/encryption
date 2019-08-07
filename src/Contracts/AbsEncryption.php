<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-22
 * Annotation:
 */

namespace CalJect\Encryption\Contracts;


use CalJect\Encryption\Components\Coding\Base64Coding;
use CalJect\Encryption\Components\Coding\HexBinCoding;
use CalJect\Encryption\Components\OptMatch;
use CalJect\Encryption\Config\OpensslMap;
use CalJect\Encryption\Constants\Openssl;
use Closure;

abstract class AbsEncryption
{
    
    /**
     * @var ICoding
     */
    protected $coding;
    
    /**
     * @var ICoding
     */
    protected $encryptCoding;
    
    /**
     * @var int
     */
    protected $codingMode = Openssl::CODING_BASE64;
    
    /**
     * @var int
     */
    protected $paddingMode = Openssl::NO_PADDING;
    
    /**
     * @var int
     */
    protected $encryptMode = Openssl::NO_PADDING;
    
    /**
     * @return ICoding
     */
    final protected function coding(): ICoding
    {
        if (!$coding = &$this->coding) {
            $class = OpensslMap::CONTACTS[$this->codingMode] ?? Base64Coding::class;
            $coding = new $class;
        }
        return $coding;
    }
    
    
    /**
     * @return ICoding
     */
    final protected function encryptCoding(): ICoding
    {
        if (!$encryptCoding = &$this->encryptCoding) {
            $class = OpensslMap::CONTACTS[$this->encryptMode] ?? HexBinCoding::class;
            $encryptCoding = new $class;
        }
        return $encryptCoding;
    }
    
    /**
     * bind opt handle
     * @param int $opts
     * @return $this
     */
    public function setOpts(int $opts)
    {
        return $this->optsHandle($opts);
    }
    
    /**
     * @param ICoding $coding
     * @return $this
     */
    public function setCoding(ICoding $coding)
    {
        $this->coding = $coding;
        return $this;
    }
    
    /**
     * @param int $codingMode self::CODING_XXX sample: self::CODING_NO
     * @return $this
     */
    public function setCodingMode(int $codingMode)
    {
        $this->codingMode = $codingMode;
        return $this;
    }
    
    /*---------------------------------------------- protected ----------------------------------------------*/
    
    /**
     * @param int $opts
     * @param Closure $binds function(OptMatch $optMatch) {}
     * @return static
     */
    protected function optsHandle(int $opts, Closure $binds = null)
    {
        $optMatch = new OptMatch($opts);
        $optMatch->bindClosure($this);
        $optMatch->binds(OpensslMap::LISTS[OpensslMap::OPT_CODING], function (int $mode) {
            $this->codingMode = $mode;
        })->binds(OpensslMap::LISTS[OpensslMap::OPT_ENCRYPT_CODING], function (int $mode) {
            $this->encryptMode = $mode;
        });
        $binds && call_user_func($binds, $optMatch);
        $optMatch->match();
        return $this;
    }
    
    
}