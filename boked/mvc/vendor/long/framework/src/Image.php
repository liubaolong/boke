<?php
namespace framework;
class Image 
{
	protected $savePath; //保存的路径
	protected $randName; //随机的图片名
	protected $extension; //图片的后缀
	protected $saveFileName;
	public function __construct($savePath = './', $randName = true, $extension = 'png')
	{
		$this->savePath = $savePath;
		$this->randName = $randName;
		$this->extension = $extension;
	}
	public function waterMark($dstPath, $srcPath, $pos = 9, $pct = 100)
	{
		//1.判断文件
		if (!is_file($dstPath)) {
			return '目标图片不存在';
		} else if (!is_file($srcPath)) {
			return '水印图片不存在';
		} else if (!is_dir($this->savePath)) {
			return '保存的路径不对';
		} else if (!is_writeable($this->savePath)) {
			return '保存的路径不可写';
		}
		//2.判断尺寸
		list($dstWidth, $dstHeight) = getimagesize($dstPath);
		list($srcWidth, $srcHeight) = getimagesize($srcPath);
		//[$dstWidth, $dstHeight] = getimagesize($dstPath);
		//['width'=>$wdith] = $arr['width'=>222];
		if ($srcWidth > $dstWidth || $srcHeight > $dstHeight) {
			return '水印图太大了';
		}
		//计算位置
		if ($pos >= 1 && $pos <= 9){
			$offsetX = ($pos - 1) % 3 * ceil(($dstWidth - $srcWidth) /2);
			$offsetY = floor(($pos - 1) / 3) * ceil(($dstHeight - $srcHeight) /2);
		} else {
			//随机位置
			$offsetX = mt_rand(0, $dstWidth);
			$offsetY = mt_rand(0, $dstHeight);
		}
		//合并图
		$dstImg = $this->openImg($dstPath);
		$srcImg = $this->openImg($srcPath);
		imagecopymerge($dstImg, $srcImg, $offsetX, $offsetY, 0, 0, $srcWidth, $srcHeight, $pct);
		$this->saveImage($dstImg, $dstPath);
		imagedestroy($dstImg);
		imagedestroy($srcImg);
		return $this->saveFileName;
		
	}
	protected function saveImage($img, $path)
	{//  abdc/ abd
		$this->saveFileName = rtrim($this->savePath, '/') . '/';
		$info = pathinfo($path);
		//名字
		if ($this->randName) {
			$this->saveFileName .= uniqid(); 
		} else {
			$this->saveFileName .= $info['filename'];
		}
		//后缀
		// if (empty($this->extension)) {
		// 	$this->extension = $info['extension'];
		// } else {
			$this->extension = ltrim($this->extension , '.');
		//}
		$this->saveFileName .= '.' . $this->extension;
		//保存图片
		if (!strcasecmp($this->extension, 'jpg')) {
			$this->extension = 'jpeg';
		}
		$savePath = 'image' . $this->extension;
		$savePath($img, $this->saveFileName);
	}
	//打开图片返回图片资源 
	protected function openImg($imgPath)
	{
		$info = getimagesize($imgPath);
		$extension = image_type_to_extension($info['2'], false);  //.png  png 
		if (!strcasecmp($extension,'jpg')) {
			$extension = 'jpeg';
		} 
		$openFunc = 'imagecreatefrom' . $extension;
		return $openFunc($imgPath);
	} 
	public function zoomImg($imgPath, $width, $height)
	{
		//1.检查文件和目录
		if (!file_exists($imgPath)) {
			return '图片不存在';
		} else if (!is_dir($this->savePath)) {
			return '不是一个目录';
		} else if (!is_writeable($this->savePath)) {
			return '保存路径不可写';
		}
		//2.计算尺寸
		list($srcWidth, $srcHeight) = getimagesize($imgPath);
		//返回值是数组
		$size = $this->getSize($width, $height, $srcWidth, $srcHeight);
		$srcImg = $this->openImg($imgPath);
		$dstImg = imagecreatetruecolor($width, $height);
		//合并图  
		$this->mergeImg($dstImg, $srcImg, $size);
		//保存图
		$this->saveImage($dstImg, $imgPath);
		imagedestroy($dstImg);
		imagedestroy($srcImg);
		return $this->saveFileName;


	}
	protected function mergeImg($dstImg, $srcImg, $size)
	{
		//获取原始图片的透明色  //返回值为-1代表没有透明色
		$lucidColor = imagecolortransparent($srcImg);
		if ($lucidColor == -1 ) {
			$lucidColor = imagecolorallocate($dstImg, 0, 0, 0);
		}
		//填充透明颜色
		imagefill($dstImg, 0, 0, $lucidColor);
		imagecolortransparent($dstImg, $lucidColor);
		//合并
		imagecopyresampled($dstImg, $srcImg, $size['offsetX'], $size['offsetY'], 0, 0, $size['newWidth'], $size['newHeight'], $size['width'], $size['height']);

	}
	protected function getSize($width, $height, $srcWidth, $srcHeight)
	{
		//原来图的尺寸
		$size['width'] = $srcWidth;
		$size['height'] = $srcHeight;
		//计算宽和高个子的比例
		$scaleWidth = $width / $srcWidth;
		$scaleHeight = $height / $srcHeight;
		//取到最小的比例
		$scaleFinal = min($scaleWidth, $scaleHeight);
		//算出来缩放之后的尺寸  *最小的比例
		$size['newWidth'] = $srcWidth * $scaleFinal;
		$size['newHeight'] = $srcHeight * $scaleFinal;
		//新画布的合并时候偏移量
		if ($scaleWidth < $scaleHeight) {
			$size['offsetX'] = 0;
			$size['offsetY'] = round(($height - $size['newHeight']) / 2);
		} else {
			$size['offsetX'] = round(($width- $size['newWidth']) / 2); 
			$size['offsetY'] = 0;
		}
		return $size;
	}
}