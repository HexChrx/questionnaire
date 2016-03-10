<?php

header("content-type:text/html;charset=utf-8");

require_once 'conn.inc';

$role = $_POST['role'];
//echo $role;
echo '<h2 align="center">请您回答问题</h2>';
$conn = Conn::getInstence();
$sql = "SELECT * FROM questionsview WHERE roleid = $role ORDER BY questionid,label";

$result = $conn->mysqli->query($sql);
$temp = 0;
echo '<table align = "center" border="0" cellspacing="10" cellpadding="0"><tr><td>';
if($row = $result->fetch_assoc()){

    $temp = $row['questionid'];
    echo '1. '.$row['questioncontent'];

}
else{
    echo '<h4 align="center">尚无问题</h4>';
    exit;
}

$result->data_seek(0);
$count = 2;

while($row = $result->fetch_assoc()){

    if($row['questionid'] == $temp){

        echo '<br>&nbsp;&nbsp'.$row['label'].'. ' . $row['optioncontent'];

    } else {
        $temp = $row['questionid'];
        echo "<br>$count. ".$row['questioncontent'].
            '<br>&nbsp;&nbsp'.$row['label'].$row['optioncontent'];
        $count += 1;
    }

}

echo '</td></tr></table>';


/*
$dsn = "mysql:dbname=questionnaire;host=114.215.113.71";

$driver_opt = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES'utf8';");

try {

    $pdo = new PDO($dsn, "root", "aschen1243", $driver_opt);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}

$sql = "SELECT * FROM roles WHERE id = ?";

$stmt = $pdo->prepare($sql);

//绑定参数
$stmt->bindParam(1, $role, PDO::PARAM_INT);

if ($stmt->execute()) {

    echo "<table align='center' width='300' cellspacing='0' border='1'>";
    echo "<caption><h3>信息</h3></caption>";
    echo "<tr>";
    for ($i = 0; $i < $stmt->columnCount(); $i++) {

        $field = $stmt->getColumnMeta($i);
        echo "<th>{$field['name']}</th>";
    }
    echo "</tr>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr align='center'>";
        foreach ($row as $value) {
            echo "<td>$value</td>";

        }
    }
    echo "</table>";

}*/