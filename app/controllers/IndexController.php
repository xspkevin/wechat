<?php
/**
 * Desc: 默认控制器
 * User: xushengping
 * QQ: 80173997
 * Email: xspkevin@163.com
 * Created: 2016-10-13 22:22:30
 */

use Phalcon\Mvc\View;
use EasyWeChat\Foundation\Application;

class IndexController extends BaseController
{
    /**
     * 初始化
     */
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * 首页
     */
    public function indexAction()
    {
        $options = require_once(APP_PATH . 'app/config/wechat.config.php');

        $app = new Application($options);



        echo 'wechat.pengpengkeng.com';
        exit;
    }
}