<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019-05-23
 * Annotation:
 */

namespace CalJect\Encryption\Components;


use Closure;

class OptMatch
{
    /**
     * @var int
     */
    protected $opts = 0;
    
    /**
     * @var array
     */
    protected $binds = [];
    
    /**
     * @var mixed
     */
    protected $closureBind;
    
    /**
     * @var bool
     */
    protected $isMatch = false;
    
    /**
     * OptMatch constructor.
     * @param int $opts
     */
    public function __construct(int $opts = 0)
    {
        $this->opts = $opts;
    }
    
    /**
     * @param int $opts
     * @return $this
     */
    public function setOpts(int $opts)
    {
        $this->opts = $opts;
        return $this;
    }
    
    /**
     * @param mixed $closureBind
     * @return $this
     */
    public function bindClosure($closureBind)
    {
        $this->closureBind = $closureBind;
        return $this;
    }
    
    /**
     * @param int $key
     * @param Closure $handle
     * @return $this
     */
    public function bind(int $key, Closure $handle)
    {
        $this->closureBind && $handle->bindTo($this->closureBind);
        $this->binds[$key] = $handle;
        return $this;
    }
    
    /**
     * @param array $keys
     * @param Closure $handle
     * @return $this
     */
    public function binds(array $keys, Closure $handle)
    {
        foreach ($keys as $key) {
            $this->bind($key, $handle);
        }
        return $this;
    }
    
    /**
     * @return void
     */
    public function match()
    {
        foreach ($this->binds as $key => $func) {
            $this->check($key) && call_user_func($func, $key);
        }
        $this->isMatch = true;
    }
    
    /**
     * @param int $key
     * @return bool
     */
    public function check(int $key): bool
    {
        return ($this->opts & $key) === $key;
    }
    
    /**
     * @return bool
     */
    public function isMatch(): bool
    {
        return $this->isMatch;
    }
    
}