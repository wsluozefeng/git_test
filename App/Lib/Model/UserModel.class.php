<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/7/13
 * Time: 11:11
 */

class UserModel extends Model{

    public function demo(){
        $tmp = $this->select();
        print_r($tmp);
        /*$user = M("demo");
        $data = $user->select();
        dump($data);*/
        //echo time();
    }
}