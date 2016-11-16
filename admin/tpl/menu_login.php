<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>输入公众号相关信息</title>
</head>
<body>
    <div>
        <form action="wx_menu.php?act=login" method="post">
            <table>
                <tr>
                    <td> username: </td>
                    <td>
                        <input type="text" name="username">
                    </td>
                </tr>
                <tr>
                    <td> passwd: </td>
                    <td>
                        <input type="password" name="passwd">
                    </td>
                </tr>
            </table>
            <button onclick="submit">提交</button>
        </form>
    </div>
</body>
</html>
