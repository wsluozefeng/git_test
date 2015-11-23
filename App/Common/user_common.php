<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/7/13
 * Time: 15:23
 *
 * 项目扩展函数库，不会自动加载，加载方式：1.在项目配置文件config.php中通过“LOAD_EXT_FILE”参数引入，2.在需要的地方，通过load(@.user_common);引入
 *
 */

function userDemo(){
    print_r($_SERVER);
}