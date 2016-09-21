<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo WXADMINNAME; ?></title>
    <link rel="stylesheet" type="text/css" href="css/common.css"/>
    <link rel="stylesheet" type="text/css" href="css/main.css"/>
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css"/>
    <script type="text/javascript" src="js/libs/modernizr.min.js"></script>
    <script src="js/jquery.min.js"></script>
	<script src="js/jquery-ui.min.js"></script>
</head>
<body>
<div class="topbar-wrap white">
    <div class="topbar-inner clearfix">
        <div class="topbar-logo-wrap clearfix">
            <h1 class="topbar-logo none"><a href="index.html" class="navbar-brand">后台管理</a></h1>
            <ul class="navbar-list clearfix">
                <li><a class="on" href="/market">首页</a></li>
            </ul>
        </div>
        <div class="top-info-wrap">
            <ul class="top-info-list clearfix">
                <li><a href="<?php echo $site_admin; ?>login.php?act=logout" onclick="return confirm('确认要退出该帐号么？')" >退出</a></li>
            </ul>
        </div>
    </div>
</div>

<div class="container clearfix">
    <div class="sidebar-wrap">
        <div class="sidebar-title">
            <h1>菜单</h1>
        </div>
        <div class="sidebar-content">
			<?php include_once('menu.php'); ?>
        </div>
    </div>
