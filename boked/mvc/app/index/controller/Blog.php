<?php
namespace index\controller;
use index\model\Blog as BlogModel;
class Blog extends Controller
{
	protected $blog;
	public function __construct()
	{
		parent::__construct();
		$this->blog = new BlogModel();
	}
	//查看博文
	public function about()
	{
		$bid = $_GET['bid'];
			if (isset($_POST['info'])) {
				if (!$this->blog->reply($_POST)) {
					$this->notice('回复失败 请登录',"index.php?bid=$bid&m=index&c=blog&a=about");
				} else {
					$this->notice('回复成功',"index.php?bid=$bid&m=index&c=blog&a=about");
				}
			}
		$arr = $this->blog->about($bid);
		$this->assign('bid', $bid);
		$this->assign('title', '博文详情');
		$this->assign('reply', $arr[1]);
		$this->assign('alter', $arr[0][0]['title']);
		$this->assign('content', $arr[0][0]['content']);
		$this->assign('addtime', $arr[0][0]['addtime']);
		$this->display();	
	}
	//所有博文
	public function newlist()
	{
		$arr = $this->blog->see();	
		$this->assign('hitsdata',$arr[2]);
		$this->assign('newdata',$arr[0]);
		$this->assign('data',$arr[1]);
		$this->assign('title', '慢生活');
		$this->display();	
	}
	//查看留言
	public function moodlist()
	{
		$res = $this->blog->look();
		$this->assign('title', '碎语');
		$this->assign('result', $res);
		$this->display();	
	}
}	