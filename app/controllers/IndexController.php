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
    public $wechat_options;
    /**
     * 初始化
     */
    public function initialize()
    {
        $this->view->setTemplateAfter('main'); // 设置视图layout
        $this->wechat_options = require_once(APP_PATH . 'app/config/wechat.config.php');
        parent::initialize();
    }

    /**
     * 首页
     */
    public function indexAction()
    {
        $this->view->nav = 'index';
        $this->view->navtitle = '首页';
        echo $this->view->render('index', 'index');
        exit;
    }

    /**
     * 用户列表
     */
    public function userlistAction()
    {
        $this->view->nav = 'user_list';
        $this->view->navtitle = '用户';

        $app = new Application($this->wechat_options);

        // 获取用户组
        $group = $app->user_group->lists();
        $groups = array();
        if ($group && $group->groups) {
            foreach ($group->groups as $item) {
                $groups[$item['id']] = $item['name'];
            }
        }
        $this->view->groups = $groups;

        // 获取用户
        $userService = $app->user;
        $groupUsers = array();
        $nextOpenId = null;
        $users = $userService->lists($nextOpenId);
        if ($users && isset($users->total) && $users->total > 0) {
            foreach ($users['data']['openid'] as $openid) {
                $groupUsers[] = $openid;
            }
        }
        if ($groupUsers) {
            $this->view->result = $userService->batchGet($groupUsers);
            $this->view->total = $users->total;
        }

        echo $this->view->render('user', 'userlist');
        exit;
    }

    /**
     * 用户组列表
     */
    public function grouplistAction()
    {
        $this->view->nav = 'group_list';
        $this->view->navtitle = '用户组';
        echo $this->view->render('user', 'grouplist');
        exit;
    }

    /**
     * 群发消息
     */
    public function broadcastAction()
    {
        $this->view->nav = 'group_broadcast';
        $this->view->navtitle = '群发消息';
        echo $this->view->render('broadcast', 'list');
        exit;
    }
}