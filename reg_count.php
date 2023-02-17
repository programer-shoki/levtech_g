<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        .reg_table {
            margin-bottom: 40px;
        }

        .title {
            font-size: 40px;
            margin-top: 20px;
        }

        .back_button {            
            width: 120px;
            height: 32px;
            font-size: 20px;
        }

        .home_button {
            margin-top: 48px;
            width:120px;
            height: 32px;
            font-size: 20px;
        }
    </style>
    <link rel="shortcut icon" href="favicon.ico">
</head>

<?php if(isset($_POST['userID'])) {     //userIDを保持
            $userID=$_POST['userID'];
        } else {
            header('Location: login.php');
        }
?>

<body>
<center>
<p class="title">間違えた回数を閲覧</p>

<?php 
// 問題テーブルの行数を取得
require("connect.php");


$sql01="SELECT COUNT(*) FROM '".$userID."';";
$result01=$conn->query($sql01);
$userID_line=$result01->fetchColumn();
    

$id_h=array();
$kind_h=array();
$answer_h=array();
$question_h=array();
$mistake_h=array();



for($a=1; $a<=$userID_line; $a++) {

    // $x02配列に$userIDテーブルの各列の値を代入
    $sql02="SELECT * FROM '".$userID."' WHERE id='".$a."';";
    $result02=$conn->query($sql02);
    $x02=array();
    $x02=$result02->fetch();
    $a_1=$a-1;


    // 表のジャンル列にセットするために$x03[4]を使う
    $sql03="SELECT * FROM quizz WHERE kind='".$x02[1]."';";
    $result03=$conn->query($sql03);
    $x03=array();
    $x03=$result03->fetch();


                        
    // userIDテーブルの全ての列の値を格納
    $id_h[$a_1]=$x02[0];
    // $kind_h[$a_1]=$x02[1];
    $kind_h[$a_1]=$x03[4];
    $question_h[$a_1]=$x02[2];
    $answer_h[$a_1]=$x02[3];
    $mistake_h[$a_1]=$x02[7];                 
} ?>



<table border="1" class="reg_table">
    <tr>
        <th>No.</th>
        <th>ジャンル</th>
        <th>単語</th>
        <th>意味</th>
        <th>間違えた回数</th>
    </tr>

    <?php 
    for($q=0; $q<$userID_line; $q++) {?>
        <tr>
            <td><?php echo $id_h[$q];?> </td>
            <td><?php echo $kind_h[$q];?> </td>
            <td><?php echo $question_h[$q];?> </td>
            <td><?php echo $answer_h[$q];?> </td>
            <td><?php echo $mistake_h[$q];?> </td>
        </tr>
    <?php
    } ?>
</table>



<form  method="POST" action="reg.php">
    <input type="hidden" name="userID" value="<?php echo $userID?>">
    <input type="submit"  class="back_button" value="戻る">
</form>

<form  method="POST" action="home.php">
    <input type="hidden" name="userID" value="<?php echo $userID?>">
    <input type="submit"  class="home_button" value="ホームへ">
</form>


</center>
</body>

</html>