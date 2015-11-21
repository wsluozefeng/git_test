<?php

/**
 * 多实例的redis驱动类（脱离Cache基类）
 * Author: youxi
 * Date:   2015/9/15 17:59
 *
 */
class CacheRedisGroup
{

    protected static $instance = array();
    protected $redis = null;

    public function __construct( $config )
    {

        if ( !extension_loaded( 'redis' ) ) {
            throw new Exception( 'php-redis扩展不存在' );
        }

        $config      = empty( $config ) ? 'default_redis' : $config;
        $redisConfig = C( $config );

        $host = isset( $redisConfig['host'] ) ? $redisConfig['host'] : '127.0.0.1';
        $port = isset( $redisConfig['port'] ) ? $redisConfig['port'] : '6379';
        $pwd  = isset( $redisConfig['auth'] ) ? $redisConfig['auth'] : '';

        try {

            $this->redis = new Redis();
            $this->redis->connect( $host, $port );
            $this->redis->ping();                  //todo redis的connect函数即使连接失败也不会报错，需要ping来验证是否连接成功

        } catch ( Exception $e ) {
            throw new Exception( "redis server connect failed " . json_encode( $redisConfig ) );
        }

        //todo 设置了密码访问
        if ( empty( $pwd ) ) {
            $this->redis->auth( $pwd );
        }

        return $this->redis;

    }

    public static function getInstance( $config = '' )
    {

        if ( !self::$instance[$config] instanceof self ) {
            self::$instance[$config] = new self( $config );
        }

        return self::$instance[$config];
    }

    public function setByLock( $key, $value, $timeOut )
    {
        if ( is_numeric( $timeOut ) && intval( $timeOut ) > 0 ) {
            $timeOut = intval( $timeOut );
            $exp     = time() + $timeOut;
        } else {
            $timeOut = 300;
            $exp     = time() + $timeOut;
        }

        empty( $timeOut ) OR $timeOut += 300;         //todo 增加redis缓存时间，使程序有足够的时间生成缓存（伪造的过期时间）
        $arg = array( "data" => $value, "expire" => $exp );
        $rs  = $this->redis->setex( $key, $timeOut, json_encode( $arg, TRUE ) );
        $this->redis->del( $key . ".lock" );           //todo 需要删除“唯一进程后台拉取新数据”的这个锁，在获取数据的时候才能进行判断是否允许一个进程进行拉取数据
        return $rs;
    }

    public function getByLock( $key )
    {
        $sth = $this->redis->get( $key );                 //todo 缓存伪造的时间（$ttl）过期了（比数据真实的过期时间多了300s），只能去后台拉取数据

        if ( $sth === false ) {
            return $sth;
        } else {
            $sth = json_decode( $sth, TRUE );

            if ( intval( $sth['expire'] ) <= time() ) {   //todo 伪造时间尚未过期的情况下，真实时间（$exp）过期，需要判断是否存在“唯一进程后台拉取新数据”的这个锁，如果存在则表明已经有一个进程在后台拉取新的数据了，其他的进程当前只能使用旧的数据
                $lock = $this->redis->incr( $key . ".lock" );

                if ( $lock === 1 ) {                      //todo 证明该资源有唯一一个进程在拉取新数据从而加锁了
                    return false;
                } else {
                    return $sth['data'];
                }

            } else {                                      //todo 真实的时间未过期，返回当前redis数据即可
                return $sth['data'];
            }
        }
    }

    /**
     * 透明使用redis 原生的方法
     * @param $func
     * @param $params
     * @return mixed
     * @throws Exception
     */
    public function __call( $func, $params )
    {
        if ( method_exists( $this->redis, $func ) ) {
            return call_user_func_array( array( $this->redis, $func ), $params );
        } else {
            throw new Exception( '不存在的方法' );
        }
    }

}