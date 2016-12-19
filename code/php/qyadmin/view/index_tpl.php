<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>拼得好 | 后台管理</title>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/sweetalert2/6.2.0/sweetalert2.min.css">
    <!--accessIds-->
    <script>
        var accessIds_JSON = '{$accessIds}'.split(',');
    </script>
    <!-- 样式重写 -->
    <!--<link rel="stylesheet" href="__PUBLIC__/css/reset.css">-->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="<?php echo __JS__;?>html5shiv.min.js"></script>
    <script src="<?php echo __JS__;?>respond.min.js"></script>
    <![endif]-->
    <style>
        body {
            font-family: "Microsoft YaHei", "微软雅黑", tahoma, arial, simsun, "宋体";
        }
        .content-wrapper {
            position: relative;
        }
        .content {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            padding: 0;
            margin: 0;
        }
        .content>iframe {
            display: block;
            width:100%;
            height:100%;
        }
        .js-access {
            /* display: none; */
        }
    </style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="#" class="logo" style="font-family: 'Microsoft YaHei';">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><strong>拼</strong></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>拼得好后台管理</b></span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="javascript:;" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="<?php echo __IMAGE__;?>user.png" class="user-image" alt="User Image">
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs"><?php echo $admin['username'];?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="<?php echo __IMAGE__;?>user.png" class="img-circle" alt="User Image">

                                <p>
                                    <?php echo $admin['username'];?>
                                    <!--<small>Member since Nov. 2012</small>-->
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <!--
                                <div class="pull-left">
                                    <a href="{:U('Home/index/index')}" target="_blank" class="btn btn-default btn-flat">访问前台</a>
                                </div>
                                <div class="pull-left">
                                    <a href="{:U('admin/admin/password')}" target="iFrameContent" class="btn btn-default btn-flat">修改密码</a>
                                </div>
                                -->
                                <div class="pull-right">
                                    <a href="<?php echo url('publicOp', 'logout');?>" class="btn btn-default btn-flat">注销登陆</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <!-- Control Sidebar Toggle Button -->
                    <!--<li>-->
                    <!--<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>-->
                    <!--</li>-->
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- 左侧边栏 -->
        <?php echo renderTpl('sidebar');?>
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content" >
            <!-- Your Page Content Here -->
            <iframe src="<?php echo url('index', 'welcome');?>" frameborder="0" name="iFrameContent"></iframe>
        </section>
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
            <strong>Copyright &copy; 2016 <a href="#">拼得好</a>.</strong> All rights reserved.
        </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
            <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
            <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <!-- Home tab content -->
            <div class="tab-pane active" id="control-sidebar-home-tab">
                <h3 class="control-sidebar-heading">Recent Activity</h3>
                <ul class="control-sidebar-menu">
                    <li>
                        <a href="javascript::;">
                            <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                                <p>Will be 23 on April 24th</p>
                            </div>
                        </a>
                    </li>
                </ul>
                <!-- /.control-sidebar-menu -->

                <h3 class="control-sidebar-heading">Tasks Progress</h3>
                <ul class="control-sidebar-menu">
                    <li>
                        <a href="javascript:;">
                            <h4 class="control-sidebar-subheading">
                                Custom Template Design
                                <span class="pull-right-container">
<span class="label label-danger pull-right">70%</span>
</span>
                            </h4>

                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                            </div>
                        </a>
                    </li>
                </ul>
                <!-- /.control-sidebar-menu -->

            </div>
            <!-- /.tab-pane -->
            <!-- Stats tab content -->
            <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
            <!-- /.tab-pane -->
            <!-- Settings tab content -->
            <div class="tab-pane" id="control-sidebar-settings-tab">
                <form method="post">
                    <h3 class="control-sidebar-heading">General Settings</h3>

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Report panel usage
                            <input type="checkbox" class="pull-right" checked>
                        </label>

                        <p>
                            Some information about this general settings option
                        </p>
                    </div>
                    <!-- /.form-group -->
                </form>
            </div>
            <!-- /.tab-pane -->
        </div>
    </aside>
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
    immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>

<!-- jQuery 2.2.3 -->
<script src="<?php echo __JS__;?>jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo __JS__;?>bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo __JS__;?>app.js"></script>
<!-- sweetalert2 -->
<script src="<?php echo __JS__;?>sweetalert2.min.js"></script>

</body>
</html>
