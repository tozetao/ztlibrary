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
        input[type='checkbox']{
            margin:auto 5px;
        }
    </style>
</head>
<body>
    <div class="title">权限列表</div>
    <div class="container-fluid">
        <form action="" method="post">
            <?php if(is_array($data)): foreach($data as $key=>$v): ?><div style="margin:5px;border-bottom:1px dotted #ccc">
                    <button type="button" class="btn btn-primary"><?php echo ($v['title']); ?></button>
                    <input type="checkbox" name="access[]" class="level1" value="<?php echo ($v['id']); ?>" <?php if(in_array($v['id'], $ids))echo "checked"?>>
                    <?php if(is_array($v['child'])): foreach($v['child'] as $key=>$con): ?><div style="margin:5px;border-top:1px solid #555">
                            <button type="button" class="btn btn-success"><?php echo ($con['title']); ?></button>
                            <input type="checkbox" name="access[]" class="level2" value="<?php echo ($con['id']); ?>" <?php if(in_array($con['id'], $ids))echo "checked"?>>
                        </div>
                        <div style="margin:5px;">
                            <?php if(is_array($con['child'])): foreach($con['child'] as $key=>$act): ?><button type="button" class="btn btn-info" ><?php echo ($act['title']); ?></button>
                                <input type="checkbox" name="access[]" class="level3" value="<?php echo ($act['id']); ?>" <?php if(in_array($act['id'], $ids))echo "checked"?>><?php endforeach; endif; ?>
                        </div><?php endforeach; endif; ?>
                </div><?php endforeach; endif; ?>
            <input type="hidden" name="id" value="<?php echo ($id); ?>">
            <button style="margin-left:10px" type="submit" class="btn btn-default">保存</button>

        </form>
    </div>
    <script type="text/javascript">
        $(function(){
            $('.level1').click(function(){
                if($(this).prop('checked')){
                    $(this).parent().find("input[type='checkbox']").prop('checked',true);
                }else{
                    $(this).parent().find("input[type='checkbox']").prop('checked',false);
                }   
            })
            $('.level2').click(function(){
                if($(this).prop('checked')){
                    $(this).parent().next().find("input[type='checkbox']").prop('checked',true);
                }else{
                   $(this).parent().next().find("input[type='checkbox']").prop('checked',false); 
                }
                
            })
            $('.level3').click(function(){
                var is = $(this).prop('checked');
                if(is){
                    $(this).prop('checked',true);
                }else{
                    $(this).prop('checked',false);
                }
            })
        })
    </script>
</body>
</html>