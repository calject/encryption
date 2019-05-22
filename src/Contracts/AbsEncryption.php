<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-22
 * Annotation:
 */

namespace Chanlly\Encryption\Contracts;


use Chanlly\Encryption\Components\Coding\Base64Coding;
use Chanlly\Encryption\Components\Coding\HexBinCoding;
use Chanlly\Encryption\Components\Coding\NoCoding;

abstract class AbsEncryption
{
    /* ======== 编码格式常量定义 ======== */
    const CODING_NO = 0;
    const CODING_BASE64 = 1;
    const CODING_HEX_BIN = 2;
    
    /**
     * @var ICoding
     */
    protected $coding;
    
    /**
     * @var int
     */
    protected $codingMode = 1;
    
    /**
     * @return ICoding
     */
    final protected function coding(): ICoding
    {
        if (!$coding = $this->coding) {
            $coding = $this->getByCodingMode($this->codingMode);
        }
        return $coding;
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
     * @param int $codingMode self::CODING_XXX sample: self::CODING_NO
     * @return ICoding
     */
    final protected function getByCodingMode(int $codingMode): ICoding
    {
        switch ($codingMode) {
            case 0:
                return new NoCoding();
            case 1:
                return new Base64Coding();
            case 2:
                return new HexBinCoding();
            default:
                return new Base64Coding();
        }
    }
}