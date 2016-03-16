<?php
/**
 * Created by PhpStorm.
 * User: chrx
 * Date: 16/3/16
 * Time: 9:17
 */

require_once '../conn/conn.inc';
header("content-type:text/html;charset=utf-8");
$questionid = $_GET['id'];

$sql = "SELECT * FROM questions WHERE id = ?";

$conn = new Conn();
$question = $conn->setResultQuery($sql, array('s', $questionid));

$sql = "SELECT * FROM options WHERE qid = ?";
$options = $conn->setResultQuery($sql, array('s',$questionid));

if(!is_null($question)){

    ?>
    <table align="center" cellpadding="5" cellspacing="0" border="1">
        <caption>编辑问题</caption>
        <tr>
            <td align="center">题目内容</td><td><? $question[0]['content'] ?></td>
        </tr>
        <tr>
        <td rowspan="<?count($options)?>"></td><td><?echo $options[0]['label'].'. '.$options[0]['label']?></td>
    </table>


    <?php

}