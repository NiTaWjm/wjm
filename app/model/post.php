<?php
/**
 * Created by PhpStorm.
 * User: wjm
 * Date: 17-7-3
 * Time: 上午11:18
 */
namespace app\model;
class post extends \core\lib\model {

    public $table = 'posts';
    /*
     *
     * 初始化方法声明表的关系
     */
    public function __construct()
    {
        parent::__construct();
        $this -> link('user','user_id','id');
        $this -> link('forum','forum_id','id');
    }


}
