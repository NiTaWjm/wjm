<?php
/**
 * Created by PhpStorm.
 * User: wjm
 * Date: 17-7-1
 * Time: 下午3:24
 */
namespace core\lib;
use  duncan3dc\Laravel\BladeInstance;
class imooc {
    /*
     *
     * 总的控制器类
     *
     */
    public static $classMap = array();//，类包
    protected $pararm;//参数
    protected $assign;
    protected $blade;

    static public function run()
    {
        $route = new \core\lib\route();

        $action = $route -> action;
        $method = $route -> method;


        $actionPath = APP.'/ctrl/'.$action.'Ctrl.php';
        if (is_file($actionPath)) {
            include $actionPath;
            $class = '\app\ctrl\\'.$action.'Ctrl';
            if (class_exists( $class)) {
                $app = new $class;
            } else {
                throw new \Exception('控制器错误'.$action);
            }
            if (method_exists( $app ,$method)) {
                $app -> $method();
            }else{
                throw new \Exception('方法错误');
            }
        }else {
            throw new \Exception('控制器错误'.$action);
        }

        echo ('ok');
    }
    /*
     *
     * 自动加载列库
     */
    static public function load($class)
    {
        $class = str_replace('\\','/',$class);
        if (isset(self::$classMap[$class])) {
            return true;
        } else {
            $file = IMOOC .'/' . $class . '.php';
            if (is_file( $file)) {
                include  $file;
                self::$classMap[$class] = $class;

            } else {
               echo '包含文件失败';
            }
        }
    }

    /**获取参数
     * @return null
     *
     */
    public function getPararm() {
        $route = new \core\lib\route();
        return $route ->getPararm();
    }

    public function assign($name,$value) {
        $this -> assign[$name] = $value;
    }

    public function display($file)
    {
        $file =  APP.'/view/'.$file;
        if (!is_file($file)) {
            throw new \Exception('视图文件不存在'.$file);
        } else {
            extract($this -> assign);
            include $file;
        }
    }

    public function __construct()
    {
        $blade = new BladeInstance("/opt/lampp/htdocs/tp/app/view", "/opt/lampp/htdocs/tp/app/cache/view");
        $this -> blade = $blade;
    }

    public function M($table) {
        $table = '\app\model\\'.$table;
        $model = new $table();
        return $model;
    }

}