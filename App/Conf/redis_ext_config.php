<?php
/**
 *
 * Author: youxi
 * Date:   2015/9/30 10:34
 *  
 */

return array(
    //redis
    'default_redis'=>array(
        'host' => '127.0.0.1',
        'port' => 6379
    ),

    'act_redis'=>array(
        'host' => '127.0.0.1',
        'port' => 6380
    ),

    'redis_key'=>array(
        'hash_page_token_list' => 'hash_page_token_list',  //存放pageToken的hash类型redis
    )
);