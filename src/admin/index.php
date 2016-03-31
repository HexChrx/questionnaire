<?php
/**
 * Created by PhpStorm.
 * User: chrx
 * Date: 16/3/14
 * Time: 18:53
 */
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd";>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>管理员登录</title>

</head>
<body>
<h3 align="center">请登录</h3>
<form name="rolesele" action="loginprocess.php" method="post">
    <table cellpadding="0" cellspacing="15" border="0" align="center">
        <tr align="center">
            <td><label>用户名:
                    <input type="text" name="username">
                </label></td>
        </tr>
        <tr>
            <td><label>密&nbsp;码:
                    <input type="password" name="password">
                </label></td>
        </tr>

            <td align="center">
                <input type="submit" value="登录">
            </td>
        </tr>
    </table>

</form>

</body>
</html>
