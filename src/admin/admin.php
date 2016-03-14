<?php
/**
 * Created by PhpStorm.
 * User: chrx
 * Date: 16/3/14
 * Time: 19:14
 */
session_start();
echo '<h4 align="center">欢迎您：'.$_SESSION['username'].'</h4><br>';