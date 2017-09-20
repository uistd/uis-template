<?php

namespace ffan\dop\main;

/**
 *  
 * @package ffan\dop\main
 */
class IndexResponse
{
    /**
     * @var int 加
     */
    public $plus;
    
    /**
     * @var int 减
     */
    public $minus;
    
    /**
     * @var int 乘
     */
    public $multiply;
    
    /**
     * @var int 除
     */
    public $divide;
    
    /**
     * 转成数组
     * @param bool $empty_convert 如果结果为空，是否转成stdClass
     * @return array|object
     */
    public function arrayPack($empty_convert = false)
    {
        $result = array();
        if (null !== $this->plus) {
            $result['plus'] = (int)$this->plus;
        }
        if (null !== $this->minus) {
            $result['minus'] = (int)$this->minus;
        }
        if (null !== $this->multiply) {
            $result['multiply'] = (int)$this->multiply;
        }
        if (null !== $this->divide) {
            $result['divide'] = (int)$this->divide;
        }
        if ($empty_convert && empty($result)) {
            return new \stdClass();
        }
        return $result;
    }
}