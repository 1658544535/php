<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>登陆</title>
    <link rel="stylesheet" type="text/css" href="css/base.css" />
    <link rel="stylesheet" type="text/css" href="css/login.css" />
</head>
<body>
    <div class="wrap">
        <h1 class="login-logo">拼得好</h1>

        <section class="login-content">

            <!-- <h2 class="login-title">登录拼得好管理系统</h2> -->
            
            <form action="auth.php?act=login" method="post" accept-charset="utf-8">

                <dl class="login-form">
                    <!-- <dt>用户名:</dt> -->
                    <dd>
                        <i class="login-icon l-i-user"></i>
                        <input type="text" name="username" placeholder="请输入用户名..." />
                    </dd>
                    <!-- <dt>密码:</dt> -->
                    <dd>
                        <i class="login-icon l-i-pwd"></i>
                        <input type="password" name="passwd" placeholder="请输入密码..." />
                    </dd>
                </dl>

                <div class="login-submit">
                    <input type="submit" value="登 录" />
                </div>

            </form>

        </section>
        
    </div>
</body>
</html>
