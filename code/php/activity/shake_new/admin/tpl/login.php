<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>微商城后台管理</title>
    <link href="css/admin_login.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="admin_login_wrap">
    <h1>后台管理系统</h1>
    <div class="adming_login_border">
        <div class="admin_input">
            <form action="<?php echo $site_admin ?>login.php" method="post">
            	<input type="hidden" name="act" value="post" />
                <ul class="admin_items">
                    <li>
                        <label for="user">用户名：</label>
                        <input type="text" name="username" value="" id="user" size="40" class="admin_input_style" />
                    </li>
                    <li>
                        <label for="pwd">密码：</label>
                        <input type="password" name="pwd" value="" id="pwd" size="40" class="admin_input_style" />
                    </li>
                    </br>
                    <li>
                        <input type="submit" tabindex="3" value="提交" class="btn btn-primary" />
                    </li>
                </ul>
            </form>
        </div>
    </div>
</div>
</body>
</html>