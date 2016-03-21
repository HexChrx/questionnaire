<?php
/**
 * Created by PhpStorm.
 * User: chrx
 * Date: 16/3/21
 * Time: 20:23
 */

require_once 'redis.php';

$uid = $_GET['uid'];

$redis->del("user:$uid");

header("header:list.php");