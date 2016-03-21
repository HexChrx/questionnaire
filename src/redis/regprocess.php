<?php
/**
 * Created by PhpStorm.
 * User: chrx
 * Date: 16/3/21
 * Time: 19:46
 */

require_once 'redis.php';

$uesrname = $_POST['name'];
$password = md5($_POST['password']);
$age = $_POST['age'];
$uid = $redis->incr("userid");
$redis->hMset("user:$uid",array("uid" => $uid,
                                "name" => $uesrname,
                                "password" => $password,
                                "age" => $age));

header("location:list.php");