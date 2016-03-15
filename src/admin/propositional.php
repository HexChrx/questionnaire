<?php
/**
 * Created by PhpStorm.
 * User: chrx
 * Date: 16/3/14
 * Time: 19:14
 */

require_once '../conn/conn.inc';
session_start();
echo '<h4 align="center">欢迎您：' . $_SESSION['username'] . '</h4><br>';
header("content-type:text/html;charset=utf-8");
function getCatelog($catelog)
{

    switch ($catelog) {

        case 1:
            return "单选题";
        case 2:
            return "多选题";

    }

}

$con = new Conn();

$sql = "SELECT
	questionid,
	questioncontent,
	catelog,
	a.`options`,
	uid,
	group_concat(a.rolename) AS rolename
FROM
	(
		SELECT
			roleid,
			questioncontent,
			catelog,
			questionid,
			uid,
			rolename,
			group_concat(
				label,
				optioncontent
			ORDER BY
				label
			) AS `options`
		FROM
			questionsview
		WHERE uid = ?
		GROUP BY
			questionid,
			roleid
	) a
GROUP BY questionid ";

//echo $sql;

$result = $con->setResultQuery($sql, array('i', $_SESSION['uid']));

?>

<table align="center" width="80%" cellpadding="5" cellspacing="0" border="1">

    <caption><h4>已出题目</h4></caption>
    <tr>
        <th>序号</th>
        <th>题目</th>
        <th>类型</th>
        <th>选项</th>
        <th>角色</th>
        <th>操作</th>
    </tr>
    <?php
    if (is_null($result)) {

        echo '<tr><td colspan="6" align="center" valign="center">没有题目</td></tr>';

    } else {
        $i = 0;
        foreach ($result as $item) {

            $i++;
            echo "<tr><td>$i</td><td>$item[questioncontent]</td><td>" .
                getCatelog($item['catelog']) . "</td><td>$item[options]</td>
                    <td>" . $item['rolename'] . "</td>
                   <td><a href='questiondele.php?id=" . $item['questionid'] . "'>删除</a>
                    </td></tr>";
        }
    }
    ?>
</table>

<?php
$sql = "SELECT id,rolename FROM roles";
$result = $con->setResultQuery($sql);
require_once 'addquestion.php';
