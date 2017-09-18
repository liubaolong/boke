<?php
namespace admin\controller;
use admin\model\Blog as BlogModel;
class Blog extends Controller
{
	protected $blog;
	public function __construct()
	{
		parent::__construct();
		$this->blog = new BlogModel();
	}
	//发博文
	public function add()
	{	
		if (!empty($_POST)) {
			if ($this->blog->Blogger()) {
					$this->notice('发表成功','index.php?m=admin&c=blog&a=add');
			} else {
					$this->notice('发表失败','index.php?m=admin&c=blog&a=add');
			}
		}
		$this->display();	
	}
	//博文管理
	public function list()
	{	
		if (isset($_POST['id'])) {
			if ($this->blog->bdelete())
			{
				echo '删除成功';
			} else {
				echo '删除失败';
			}
		}
		if (isset($_GET['id'])){
			$this->blog->abdelete();
		}
		$vid = empty($_GET['vid']) ? '' : $_GET['vid'];
		if (empty($vid)) {
			$res = $this->blog->blist();
		} else {
			$res = $this->blog->sousuo();
		}
		$this->assign('result',$res);
		$this->display();
	}
	//回收站
	public function rubbish()
	{	
		if (isset($_GET['did'])) {
			if ($res = $this->blog->alldel()) {
				echo '删除成功';
			} else {
				echo '删除失败';
			} 
		} else {
			if (isset($_POST['id'])) {

				if ($this->blog->rdelete()) {
					echo '恢复成功';
				} else {
					echo '回复失败';
				}
			}
		}
		if (isset($_GET['id'])) {
			$this->blog->ardelete();
		}
	
			$res = $this->blog->brubbish();
		
		$this->assign('result',$res);
		$this->display();
	}
}	