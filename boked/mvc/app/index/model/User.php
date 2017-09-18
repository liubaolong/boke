<?php
namespace index\model;
use framework\Model;
class User extends Model
{
	//注册
	public function check($data)
	{
			$newname  = empty($data)? '' : $data['newuser'];
			$newpass  = empty($data)? '' : $data['newpass'];
			$rnewpass = empty($data)? '' : $data['rnewpass'];
			$newphone = empty($data)? '' : $data['newphone'];
			$num[] = '';
			//用户名检测
			if (empty($newname)) {
					$num[]  = '请输入用户名';
					$result = false;
				} else {
				$result = $this->where(["username = '$newname'"])->select();
				if ($result) {	
					 $num[] = '用户名已存在';
					}
				}
			//密码检查
			if (empty($newpass)) {
					$num[]  = '请输入密码';
				} else {
					if (preg_match('/^\d+$/', $newpass)) {
							$num[] = '密码不能为纯数字';
					}
					if (!($newpass==$rnewpass)) {
							$num[] = '密码错误';
					}
					if (strLen($newpass) < 6)
					{
						    $num[] = '密码安全性较低';
					}
				}
			//电话号码检测
			if (empty($newphone)) {
					        $num[] = '请输入电话号码';
				} else {
				if (!preg_match('/^1[34578]{1}\d{9}$/', $newphone)) {
						    $num[] = '电话错误';
					} else {
						if ($this->where(["phone = '$newphone'"])->select()) {
							$num[] = '此号码已经注册';
							$phone = false;
						} else {
							$phone = true;
						}
					}
				}

			if (!$result&!(preg_match('/^\d+$/', $newpass))&($newpass==$rnewpass)&(strLen($newpass) >= 6)&!empty($newpass)&preg_match('/^1[34578]{1}\d{9}$/', $newphone)&$phone)
			{
				$data = ['username'=>$newname, 'password'=>md5($newpass), 'phone'=>$newphone, 'undertype'=>0, 'allowlogin'=>0, 'regtime'=>time()];
					$res = $this->insert($data);
					return $res;
			} else {
				return $num;

			}
	}
	//登录
	public function affrim($data)
	{
		$username = empty($data) ? '' : $data['user'];
		$password = empty($data) ? '' : $data['password'];
		$yzm      = empty($data) ? '' : $data['yzm'];
		$num[] = '';
		//检查用户名是否存在
		$result = $this->field('username,uid,undertype,allowlogin')->where(["username =  '$username'"])->select();
		$uid = empty($result)? '' : $result[0]['uid'];
		$login = empty($result)? '' : $result[0]['allowlogin'];
		if($login==0){
			$login =true ;
			}else{
				$num[] = '用户已被锁定';
			$login =false;
			}
				$undertype  = empty($result[0]['undertype'])? '' : $result[0]['undertype'];			
				if(!$result){
					$num[]  = '用户名不存在';
					$result = false;
				}else{
					$result = true;
				}
				//检查密码
				$upass = $this->field('password')->where(["username  =  '$username'"])->select();
				if(!empty($upass)){
					$upass = $upass[0]['password'];
				}
				//检测密码是否一致
				if($upass){
					if(md5($password)!=$upass){
						$num[] = '密码错误';
						}
					}
				//检测验证码是否正确
				if(!empty($yzm)){
					if($yzm!=$_SESSION['yzm']){
						$num[] = '验证码错误';
						$yzm = false;
					}else{
						$yzm = true;
					}	
				}else{
					$yzm = false;
				}
				if($result&(md5($password)==$upass)&$yzm&$login){
						$arr = '';
						$_SESSION['user'] = $username;
						$_SESSION['uid'] = $uid;
						if($undertype==1){
							$_SESSION['undertype'] = $undertype;
						}else{
							$_SESSION['undertype'] = '';
						}
					return $arr;
				}else{
					return $num;
				}
	}
	//重置密码
	public function checkname()
	{
		$user   = empty($_POST['user'])  ? '' : $_POST['user'];
		$phone  = empty($_POST['phone']) ? '' : $_POST['phone'];
		$result = $this->where(["username = '$user'"])->select();
		if($result){
			if($result[0]['phone']==$phone){
				$_SESSION['phone'] = $phone;
				return $result; 
			}else{
				return '';
			}
		}else{
			return '';
		}
	}
	public function reset()
	{
		$password  = empty($_POST['password']) ? '' : $_POST['password'];
		$rpassword = empty($_POST['rpassword'])? '' : $_POST['rpassword'];
		if($password==$rpassword){
			$data  = ['password'=>md5($password)];
			$phone = $_SESSION['phone'];
			$res   = $this->where(["phone = '$phone'"])->update($data);	
			$_SESSION = array();
			return true;
		}else{
			return false;
		}
	}
}