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
        $this->wechat_options = require_once(APP_PATH . 'app/config/wechat.config.php');
        parent::initialize();
    }

    /**
     * 首页
     */
    public function indexAction()
    {
        $this->view->setTemplateAfter('main'); // 设置视图layout
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
        $this->view->setTemplateAfter('main'); // 设置视图layout
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
     * 用户分组
     */
    public function usertogroupAction()
    {
        if (isset($_POST['groupid']) && isset($_POST['openid'])) {
            $groupid = $_POST['groupid'];
            $openid = $_POST['openid'];
            if ($groupid && $openid)
            {
                $openidArr = explode(',', $openid);
                $app = new Application($this->wechat_options);
                $group = $app->user_group;
                $group->moveUsers($openidArr, $groupid);
                $response = array('errcode' => 0, 'msg' => 'success');
            } else {
                $response = array('errcode' => 1, 'msg' => '操作失败！');
            }
            header("Content-type: application/json");
            echo json_encode($response);
            exit;
        }
    }

    /**
     * 用户组列表
     */
    public function grouplistAction()
    {
        $this->view->setTemplateAfter('main'); // 设置视图layout
        $this->view->nav = 'group_list';
        $this->view->navtitle = '用户组';

        // 获取用户组
        $app = new Application($this->wechat_options);
        $group = $app->user_group;
        $this->view->groups = $group->lists();

        echo $this->view->render('user', 'grouplist');
        exit;
    }

    /**
     * 用户组编辑
     */
    public function groupeditAction()
    {
        header("Content-type: application/json");
        if (isset($_POST['group_id']) && isset($_POST['group_name'])) {
            $group_id = $_POST['group_id'];
            $group_name = $_POST['group_name'];
            if (trim($group_name) == '') {
                $response = array('errcode' => 1, 'msg' => '请输入用户组名称！');
            } else {
                $app = new Application($this->wechat_options);
                $group = $app->user_group;
                if ($group_id) // 编辑
                {
                    $group->update($group_id, $group_name);
                } else { // 添加
                    $group->create($group_name);
                }
                $response = array('errcode' => 0, 'msg' => 'success');
            }
            echo json_encode($response);
            exit;
        }
    }

    /**
     * 删除用户组
     */
    public function groupdelAction()
    {
        header("Content-type: application/json");
        if (isset($_POST['group_id'])) {
            $group_id = $_POST['group_id'];
            $app = new Application($this->wechat_options);
            $group = $app->user_group;
            $group->delete($group_id);
            $response = array('errcode' => 0, 'msg' => 'success');
            echo json_encode($response);
            exit;
        }
    }

    /**
     * 群发消息列表
     */
    public function broadcastAction()
    {
        $this->view->setTemplateAfter('main'); // 设置视图layout
        $this->view->nav = 'group_broadcast';
        $this->view->navtitle = '群发消息';

        $app = new Application($this->wechat_options);

        // 获取用户组
        $group = $app->user_group->lists();
        $groups = array();
        if ($group && $group->groups) {
            foreach ($group->groups as $item) {
                $groups[$item['id']] = $item['name'] . ' (' . $item['count'] . ')';
            }
        }
        $this->view->groups = $groups;

        $broadcast = new Broadcast();
        $this->view->result = $broadcast::find(array('order' => 'created_at DESC'));

        echo $this->view->render('broadcast', 'list');
        exit;
    }

    /**
     * 群发消息
     */
    public function groupsendAction()
    {
        header("Content-type: application/json");
        if (isset($_POST['group_id']) && isset($_POST['content'])) {
            $group_id = $_POST['group_id'];
            $content = $_POST['content'];
            if (trim($content) == '') {
                $response = array('errcode' => 1, 'msg' => '请输入要发送的内容！');
            } else {
                $app = new Application($this->wechat_options);

                // 发送消息
                $broadcast = $app->broadcast;
                $broadcast->sendText($content, $group_id);

                // 获取用户组
                $group = $app->user_group->lists();
                $group_name = '';
                $count = 0;
                if ($group && $group->groups) {
                    foreach ($group->groups as $item) {
                        if ($item['id'] == $group_id) {
                            $group_name = $item['name'];
                            $count = $item['count'];
                            break;
                        }
                    }
                }

                // 保存在数据库
                $broadcast = new Broadcast();
                $broadcast->group_id = intval($group_id);
                $broadcast->group_name = $group_name;
                $broadcast->message = trim($content);
                $broadcast->count = $count;
                $broadcast->created_at = date('Y-m-d H:i:s');
                $broadcast->save();

                // 返回结果
                $response = array('errcode' => 0, 'msg' => 'success');
            }
            echo json_encode($response);
            exit;
        }
    }

    /**
     * 删除群发消息
     */
    public function broadcastdelAction(){
        header("Content-type: application/json");
        if (isset($_POST['id'])) {

            $broadcast = new Broadcast();
            $row = $broadcast->findFirst('broadcast_id=' . intval($_POST['id']));
            $row->delete();

            $response = array('errcode' => 0, 'msg' => 'success');
            echo json_encode($response);
            exit;
        }
    }
}