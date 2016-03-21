<a href="reg.html">注册</a><br>
<?php
/**
 * Created by PhpStorm.
 * User: chrx
 * Date: 16/3/21
 * Time: 20:19
 */

require_once 'redis.php';
header("content-type:text/html;charset=utf-8");

for($i = 1; $i <= $redis->get("userid"); ++$i){

    $data[] = $redis->hGetAll("user:$i");

}

$data = array_filter($data);

?>
<table cellspacing="0" cellpadding="5" border="1" align="center">

    <caption>用户信息</caption>
    <tr><th>uid</th><th>name</th><th>age</th><th>操作</th></tr>


<?php
foreach($data as $item) {
    echo "<tr><td>" . $item['uid'] . "</td>".
        "<td>".$item['name']."</td>".
        "<td>".$item['age']."</td>".
        "<td><a href='del.php?id=".$item['uid'].">删除</a></td></tr>";
}
?>
</table>