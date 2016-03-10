<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd";>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>角色选择</title>

</head>
<body>
<?php
    require_once 'src/conn.inc';
?>
<h3 align="center">请选择您的角色</h3>
<form name="roleSelect" action="src/rolesele.php" method="post">
    <table cellpadding="0" cellspacing="15" border="0" align="center">
        <tr align="center">
            <td>
                <?php
                    $conn = new Conn();
                    $sql = "SELECT * FROM roles";
                    $result = $conn->setResultQuery($sql);
                    if($result != null){

                        echo '<input type="radio" name="role" value="'.
                            $result[0]['id'].'" checked>'.$result[0]['rolename'];

                    }else{
                        exit;
                    }
                    for($i = 1; $i < count($result); ++$i){

                        echo '<input type="radio" name="role" value="'.
                            $result[$i]['id'].'">'.$result[$i]['rolename'];

                    }
                ?>
            </td>
        </tr>
        <tr>
            <td align="center">
                <input type="submit" value="确定">
            </td>
        </tr>
    </table>

</form>

</body>
</html>