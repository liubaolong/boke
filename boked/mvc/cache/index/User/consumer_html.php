<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="renderer" content="webkit">
<title></title>
<link rel="stylesheet" href="<?php echo CSS_PATH;?>pintuer.css">
<link rel="stylesheet" href="<?php echo CSS_PATH;?>admin.css">
<script src="<?php echo JS_PATH;?>jquery.js"></script>
<script src="<?php echo JS_PATH;?>pintuer.js"></script>
</head>
<body>
<form method="post" action="index.php?m=admin&c=user&a=consumer" id="listform">
  <div class="panel admin-panel">
    <div class="panel-head"><strong class="icon-reorder"> 内容列表</strong> <a href="" style="float:right; display:none;">添加字段</a></div>
    <div class="padding border-bottom">
      <ul class="search" style="padding-left:10px;">
        <li> <a class="button border-main icon-plus-square-o" href="index.php?m=admin&c=blog&a=add" target="right"> 添加内容</a> </li>
     
      </ul>
    </div>
    <table class="table table-hover text-center">
      <tr>
        <th width="100" style="text-align:left; padding-left:20px;"></th>
        <th>主题</th>
        <th width="10%">注册时间</th>
        <th>手机号</th>
      </tr>
      <volist name="list" id="vo">
      <?php foreach($result as $key=>$value): ?>
        <tr>
          <td style="text-align:left; padding-left:20px;"><input type="checkbox" name="id[]" value="<?=$value['uid']; ?>" />
           </td>
          <td><?=$value['username']; ?></td>
          <td width="10%"><?=date('Y-m-d',$value['regtime'])?></td>
          <td><?=$value['phone']; ?><td>
          <td><div class="button-group" style="float:right;"><?php if($value['allowlogin']==0):?> <a class="button border-red" href="index.php?sid=1&id=<?=$value['uid']; ?>&m=admin&c=user&a=consumer"><span class="icon-trash-o"></span> 锁定</a><?php else:?><a class="button border-red" href="index.php?sid=2&id=<?=$value['uid']; ?>&m=admin&c=user&a=consumer"><span class="icon-trash-o"></span> 解锁</a><?php endif;?> <a class="button border-red" href="index.php?cid=1&id=<?=$value['uid']; ?>&m=admin&c=user&a=consumer"><span class="icon-trash-o"></span> 删除</a> </div></td>
        </tr>
       <?php endforeach;?>
      <tr>
        <td style="text-align:left; padding:19px 0;padding-left:20px;"><input type="checkbox" id="checkall"/>
          全选 </td>
        <td colspan="7" style="text-align:left;padding-left:20px;"><a href="javascript:void(0)" class="button border-red icon-trash-o" style="padding:5px 15px;" onclick="DelSelect()"> 删除</a> 
    </table>
  </div>
</form>
<script type="text/javascript">

//搜索
function changesearch(){	
		
}

//单个删除
function del(id,mid,iscid){
	if(confirm("您确定要删除吗?")){
		
	}
}

//全选
$("#checkall").click(function(){ 
  $("input[name='id[]']").each(function(){
	  if (this.checked) {
		  this.checked = false;
	  }
	  else {
		  this.checked = true;
	  }
  });
})

//批量删除
function DelSelect(){
	var Checkbox=false;
	 $("input[name='id[]']").each(function(){
	  if (this.checked==true) {		
		Checkbox=true;	
	  }
	});
	if (Checkbox){
		var t=confirm("您确认要删除选中的内容吗？");
		if (t==false) return false;		
		$("#listform").submit();		
	}
	else{
		alert("请选择您要删除的内容!");
		return false;
	}
}
</script>
</body>
</html>