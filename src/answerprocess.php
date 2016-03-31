<?php

header("content-type:text/html;charset=utf-8");
header("refresh: 3;url='../index.php'");
require_once 'conn/conn.inc';

$count = $_POST['count'];
$role = $_POST['role'];
$answer = array();

for($i = 0; $i < $count; ++$i){

    if(!is_null($select = $_POST['var'.($i + 1)])){

        $sub = array();
        if(is_array($select)){

            foreach($select as $value){
                array_push($sub,'s');
                array_push($sub, $value);

                array_push($answer, $sub);
                $sub = array();
            }

        } else {
            array_push($sub,'s');
            array_push($sub, $select);
            array_push($answer, $sub);
        }
    }

}

$conn = new Conn();
if($conn->getConnectErrno()){
    echo "发生错误";
    exit;
}
$conn->beginTransaction();
$sql1 = "UPDATE `options` SET count = count + 1 WHERE id IN (?)";
$sql2 = "UPDATE `roles` SET visitcount = visitcount + 1 WHERE id = ? ";
//echo $sql.'<br>';
if($conn->setNoResultMultiQuery($sql1, $answer) &&
        $conn->setNoResultQuery($sql2, array('s', (string)$role))){

    if($conn->commit()) {
        echo '<h2 align="center">提交成功，谢谢</h2>';
    }else {
        $conn->rollback();
        echo '<h2 align="center">提交失败</h2>';
    }

} else {

    $conn->rollback();
    echo '<h2 align="center">提交失败</h2>';
}

echo '<br><h6 align="center">3秒后跳到首页</h6>';

