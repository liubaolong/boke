<?php
namespace framework;
$config = include 'config/database.php';
class Verify
{
	protected $width; //宽
	protected $height;//高
	protected $length;//验证码长度
	protected $type;//类型
	protected $img; //画布资源
	protected $code; //验证码

	public function __construct($width = 200, $height = 50, $length = 4, $type = 3)
	{
		$this->width = $width;
		$this->height = $height;
		$this->length = $length;
		$this->type = $type;
		$this->outPut();
	}
	static  function ver($width = 200, $height = 50, $length = 4, $type = 3)
	{
		$ver = new Verify($width, $height, $length, $type);
		return $ver->code;

	}
	protected function outPut()
	{
		//创建画布
		$this->createImg();
		//画字符串
		$this->verCode();
		//画干扰元素
		$this->setDisturb();
		$this->sendImg();
	}
	protected function createImg()
	{
		$this->img = imagecreatetruecolor($this->width, $this->height);
		$color = $this->getColor(true);
		imagefill($this->img, 0, 0, $color);
	}
	//产生颜色
	protected function getColor($isLight = false)
	{	//0 1    
		$start = (int)$isLight * 127;  //0*127 = 0 1* 127=127
		$end   = $start + 128;//
		$red   = mt_rand($start, $end);
		$green = mt_rand($start, $end);
		$blue  = mt_rand($start, $end);
		return imagecolorallocate($this->img, $red, $green, $blue);
	}
	//画随机字符串
	protected function verCode()
	{
		$str = $this->randString();
		$fontsize = $this->height / 2;
		$offsetY = ($this->height + $fontsize) / 2; 
		is_array($str) ? $count = strlen($str['str']) : $count = strlen($str);
		$perWidth = $this->width / $count;
		$delta = $perWidth - $fontsize;
		for ($i=0; $i < $count; $i++) { 
			$angle = mt_rand(-30, 30);
			$color = $this->getColor();
			$offsetX = $i * $perWidth + $delta;
			$_SESSION['code'] = $this->type;
			if ($this->type == 4) {
				
				imagettftext($this->img, $fontsize, $angle, $offsetX, $offsetY, $color, 'public/font/lxkmht.ttf', $str['str'][$i]);
				$_SESSION['yzm'] = $str;
			} else {
				
				imagettftext($this->img, $fontsize, $angle, $offsetX, $offsetY, $color, 'public/font/lxkmht.ttf', $str[$i]);
				$_SESSION['yzm'] = $str;
			} 
			
		}
	}
	//画的干扰元素
	protected function setDisturb()
	{
		//点
		$total = $this->width * $this->height / 50;
		for ($i=0; $i < $total; $i++) { 
			$color = $this->getColor();
			$offsetX = mt_rand(0, $this->width);
			$offsetY = mt_rand(0, $this->height);
			imagesetpixel($this->img, $offsetX, $offsetY, $color);
		}
		for ($i=0; $i < 10; $i++) {
			$color = $this->getColor(); 
			imageline($this->img, mt_rand(0, $this->width), mt_rand(0, $this->height), mt_rand(0, $this->width), mt_rand(0, $this->height), $color);
		}
	}
	//产生随机字符串
	protected function randString()
	{
		switch ($this->type) {
				case 1://纯数字
					$str = $this->randNum();
					break;
				case 2://纯字母
					$str = $this->randAlpha();
					break;
				case 3://数字字母混合
					$str = $this->randMixed();
					break;
				case 4://等式
					$str = $this->randCom();
					break;
				default:
					$str = $this->randNum();
					break;
		}
		$this->type == 4 ? $this->code = $str['code'] : $this->code = $str;
		return $str;	
	}
	protected function randCom()
	{
		$num1 = mt_rand(0, 9);
		$num2 = mt_rand(0, 9);
		$arr = ['+', '-', '*'];
		$com = $arr[mt_rand(0, 2)];
		$str = $num1 . $com . $num2 . '=?';
		switch ($com) {
			case '+':
				$re = $num1 + $num2;
				break;
			case '-':
				$re = $num1 - $num2;
				break;
			case '*':
				$re = $num1 * $num2;
				break;
		}
		return ['str'=>$str, 'code'=>$re];

	}
	protected function randNum()
	{
		$str = 1234567890;
		return substr(str_shuffle($str), 0, $this->length);
	}
	protected function randAlpha()
	{
		$str = range('a', 'z');
		$str = join('', $str);
		return substr(str_shuffle($str), 0, $this->length);
	}
	protected function randMixed()
	{
		return substr(md5(mt_rand(1 ,99)), 0, $this->length);
	}
	// 输出资源
	protected function sendImg()
	{
		header('content-type:image/png');
		imagepng($this->img);
	}
	public function code()
	{
		return $this->code;
	}
}

// $code = Verify::ver();
