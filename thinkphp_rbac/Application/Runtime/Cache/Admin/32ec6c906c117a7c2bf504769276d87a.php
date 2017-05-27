<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>注册</title>
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
        .dialog{
            position: absolute;
            left:0px;
            top:0px;
            z-index: 99;
            background: rgba(0,0,0,0.75);
            padding: 100px ;
        }
        .dialog .head{
            width:360px;
            margin:0 auto;
            background-color: #fff;
            padding: 0px 20px;
        }
        .dialog .head a{
            display: inline-block;
            width: 60px;
            height:48px;
            line-height: 48px;
            text-align: center;
            color:#666;
            font-size: 16px;

        }
        .dialog .head a.active{
            color:#f00;
            border-bottom: 1px solid #f00;
        }
        .dialog .content{
            width:360px;
            margin:0px auto;
            background-color: #fff;
            padding: 10px 20px;
        }
        .dialog .content ul{
            list-style: none;
            width:100%;
            padding: 0px;
        }
        .dialog .content ul li{
            margin:5px auto;
            width:100%;
        }
        .dialog .content ul li input[type="text"],input[type="password"]{
            display: inline-block;
            width:90%;
            height:30px;
        }
        .dialog .content ul li img{
            margin-left:10px;
        }
        .dialog .content ul.register{
            display: none;
        }

    </style>
</head>
<body>
    <div class="dialog">
        <div class="head">
            <a href="#" class="active login">登陆</a>
            <a href="#" class="register">注册</a>
        </div>
        <div class="content">
            <ul class="register">
                <form class="form-horizontal" method="post" action="<?php echo U('Admin/Login/signup');?>">
                    <li><input type="text" name="name" placeholder="用户名"/></li>
                    <li><input type="password" name="passwd" placeholder="密码"></li>
                    <li><input type="password" name="confirm" placeholder="确认密码"></li>
                    <li>
                        <input type="text" name="code" style="width:80px">
                        <img class="captcha" src="<?php echo U('Admin/Login/captcha');?>" alt="">
                    </li>
                    <li><input type="submit" value="提交"></li>
                </form>
            </ul>
            <ul class="login">
                <form class="form-horizontal" method="post" action="<?php echo U('Admin/Login/signin');?>">
                    <li><input type="text" name="name" placeholder="用户名"/></li>
                    <li><input type="password" name="passwd" placeholder="密码"></li>
                    <li>
                        <input type="text" name="code"  style="width:80px">
                        <img class="captcha" src="<?php echo U('Admin/Login/captcha');?>" alt="">
                    </li>
                    <li><input type="submit" value="提交"></li>
                </form>
            </ul>
        </div>
    </div>
    <script type="text/javascript">
        $(function(){
            var width = $(window).width();
            var height = $(window).height();
            $('.dialog').css({width:width+'px',height:height+'px'})
            $('.dialog .head a.login').click(function(){
                $(this).siblings().removeClass('active');
                $(this).addClass('active').css({'text-decoration':'none'});
                $('.dialog .content .login').css({'display':'block'});
                $('.dialog .content .register').css({'display':'none'});
                //$('.dialog .content form').attr('action',"<?php echo U('Admin/Login/signin');?>");
            })
            $('.dialog .head a.register').click(function(){
                $(this).siblings().removeClass('active');
                $(this).addClass('active').css({'text-decoration':'none'});
                $('.dialog .content .login').css({'display':'none'});
                $('.dialog .content .register').css({'display':'block'});
                //$('.dialog .content form').attr('action',"<?php echo U('Admin/Login/signup');?>")
            })
            $('.captcha').click(function(){
                var url = "<?php echo U('Admin/Login/captcha');?>";
                $('.captcha').attr('src',url+'?id='+Math.random());
            })
        })

        
    </script>
</body>
</html>