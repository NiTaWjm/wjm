<?php
/**
 * Created by PhpStorm.
 * User: wjm
 * Date: 17-7-5
 * Time: 下午8:45
 */
namespace app\ctrl;
use \core\lib\imooc;
use EasyWeChat\Foundation\Application;
class weixinCtrl extends imooc{
    public function index()
    {
        $options = [
            'debug'  => true,
            'app_id' => 'wx7faaaaf990c49a91',
            'secret' => 'c736afb13bce9481410c09183c68a061',
            'token'  => 'link',
            'aes_key' => 'd0VEx1hvK9BwpB0sRo0OlWq9Y8Z5IfCGE8wMPFqL99q', // 可选
            'log' => [
                'level' => 'debug',
                'file'  => '/opt/lampp/htdocs/tp/log/wechat.log',
            ],
        ];
        $app = new Application($options);
        $response = $app->server->serve();
// 将响应输出
        $response->send(); // Laravel 里请使用：return $response;
    }
}