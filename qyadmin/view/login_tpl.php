<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>拼得好后台管理</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="<?php echo __CSS__;?>bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo __CSS__;?>font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo __CSS__;?>ionicons.min.css">
    <link rel="stylesheet" href="<?php echo __CSS__;?>AdminLTE.min.css">
    <link rel="stylesheet" href="<?php echo __CSS__;?>skins/skin-blue.min.css">
    <!-- sweetalert2 -->
    <link rel="stylesheet" href="<?php echo __CSS__;?>sweetalert2.min.css">
    <!-- 样式重写 -->
    <link rel="stylesheet" href="<?php echo __CSS__;?>reset.css">
    <!--[if lt IE 9]>
    <script src="<?php echo __JS__;?>html5shiv.min.js"></script>
    <script src="<?php echo __JS__;?>respond.min.js"></script>
    <![endif]-->
</head>

<body>

<style>
    .content-wrapper {
        background:none!important;
    }
</style>
<div class="login-box">
    <div class="login-logo">
        <a><b>拼得好</b>后台</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <form action="<?php echo url('publicOp', 'login');?>" method="post" id="loginForm">
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="请输入管理员账号 ..." name="username">
                <!--<span class="glyphicon glyphicon-envelope form-control-feedback"></span>-->
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="请输入密码 ..." name="password">
                <!--<span class="glyphicon glyphicon-lock form-control-feedback"></span>-->
            </div>
            <div class="row">
                <div class="col-xs-4 col-xs-offset-8">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">登陆</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
    </div>
    <!-- /.login-box-body -->
</div>

<!-- jQuery 2.2.3 -->
<script src="<?php echo __JS__;?>jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo __JS__;?>bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo __JS__;?>app.js"></script>
<!-- sweetalert2 -->
<script src="<?php echo __JS__;?>sweetalert2.min.js"></script>

<script src="<?php echo __JS__;?>jquery.form.js"></script>

<script>
    /* ajax 提交登陆 */
    $('#loginForm').ajaxForm({
        dataType: "json",
        success: function (data) {
            if(data.status){
                window.location.href="<?php echo url('Index');?>";
            }else{
                alert(data.info);
            }
        }
    });
</script>
</body>

</html>