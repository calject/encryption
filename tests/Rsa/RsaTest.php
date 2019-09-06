<?php
/**
 * Author: 沧澜
 * Date: 2019-09-06
 */

namespace CalJect\Encryptio\Test\Rsa;

use CalJect\Encryption\Constants\Openssl;
use CalJect\Encryption\Encryption;
use CalJect\Encryption\Exceptions\IoException;
use CalJect\Encryption\Exceptions\RsaException;
use PHPUnit\Framework\TestCase;

class RsaTest extends TestCase
{
    /**
     * @var string
     */
    protected $resourcePath;
    
    protected $priPathPkcs8;
    protected $priPathPkcs12;
    protected $pubPathPem;
    protected $pubPathX509;
    
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->resourcePath = dirname(__DIR__) . '/resources';
        $this->priPathPkcs8 = $this->resource('private_p8.pem');
        $this->priPathPkcs12 = $this->resource('private_p12.pfx');
        $this->pubPathPem = $this->resource('public.pem');
        $this->pubPathX509 = $this->resource('public.x509');
    }
    
    /**
     * @throws IoException
     * @throws RsaException
     */
    public function testPkcs8()
    {
        $pkcs8 = Encryption::rsaFactory()::createPkcs8($this->pubPathPem, $this->priPathPkcs8, Openssl::CODING_HEX_BIN);
        $data = 'test encryption with rsa pkcs8.';
        $encryptData = $pkcs8->encrypt($data);
        $signData = $pkcs8->sign($data);
        $this->assertEquals($data, $pkcs8->decrypt($encryptData));
        $this->assertEquals(true, $pkcs8->verify($data, $signData));
    }
    
    /**
     * @throws IoException
     * @throws RsaException
     */
    public function testExceptions()
    {
        $this->expectException(IoException::class);
        $pkcs8 = Encryption::rsaFactory()::createPkcs8('', '', Openssl::CODING_HEX_BIN);
        $data = 'test encryption with rsa pkcs8.';
        $pkcs8->encrypt($data);
        $this->assertEquals(true, true);
        
    }
    
    /**
     * @param string $fileName
     * @return string
     */
    protected function resource(string $fileName)
    {
        return $this->resourcePath . '/' . $fileName;
    }
    
}