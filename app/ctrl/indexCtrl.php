<?php
/**
 * Created by PhpStorm.
 * User: wjm
 * Date: 17-7-1
 * Time: 下午10:02
 */
namespace app\ctrl;
use \core\lib\imooc;
class indexCtrl extends imooc{
    public function  index() {
       /*$mysql = new \core\lib\model();
       $sql ='select * from users';
       echo $sql;
       $ret = $mysql ->query($sql);
       dd($ret -> fetchAll());*/
       /*$data = $this -> getPararm();
        $this -> assign('ids',$data);
       $this -> assign('id',$data);
       $this -> display('index/index.html');*/
        /*$action = \core\lib\config::get('config');
        dd($action);*/
        /*dump($_SERVER);*/

        /*echo $this->blade->render("index",['data' => ['1','2']]);
       dd($_SERVER);
       $user = $this -> M('user');
       $id = $this -> getPararm();
       $data = $user ->group('parea') -> having('id = 20') -> find();
       dd($data);*/
        /*$post = $this -> M('post');
        $data = $post -> findAll();
        dd($data);*/
       // dd(1);
    }
    public function dex() {
       dd( $this-> getPararm());
    }
}