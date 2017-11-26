<?php
namespace app\index\controller;

use wechat\Autowechat;
use think\Loader;
use think\Controller;
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
        $this->assign('qrcode', $qrcode);
        return $this->fetch();
    }

    public function login(){
    	$auto_wechat = new Autowechat();
    	$login_return = $auto_wechat->login($this->uuid);

    }
}
