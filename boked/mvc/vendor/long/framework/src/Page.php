<?php
namespace framework;
class Page
{
	protected $total; //总条数
	protected $pageSize; //每一页显示
	protected $page; //当前页
	protected $pageCount;
	protected $url;
	public function __construct($total, $pageSize = 5)
	{
		$this->total = $total;
		$this->pageSize = $pageSize;
		$this->pageCount = ceil($total / $pageSize);
		$this->page = $this->getPage();
		$this->url = $this->getUrl();
		//$this->setPage(2);
	}
	//首页
	public function headPage()
	{
		return $this->setPage(1);
	}
	//尾页
	public function lastPage()
	{
		return $this->setPage($this->pageCount);
	}
	//上一页
	public function prevPage()
	{
		if ($this->page < 2) {
			return $this->headPage();
		} else {
			return $this->setPage($this->page - 1);
		}
	}
	//下一页
	public function nextPage()
	{
		if ($this->page < $this->pageCount) {
			return $this->setPage($this->page + 1);
		} else {
			return $this->lastPage();
		}
	}
	//跳转到指定页面
	public function givenPage($page)
	{
		if ($page < 1) {
			$page = 1;
		} else if ($page > $this->pageCount) {
			$page = $this->pageCount;
		}
		return $this->setPage($page);
	}
	public function listPage()
	{
		return [
			'head' => $this->headPage(),
			'last' => $this->lastPage(),
			'next' => $this->nextPage(),
			'prev' => $this->prevPage()
		];
	}
	//http://www.wokao.com/day4/code/page.php?tid=2
	public function getUrl()
	{
		$url = $_SERVER['REQUEST_SCHEME'];//协议
		$url .= '://' . $_SERVER['HTTP_HOST'];
		$url .= $_SERVER['SERVER_PORT'];//端口号
		$url .= $_SERVER['REQUEST_URI'];
		$replaceStr = 'page=' . $this->page;
		//http://www.wokao.com/day4/code/page.php?page=2&tid=2
		//?page=1 //?page=1
		//?tid=5&page=4 //&page=4
		//?tid=5&page=4&cid=4  //
		$replaceArr = [
						$replaceStr . '&',
						'&' . $replaceStr,
						'?' . $replaceStr
					];
		$replaceUrl = str_replace($replaceArr, '', $url);
		return $replaceUrl;
	}
	public function getPage()
	{
		return empty($_GET['page']) ? 1 : (int)$_GET['page'];
	}
	public function setPage($page)
	{
		if (strpos($this->url, '?')) {
			return $this->url . '&page=' . $page; 
		} else {
			return $this->url . '?page=' . $page;
		}
	}
	public function limit(){
	return ($this->page - 1) * $this->pageSize . ',' .  ($this->page * $this->pageSize > $this->total ? $this->total : $this->page * $this->pageSize);
	}
}
