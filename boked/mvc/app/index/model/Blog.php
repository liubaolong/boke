<?php
namespace index\model;
use	framework\Model;
use framework\Page;
class Blog extends Model
{	
	//添加留言
	public function message()
	{
		$message = empty($_POST['info']) ? '' : $_POST['info'];
		$uid     = $_SESSION['uid'];
		$addtime = time();
		$sql     ="insert into bk_message(messages,uid,addtime,isdel) values('$message',$uid,$addtime,0)";
		$result  = $this->exec($sql, true);
		return $result;
	}
	//查询留言
	public function look()
	{
		$sql = 'select m.messages,m.addtime,u.username from bk_message as m,bk_user as u where m.uid=u.uid and m.isdel != 1 order by addtime desc';
		$result = $this->query($sql, MYSQLI_ASSOC);
		return $result;
	}
	//查询博文
	public function BFS()
	{
		$name   = empty($_SESSION['user'])? '' : $_SESSION['user'];
		$uid    = empty($_SESSION['uid'])? '' : $_SESSION['uid'];
		$id     = empty($_GET['id'])? '' : $_GET['id'];
		$data   = $this->field('addtime,title,content,bid,hits')->where(['first=1','isdel=0'])->order('hits desc')->limit('0,5')->select();
		$sql    = "select bid from bk_like where uid = $uid";
		$likes  = $this->query($sql, MYSQLI_ASSOC);
		$sql    = "select bid from bk_collect where uid = $uid";
		$collect= $this->query($sql, MYSQLI_ASSOC);
		$res =$this->field('title,bid')->where(['first=1','isdel=0'])->order('addtime desc')->limit('0,5')->select();
		$result = [$res,$data,$likes,$collect];
		return $result;
	}
	//点赞
	public function likes()
	{
		$name = empty($_SESSION['user'])? '' : $_SESSION['user'];
		$uid = empty($_SESSION['uid'])? '' : $_SESSION['uid'];
		$id = empty($_GET['id'])? '' : $_GET['id'];
		$lid = empty($_GET['lid'])? '' : $_GET['lid'];
				$sql    = "select bid from bk_like where uid = $uid";
		        $likes  = $this->query($sql, MYSQLI_ASSOC);

		        if (!empty($likes)) {
						if (in_array($id,$likes[0])) {
								foreach($likes[0] as $k=>$v){
	      						  if (!strcmp($v,$id)) {
	          						 $sqll = "delete from bk_like where bid = $id";
	          						 $res = $this->exec($sqll);     
	          						}
	  							  }	
							} else {
								$sqll = "insert into bk_like values('$uid','$id')";
								$res = $this->exec($sqll);    
						}
				} else {
					$sqls = "insert into bk_like(uid,bid) values($uid,$id)";
					$res = $this->exec($sqls, true); 
				}
	}
	//收藏
	public function collect()
	{
		$name = empty($_SESSION['user'])? '' : $_SESSION['user'];
		$uid = empty($_SESSION['uid'])? '' : $_SESSION['uid'];
		$id = empty($_GET['id'])? '' : $_GET['id'];
		$lid = empty($_GET['lid'])? '' : $_GET['lid'];
			$sql    = "select bid from bk_collect where uid = $uid";
			$collect= $this->query($sql, MYSQLI_ASSOC);
			   if (!empty($collect)) {
					if (in_array($id,$collect[0])) {
								foreach($collect[0] as $k=>$v) {
	      						  if (!strcmp($v,$id)) {
	          						 $sqll = "delete from bk_collect where bid = $id";
	          						 $res = $this->exec($sqll);       
	          						}
	  							  }
							} else {
								$sqll = "insert into bk_collect(uid,bid) values($uid,$id)";
								$res = $this->exec($sqll); 
								}
				} else {
					$sqls = "insert into bk_collect(uid,bid) values($uid,$id)";
					$res = $this->exec($sqls, true); 
				}
	}
	//查看博文
	public function about($id)
	{	
		$result = $this->field('title,content,addtime,hits')->where(["bid='$id'"])->select();
		$data = ['hits'=>$result[0]['hits']+1];
		$this->where(["bid='$id'"])->update($data);
		$sql = "select b.content,u.username,b.addtime from bk_blog as b,bk_user as u where  b.tid=$id and u.uid=b.uid and b.isdel != 1";
		$reply = $this->query($sql, MYSQLI_ASSOC);
		$arr = [$result,$reply];
		return $arr;
	}
	//回复
	public function reply()
	{
		$info = empty($_POST['info']) ? '' : $_POST['info'];
		$bid  = empty($_GET['bid']) ? '' : $_GET['bid']; 
		if (!empty($info)&!empty($bid)) {
			$data = ['title'=>0,'content'=>$info,'tid'=>$bid,'isdel'=>0,'uid'=>$_SESSION['uid'],'first'=>0,'addtime'=>time()];
			$result=$this->insert($data);
			if ($result) {
				return $data;
			} else {
				return false;
			}
		}
	}
	//
	public function see()
	{
		$data   = $this->field('addtime,title,content,bid')->where(['first=1','isdel=0'])->order('hits desc')->select();
		$res    = $this->field('title,bid')->where(['first=1','isdel=0'])->order('addtime desc')->limit('0,5')->select();
		$arr    = $this->field('title,bid')->where(['first=1','isdel=0'])->order('hits desc')->limit('0,5')->select();
		$result = [$res,$data,$arr];
		return $result;
	}
}