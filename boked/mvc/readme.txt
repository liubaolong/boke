一个轻量级的自主封装的mvc框架制作的个人博客
app     admin 后台模块 controller blog 博文控制器
					 			 index后台控制器
								 user用户控制器 
					model  数据处理
					view 	html模板
	    index 前台模块 controller  blog 博文控制器
					             index后台控制器
					             user用户控制器 
					model 数据处理
					view  html模板
boot    Psr4Autoloader.php 自动加载类 
	    start.php 入口文件 接受跳转的模块名 控制器名 方法名
cache   database 数据库缓存文件 对应表字段的缓存
	    index 前台模板引擎的缓存
	    admin 后台模板引擎的缓存
config  config 	定义路径
		database 数据库各表的公共部分
		namespace 定义命名空间
		zhandian 网站定义的全局常量
public  js js文件
		cs cs文件
		font 字体文件
upload 上传的文件
vendor 公共的方法

