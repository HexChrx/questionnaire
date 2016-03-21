<a href="reg.html">注册</a><br>
<?php
/**
 * Created by PhpStorm.
 * User: chrx
 * Date: 16/3/21
 * Time: 20:19
 */

require_once 'redis.php';

for($i = 1; $i < $redis->get("userid"); ++$i){

    $data[] = $redis->hGetAll("user:$i");

}

$data = array_filter($data);
?>
<table cellspacing="5" cellpadding="0" border="1" align="center">

    <caption>用户信息</caption>
    <tr><th>uid</th><th>name</th><th>age</th><th>操作</th></tr>


<?php
foreach($data as $item) {
    echo "<tr><td>" . $item['uid'] . "</td>".
        "<td>".$item['name']."</td>".
        "<td>".$item['age']."</td>".
        "<td><a href='del.php?id='".$item['uid']."</td></tr>";
}
?>
</table>