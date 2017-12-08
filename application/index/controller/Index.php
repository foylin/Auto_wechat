<?php
namespace app\index\controller;

use wechat\Autowechat;
use think\Loader;
use think\Controller;
use think\Request;
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
            if($init_post == '1203'){
                return $init_post;    
            }else{
                return $init_post;
                $init_callback = $auto_wechat->wxinit($init_post);
            }
            
            

            // $init_callback['code'] = 200;
            return $init_callback;
        }else{
            return $login_return;
        }
        
    }

    public function test(){
        $content = "window.code=200;window.redirect_uri=\"https://wx.qq.com/cgi-bin/mmwebwx-bin/webwxnewloginpage?ticket=AXMhC-q8hFm1YagQCIfejW0W@qrticket_0&uuid=wYGRJ91k7A==&lang=en_US&scan=1466408041\";";
        $content = explode(";", $content);
        $content = explode("window.redirect_uri=", $content[1]);
        $uri = str_replace("\"","",$content[1]);
        echo $uri;
    }
}
