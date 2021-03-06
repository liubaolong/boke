﻿<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?=WEB_NAME?><?=$title; ?></title>
<meta name="keywords" content="个人博客模板,博客模板" />
<meta name="description" content="寻梦主题的个人博客模板，优雅、稳重、大气,低调。" />
<link href="<?php echo CSS_PATH;?>base.css" rel="stylesheet">
<link href="<?php echo CSS_PATH;?>index.css" rel="stylesheet">
<!--[if lt IE 9]>
<script src="js/modernizr.js"></script>
<![endif]-->
</head>
<body>

<header>
  <nav class="topnav" id="topnav" style='overflow:hidden;'>

  <?php if(!empty($_SESSION['user'])):?><div style="font-size:24px;float:left;">欢迎<?=$_SESSION['user']; ?></div>
  <?php else:?><div style="font-size:24px;float:left;">
  <a href="index.php?m=index&c=user&a=register" style="border:1px solid blue;">登录</a>  |   <a href="index.php?m=index&c=user&a=register" style="border:1px solid green">注册</a>
 </div><?php endif;?> <div style="font-size:24px;float:left;"> | <a href="index.php?oid=1" style="border:1px solid black;">  退出</a>  <?php if(!empty($_SESSION['undertype'])):?>
|  <a href="index.php?m=admin&c=index&a=admin" style="font-size:24px;float:left;">管理</a> 
  <?php endif;?></div><a href="index.php"><span>首页</span><span class="en">Protal</span></a><a href="index.php?m=index&&c=blog&&a=newlist"><span>慢生活</span><span class="en">Life</span></a><a href="index.php?m=index&&c=blog&&a=moodlist"><span>碎言碎语</span><span class="en">Doing</span></a><a href="index.php?m=index&&c=index&&a=insertAc"><span>留言版</span><span class="en">Gustbook</span></a></nav>
  </nav>
</header>

<div class="banner">
  <section class="box">
    <ul class="texts"'>
    <p> 一个程序员在海滨游泳时溺水身亡。</p>
    <p>当时海滩上有许多救生员，救生员们只听见有人大声喊“F1!”“F1!”，谁都不知道“F1”究竟是什么意思。</p>
    </ul>
  </section>

</div>
<article>
  <h2 class="title_tj">
    <p>文章<span>推荐</span></p>
  </h2>
  <div class="bloglist left">
  <?php foreach($data as $key=>$value): ?>
    <h3><?=$value['title']; ?></h3>
    <figure><img src="<?php echo IMG_PATH;?>001.png"></figure>
    <ul>
      <span style="display:block;height:96px;line-height:34px;overflow:hidden;text-overflow:ellipsis;">
      <a href="index.php?bid=<?=$value['bid']; ?>&m=index&c=blog&a=about"><?=$value['content']; ?></a></span>
      <a title="/" href="index.php?bid=<?=$value['bid']; ?>&m=index&c=blog&a=about"  class="readmore">阅读全文>></a>
    </ul>
    <p class="dateview"><span><?=date('Y-m-d',$value['addtime'])?></span><span>作者:long</span>
    <span>
    <?php if(empty($_SESSION['user'])):?>
      <a href="index.php?&m=index&c=user&a=register">赞</a>
    <?php else:?>
        <?php if(!empty($likes)):?>
            <?php if(!in_array($value['bid'],$likes[0])){ ?><a href="index.php?lid=1&id=<?=$value['bid']; ?>&m=index&c=index&a=index">赞</a> 
            <?php }else{ ?>
            <a href="index.php?lid=1&id=<?=$value['bid']; ?>&m=index&c=index&a=index">已赞</a>
            <?php } ?>
        <?php else:?>
            <a href="index.php?lid=1&id=<?=$value['bid']; ?>&m=index&c=index&a=index">赞</a> 
        <?php endif;?>
    <?php endif;?>
    </span>
    <span>
    <?php if(empty($_SESSION['user'])):?>
      <a href="index.php?m=index&c=user&a=register">收藏 </a>
    <?php else:?>
        <?php if(!empty($collect)):?>
            <?php if(!in_array($value['bid'],$collect[0])){ ?><a href="index.php?lid=2&id=<?=$value['bid']; ?>&m=index&c=index&a=index">收藏 </a>
            <?php }else{ ?><a href="index.php?id=<?=$value['bid']; ?>&m=index&c=index&a=index">已收藏</a>
            <?php } ?>
        <?php else:?>
            <a href="index.php?lid=2&id=<?=$value['bid']; ?>&m=index&c=index&a=index">收藏 </a>
        <?php endif;?>
    <?php endif;?>
    </span>浏览数 <?=$value['hits']; ?>
    </p>

  <?php endforeach;?>
  </div>
  <aside class="right">
    <div class="weather"><iframe width="420" scrolling="no" height="60" frameborder="0" allowtransparency="true" src="http://i.tianqi.com/index.php?c=code&id=12&icon=1&py=beijing&num=1&site=12"></iframe></div>
    <div class="news">
    <h3>
      <p>最新<span>文章</span></p>
    </h3>
    <ul class="rank">
    <?php foreach($newdata as $key=>$value): ?>
      <li><a href="index.php?bid=<?=$value['bid']; ?>&m=index&c=blog&a=about" title="Column 三栏布局 个人网站模板" "><?=$value['title']; ?></a></li>
    <?php endforeach;?>  
    </ul>
    </div>  
    <!-- Baidu Button BEGIN -->
    <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585" ></script> 
    <script type="text/javascript" id="bdshell_js"></script> 
    <script type="text/javascript">
document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
</script> 
    <!-- Baidu Button END -->   
    <a href="/" class="weixin"> </a></aside>
</article>
<footer>
</footer>
<script src="<?php echo JS_PATH;?>silder.js"></script>
</body>
</html>
