<?php
class Psr4Autoloader
{
	protected $namespaces = [];
    public function __construct($namespaces = null)
    {
    	spl_autoload_register([$this, 'loadClass']);
    	if (is_array($namespaces)) {
    		$this->addNamespace($namespaces);
    	}
    }
	public function loadClass($className)
	{
		//将类名与命名空间区分
		$pos = strrpos($className, '\\');
		//命名空间
		$namespace = substr($className, 0,  $pos+1);
		if (array_key_exists($namespace, $this->namespaces)) {
			//类名
			$realClass = substr($className, $pos+1);
			//调用真正位置
			$this->loadMappedFile($namespace, $realClass);
		} else {

			$className = str_replace('\\', '/', $className) . '.php';
			if (file_exists($className)) {
				include $className;
			}
		}
	}
	protected function loadMappedFile($namespace, $realClass) {
	
		$className = $this->namespaces[$namespace] . $realClass . '.php';
		if (file_exists($className)) {
				include $className;
			}
		
	}
	//存储对应关系
	public function addNamespace($namespace, $realPath = null) 
	{
		if (is_array($namespace)) {
			foreach ($namespace as $key => $value) {
				$this->addPsr4($key, $value);
			}
			
		} else {
			$this->addPsr4($namespace, $realPath);
		}
		
	}
	protected function addPsr4($namespace, $realPath)
	{
		$namespace = trim($namespace, '\\') . '\\';
		$realPath = rtrim(str_replace('\\', '/', $realPath), '/') . '/';
		$this->namespaces[$namespace] = $realPath;
	}


}