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
/* ------------------------------------------------------------------------------------- */

$router->mount($defaultGroup); // 挂载路由组
return $router; // 返回路由实例