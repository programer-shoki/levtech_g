<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8">
<link rel="stylesheet" href="css/result.css">
<link rel="shortcut icon" href="favicon.ico">
</head>
<?php if(isset($_POST['userID'])) {     //userIDを保持
            $userID=$_POST['userID'];
            $userID_result=$userID."result";
        } else {
            header('Location: login.php');
        }
?>

<?php
    require("connect.php");
    $quizz="quizz";
    $sql1="SELECT COUNT(*) FROM '".$userID_result."';";
    $result1=$conn->query($sql1);
    $userID_result_line=$result1->fetchColumn();
?>

<body>
<center>
    <h1>結果発表</h1>
            <h2>お疲れさまでした!<br>結果は以下の通りです</h2>
            
                <?php // resultテーブルの各列の値を配列で取得
                      $id_h=array();
                      $tf_h=array();
                      $kind_h=array();
                      $question_h=array();
                      $user_ans_h=array();
                      $model_ans_h=array();

                      for($p=1; $p<=$userID_result_line; $p++) {
                        $sql2="SELECT * FROM '".$userID_result."' WHERE id='".$p."';";
                        $result2=$conn->query($sql2);

                        // [0]=>id, [1]=>tf, [2]=>kind, [3]=>question, [4]=>user_ans, [5]=>model_ans
                        $x2=array();
                        $x2 = $result2->fetch();
                        $p1=$p-1;


                        // ジャンルの表記法を設定
                        $sql2_add1="SELECT * FROM '".$quizz."' WHERE kind = '".$x2[2]."';";
                        $result2_add1=$conn->query($sql2_add1); 
                        $sql_h2_add1 = $result2_add1->fetch();


                        $id_h[$p1]=$x2[0];
                        $tf_h[$p1]=$x2[1];
                        // $kind_h[$p1]=$x2[2];
                        $kind_h[$p1]=$sql_h2_add1[4];
                        $question_h[$p1]=$x2[3];
                        $user_ans_h[$p1]=$x2[4];
                        $model_ans_h[$p1]=$x2[5];
                      } ?>
            <table border="1">
                <tr>
                    <th>問題番号</th>
                    <th>正誤</th>
                    <!-- <th>ジャンル</th> -->
                    <th>問題</th>
                    <th>あなたの回答</th>
                    <th>答え</th>
                </tr>
                <?php for($q=0; $q<=$userID_result_line-1; $q++) {?>
                <tr>
                        <td><?php echo $id_h[$q];?> </td>
                        <td><?php echo $tf_h[$q];?> </td>
                        <td><?php echo $kind_h[$q];?> </td>
                        <td><?php echo $question_h[$q];?> </td>
                        <td><?php echo $user_ans_h[$q];?> </td>
                        <td><?php echo $model_ans_h[$q];?> </td>
                </tr>
                <?php } ?>

            </table><br>
            
            <form  method="POST" action="home.php" class="replace_home">
                <input type="hidden" name="userID" value="<?php echo $userID?>">
                <input type="submit"  class="home" value="ホームへ">
            </form>

</center>
</body>

</html>