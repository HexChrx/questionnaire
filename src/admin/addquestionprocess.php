<?php
/**
 * Created by PhpStorm.
 * User: chrx
 * Date: 16/3/15
 * Time: 19:01
 */
header("content-type:text/html;charset=utf-8");
echo $_POST['questioncontent'].'<br>';
$oc = $_POST['optioncount'].'<br>';

echo $_POST['catelog'];
print_r($_POST['roleid']);

require_once '../conn/conn.inc';
session_start();
$conn = new Conn();
$conn->beginTransaction();
$sql = "INSERT INTO questions(content,uid,catelog,addtime) VALUES (?,?,?,?)";
$d =  date('Y-m-d H:i:s',time());
$param = array('ssss',$_POST['questioncontent'],
                $_SESSION['uid'],$_POST['catelog'],$d);
$qid = 0;
print_r($param);
$validation = true;
if($conn->setNoResultQuery($sql, $param)){
    $validation = true;
    $qid = $conn->getInsertId();

}else{
    $validation = false;
}
//echo '<br>'.$qid.'<br>';

$sql = "INSERT INTO role_question (roleid,questionid) VALUES (?,?)";

$roleid = $_POST['roleid'];
$param = array();
if(is_array($roleid)){

    foreach($roleid as $value){

        $sub = array('ss');
        array_push($sub, $value);
        array_push($sub, $qid);
        array_push($param, $sub);

    }

    $validation = $validation && $conn->setNoResultMultiQuery($sql, $param);

}
$sql = "INSERT INTO `options` (label,content,qid,addtime) VALUES (?,?,?,?)";
$param = array();
for($i = 1;$i <= (int)$oc; ++$i){

    $sub = array('ssss');
    array_push($sub, chr(ord('A')+$i - 1));
    array_push($sub, $_POST["option$i"]);
    array_push($sub, $qid);
    array_push($sub, $d);

    array_push($param, $sub);
}

print_r($param);

$validation = $validation && $conn->setNoResultMultiQuery($sql, $param);

if($validation && $conn->commit()){
    echo "插入成功";
    header("refresh: 3;url='propositional.php'");

}else{
    $conn->rollback();
    echo '失败，回滚';
}