<?php
/**
* 
*/
namespace framework;
class Upload
{
	protected $savePath = './upload';
	protected $randName = true;
	protected $mime = ['image/png', 'image/jpeg', 'image/gif'];
	protected $extension = 'png';
	public $errorNumber = 0;
	public $errorMessage = '成功';
	protected $datePath = true;
	protected $maxSize = 2000000;
	protected $pathName;
	protected $uploadInfo;

	public function __construct($options = null)//['savePath'=>'./upload/image', 'randName'=>]
	{
		$this->setOption($options);
	}
	protected function setOption($options)
	{
		if (is_array($options)) {
			//获取类内所有成员属性
			$keys = get_class_vars(__CLASS__);
			foreach ($options as $key => $value) {
				//判断成员属性数组中有没有当前参数
				if (array_key_exists($key, $keys)) {
					$this->$key = $value;
				}
			}
		}
	}
	public function uploadFile($field)
	{
		//1.检查保存的路径
		if  (!$this->checkSavePath()) {
			return false;
		}
		//2.检查上传信息
		if  (!$this->checkUploadInfo($field)) {
			return false;
		}
		//3.检查error信息
		if  (!$this->checkUploadError()) {
			return false;
		}
		//4.检查自定义信息
		if  (!$this->checkAllowOption()) {
			return false;
		}
		//5.检查是不是上传的文件
		if  (!$this->checkUploadFile()) {
			return false;
		}
		//6.拼接保存的路径
		if  (!$this->joinPathName()) {
			return false;
		}
		//7.移动文件
		if (!$this->moveUploadFile()) {
			return false;
		}
		return true;

	}
	protected function moveUploadFile()
	{
		if (!move_uploaded_file($this->uploadInfo['tmp_name'], $this->pathName)) {
			$this->errorNumber = -8;
			$this->errorMessage = '移动文件失败';
			return false;
		}
		return true;
	}
	protected function joinPathName()
	{
		//路径
		$this->pathName = $this->savePath;
		if ($this->datePath) {
			// ./Upload/2017/07/14/dfgh.jpg
			$this->pathName .= date('Y/m/d') . '/';
			if (!file_exists($this->pathName)) {
				mkdir($this->pathName, 0777, true);
			}
		}
		//名字
		if ($this->randName) {
			$this->pathName .= uniqid();
		} else {
			$info = pathinfo($this->uploadInfo['name']);
			$this->pathName .= $info['filename'];
		}
		//后缀
		$this->pathName .= '.' . $this->extension;
		return true;
	}
	protected function checkUploadFile()
	{
		if (!is_uploaded_file($this->uploadInfo['tmp_name'])) {
			$this->errorNumber = -6;
			$this->errorMessage = '不是post传来的';
			return false;
		}
		return true;
	}
	protected function checkAllowOption()
	{
		if (!in_array($this->uploadInfo['type'], $this->mime)) {
			$this->errorNumber = -4;
			$this->errorMessage = '不是允许的mime类型';
			return false;
		}
		if ($this->uploadInfo['size'] > $this->maxSize) {
			$this->errorNumber = -5;
			$this->errorMessage = '超过了允许的大小';
			return false;
		}
		return true;

	}
	protected function checkUploadError()
	{
		if (!$this->uploadInfo['error']) {
			return true;
		}
		switch ($this->uploadInfo['error']) {
            case UPLOAD_ERR_INI_SIZE:
                $this->errorNumber = UPLOAD_ERR_INI_SIZE;
                $this->errorMessage = '超出配置文件中设置的文件大小';
                break;

            case UPLOAD_ERR_FORM_SIZE:
                $this->errorNumber = UPLOAD_ERR_FORM_SIZE;
                $this->errorMessage = '超出MAX_FILE_SIZE的大小';
                break;

            case UPLOAD_ERR_PARTIAL:
                $this->errorNumber = UPLOAD_ERR_PARTIAL;
                $this->errorMessage = '部分文件上传';
                break;
                
            case UPLOAD_ERR_NO_FILE:
                $this->errorNumber = UPLOAD_ERR_NO_FILE;
                $this->errorMessage = '没有文件上传';
                break;

            case UPLOAD_ERR_NO_TMP_DIR:
                $this->errorNumber = UPLOAD_ERR_NO_TMP_DIR;
                $this->errorMessage =  '没有找到临时文件夹';
                break;

            case UPLOAD_ERR_CANT_WRITE:
                $this->errorNumber = UPLOAD_ERR_CANT_WRITE;
                $this->errorMessage = '文件写入失败';
                break;
        }
        $this->errorNumber = $this->uploadInfo['error'];
        return false;
	}
	protected function checkUploadInfo($field)
	{
		if (empty($_FILES[$field])) {
			$this->errorNumber = -3;
			$this->errorMessage = '没有上传的key';
			return false;
		}
		$this->uploadInfo = $_FILES[$field];
		return true;

	}
	protected function checkSavePath()
	{
		if (!is_dir($this->savePath)) {
			$this->errorNumber = -1;
			$this->errorMessage = '目录不存在';
			return false;
		}
		if (!is_writeable($this->savePath)) {
			$this->errorNumber = -2;
			$this->errorMessage = '目录不可写';
			return false;
		}
		$this->savePath = rtrim($this->savePath, '/') . '/';
		return true;
	}
}
