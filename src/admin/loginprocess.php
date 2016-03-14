<?php
/**
 * Created by PhpStorm.
 * User: chrx
 * Date: 16/3/14
 * Time: 18:54
 */
header("content-type:text/html;charset=utf-8");
$username = $_POST['username'];
$password = $_POST['password'];

if(!isset($username) || !isset($password)){

    echo '用户名和密码不能为空,3秒后跳到登录页';
    header("refresh: 3;url='../index.php'");
    exit();

}

require_once '../conn/conn.inc';

//echo $username.'  '.$password.'<br>';

$conn = new Conn();

$sql = "SELECT * FROM `users` WHERE username = ? and password = ?";

$param = array('ss',$username, $password);


$result = $conn->setResultQuery($sql, $param);


if(count($result) == 0){

    echo '用户名或密码错误,3秒后跳到登录页';
    //header("refresh: 3;url='index.php'");
    exit();

}

session_start();
$_SESSION['username'] = $username;
$_SESSION['roleid'] = $result[0]['roleid'];

switch($result[0]['roleid']){

    case 1: require_once 'propositional.php';break;
    case 2: require_once 'admin.php';

}
