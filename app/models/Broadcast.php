<?php
/**
 * Created by PhpStorm.
 * User: xushengping
 * Date: 16/10/20
 * Time: 下午12:44
 */

use Phalcon\Mvc\Model;
use Phalcon\Di;

class Broadcast extends Model
{
    /**
     * initialize()在每个请求期间只会调用一次
     */
    public function initialize()
    {
        $this->setSource("broadcast"); // 设置对应的数据表
    }

}