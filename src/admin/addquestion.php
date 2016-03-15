<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>添加题目</title>

</head>
<body>

<script type="text/javascript">
    function insertOption() {

        var form1 = document.getElementById("addquestion");
        var oc = document.getElementById('oc');
        oc.value = parseInt(oc.value) + 1;
        //创建文本
        var text15 = document.createElement('input');
        text15.setAttribute('type', 'text');
        text15.setAttribute('name', "option" + oc.value);
        text15.setAttribute('id', "text" + oc.value);
        //把文本添加到li下面 appendChild

        form1.appendChild(text15);

        /*
        var btn = document.createElement('input');
        btn.setAttribute('type', 'button');
        //btn.attachEvent('onclick',deleOpt(oc.value))
        btn.setAttribute('id','btn' + oc.value);
        btn.setAttribute('onclick','deleOpt('+ oc.value +')');
        form1.appendChild(btn);
        */

    }

    function deleOpt(id){

        var form1 = document.getElementById("addquestion");
        var text15 = document.getElementById('text' + id);
        //form1.removeChild(text15);
        form1.removeChild(text15);
        form1.removeChild(document.getElementById('btn' + id));

    }
</script>

<form id="addquestion" action="addquestionprocess.php" method="post">
    <input type="hidden" id="oc" name="optioncount" value=2 />
    <table align="center" cellspacing="0" cellpadding="5" id="table1">
        <caption><h3>添加题目</h3></caption>
        <tr>
            <td>
                <label>题目内容:<input type="text" name="questioncontent" value="" size="50"></label>
            </td>
        </tr>
        <tr>
            <td>
                <input type="button" value="增加选项" id="addOption" onclick="insertOption()"/>
            </td>
        </tr>
        <tr>
            <td>
                <input type="text" name="option1" value="">
                <br><input type="text" name="option2" value="">
            </td>
        </tr>

        <tr>
            <td><label><input type="radio" name="catelog" value="1" checked>单选题</label>
            <label><input type="radio" name="catelog" value="2">多选题</label></td>
        </tr>
        <tr>
            <td>
                <?php
                header("content-type:text/html;charset=utf-8");
                    foreach($result as $value){

                        echo '<label><input type="checkbox" name="roleid[]" value="'
                            .$value['id'].'">'.$value['rolename'].'</label>';

                }
                ?>
            </td>
        </tr>
        <tr>
            <td><input type="submit" value="提交"></td>
        </tr>
    </table>
</form>


</body>
</html>