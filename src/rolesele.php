<?php

header("content-type:text/html;charset=utf-8");

require_once 'conn.inc';

function getQuestionType($catelog){

    $type = 'radio';
    switch($catelog){
        //todo 类型增加时，添加case
        case 2: $type = 'checkbox';break;

    }

    return $type;

}

function needBracket($catelog){

    $res = '';
    switch(getQuestionType($catelog)){
        //todo 类型增加时，添加case
        case 'checkbox': $res = '[]';break;

    }
    return $res;
}

$role = $_POST['role'];

if(!isset($role)){

    echo '<h3 align="center">请选择角色</h3><br>'
        .'<h5 align="center">3秒后跳回首页</h5>';

    header("refresh: 3;url='../index.php'");
    exit();

}

echo '<h2 align="center">请您回答问题</h2>';
$conn = new Conn();
$sql = "SELECT * FROM questionsview WHERE roleid = ? ORDER BY questionid,label";

$result = $conn->setResultQuery($sql, array($role));
$temp = 0;
echo '<table align = "center" border="0" cellspacing="10" cellpadding="0"><tr><td>';
if($result != null){

    $temp = $result[0]['questionid'];
    echo '1. '.$result[0]['questioncontent'];

}
else{
    echo '<h4 align="center">尚无问题</h4>';
    exit;
}

$count = 1;

echo '<form action="answerprocess.php" method="post">';


foreach($result as $value){

    if($value['questionid'] == $temp){


        echo '<br>&nbsp;&nbsp'
            .'<input type="'.getQuestionType($value['catelog']).'" name="var'
            .$count.needBracket($value['catelog']).'" value="'.$value['optionid'].'">'
            .$value['label'].'. ' . $value['optioncontent'];

    } else {
        $temp = $value['questionid'];
        $count += 1;

        echo "<br>$count. ".$value['questioncontent'].
            '<br>&nbsp;&nbsp'.'<input type="'. getQuestionType($value['catelog'])
            .'" name="var'.$count.needBracket($value['catelog']).'" value="'.$value['optionid'].'">'
            .$value['label'].'. '. $value['optioncontent'];
    }

}
echo '<input type="hidden" name="count" value="'.$count.'">';
echo '<input type="hidden" name="role" value="'.$role.'">';
echo '<br><br><input type="submit" value="提交"/></form></tr></table>';
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