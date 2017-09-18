<?php
namespace admin\model;
use framework\Model;
class User extends Model
{
	//查询博主名
	public function pass()
	{
		$result = $this->field('username')->where(['undertype=1'])->select();
		$result = empty($result) ? '' : $result[0]['username'];
		return $result;
	}
	//修改密码
	public function alter()
	{
		$password = empty($_POST['mpass']) ? '' : $_POST['mpass'];
		$newpass  = empty($_POST['newpass']) ? '' : $_POST['newpass'];
		$result   = $this->field('password')->where(['undertype=1'])->select();
		$result   = empty($result) ? '' : $result[0]['password'];
		if(md5($password)==$result){
			$data = ['password'=>md5($newpass)];
			$res  = $this->where(['undertype=1'])->update($data); 
		}
		return $res;
	}
	//查询所有用户
	public function cuser()
	{
		$result = $this->where(['undertype=0'])->select();
		return $result;
	}
	//锁定用户
	public function lock()
	{
		$uid  = empty($_GET['id']) ? '' : $_GET['id'];
		$data = ['allowlogin'=>1];
		$res  = $this->where(["uid = '$uid'"])->update($data);
	}
	//解锁用户
	public function clear()
	{
		$uid  = empty($_GET['id']) ? '' : $_GET['id'];
		$data = ['allowlogin'=>0];
		$res  = $this->where(["uid = '$uid'"])->update($data);
	}
	//单一删除用户
	public function udelete()
	{
		$uid  = empty($_GET['id']) ? '' : $_GET['id'];
		$res = $this->where(["uid = '$uid'"])->delete();
		$msql = "delete from bk_message where uid = $uid";
		$this->exec($msql);
		$bsql = "delete from bk_blog where uid  = $uid";
		$this->exec($bsql);
	}
	//批量删除用户
	public function alldelete()
	{
		$id   = $_POST['id'];
		$id   = implode($id,',');
		$res  = $this->where(["uid in($id)"])->delete();
		$msql = "delete from bk_message where uid in($id)";
		$this->exec($msql);
		$bsql = "delete from bk_blog where uid in($id)";
		$this->exec($bsql);
	}
}