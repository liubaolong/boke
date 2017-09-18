<?php
namespace index\controller;
use index\model\User as UserModel;
use framework\Verify;
use framework\Ucpaas;
class User extends Controller
{
	protected $user;
	public function __construct()
	{
		parent::__construct();
		$this->user = new UserModel();
	}
	//登录注册
	public function register()
	{
		if (!empty($_POST)) {
			//注册
			if (isset($_POST['newphone'])) {
				$con = $this->user->check($_POST);	
	 			if (!is_array($con)) {
	 				$this->notice('恭喜注册成功','index.php?m=index&c=user&a=register');
	 			} else {   
	 				$str = join(',', $con);
	 				$str = ltrim($str, ',');
	 				$this->notice($str, 'index.php?m=index&c=user&a=register');
	 			}
			} else {		
			//登录
				$con = $this->user->affrim($_POST);
				if (WEB_CLOSE!='false') {
					if(empty($con[1])){
						$this->notice('登录成功 ','index.php');
					} else {
						$str = join(',', $con);
		 				$str = ltrim($str, ',');
						$this->notice('登录失败' . $str,'index.php?m=index&c=user&a=register');
						}
				} else {
					if (!empty($_SESSION['user'])) {
						if (!empty($_SESSION['undertype'])) {

							$_SESSION=array();
							
							$this->notice('欢迎管理员','index.php?m=admin&c=index&a=admin');
						} else {
							$_SESSION=array();
							$this->notice('本站只允许管理员登录','index.php?m=index&c=user&a=register');
						}
					} else {
						$this->notice('未登录','index.php?m=index&c=user&a=register');
					}
				}
			}
		} else {
			$this->assign('title', '登录');
			$this->display('register.html');

		}
	}
	//调用验证码
	public function codeimg()
	{
		$code = Verify::ver();	
	}
	public function retrieve()
	{
		$this->assign('title','找回密码');
		$this->display();
	}
	public function affirm()
	{
		$id = empty($_GET['id'])? '' : $_GET['id'];
		if (!empty($_POST)) {
			if (empty($id)) {
				if (!is_array($this->user->checkname())) {
					$this->notice('用户不存在或手机号错误','index.php?m=index&c=user&a=retrieve');
				}	
			} else {
				if ($this->user->reset()) {
					$this->notice('修改成功','index.php?m=index&c=user&a=register');
				} else {
					$this->notice('两次密码不一致','index.php?m=index&c=user&a=affirm');
				}
			}
		}
		$this->assign('title','重置密码');
		$this->display();
	}
	public function dosafety()
	{
	    //初始化必填
	    $options['accountsid']='01bf8da4162f5f46fbcae857d8edb55a';
	    $options['token']='755ae3c916038dc6bf76a00cb96e8b2d';
	    $str = '12345678900987654321';
	    $str1 = substr(str_shuffle($str),0,4);
	    //初始化 $options必填
	    $ucpass = new Ucpaas($options);
	    //开发者账号信息查询默认为json或xml
	    //短信验证码（模板短信）,默认以65个汉字（同65个英文）为一条（可容纳字数受您应用名称占用字符影响），超过长度短信平台将会自动分割为多条发送。分割后的多条短信将按照具体占用条数计费。
	    $appId = "7237e9c9a7a94c8590316e3ff9d0d250";
	    $to = $_POST['phone'];
	    $templateId = "65220";
	    $param=$str1;
	    echo json_encode(array('notice'=>$str1));
	    // $ucpass->templateSMS($appId,$to,$templateId,$param);
    }
}