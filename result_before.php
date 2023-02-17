<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="css/result.css">
<link rel="shortcut icon" href="favicon.ico">
</head>


<?php
    $up1=1;
    $quizz="quizz";
    $result_name="result";
    require("connect.php");
    // require("method.php");


    // 更新ボタンを押されたとき、$_POST["q_table"]は空なので、その対処

    // $add00_h=$a01->SelectCheckedSQL($quizz, $up1);
    $sql02_add1="SELECT * FROM '".$quizz."' WHERE checked = '".$up1."';";
    $result02_add1=$conn->query($sql02_add1);       
    $add00_h = $result02_add1->fetch();
    $q_table=$add00_h[1];


    // $q_tableテーブルの行数を取得
    // $count_sub=$a01->CountLineSQL($q_table);

    $sql_add2="SELECT COUNT(*) FROM '".$q_table."';";
    $result_add2=$conn->query($sql_add2);
    $count_sub=$result_add2->fetchColumn();
?>

<body>
    <center>
    <h1>結果発表</h1>
            <h2>お疲れさまでした!<br>結果は以下の通りです</h2>
            
                <?php // resultテーブルの各列の値を配列で取得
                      $id_h=array();
                      $tf_h=array();
                      $question_h=array();
                      $user_ans_h=array();
                      $model_ans_h=array();
                      for($p=1; $p<=$count_sub; $p++) {

                        // $x4=$a01->SelectIdSQL($result_name, $p);
                        $sql02_add3="SELECT * FROM '".$result_name."' WHERE id = '".$p."';";
                        $result02_add3=$conn->query($sql02_add3);       
                        $x4 = $result02_add3->fetch();
                        
                        $p1=$p-1;

                        $id_h[$p1]=$x4[0];
                        $tf_h[$p1]=$x4[1];
                        $question_h[$p1]=$x4[2];
                        $user_ans_h[$p1]=$x4[3];
                        $model_ans_h[$p1]=$x4[4];
                      } ?>
            <table border="2">
                <tr>
                    <th>問題番号</th>
                    <th>正誤</th>
                    <th>問題</th>
                    <th>あなたの回答</th>
                    <th>答え</th>
                </tr>
                <?php for($q=0; $q<=$count_sub-1; $q++) {?>
                <tr>
                        <td><?php echo $id_h[$q];?> </td>
                        <td><?php echo $tf_h[$q];?> </td>
                        <td><?php echo $question_h[$q];?> </td>
                        <td><?php echo $user_ans_h[$q];?> </td>
                        <td><?php echo $model_ans_h[$q];?> </td>
                </tr>
                
                <?php }  ?>
            </table>
            <br>

            <form  method="POST" action="list_before.php" class="replace_list">
                <input type="submit" class="list" value="クイズリストヘ">
            </form>
    </center>
</body>

</html>