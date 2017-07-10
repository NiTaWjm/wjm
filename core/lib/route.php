<?php
namespace core\lib;
class route {


    /*
     *
     * 路由加载
     */
    public $ctrl;//入口文件
    public $action;//控制器
    public $method;//方法
    private $pararm;//参数


    public function __construct()
    {
        /*
         *
         * 1.隐藏index.php
         * 2.获取url参数部分
         * 3.返回对应控制器和方法
         */
        if (isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] != '/') {
            /*
             * 解析url
             */
            $path = $_SERVER['REQUEST_URI'];
            $patharr = explode('/', trim($path, '/'));

            $config = new \core\lib\config();

            if (isset($patharr[0])) {
                $this->ctrl = $patharr[0];
                unset($patharr[0]);
            }else {
                throw new \Exception('入口文件错误');
                exit();
            }
            if (isset($patharr[1])) {
                $this->action = $patharr[1];
                unset($patharr[1]);
            } else {
                $this->action = $config->get('config','ACTION');

            }
            if (isset($patharr[2])) {
                $this -> method = $patharr[2];
                unset($patharr[2]);
            } else {
                $this -> method = $config->get('config','METHOD');
            }
            $count = count($patharr) + 3;
            for ($i=3; $i<$count ;$i = $i+2) {
                if (!empty($patharr[$i+1])) {
                    $pararm[$patharr[$i]] = $patharr[$i+1];
                }else {
                   throw new \Exception('参数错误');
                   exit();
                }
            }
            if(!empty($pararm)) {
                $this -> pararm = $pararm;
            }else {
                $this -> pararm = null;
            }
        } else {

        }
    }
    public function getPararm () {
        return $this -> pararm;
    }
}