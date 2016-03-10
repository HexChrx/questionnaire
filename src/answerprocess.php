<?php

header("content-type:text/html;charset=utf-8");
header("refresh: 3;url='../index.php'");
require_once 'conn.inc';

$count = $_POST['count'];
$answer = '';

for($i = 0; $i < $count; ++$i){

    if(!is_null($_POST['radio'.($i + 1)])){

        $answer .= ','.$_POST['radio'.($i + 1)];

    }

}

$answer = ltrim($answer, ',');
//echo $answer;

$conn = new Conn();
$sql = "UPDATE `options` SET count = count + 1 WHERE id IN (?)";
//echo $sql.'<br>';
if($conn->setNoResultQuery($sql, array($answer))){

    echo '<h2 align="center">提交成功，谢谢</h2>';

} else {
    echo '<h2 align="center">提交失败</h2>';
}

echo '<br><h6 align="center">3秒后跳到首页</h6>';

