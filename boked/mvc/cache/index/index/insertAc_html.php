<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?=WEB_NAME?><?=$title; ?></title>
<script type="text/javascript" src="public/ckeditor/ckeditor.js"></script>
<meta name="keywords" content="个人博客,杨青个人博客,个人博客模板,杨青" />
<meta name="description" content="杨青个人博客，是一个站在web前端设计之路的女程序员个人网站，提供个人博客模板免费资源下载的个人原创网站。" />
<link href="<?php echo CSS_PATH;?>base.css" rel="stylesheet">
<link href="<?php echo CSS_PATH;?>about.css" rel="stylesheet">
<!--[if lt IE 9]>
<script src="js/modernizr.js"></script>
<![endif]-->

</head>
<body>
<header>
  <nav class="topnav" id="topnav"><a href="index.php"><span>首页</span><span class="en">Protal</span></a><a href="index.php?m=index&&c=blog&&a=newlist"><span>慢生活</span><span class="en">Life</span></a><a href="index.php?m=index&&c=blog&&a=moodlist"><span>碎言碎语</span><span class="en">Doing</span></a><a href="index.php?m=index&&c=index&&a=insertAc"><span>留言版</span><span class="en">Gustbook</span></a></nav>
  </nav>
</header>
<article class="aboutcon">
<h1 class="t_nav"><span>像“草根”一样，紧贴着地面，低调的存在，冬去春 来，枯荣无恙。</span><a href="/" class="n1">网站首页</a><a href="index.php?m=index&c=index&a=insertAc" class="n2">留言板</a></h1>
<div class="about left">
    <div id="test-editormd">
    <?php if(!empty($_SESSION['user'])):?>
        <form action="index.php?m=index&c=index&a=insertAc" method="POST">
                  <div style="width:600px;margin:auto;"><textarea name="info" id="1" class="ckeditor"></textarea>
             <div><input type="submit" value="评论"></div></div>
         </form>
    <?php else:?>
           <form action="index.php?m=index&c=user&a=register" method="POST">
                  <div style="width:600px;margin:auto;"><textarea  id="1" class="ckeditor"></textarea>
             <div><a href="index.php?m=index&c=user&a=register"><input type="submit" value="评论" style="width:100px;height:50px;"></a></div></div>
         </form>
    <?php endif;?>
  </div>
</div>
<aside class="right">  
    <div class="about_c">
    <p>QQ：<?=WEB_QQ?></p>
    <p>姓名：<?=WEB_USER?> </p>
    <p>生日：<?=WEB_BRITHDAY?></p>
    <p>籍贯：<?=WEB_ADRESS?></p>
    <p>网站描述：<?=WEB_TITLE?></p>
    <p>网站关键字：<?=WEB_CONTENT?></p>
    <p>联系电话：<?=WEB_PHONE?></p>
    <p>喜欢的书：<?=WEB_BOOK?></p>
<a target="_blank" href="http://wp.qq.com/wpa/qunwpa?idkey=d4d4a26952d46d564ee5bf7782743a70d5a8c405f4f9a33a60b0eec380743c64">
<img src="http://pub.idqqimg.com/wpa/images/group.png" alt="杨青个人博客网站" title="杨青个人博客网站"></a>
<a target="_blank" href="http://mail.qq.com/cgi-bin/qm_share?t=qm_mailme&amp;email=HHh9cn95b3F1cHVye1xtbTJ-c3E" ><img src="http://rescdn.qqmail.com/zh_CN/htmledition/images/function/qm_open/ico_mailme_22.png" alt="杨青个人博客网站"></a>
</div>     
</aside>
</article>
<script src="<?php echo JS_PATH;?>silder.js"></script>
</body>
</html>


