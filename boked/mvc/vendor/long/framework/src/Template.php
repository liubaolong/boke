<?php
namespace framework;
class Template
{
	protected $tplPath; //模板文件所在路径

	protected $cachePath; //缓存文件路径

	protected $vars = []; //保存变量

	protected $validTime;
	public function __construct($tplPath = './view/', $cachePath = './cache/template/' ,$validTime = 3600)
	{
		$this->tplPath = $this->checkPath($tplPath);
		$this->cachePath = $this->checkPath($cachePath);
		$this->validTime = $validTime;
	}
	//检查目录
	protected function checkPath($dir)
	{
		$dir = rtrim($dir, '/') . '/';
		if (!is_dir($dir)) {
			mkdir($dir, 0777, true);
		}
		if (!is_readable($dir) || !is_writeable($dir)) {
			chmod($dir, 0777);
		}
		return $dir;
	}
	//分配变量
	public function assign($name, $value)
	{
		$this->vars[$name] = $value;
	}
	public function display($tplFile, $isExcute = true)
	{
		$cacheFile = $this->getCacheFile($tplFile); //cache/template/index_html.php
		$tplFile = $this->tplPath . $tplFile; //拼接模板文件路径 ./view/index.html
		if (!file_exists($tplFile)) {
			exit($tplFile . '模板文件不存在');
		}
		//缓存文件不存在 缓存文件修改时间<模板文修改  缓存文件的时间+3600 < time 
		if (!file_exists($cacheFile) 
			|| filemtime($cacheFile) < filemtime($tplFile)
			|| (filemtime($cacheFile) + $this->validTime) < time()
			) {
			$file = $this->complie($tplFile);
			$this->checkPath(dirname($cacheFile));
			file_put_contents($cacheFile, $file);
		} else {
			//更新include的文件
			$this->updateInclude($tplFile);
		}
		if (!empty($this->vars)) {
			extract($this->vars);
		}
		if ($isExcute) {
			include $cacheFile;
		}
	}
	protected function updateInclude($tplFile)
	{
		$file = file_get_contents($tplFile);
		$reg = '/\{include (.+)\}/U';
		if (preg_match_all($reg, $file, $matches)) {
			$this->display($matches[1][0], false);
		}
	}
	protected function complie($tplFile)
	{
		$file = file_get_contents($tplFile);
		$keys = [
				'__%%__' 	 		  => '<?php echo \1;?>',
				'${%%}'     		  => '<?php echo \1;?>',
				'{elseif %%}'		  => '<?php elseif(\1):?>',
				'{$%%}'		 		  => '<?=$\1; ?>',
				'{if %%}'		 	  => '<?php if(\1):?>',
				'{else}' 		 	  => '<?php else:?>',
				'{/if}'				  => '<?php endif;?>',
				'{switch %% case %%}' => '<?php switch(\1): case \2: ?>',
				'{case %%}'  		  => '<?php case \1:?>',
				'{break}'    		  => '<?php break;?>',
				'{/switch}'  		  => '<?php endswitch;?>',
				'{include %%}' 		  => '<?php include "\1"?>',
				'{for %%}'  		  => '<?php for(\1):?>',
				'{/for}'  			  => '<?php endfor;?>',
				'{foreach %%}' 		  => '<?php foreach(\1): ?>',
				'{/foreach}' 		  => '<?php endforeach;?>',
				'{section}' 		  =>'<?php ',
				'{/section}' 		  => '?>',
			];
		foreach ($keys as $key => $value) {
			$key = preg_quote($key, '#');
			$reg = '#' . str_replace('%%', '(.+)', $key) . '#U';
			if (strpos($reg, 'include')) {
				$file = preg_replace_callback($reg, [$this,'complieInclude'], $file);
			} else {
				$file = preg_replace($reg, $value, $file);
			}
		}
		return $file;
	}
	protected function complieInclude($matches)
	{
		$file = $matches[1];
		$this->display($file, false);
		//include header.html ===>  php include 'header_html.php'
		$cacheFile = $this->getCacheFile($file);
		return "<?php include '$cacheFile'?>";

	}
	protected function getCacheFile($tplFile)
	{
		return $this->cachePath . str_replace('.', '_', $tplFile) . '.php';
	}
	public function clearCache()
	{
		$this->clearDir($this->cachePath);
	}
	protected function clearDir($dir)
	{
		$dir = rtrim($dir, '/') . '/';
		$dp = opendir($dir);
		while ($file = readdir($dp)) {
			if ($file == '.' || $file == '..') {
				continue;
			}
			$fileName = $dir . $file;
			if (is_dir($fileName)) {
				$this->clearDir($fileName);
			} else {
				unlink($fileName);
			}
		}
		closedir($dp);
		rmdir($dir);
	}

}
