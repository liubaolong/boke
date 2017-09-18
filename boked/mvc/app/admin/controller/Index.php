<?php
namespace admin\controller;
use admin\model\User;
use admin\model\Blog as BlogModel;
class Index extends Controller
{
	protected $blog;
	public function __construct()
	{
		parent::__construct();
		$this->blog = new BlogModel();
	}
	//后台管理首页
	public function admin()
	{
		$this->assign('title', '后台管理');
		$this->display();
	}
	//站点信息
	public function info()
	{	
		if (!empty($_POST)) {
			if ($this->blog->site()) {
				$this->notice('修改成功','index.php?m=admin&c=index&a=info');
			} else {
				$this->notice('失败成功','index.php?m=admin&c=index&a=info');
			}
		}
		$this->display();
	}
	//留言管理
	public function book()
	{	
		if (!empty($_POST)) {
			if ($this->blog->mdelete())
			{
				echo '删除成功';
			}else{
				echo '删除失败';
			}
		}
		if (isset($_GET['id'])) {
			$this->blog->adelete();
		}
		$res = $this->blog->message();
		$this->assign('message',$res);
		$this->display();
	}
}