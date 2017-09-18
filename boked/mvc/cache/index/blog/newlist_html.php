﻿<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?=WEB_NAME?><?=$title; ?></title>
<meta name="keywords" content="个人博客,杨青个人博客,个人博客模板,杨青" />
<meta name="description" content="杨青个人博客，是一个站在web前端设计之路的女程序员个人网站，提供个人博客模板免费资源下载的个人原创网站。" />
<link href="<?php echo CSS_PATH;?>base.css" rel="stylesheet">
<link href="<?php echo CSS_PATH;?>style.css" rel="stylesheet">
<!--[if lt IE 9]>
<script src="js/modernizr.js"></script>
<![endif]-->
</head>
<body>
<header>
 <nav class="topnav" id="topnav"><a href="index.php"><span>首页</span><span class="en">Protal</span></a><a href="index.php?m=index&&c=blog&&a=newlist"><span>慢生活</span><span class="en">Life</span></a><a href="index.php?m=index&&c=blog&&a=moodlist"><span>碎言碎语</span><span class="en">Doing</span></a><a href="index.php?m=index&&c=index&&a=insertAc"><span>留言版</span><span class="en">Gustbook</span></a></nav>
  </nav>
</header>
<article class="blogs">
<h1 class="t_nav"><span>“慢生活”不是懒惰，放慢速度不是拖延时间，而是让我们在生活中寻找到平衡。</span><a href="index.php" class="n1">网站首页</a><a class="n2"><?=$title; ?></a></h1>
<div class="newblog left">
  <?php foreach($data as $key=>$value): ?>
   <h2><?=$value['title']; ?></h2>
   <p class="dateview"><span><?=date('Y-m-d H:i:s',$value['addtime'])?></span><span>作者：long</span></span></p>
    <figure><img src="<?php echo IMG_PATH;?>001.png"></figure>
    
    <ul class="nlist">
      <span style="display:block;height:96px;line-height:34px;overflow:hidden;text-overflow:ellipsis;"><?=$value['content']; ?></span>
      <a title="/" href="index.php?bid=<?=$value['bid']; ?>&m=index&c=blog&a=about" class="readmore">阅读全文>></a>
    </ul>
    <?php endforeach;?>
    <div class="line"></div>  
    <div class="blank"></div>
</div>
<aside class="right">
   <div class="rnav">
      <ul>
       <li class="rnav1"><a >日记</a></li>
       <li class="rnav2"><a >程序人生</a></li>
       <li class="rnav3"><a >欣赏</a></li>
       <li class="rnav4"><a >短信祝福</a></li>
     </ul>      
    </div>
<div class="news">
<h3>
      <p>最新<span>文章</span></p>
    </h3>
    <ul class="rank">
    <?php foreach($newdata as $key=>$value): ?>
      <li><a href="index.php?bid=<?=$value['bid']; ?>&m=index&c=blog&a=about" ><?=$value['title']; ?></a></li>
    <?php endforeach;?>
    </ul>
    <h3 class="ph">
      <p>点击<span>排行</span></p>
    </h3>
    <ul class="paih">
    <?php foreach($hitsdata as $k=>$v): ?>
      <li><a href="index.php?bid=<?=$value['bid']; ?>&m=index&c=blog&a=about"><?=$v['title']; ?></a></li>
    <?php endforeach;?>
    </ul>
    </div>

    <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585" ></script> 
    <script type="text/javascript" id="bdshell_js"></script> 
    <script type="text/javascript">
document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
</script> 
    <!-- Baidu Button END -->   
</aside>
</article>
<script src="<?php echo JS_PATH;?>silder.js"></script>
</body>
</html>