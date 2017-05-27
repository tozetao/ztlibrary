<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Fixed Top Navbar Example for Bootstrap</title>
        <link href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
        <style type="text/css">
        	*{padding:0px;margin:0px;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;}
        	ul{list-style: none;}
        	.wrap{
        		width:100%;
        		height:auto;
        		margin-top:50px;
        		background: #f5f5f5;
        	}
			.wrap .left{
				width:160px;
				float: left;
				border:1px solid green;
			}
			.wrap .left li a,h4{
				display: inline-block;
				width:100%;
				height:28px;
				line-height:28px;
				text-align: center;
				font-weight: bolder;
				color:#000;
			}
			.wrap .left li h4{margin:0px;background: #e3e3e3}
			.wrap .right{
				float: right;
				border:1px solid #ccc;
			}
        </style>
        <base target="url">
    </head>
  	<body>
  		
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Project name</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
                <li class="dropdown"><a href="#">Dropdown</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a>你好:<?php echo $_SESSION['name']?></a></li>
                <li class="dropdown">
                    <a href="<?php echo U('Admin/Login/signout');?>" class="dropdown-toggle">退出</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
	    
  		<div class="wrap">
  			<div class="left">
  				<ul>
	<li><h4>权限管理</h4></li>
	<li><a href="<?php echo U('Admin/Access/index');?>">用户列表</a></li>
	<li><a href="<?php echo U('Admin/Access/role');?>">角色列表</a></li>
	<li><a href="<?php echo U('Admin/Access/node');?>">节点列表</a></li>
</ul>

<!-- 
权限
	将用户的权限以节点的形式来标识。

	模块作为顶级节点 => 控制器作为中间层节点 => 方法作为子节点

 -->
  			</div>
  			<div class="right">
  				<iframe src="<?php echo U('Admin/Access/index');?>" scrolling="yes" width="100%" height="100%" frameborder="0" name="url"></iframe>
  			</div>
  		</div>
	  	<script src="http://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
	    <script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	    <script type="text/javascript">
	        $(function(){
	            $('.navbar-nav li').click(function(){
	                $(this).addClass('active').siblings().removeClass('active');
	            })
	            var win_width = $(window).width();
	            var heights = $(window).height()-50;
	            var widths = win_width - 180;
	            $('.wrap .right').css({width:widths+'px',height:heights+'px'})
	        })
	    </script>
	</body>
</html>