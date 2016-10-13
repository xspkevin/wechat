<?php
/**
 * @Desc: 主配置文件
 * @User: xushengping
 * @QQ: 80173997
 * @Email: xspkevin@163.com
 * @Created: 2016-10-13 22:15:30
 */

return array(
    'environment'  => 'development', // 服务器环境(development: 开发环境；test: 测试环境；production: 生产环境)
    'timezone'     => 'Asia/Shanghai', // 时区
    'host'         => 'http://wechat.pengpengkeng.com', // 域名地址(测试)
    'session_max_time' => 36000 * 24, // session会话的保存时间（单位：秒）(测试)

    /*
    'redis' => array(
        // 测试环境
        'default' => array(
            'host' => '127.0.0.1',
            'port' => 6379,
            'database' => 0
        ),
    )*/
);
