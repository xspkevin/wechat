<?php
/**
 * @Desc: 控制器基类
 * @User: xushengping
 * @QQ: 80173997
 * @Email: xspkevin@163.com
 * @Created: 2016-10-13 22:25:30
 */

use Phalcon\Mvc\Controller;

class BaseController extends Controller
{
    /**
     * 初始化
     */
    public function initialize()
    {
        $this->view->config = $this->config; // 设置视图的配置项
    }

    public function beforeExecuteRoute()
    {

    }
}