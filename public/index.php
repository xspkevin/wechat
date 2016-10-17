<?php
/**
 * @Desc: 程序入口文件
 * @User: xushengping
 * @QQ: 80173997
 * @Email: xspkevin@163.com
 * @Created: 2016-10-13 22:14:25
 */

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Config;

define('DS', DIRECTORY_SEPARATOR); // 分隔符
define('APP_PATH', realpath('..') . '/');   // 定义APP PATH
$settings = require_once(APP_PATH . 'app/config/config.php');   // 加载配置文件
$config = new Config($settings);

date_default_timezone_set($config->timezone); // 设置时区

// 设置报错级别
if ($config->environment == 'development') { // 开发环境
    error_reporting(E_ALL); // 报告所有错误
    ini_set('display_errors', '1');
} elseif ($config->environment == 'test') {  // 测试环境
    error_reporting(E_ALL); // 报告所有错误
} elseif ($config->environment == 'production') { // 生产环境
    error_reporting(0); // 生产环境禁用错误报告
}

try {
    // Register an autoloader
    $loader = new Loader();
    $loader->registerDirs(array(
        APP_PATH . 'app/controllers/',
        APP_PATH . 'app/models/',
        APP_PATH . 'app/library/',
    ))->register();

    // 定义命名空间
    $loader->registerNamespaces([
        'EasyWechat' => APP_PATH . 'app' . DS . 'library' . DS . 'easywechat' . DS . 'src',
        'EasyWechat\\Foundation' => APP_PATH . 'app' . DS . 'library' . DS . 'easywechat' . DS . 'src' . DS . 'Foundation'
    ])->register();

    // Create a DI
    $di = new FactoryDefault();

    // Setup the view component
    $di->set('view', function () {
        $view = new View();
        $view->setViewsDir(__DIR__ . '/../app/views/'); // 设置视图目录
        $view->setLayoutsDir('layouts/'); // 设置模板目录
        $view->setPartialsDir('layouts/partial/'); // 设置局部模板目录
        return $view;
    });

    // Start the session the first time when some component request the session service
    $di->setShared('session', function() use ($config) {
        $session = new Phalcon\Session\Adapter\Files();
        $lifetime = isset($config->session_max_time) ? $config->session_max_time : 86400;
        $session->start();
        setcookie(session_name(), session_id(), time() + $lifetime, "/");
        return $session;
    });

    $routeFile = APP_PATH . 'app/routes.php';
    if (file_exists($routeFile)) {
        $di->set('router', function() use ($routeFile) {      // 注册路由
            return require_once $routeFile;
        });
    } else {
        Log::error('路由文件缺失：route_path=' . $routeFile, 'core');
    }

    // 设置配置文件
    $di->set('config', $config);

    // 设置缓存
    /*
    $di->set('redis', function () use ($config) {
        return new WeRedis($config->redis->default->toArray());
    });
    */

    // 启动应用
    $application = new Application();
    $application->setDI($di);
    echo $application->handle()->getContent();
} catch (\Exception $e) {
    echo "Exception: ", $e->getMessage();
}