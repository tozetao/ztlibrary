<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<meta http-equiv="X-UA-Compatiable" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- 新 Bootstrap 核心 CSS 文件 -->
	<link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">

<!-- 可选的Bootstrap主题文件（一般不用引入） -->

<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
	<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>

<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
	<script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<style type="text/css">
		.title{margin:10px;}
	</style>
</head>
<body>
	<div class="title">
		<a class="btn btn-default" href="<?php echo U('Admin/Access/add_node');?>" >添加节点</a>
	</div>
	<div class="container-fluid">
		<?php if(is_array($data)): foreach($data as $key=>$v): ?><div style="margin:5px;border-bottom:1px dotted #ccc">
				<button type="button" class="btn btn-primary"><?php echo ($v['title']); ?></button>
				<a href="<?php echo U('Admin/Access/add_node',array('pid'=>$v['id'],'level'=>$v['level'] + 1));?>">添加</a>
				<a href="<?php echo U('Admin/Access/del_node',array('id'=>$v['id']));?>">删除</a>
			</div>
			<?php if(is_array($v['child'])): foreach($v['child'] as $key=>$con): ?><div style="margin:5px;border-top:1px solid #555">
					<button type="button" class="btn btn-success"><?php echo ($con['title']); ?></button>
					<a href="<?php echo U('Admin/Access/add_node',array('pid'=>$con['id'],'level'=>$con['level'] + 1));?>">添加</a>
					<a href="<?php echo U('Admin/Access/del_node',array('id'=>$con['id']));?>">删除</a>
				</div>
				<div style="margin:5px;">
					<?php if(is_array($con['child'])): foreach($con['child'] as $key=>$act): ?><button type="button" class="btn btn-info" ><?php echo ($act['title']); ?></button>
						<a style="margin-right:10px" href="<?php echo U('Admin/Access/del_node',array('id'=>$act['id']));?>">删除</a><?php endforeach; endif; ?>
				</div><?php endforeach; endif; endforeach; endif; ?>
		
	</div>
</body>
</html>