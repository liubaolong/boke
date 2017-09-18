<?php
include 'boot/Psr4Autoloader.php';

class Start
{
	public static function init()
	{
		$namespace = include 'config/namespace.php';
		include 'config/zhandian.php';
		new Psr4Autoloader($namespace);
	}
	public static function route()
	{
		$_GET['m'] = empty($_GET['m']) ? 'index' : $_GET['m'] ;
		$_GET['c'] = empty($_GET['c']) ? 'index' : $_GET['c'] ;
		$_GET['a'] = empty($_GET['a']) ? 'index' : $_GET['a'] ;
		$controller = $_GET['m'] . '\\controller\\' . ucfirst($_GET['c']);
		call_user_func([new $controller, $_GET['a']]);
	}
}