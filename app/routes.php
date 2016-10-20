<?php
/**
 * @Desc: 配置路由
 * @User: xushengping
 * @QQ: 80173997
 * @Email: xspkevin@163.com
 * @Created: 2016-10-13 22:19:30
 */

use Phalcon\Mvc\Router;
use Phalcon\Mvc\Router\Group as RouterGroup;

$router = new Router();
$defaultGroup = new RouterGroup();

/* ------------------------------------------------------------------------------------- */
$defaultGroup->add('/', ['controller' => 'index', 'action' => 'index']); // 首页
$defaultGroup->add('/signin', ['controller' => 'member', 'action' => 'signin']); // 登录
$defaultGroup->add('/logout', ['controller' => 'member', 'action' => 'logout']); // 登出
$defaultGroup->add('/user/list', ['controller' => 'index', 'action' => 'userlist']); // 用户列表
$defaultGroup->add('/user/group/list', ['controller' => 'index', 'action' => 'grouplist']); // 用户组列表
$defaultGroup->add('/user/user_to_group', ['controller' => 'index', 'action' => 'usertogroup']); // 用户分组
$defaultGroup->add('/user/group_edit', ['controller' => 'index', 'action' => 'groupedit']); // 编辑用户组
$defaultGroup->add('/user/group_del', ['controller' => 'index', 'action' => 'groupdel']); // 删除用户组
$defaultGroup->add('/broadcast/group/list', ['controller' => 'index', 'action' => 'broadcast']); // 群发消息列表
$defaultGroup->add('/broadcast/group_send', ['controller' => 'index', 'action' => 'groupsend']); // 群发消息
$defaultGroup->add('/broadcast/group_del', ['controller' => 'index', 'action' => 'broadcastdel']); // 删除群发消息
/* ------------------------------------------------------------------------------------- */

$router->mount($defaultGroup); // 挂载路由组
return $router; // 返回路由实例