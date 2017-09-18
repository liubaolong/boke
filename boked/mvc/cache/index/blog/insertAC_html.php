<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?=$title; ?></title>
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
  <nav class="topnav" id="topnav"><a href="index.php"><span>首页</span><span class="en">Protal</span></a><a href="index.php?m=index&&c=index&&a=about"><span>关于我</span><span class="en">About</span></a><a href="index.php?m=index&&c=index&&a=newlist"><span>慢生活</span><span class="en">Life</span></a><a href="index.php?m=index&&c=index&&a=moodlist"><span>碎言碎语</span><span class="en">Doing</span></a><a href="index.php?m=index&&c=blog&&a=insertAc"><span>留言版</span><span class="en">Gustbook</span></a></nav>
  </nav>
</header>
<article class="aboutcon">
<h1 class="t_nav"><span>像“草根”一样，紧贴着地面，低调的存在，冬去春 来，枯荣无恙。</span><a href="/" class="n1">网站首页</a><a href="/" class="n2">留言板</a></h1>
<div class="about left">
    <div id="test-editormd">
        <form action="index.php?m=index&c=blog&a=insertAc" method="POST">
                  <div style="width:600px;margin:auto;"><textarea name="info" id="1" class="ckeditor"></textarea>
             <div><input type="submit" value="评论"></div></div>
         </form>
  </div>
</div>
<aside class="right">  
    <div class="about_c">
    <p>网名：<span>DanceSmile</span> | 即步非烟</p>
    <p>姓名：杨青 </p>
    <p>生日：1987-10-30</p>
    <p>籍贯：四川省—成都市</p>
    <p>现居：天津市—滨海新区</p>
    <p>职业：网站设计、网站制作</p>
    <p>喜欢的书：《红与黑》《红楼梦》</p>
    <p>喜欢的音乐：《burning》《just one last dance》《相思引》</p>
<a target="_blank" href="http://wp.qq.com/wpa/qunwpa?idkey=d4d4a26952d46d564ee5bf7782743a70d5a8c405f4f9a33a60b0eec380743c64">
<img src="http://pub.idqqimg.com/wpa/images/group.png" alt="杨青个人博客网站" title="杨青个人博客网站"></a>
<a target="_blank" href="http://mail.qq.com/cgi-bin/qm_share?t=qm_mailme&amp;email=HHh9cn95b3F1cHVye1xtbTJ-c3E" ><img src="http://rescdn.qqmail.com/zh_CN/htmledition/images/function/qm_open/ico_mailme_22.png" alt="杨青个人博客网站"></a>
</div>     
</aside>
</article>
<script src="<?php echo JS_PATH;?>silder.js"></script>
</body>
</html>
<!-- <!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
    <title><?=$title; ?></title>
    <script type="text/javascript" src="public/ckeditor/ckeditor.js"></script>
</head>
<body>
	<div id="test-editormd">
		<form action="index.php?m=index&c=blog&a=insertAc">
                  <div style="width:800px;margin:auto;"><textarea name="info" id="1" class="ckeditor"></textarea>
             <div><input type="submit" value="评论"></div></div>
         </form>
    </div>

</body>
</html> -->

