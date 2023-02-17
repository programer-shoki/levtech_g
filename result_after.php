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
    $sql01="SELECT COUNT(*) FROM $userID_result;";
    $result01=$conn->query($sql01);
    $userID_result_line=$result01->fetchColumn();
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
                      for($a=1; $a<=$userID_result_line; $a++) {
                        $sql02="SELECT * FROM '".$userID_result."' WHERE id='".$a."';";
                        $result02=$conn->query($sql02);

                        $x02=array();
                        $x02 = $result02->fetch();
                        $a_1=$a-1;

                        $id_h[$a_1]=$x02[0];
                        $tf_h[$a_1]=$x02[1];
                        $question_h[$a_1]=$x02[3];
                        $user_ans_h[$a_1]=$x02[4];
                        $model_ans_h[$a_1]=$x02[5];
                      } ?>
            <table border="1">
                <tr>
                    <th>問題番号</th>
                    <th>正誤</th>
                    <th>問題</th>
                    <th>あなたの回答</th>
                    <th>答え</th>
                </tr>
                <?php for($p=1; $p<=$userID_result_line; $p++) {
                        $q=$p-1;
                ?>
                <tr>
                        <td><?php echo $id_h[$q];?> </td>
                        <td><?php echo $tf_h[$q];?> </td>
                        <td><?php echo $question_h[$q];?> </td>
                        <td><?php echo $user_ans_h[$q];?> </td>
                        <td><?php echo $model_ans_h[$q];?> </td>
                </tr>

                <?php } 
                ?>
            </table><br>
            <form  method="POST" action="home.php" class="replace_home">
                <input type="hidden" name="userID" value="<?php echo $userID?>">
                <input type="submit"  class="home" value="ホームへ">
            </form>
    </center>     
</body>

</html>