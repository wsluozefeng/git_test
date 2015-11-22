<?php
return array(
	//'配置项'=>'配置值'

    'LOAD_EXT_CONFIG' => 'redis_ext_config, ajia_ext_config',    //加载用户自定义的配置文件，该配置文件是不会被编译缓存的，
    //'APP_STATUS' => 'ajia_debug_config',   //在开启了debug模式之后（也就是APP_DEBUG设置为true），系统默认会调用/thinkPHP/conf/debug.php调试文件(如果在项目配置目录中新增了debug.php文件，则会优先读取该文件)，如果需要使用不同的调试文件，可以在对应的项目配置文件中设置“APP_STATUS”参数，系统就会自动加载

    'LOAD_EXT_FILE' => 'CurlHandle',     //加载项目扩展函数库, 如果只是在个别模块中使用到该函数库，则通过手动加载：load("@.user_common")

    'SHOW_PAGE_TRACE' => true,              //开启页面跟踪信息显示

    //数据库配置
    'DB_TYPE'   => 'mysql',
    'DB_HOST'   => '127.0.0.1',
    'DB_NAME'   => 'thinkphp',
    'DB_USER'   => 'root',
    'DB_PWD'    => '',
    'DB_PORT'   => '',
    'DB_PREFIX' => 'ajia_',

    /*//PDO连接方式
    'DB_TYPE'   => 'pdo', // 数据库类型
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => '', // 密码
    'DB_PREFIX' => '', // 数据库表前缀
    'DB_DSN'    => 'mysql:host=localhost;dbname=test',*/


);
?>