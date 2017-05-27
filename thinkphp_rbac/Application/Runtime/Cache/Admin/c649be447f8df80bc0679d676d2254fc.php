<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 新 Bootstrap 核心 CSS 文件 -->
	<link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">

<!-- 可选的Bootstrap主题文件（一般不用引入） -->

<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
	<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>

<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
	<script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <style type="text/css">
		.title{
			border-bottom: 1px dotted #ccc;
			height:auto;
			text-align: center;
			font-weight: bolder;
			font-size: 21px;
			color: #000;
			padding: 5px;
			margin-bottom:5px; 
		}
		.control-label{
			padding: 7px 2px;
		}
    </style>
</head>
<body>
	<div class="title">添加节点</div>
	<div class="container-fluid">
		<form class="form-horizontal" method="post" action="<?php echo U('Admin/Access/do_node');?>">
		  	<div class="form-group">
		    	<label for="inputEmail3" class="col-md-1 control-label"><?php echo ($view); ?>:</label>
		    	<div class="col-md-3">
		      		<input type="text" class="form-control" name="name">
		    	</div>
		  	</div>
		  	<div class="form-group">
		    	<label for="inputPassword3" class="col-md-1 control-label">描述:</label>
		    	<div class="col-md-3">
		      		<input type="text" class="form-control" name="title">
		    	</div>
		  	</div>
		  	<div class="form-group">
		    	<label for="inputPassword3" class="col-md-1 control-label">排序:</label>
		    	<div class="col-md-3">
		      		<input type="text" class="form-control" value="100" name="sort">
		      		<input type="hidden" name="level" value="<?php echo ($level); ?>">
		      		<input type="hidden" name="pid" value="<?php echo ($pid); ?>">
		    	</div>
		  	</div>
		  	<div class="form-group">
		    	<div class="col-md-offset-1 col-md-3">
		      		<button type="submit" class="btn btn-default">保存</button>
		    	</div>
		  	</div>
		</form>
	</div>
</body>
</html>