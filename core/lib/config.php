<?php
/**
 * Created by PhpStorm.
 * User: wjm
 * Date: 17-7-2
 * Time: 下午2:53
 */
namespace core\lib;
class config {
    public static $config;

    static public function get($file, $name = '')
    {
        /**
         *
         * 1.判端配置文件是不是存在
         * 2.配置存不存在
         * 3.缓存配置
         */
        if (isset(self::$config[$file])) {
            return self::$config[$file];
        } else {
            $file = CORE . '/config/' . $file . '.php';
            if (is_file($file)) {
                $config = include $file;
                self::$config = $config;
                if (empty($name)) {
                    return self::$config;
                } else {
                    return self::$config[$name];
                }
            } else {
                throw new \Exception('找不到配置文件' . $file);
            }
        }

    }
}