<?php
/**
 * Created by PhpStorm.
 * User: chrx
 * Date: 16/3/21
 * Time: 19:45
 */

$redis = new Redis();
$redis->connect("114.215.113.71", 6379);
$redis->auth("aschen1243");