<?php
namespace admin\controller;
use admin\model\User as UserModel;
use framework\Verify;
class User extends Controller
{
	protected $user;
	public function __construct()
	{
		parent::__construct();
		$this->user = new UserModel();
	}
	//修改密码
	public function pass()
	{	
		if (!empty($_POST)) {
			if ($this->user->alter()) {
				$this->notice('修改成功','index.php?m=admin&c=user&a=pass');
			}else{
				$this->notice('修改失败','index.php?m=admin&c=user&a=pass');
			}
		}
		$result =$this->user->pass();
		$this->assign('user', $result);
		$this->display();
	}
	//用户管理
	public function consumer()
	{
		$sid = empty($_GET['sid']) ? '' : $_GET['sid'];
		$cid = empty($_GET['cid']) ? '' : $_GET['cid'];
		if (!empty($sid)) {
			if ($sid==1){
				$this->user->lock();
			} else {
				$this->user->clear();
			}
		}
		if (!empty($cid)) {
				$this->user->udelete();
		}
		if (!empty($_POST)) {
				$this->user->alldelete();
		}
		$result = $this->user->cuser();
		$this->assign('result', $result);
		$this->display();
	}
} 