﻿<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?=WEB_NAME?><?=$title; ?></title>
<meta name="keywords" content="个人博客,杨青个人博客,个人博客模板,杨青" />
<meta name="description" content="杨青个人博客，是一个站在web前端设计之路的女程序员个人网站，提供个人博客模板免费资源下载的个人原创网站。" />
<link href="<?php echo CSS_PATH;?>base.css" rel="stylesheet">
<link href="<?php echo CSS_PATH;?>mood.css" rel="stylesheet">
<!--[if lt IE 9]>
<script src="js/modernizr.js"></script>
<![endif]-->
</head>
<body>
<header>
 <nav class="topnav" id="topnav"><a href="index.php"><span>首页</span><span class="en">Protal</span></a><a href="index.php?m=index&&c=blog&&a=newlist"><span>慢生活</span><span class="en">Life</span></a><a href="index.php?m=index&&c=blog&&a=moodlist"><span>碎言碎语</span><span class="en">Doing</span></a><a href="index.php?m=index&&c=index&&a=insertAc"><span>留言版</span><span class="en">Gustbook</span></a></nav>
  </nav>
</header>
<div class="moodlist">
  <h1 class="t_nav"><span>删删写写，回回忆忆，虽无法行云流水，却也可碎言碎语。</span><a href="/" class="n1">网站首页</a><a class="n2">碎言碎语</a></h1>
  <?php foreach($result as $key=>$value): ?>
  <div class="bloglist">
    <ul class="arrow_box">
    
     <div class="sy" style="margin-left:20px;">
      <?=$value['username']; ?>
      <p> <?=$value['messages']; ?></p>
      </div>
      <span class="dateview"><?=date('Y-m-d H:i:s',$value['addtime'])?></span>
    </ul> 
  </div>
   <?php endforeach;?>
</div>
<script src="<?php echo JS_PATH;?>silder.js"></script>
</body>
</html>