<?php
namespace admin\model;
use	framework\Model;
use framework\Upload;
class Blog extends Model
{	
	//发博文
	public function Blogger()
	{
		$title   = empty($_POST['title']) ? '' : $_POST['title'];
		$img     = empty($_POST['img']) ? '': $_POST['img'];
		$content = empty($_POST['content']) ? '' : $_POST ['content'];
		$data    = ['uid'=>$_SESSION['uid'],'title'=>$title,'content'=>$content,'first'=>1,'addtime'=>time()];
		$result  = $this->insert($data);
		return $result;
	}
	//留言查看
	public function message()
	{
		
		$sql = 'select m.mid,m.messages,m.addtime,u.username,u.phone from bk_message as m,bk_user as u where m.uid=u.uid and m.isdel != 1';
		$result = $this->query($sql, MYSQLI_ASSOC);
		return $result;
	}
	//留言批量删除
	public function mdelete()
	{

		$id   = $_POST['id'];
		$id   = implode($id,',');
		$sql  = "delete from bk_message  where mid in($id)";
		$res  = $this->exec($sql);
		return $res;
	}
	//单个删除留言
	public function adelete()
	{

		$id = $_GET['id'];
		$sql = "delete from bk_message where mid = $id";
		$res = $this->exec($sql);
		return $res;
	}
	//博文查看
	public function blist()
	{
		$result = $this->field('bid,title,addtime')->where(['first = 1 and isdel = 0'])->select();
		return $result;
	}
	//博文搜索
	public function sousuo()
	{
		$content = $_POST['sousuo'];
		$result = $this->field('bid,title,addtime')->where(["title like '%$content%'"])->select();
		return $result;
	}
	//批量单个删除
	public function bdelete()
	{

		$id   = $_POST['id'];
		$id   = implode($id,',');
		$sql  = "update bk_blog set isdel = 1 where bid in($id)";
		$res  = $this->exec($sql);
		return $res;
	}
	//单一删除博文
	public function abdelete()
	{

		$id = $_GET['id'];
		$sql = "update bk_blog set isdel = 1 where bid = $id";
		$res = $this->exec($sql);
		return $res;
	}
	//回收站
	public function brubbish()
	{
		$result = $this->field('bid,title,addtime')->where(['first = 1 and isdel = 1'])->select();
		return $result;
	}
	//博文单个恢复
	public function rdelete()
	{

		$id   = $_POST['id'];
		$id   = implode($id,',');
		$sql  = "update bk_blog set isdel = 0 where bid in($id)";
		$res  = $this->exec($sql);
		return $res;
	}
	//批量恢复博文
	public function ardelete()
	{

		$id = $_GET['id'];
		$sql = "update bk_blog set isdel = 0 where bid = $id";
		$res = $this->exec($sql);
		return $res;
	}
	//清空回收站
	public function alldel()
	{
		$bid = $this->field('bid')->where(['isdel = 1 and first = 1'])->select();
		$bid = empty($bid)? '' : $bid[0]['bid'];
		$res = $this->where(["isdel = 1 and first = 1"])->delete();
		$arr = $this->where(["tid = $bid"])->delete();
		return $res;
	}
	//站点信息
	public function site()
	{
		$file = file_get_contents('config/zhandian.php');
		foreach($_POST as $key=>$val){
			$file=preg_replace("/define\('$key', '.*?'\)/", "define('$key', '$val')", $file);
		}
		$res = file_put_contents('config/zhandian.php',$file);
		return $res;
	}	
}