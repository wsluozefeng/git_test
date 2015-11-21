<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {


    public function index(){

        echo "ggggg7987";exit;

        $redis = CacheRedisGroup::getInstance('act_redis');
        $tmp = $redis->set('my_name', '456');
        $rel = $redis->get('my_name');
        var_dump($rel);
        exit;

        $redis = Cache::getInstance( 'redis' );
        $tmp = $redis->set('ajia_name123', '852');
        $rel = $redis->get('ajia_name123');
        var_dump($rel);
        exit;

        //$me = new UnionDeductionModel();
        $me = D("User");        //D方法，当查找不到用户自定义的User模型时候，会在底层自动切换成M方法去寻找基础模型
        $where = array('id' => 4);
        $where2 = 'id = 5';
        $rel = $me->where($where2)->select();
        print_r($rel);
        exit;

        $config['user_id'] = 1;
        $config['user_type'] = 1;
        C($config,'name123');

        //print_r( C('','name123') );

        /*echo date("Y-m-d");

        exit('runtimesdfsdfsdfsdfasdfasdfasdfsadf');*/
        //echo U('Index/user');  //生产url

        //load("@.user_common");  //动态加载项目扩展的函数库
        //userDemo();
        //exit;

        //数据库的curd操作=========================================

        //表名可以使用驼峰命名方式
        /*$data = M("sgoods_info")->select();
        $data = M("SgoodsInfo")->select();
        dump($data);exit;*/

        //add 插入操作
        $data = array('id'=>11, 'name'=>'me22222');
        $dataArr = array(
            array('id'=>null, 'name'=>'xiaohong123'),
            array('id'=>null, 'name'=>'xiaoming123'),
            array('id'=>null, 'name'=>'xiaogang123')
        );
        //$id   = M("user")->add($data);   //如果存在自增的字段，则返回该自增的最新值
        //$id   = M("user")->addAll($dataArr);
        //echo M()->getLastSql();           //获取最后一次执行的sql语句

        //select 查询操作，通过where函数查找：1.直接字符串查找， 2.数组形式， 3.表达式查询, 4.区间查询， 5.混合查询

        //直接字符串查询
        //$data = M('user')->where("id=2")->select();

        //数组形式查询
        //$where = array('id'=>2, 'name'=>'youxi');     //默认是and的操作
        //$where['_logic'] = 'or';                      //修改条件成为or的关系
        //$data = M('user')->where($where)->select();

        //表达式查询
        //$where = array('id' => array( 'gt', 10 ));        //查找id大于10的数据，类似的有eq、neq、lt等等
        //$where = array('id' => array( 'between', "1,3" ));
        //$where = array('id' => array( 'not in', "1,10" ));
        //$where = array('name' => array( 'like', "%xiao%" ));
        //$where = array('name' => array( 'like', array("%xiao%","youxi") ));  //`name` LIKE '%xiao%' OR `name` LIKE 'youxi'

        //区间查询，id > 10 or id < 3,  无法使用“_logic”来修改关系
        //$where = array('id' => array(array( 'gt', 10 ), array('lt', 3), 'or'));

        //混合查询
        //$where = array('id' => array( 'gt', 10 ));  //混合用法，默认是and的，使用_logic修改
        //$where['_logic'] = 'or';
        //$where['_string'] = " name like '%ming%' ";

        //$data = M('user')->where($where)->select();

        //统计查询：count、sum、avg、max、min
        //$data = M('user')->count();
        //$data = M('user')->sum('id');
        //$data = M('user')->max('id');
        //$data = M('user')->min('id');


        //update操作
        /*$where['id'] = array('in', '2,3');
        $data = M('user')->where($where)->select();
        dump($data);

        $newData['name'] = "ling_ajia";
        M('user')->where($where)->save($newData);  //更新操作
        $data = M('user')->where($where)->select();
        dump($data);*/

        //$where['id'] = array('in', '2,3');
        //$ajia = M('user')->where($where)->delete();  //M('user')->delete('主键的值'); //直接使用delete时候，其参数只能是主键的值


        //order操作,order('id desc, score asc');
        //$data = M('user')->order('id desc')->select();

        //field字段获取：field($string, $bool)  $string 多个值使用英文逗号隔开， $bool:true或false，取除了$string参数之外的字段, 默认是false
        //$data = M('user')->field('update_time')->select();

        //limit限制：limit(start, offset);
        //$data = M('user')->limit(1,3)->select();

        //page分页：page(第几页，每页多少条数据=20)
        //$data = M('user')->page(1,2)->select();  //每页2条数据，取第一页

        //group操作
        //$data = M('user')->field( 'score, count(score) as total' )->group('score')->having('total>1')->select();  //每种分数的总数, 切总数>1

        //多表查询
        //第一种：table(array('表名1'=>'别名','表名2'=>'别名'))  //这里的表名需要加前缀
        //$data = M()->table(array('user'=>'u', 'sex'=>'s'))->field('u.id,u.name,s.sex')->where('u.id=s.uid')->select();

        //第二种：join()：支持字符串和数组形式，默认是left join
        //$data = M('user')->join('sex on user.id = sex.uid')->select();
        //$data = M('user')->join('right join sex on user.id = sex.uid')->select();  //right join
        //$data = M('user')->join( array('right join sex on user.id = sex.uid', 'right join age on user.id = age.uid' ) )->select();

        //dump($data);



        /*//1. 实例化 基础模型 =========================================
        //$user = new Model("user");
        $user = M("User");  //是 new Model("user")的简便方法， 直接操作user表,其中表名第一个字母不区分大小写
        $data = $user->select();

        //2. 实例化 用户自定义模型， 在 项目目录/Lib/Model/ 创建，必须以Model.class.php结尾
        //$me = new UserModel();
        $me = D("User");        //D方法，当查找不到用户自定义的User模型时候，会在底层自动切换成M方法去寻找基础模型
        $me->demo();

        //3. 实例化 空模型 直接运行行sql语句 (可以用于很复杂的sql语句)
        $user = M();
        //$data = $user->query("select * from demo where id = 4");                //query只能执行查询语句
        //$user->execute("insert into user value (null, 'ruohua')");    //execute只能执行操作语句：insert、update等
        dump($data);

        exit;*/


        //调试方法 =========================================
        //trace("ext_name", C("name"));  //通过trace函数跟踪得出其值
        //dump($_SERVER);                //dump是thinkphp对于原生var_dump的扩展
        //获取运行时间，以毫秒为单位
        /*G("run");
        for($i=0; $i<1000000; $i++){}
        echo G("run", "end");*/

        //模板标签的举例使用 =========================================
        $num = 25;
        //$num = 'ajia';

        $userInfo = array(
            array('id'=>1, 'name'=>'ajia', 'age'=>11),
            array('id'=>2, 'name'=>'youxi', 'age'=>88),
            array('id'=>99, 'name'=>'xiaotou', 'age'=>20),
        );

        //$tmp = "1,2,3,4,5,10";   //todo 变量在thinkphp的模板中标签调用是可以直接使用$tmp的形式加载
        $tmp = "ajia,youxi.xiaotou";

        $this->assign('num', $num)->assign('userInfo', $userInfo)->assign('tmp', $tmp);
        $this->display();

        //$tmp = C("LOG_LEVEL");
        //var_dump($tmp);
        //$this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p></div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }


    /**
     * 控制器自带的空操作方法：控制器中不存在的方法都会调用该方法
     * @param string $actName 方法名
     */
    public function _empty( $actName ){
        echo $actName;
    }

    public function buy(){
        $this->display();

    }

    public function pay(){

        Vendor('PayPal.autoload');
        $paypal = new \PayPal\Rest\ApiContext( new PayPal\Auth\OAuthTokenCredential( 'Aalk1zwrOeUI45sYG6kVWJlaFpRQ9WM6zIGfc8mWd1XBrwu8MdfD-c7r8j6MuzuqBgpWtmA1DbkgkWxg', 'EGpXWlOFXS8B3MDwtn3rCtFMtz5sODXo6x6jq3bSh-sSW5kWNCpupFv09ivfCYYLsIyWMG1CzvDYz53S' ) );
        $paymentID = $_GET['paymentId'];
        $payerId = $_GET['PayerID'];

        $payment = PayPal\Api\Payment::get($paymentID, $paypal);

        $execute = new PayPal\Api\PaymentExecution();
        $execute->setPayerId($payerId);

        try{
            $result = $payment->execute($execute, $paypal);
            print_r($result);
        }catch(Exception $e){
            die($e);
        }

        echo "<hr>";
        echo '支付成功！感谢支持!';
        echo "<hr>";
        print_r($_REQUEST);
        exit;
    }

    public function indexBak(){

        define(SITE_URL,'http://localhost/thinkphp313');

        Vendor('PayPal.autoload');
        $paypal = new \PayPal\Rest\ApiContext( new PayPal\Auth\OAuthTokenCredential( 'Aalk1zwrOeUI45sYG6kVWJlaFpRQ9WM6zIGfc8mWd1XBrwu8MdfD-c7r8j6MuzuqBgpWtmA1DbkgkWxg', 'EGpXWlOFXS8B3MDwtn3rCtFMtz5sODXo6x6jq3bSh-sSW5kWNCpupFv09ivfCYYLsIyWMG1CzvDYz53S' ) );

        $product = 'CK-秋款牛仔裤';
        $price = 1.9;
        $shipping = 2.00; //运费

        $total = $price + $shipping;

        $payer = new PayPal\Api\Payer();
        $payer->setPaymentMethod('paypal');

        $item = new PayPal\Api\Item();
        $item->setName($product)
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($price);

        $itemList = new PayPal\Api\ItemList();
        $itemList->setItems([$item]);

        $details = new PayPal\Api\Details();
        $details->setShipping($shipping)
            ->setSubtotal($price);

        $amount = new PayPal\Api\Amount();
        $amount->setCurrency('USD')
            ->setTotal($total)
            ->setDetails($details);

        $transaction = new PayPal\Api\Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("支付描述内容")
            ->setInvoiceNumber(uniqid());

        $redirectUrls = new PayPal\Api\RedirectUrls();
        /*$redirectUrls->setReturnUrl(SITE_URL . '/pay.php?success=true')
            ->setCancelUrl(SITE_URL . '/pay.php?success=false');*/
        $redirectUrls->setReturnUrl(SITE_URL . '/index.php?m=Index&a=pay&success=true')
            ->setCancelUrl(SITE_URL . '/index.php?m=Index&a=pay&success=false');

        $payment = new PayPal\Api\Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions([$transaction]);

        try {
            $payment->create($paypal);
        } catch (PayPal\Exception\PayPalConnectionException $e) {
            echo $e->getData();
            die();
        }

        $approvalUrl = $payment->getApprovalLink();
        header("Location: {$approvalUrl}");



        exit;



        $redis = CacheRedisGroup::getInstance('act_redis');
        $tmp = $redis->set('my_name', '456');
        $rel = $redis->get('my_name');
        var_dump($rel);
        exit;

        $redis = Cache::getInstance( 'redis' );
        $tmp = $redis->set('ajia_name123', '852');
        $rel = $redis->get('ajia_name123');
        var_dump($rel);
        exit;

        //$me = new UnionDeductionModel();
        $me = D("User");        //D方法，当查找不到用户自定义的User模型时候，会在底层自动切换成M方法去寻找基础模型
        $where = array('id' => 4);
        $where2 = 'id = 5';
        $rel = $me->where($where2)->select();
        print_r($rel);
        exit;

        $config['user_id'] = 1;
        $config['user_type'] = 1;
        C($config,'name123');

        //print_r( C('','name123') );

        /*echo date("Y-m-d");

        exit('runtimesdfsdfsdfsdfasdfasdfasdfsadf');*/
        //echo U('Index/user');  //生产url

        //load("@.user_common");  //动态加载项目扩展的函数库
        //userDemo();
        //exit;

        //数据库的curd操作=========================================

        //表名可以使用驼峰命名方式
        /*$data = M("sgoods_info")->select();
        $data = M("SgoodsInfo")->select();
        dump($data);exit;*/

        //add 插入操作
        $data = array('id'=>11, 'name'=>'me22222');
        $dataArr = array(
            array('id'=>null, 'name'=>'xiaohong123'),
            array('id'=>null, 'name'=>'xiaoming123'),
            array('id'=>null, 'name'=>'xiaogang123')
        );
        //$id   = M("user")->add($data);   //如果存在自增的字段，则返回该自增的最新值
        //$id   = M("user")->addAll($dataArr);
        //echo M()->getLastSql();           //获取最后一次执行的sql语句

        //select 查询操作，通过where函数查找：1.直接字符串查找， 2.数组形式， 3.表达式查询, 4.区间查询， 5.混合查询

        //直接字符串查询
        //$data = M('user')->where("id=2")->select();

        //数组形式查询
        //$where = array('id'=>2, 'name'=>'youxi');     //默认是and的操作
        //$where['_logic'] = 'or';                      //修改条件成为or的关系
        //$data = M('user')->where($where)->select();

        //表达式查询
        //$where = array('id' => array( 'gt', 10 ));        //查找id大于10的数据，类似的有eq、neq、lt等等
        //$where = array('id' => array( 'between', "1,3" ));
        //$where = array('id' => array( 'not in', "1,10" ));
        //$where = array('name' => array( 'like', "%xiao%" ));
        //$where = array('name' => array( 'like', array("%xiao%","youxi") ));  //`name` LIKE '%xiao%' OR `name` LIKE 'youxi'

        //区间查询，id > 10 or id < 3,  无法使用“_logic”来修改关系
        //$where = array('id' => array(array( 'gt', 10 ), array('lt', 3), 'or'));

        //混合查询
        //$where = array('id' => array( 'gt', 10 ));  //混合用法，默认是and的，使用_logic修改
        //$where['_logic'] = 'or';
        //$where['_string'] = " name like '%ming%' ";

        //$data = M('user')->where($where)->select();

        //统计查询：count、sum、avg、max、min
        //$data = M('user')->count();
        //$data = M('user')->sum('id');
        //$data = M('user')->max('id');
        //$data = M('user')->min('id');


        //update操作
        /*$where['id'] = array('in', '2,3');
        $data = M('user')->where($where)->select();
        dump($data);

        $newData['name'] = "ling_ajia";
        M('user')->where($where)->save($newData);  //更新操作
        $data = M('user')->where($where)->select();
        dump($data);*/

        //$where['id'] = array('in', '2,3');
        //$ajia = M('user')->where($where)->delete();  //M('user')->delete('主键的值'); //直接使用delete时候，其参数只能是主键的值


        //order操作,order('id desc, score asc');
        //$data = M('user')->order('id desc')->select();

        //field字段获取：field($string, $bool)  $string 多个值使用英文逗号隔开， $bool:true或false，取除了$string参数之外的字段, 默认是false
        //$data = M('user')->field('update_time')->select();

        //limit限制：limit(start, offset);
        //$data = M('user')->limit(1,3)->select();

        //page分页：page(第几页，每页多少条数据=20)
        //$data = M('user')->page(1,2)->select();  //每页2条数据，取第一页

        //group操作
        //$data = M('user')->field( 'score, count(score) as total' )->group('score')->having('total>1')->select();  //每种分数的总数, 切总数>1

        //多表查询
        //第一种：table(array('表名1'=>'别名','表名2'=>'别名'))  //这里的表名需要加前缀
        //$data = M()->table(array('user'=>'u', 'sex'=>'s'))->field('u.id,u.name,s.sex')->where('u.id=s.uid')->select();

        //第二种：join()：支持字符串和数组形式，默认是left join
        //$data = M('user')->join('sex on user.id = sex.uid')->select();
        //$data = M('user')->join('right join sex on user.id = sex.uid')->select();  //right join
        //$data = M('user')->join( array('right join sex on user.id = sex.uid', 'right join age on user.id = age.uid' ) )->select();

        //dump($data);



        /*//1. 实例化 基础模型 =========================================
        //$user = new Model("user");
        $user = M("User");  //是 new Model("user")的简便方法， 直接操作user表,其中表名第一个字母不区分大小写
        $data = $user->select();

        //2. 实例化 用户自定义模型， 在 项目目录/Lib/Model/ 创建，必须以Model.class.php结尾
        //$me = new UserModel();
        $me = D("User");        //D方法，当查找不到用户自定义的User模型时候，会在底层自动切换成M方法去寻找基础模型
        $me->demo();

        //3. 实例化 空模型 直接运行行sql语句 (可以用于很复杂的sql语句)
        $user = M();
        //$data = $user->query("select * from demo where id = 4");                //query只能执行查询语句
        //$user->execute("insert into user value (null, 'ruohua')");    //execute只能执行操作语句：insert、update等
        dump($data);

        exit;*/


        //调试方法 =========================================
        //trace("ext_name", C("name"));  //通过trace函数跟踪得出其值
        //dump($_SERVER);                //dump是thinkphp对于原生var_dump的扩展
        //获取运行时间，以毫秒为单位
        /*G("run");
        for($i=0; $i<1000000; $i++){}
        echo G("run", "end");*/

        //模板标签的举例使用 =========================================
        $num = 25;
        //$num = 'ajia';

        $userInfo = array(
            array('id'=>1, 'name'=>'ajia', 'age'=>11),
            array('id'=>2, 'name'=>'youxi', 'age'=>88),
            array('id'=>99, 'name'=>'xiaotou', 'age'=>20),
        );

        //$tmp = "1,2,3,4,5,10";   //todo 变量在thinkphp的模板中标签调用是可以直接使用$tmp的形式加载
        $tmp = "ajia,youxi.xiaotou";

        $this->assign('num', $num)->assign('userInfo', $userInfo)->assign('tmp', $tmp);
        $this->display();

        //$tmp = C("LOG_LEVEL");
        //var_dump($tmp);
	    //$this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p></div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }




}