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
        <a class="btn btn-default" href="<?php echo U('Admin/Access/add_user');?>" >添加用户</a>
    </div>
    <div class="container-fluid">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>名称</th>
                    <th>角色</th>
                    <th>时间</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($data)): foreach($data as $key=>$v): ?><tr>
                        <td><?php echo ($v['id']); ?></td>
                        <td><?php echo ($v['name']); ?></td>
                        <td><?php echo ($v['role']); ?></td>
                        <td><?php echo (date("Y-m-d",$v['time'])); ?></td>
                        <td>
                            <a href="<?php echo U('Admin/Access/add_user',array('user_id'=>$v['id'],'role_id'=>$v['role_id']));?>">编辑</a>
                            <a href="<?php echo U('Admin/Access/del_user',array('id'=>$v['id']));?>">删除</a>
                        </td>
                    </tr><?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>