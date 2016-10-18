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
//        $options = require_once(APP_PATH . 'app/config/wechat.config.php');
//
//        $app = new Application($options);
//
//        // 群发消息
//        $broadcast = $app->broadcast;
//
//
//        // 获取所有分组
//        $group = $app->user_group;
//        $result = $broadcast->sendText('河里小鱼游游游 <a href="http://www.baidu.com">点我啊</a>', 100);
//        var_dump($result);exit;
//
//        /*
//        // 创建分组
//        // $group->create('FAE');
//
//        // 删除分组
//        // $group->delete(101);
//
//
//        $groups = $group->lists();
//        echo '<pre>';
//        print_r($groups);
//        exit;
//        */
//
//        // 将响应输出
//        $userService = $app->user;
//        $users = $userService->lists();
//
//        $groupUsers = array();
//        if ($users && isset($users->total) && $users->total > 0) {
//            foreach ($users['data']['openid'] as $openid) {
//                $groupUsers[] = $openid;
//                /*
//                echo $openid . ' ----- ';
//                echo $userService->group($openid)->groupid . '<br />';
//                */
//            }
//        }
//        print_r($groupUsers);
//        $group->moveUsers($groupUsers, 100);
//
//        exit;
    }
}