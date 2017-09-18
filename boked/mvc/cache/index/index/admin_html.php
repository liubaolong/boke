<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="renderer" content="webkit">
    <title><?=WEB_NAME?>后台管理中心</title>  
    <link rel="stylesheet" href="<?php echo CSS_PATH;?>pintuer.css">
    <link rel="stylesheet" href="<?php echo CSS_PATH;?>admin.css">
    <script src="<?php echo JS_PATH;?>jquery.js"></script>   
</head>
<body style="background-color:#f2f9fd;">
<div class="header bg-main" style="background:url(<?php echo IMG_PATH;?>/images/bg.jpg) no-repeat 0 -1000px;">
  <div class="logo margin-big-left fadein-top">
    <h1><img src="<?php echo IMG_PATH;?>images/y.jpg" class="radius-circle rotate-hover" height="50" alt="" />后台管理中心</h1>
  </div>
  <div class="head-l"><a class="button button-little bg-green" href="index.php" target="_top"><span class="icon-home"></span> 前台首页</a> &nbsp;&nbsp;<a class="button button-little bg-red" href="index.php?oid=1"><span class="icon-power-off"></span> 退出登录</a> </div>
</div>
<div class="leftnav">
  <div class="leftnav-title" style="background:url(<?php echo IMG_PATH;?>images/bg.jpg) no-repeat 0 -1000px;"><strong><span class="icon-list"></span>菜单列表</strong></div>
  <h2><span class="icon-user"></span>基本设置</h2>
  <ul style="display:block">
    <li><a href="index.php?m=admin&c=index&a=info" target="right"><span class="icon-caret-right"></span>网站设置</a></li>
    <li><a href="index.php?m=admin&c=user&a=pass" target="right"><span class="icon-caret-right"></span>修改密码</a></li>  
    <li><a href="index.php?m=admin&c=index&a=book" target="right"><span class="icon-caret-right"></span>留言管理</a></li>     
     <li><a href="index.php?m=admin&c=user&a=consumer" target="right"><span class="icon-caret-right"></span>用户管理</a></li>    
  </ul>   
  <h2><span class="icon-pencil-square-o"></span>栏目管理</h2>
  <ul>
    <li><a href="index.php?m=admin&c=blog&a=list" target="right"><span class="icon-caret-right"></span>内容管理</a></li>
    <li><a href="index.php?m=admin&c=blog&a=add" target="right"><span class="icon-caret-right"></span>添加内容</a></li>   
    <li><a href="index.php?m=admin&c=blog&a=rubbish" target="right"><span class="icon-caret-right"></span>回收站</a></li> 
  </ul>  
</div>
<script type="text/javascript">
$(function(){
  $(".leftnav h2").click(function(){
	  $(this).next().slideToggle(200);	
	  $(this).toggleClass("on"); 
  })
  $(".leftnav ul li a").click(function(){
	    $("#a_leader_txt").text($(this).text());
  		$(".leftnav ul li a").removeClass("on");
		$(this).addClass("on");
  })
});
</script>
<ul class="bread">
  <li><a href="{:U('Index/info')}" target="right" class="icon-home"> 首页</a></li>
  <li><a href="##" id="a_leader_txt">网站信息</a></li>
  
</ul>
<div class="admin">
  <iframe scrolling="auto" rameborder="0" src="index.php?m=admin&c=index&a=info" name="right" width="100%" height="100%"></iframe>
</div>
<div style="text-align:center;">
<p>来源:<a href="http://www.mycodes.net/" target="_blank">源码之家</a></p>
</div>
</body>
</html>