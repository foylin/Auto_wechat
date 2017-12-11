<?php
namespace app\index\controller;

use wechat\Autowechat;
use think\Loader;
use think\Controller;
use think\Request;
use think\Session;
class Index extends Controller
{
	private $uuid = '';
    public function index()
    {
        // Loader::import('wechat.Autowechat',EXTEND_PATH);
        // Loader::import('wechat.Autowechat', EXTEND_PATH);
        // include(EXTEND_PATH.'wechat\Autowechat.php');
        // dump(EXTEND_PATH);
        // vendor('wechat.Autowechat');
        $auto_wechat = new Autowechat();
        
        $uuid = $auto_wechat->get_uuid();
        $this->uuid = $uuid;
        $qrcode = $auto_wechat->qrcode($uuid);
        // echo $qrcode;
        // return view();
        // dump($uuid);
        $this->assign('uuid', $uuid);
        $this->assign('qrcode', $qrcode);
        return $this->fetch();
    }

    public function login(){
        $request = request::instance();
        $uuid = $request->param('uuid');
        if(!$uuid){
            return 0;
        }
    	$auto_wechat = new Autowechat();
    	$login_return = $auto_wechat->login($uuid);
        if($login_return['code'] == 200){
            // return $login_return;
            // 获取登录参数（uin、skey、sid、pass_ticket）
            $login_callback = $auto_wechat->get_uri($login_return['redirect_uri']);
            // return $login_callback;

            //获取初始化信息（账号头像信息、聊天好友、阅读等）
            $init_post = $auto_wechat->post_self($login_callback);
            Session::set('init_post', $init_post);
            return $init_post;
            // if($init_post == '1203'){
            //     return $init_post;    
            // }else{
            //     // return $init_post;
            //     $init_callback = $auto_wechat->wxinit($init_post);
            // }
            
            // $init_callback = json_decode($init_callback, true);

            // // $init_callback['code'] = 200;
            // return $init_callback;
        }else{
            return $login_return;
        }
        
    }

    // 初始化微信
    public function wxinit(){
        $r = input('get.r');
        $init_post = Session::get('init_post');
        $auto_wechat = new Autowechat();
        $init_callback = $auto_wechat->wxinit($init_post, $r);
        Session::set('init_login', $init_callback);
        // $init_callback = json_decode($init_callback, true);
        return $init_callback;
    }

    public function test(){
        // $content = "window.code=200;window.redirect_uri=\"https://wx.qq.com/cgi-bin/mmwebwx-bin/webwxnewloginpage?ticket=AXMhC-q8hFm1YagQCIfejW0W@qrticket_0&uuid=wYGRJ91k7A==&lang=en_US&scan=1466408041\";";
        // $content = explode(";", $content);
        // $content = explode("window.redirect_uri=", $content[1]);
        // $uri = str_replace("\"","",$content[1]);
        // $init_post = 123;
        // $post = new \stdClass;
        //     // $Ret = $callback['Ret'];
        //     // $status = $Ret['ret'];
        // $post->skey = 1;

        //         $post->pass_ticket = 2;

        //         $post->sid = 3;

        //         $post->uin = 4;
        // Session::set('init_post', $post);
        // $auto_wechat = new Autowechat();
        // $init_post = Session::get('init_post');
        // $init_callback = $auto_wechat->wxinit($init_post);
        // $init_callback = json_decode($init_callback, true);
        // dump($init_callback);

        $init_login = Session::get('init_login');
        $init_login = json_decode($init_login, true);
        // dump(Session::get());
        dump($init_login);
    }
}
