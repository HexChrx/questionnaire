<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd";>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>角色选择</title>

</head>
<body>
<?php
    require_once 'conn.inc';
?>
<h3 align="center">请选择您的角色</h3>
<form name="roleSelect" action="src/rolesele.php" method="post">
    <table cellpadding="0" cellspacing="15" border="0" align="center">
        <tr align="center">
            <td>
                <?php
                    $conn = Conn::getInstence();
                    $sql = "SELECT * FROM roles";
                    $result = $conn->mysqli->query($sql);
                    echo $result->num_rows;
                ?>
                <input id="radio1" type="radio" name="role" value="1" checked>
                <label for="radio1">普通学生</label>
                <label for="radio2"></label>
                <input id="radio2" type="radio" name="role" value="2">毕业生
                <label>
                    <input type="radio" name="role" value="3">
                </label>研究生
            </td>

            <td align="center">
                <input type="submit" value="确定">
            </td>
        </tr>
    </table>

</form>

</body>
</html>