<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd";>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>角色选择</title>

</head>
<body>
<?php

header("content-type:text/html;charset=utf-8");
require_once 'src/conn/conn.inc';

$conn = new Conn();

$sql = "UPDATE `property` SET count = count + 1"
    . " WHERE `property`.`property` = 'visit'";

$conn->setNoResultQuery($sql);

$sql = "SELECT count FROM `property` WHERE" .
    "`property`.`property` = 'visit'";

$result = $conn->setResultQuery($sql);
$visitNo = $result[0]['count'];

?>
<h3 align="center">欢迎您第<?php echo $visitNo ?>位访客，请选择您的角色</h3>

<form name="roleSelect" action="src/rolesele.php" method="post">
    <table cellpadding="0" cellspacing="15" border="0" align="center">
        <tr align="center">
            <td>
                <?php
                $sql = "SELECT * FROM roles";
                $result = $conn->setResultQuery($sql);
                if ($result == null) {

                    exit();

                }
                for ($i = 0; $i < count($result); ++$i) {

                    echo '<input type="radio" name="role" value="' .
                        $result[$i]['id'] . '">' . $result[$i]['rolename'];
                    if (($i + 1) % 5 == 0) echo '<br>';

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