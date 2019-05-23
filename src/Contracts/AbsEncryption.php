<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-22
 * Annotation:
 */

namespace Chanlly\Encryption\Contracts;


use Chanlly\Encryption\Components\Coding\Base64Coding;
use Chanlly\Encryption\Components\Padding\NoPadding;
use Chanlly\Encryption\Config\OpensslMap;
use Chanlly\Encryption\Constants\Openssl;

abstract class AbsEncryption
{
    
    /**
     * @var ICoding
     */
    protected $coding;
    
    /**
     * @var int
     */
    protected $codingMode = Openssl::CODING_BASE64;
    
    /**
     * @var IPadding
     */
    protected $padding;
    
    /**
     * @var int
     */
    protected $paddingMode = Openssl::NO_PADDING;
    
    /**
     * @return ICoding
     */
    final protected function coding(): ICoding
    {
        if (!$coding = &$this->coding) {
            $class = OpensslMap::CODING_MAP[$this->codingMode] ?? Base64Coding::class;
            $coding = new $class;
        }
        return $coding;
    }
    
    /**
     * @return IPadding
     */
    final protected function padding(): IPadding
    {
        if (!$padding = &$this->padding) {
            $class = OpensslMap::PADDING_MAP[$this->paddingMode] ?? NoPadding::class;
            $padding = new $class;
        }
        return $padding;
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
    
    /**
     * @param IPadding $padding
     * @return $this
     */
    public function setPadding(IPadding $padding)
    {
        $this->padding = $padding;
        return $this;
    }
    
    /**
     * @param int $paddingMode
     * @return $this
     */
    public function setPaddingMode(int $paddingMode)
    {
        $this->paddingMode = $paddingMode;
        return $this;
    }
    
}