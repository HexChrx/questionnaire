<?php
/**
 * Created by PhpStorm.
 * User: chrx
 * Date: 16/3/16
 * Time: 9:03
 */

header("content-type:text/html;charset=utf-8");
require_once '../conn/conn.inc';

//echo $_GET['id'];

$conn = new Conn();
$sql = "DELETE FROM questions WHERE id = ?";

if($conn->setNoResultQuery($sql, array('s', $_GET['id']))){

    header("refresh: 0;url='propositional.php'");

}else{

    echo '删除失败，3秒后返回';
    header("refresh: 3;url='propositional.php'");

}
