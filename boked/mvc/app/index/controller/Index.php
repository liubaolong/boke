<?php
namespace index\controller;
use index\model\User;
use index\model\Blog as BlogModel;
class Index extends Controller
{
	protected $blog;
	public function __construct()
	{
		parent::__construct();
		$this->blog = new BlogModel();
	}
	//前台首页
	public function index()
	{	
		if (WEB_CLOSE=='false') {
			$this->notice('本站已关闭', 'index.php?m=index&c=user&a=register');
			exit;
		}
		$lid = empty($_GET['lid']) ? '' : $_GET['lid'];
		$oid = empty($_GET['oid']) ? '' : $_GET['oid'];
		if (!empty($oid)) {
			$_SESSION=array();
		}
		if ($lid==1) {

			$this->blog->likes();
		} else {
			$this->blog->collect();
		}	
			$data = $this->blog->BFS();
			$this->assign('collect',$data[3]);
			$this->assign('likes',$data[2]);
			$this->assign('data', $data[1]);
			$this->assign('newdata',$data[0]);
			$this->assign('title', '博客');
			$this->display();
	}
	//留言
	public function insertAc()
	{
		if (!empty($_POST['info'])) {
			if ($this->blog->message()) {
				$this->notice('留言成功','index.php?m=index&c=index&a=insertAc');
			} else {
				$this->notice('留言失败','index.php?m=index&c=index&a=insertAc');
			}
		}
		$this->assign('title', '留言板');
		$this->display();
	}

}