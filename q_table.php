<!DOCTYPE html>
<html>
    <title>クイズの予告</title>
<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="favicon.ico">
    <style>
        .start_button {
            margin-top: 40px;
            width: 120px;
            height: 48px;
            font-size: 24px;
        }

        .back_button {
            margin-top: 32px;
            width:120px;
            height: 32px;
            font-size: 20px;
        }

        .home_button {            
            margin-top: 24px;
            width:120px;
            height: 32px;
            font-size: 20px;
        }

        .title {
            text-align: center;
            margin-bottom: 16px;
            font-size: 40px;
        }
    </style>
</head>
<body>
<center>
<?php 
require("connect.php");

if(isset($_POST['userID'])) {     //userIDを保持
        $userID=$_POST['userID'];
        $userID_quizz_past=$userID."quizz_past";
} else {
        header('Location: login.php');
}
    

if(isset($_POST['mistake'])) {
        $mistake=$_POST['mistake'];
        if($mistake=="more") {
            $count="4回以上";
        } else {
            $count=$mistake.'回';
        }
}


// userID_quizz_pastテーブルの行数を取得
$sql01="SELECT COUNT(*) FROM '".$userID_quizz_past."';";
$result01=$conn->query($sql01);
$userID_quizz_past_line=$result01->fetchColumn();

$num0=0;


// $userID_quizz_pastテーブルの行数が0のときだけ値をセットする
if($userID_quizz_past_line == 0) {

    // userIDテーブルのkind, answer, mistake, question列の値を配列で取得
    $kind_h=array();
    $answer_h=array();
    $question_h=array();
    $mistake_h=array();


    $sql02="SELECT COUNT(*) FROM '".$userID."';";
    $result02=$conn->query($sql02);
    $userID_line=$result02->fetchColumn();


    // userIDテーブルの全ての行の各列の値を直前に作った配列に代入
    for($a03=1; $a03<=$userID_line; $a03++) {

        $a03_1=$a03-1;

        // ジャンル, 答え, 間違えた回数を取得
        $sql03="SELECT * FROM '".$userID."' WHERE id='".$a03."';";
        $result03=$conn->query($sql03);
        $sql03_h=array();
        $sql03_h = $result03->fetch();
        $kind_h[$a03_1]=$sql03_h[1];
        $question_h[$a03_1]=$sql03_h[2];
        $answer_h[$a03_1]=$sql03_h[3];
        $mistake_h[$a03_1]=$sql03_h[7];
    }


    // quizz_pastテーブルにreg_q.phpから送られてきた間違えた回数の行を挿入
    $bb=0;
    for($b=0; $b<$userID_line; $b++) {

        if($mistake_h[$b]==$mistake) {  // 間違えた回数が0~3回のとき
            $sql4=$conn->prepare('INSERT INTO '.$userID_quizz_past.' (id, kind, question, answer, q_num, checked) VALUES(:id, :kind, :question, :answer, :q_num, :checked)');
            $sql4->bindValue(':id', $bb);
            $sql4->bindValue(':kind', $kind_h[$b]);
            $sql4->bindValue(':question', $question_h[$b]);
            $sql4->bindValue(':answer', $answer_h[$b]);
            $sql4->bindValue(':q_num', $num0);
            $sql4->bindValue(':checked', $num0);
            $sql4->execute();
            $bb++;
        }

        if($mistake_h[$b]>=4 && $mistake=="more") { // 間違えた回数が4回以上の時
            $sql5=$conn->prepare('INSERT INTO '.$userID_quizz_past.' (id, kind, question, answer, q_num, checked) VALUES(:id, :kind, :question, :answer, :q_num, :checked)');
            $sql5->bindValue(':id', $bb);
            $sql5->bindValue(':kind', $kind_h[$b]);
            $sql5->bindValue(':question', $question_h[$b]);
            $sql5->bindValue(':answer', $answer_h[$b]);
            $sql5->bindValue(':q_num', $num0);
            $sql5->bindValue(':checked', $num0);
            $sql5->execute();
            $bb++;
        }

    }
}




// tdタグで使うためにquizz_pastテーブルのkind, question, answer列の値を配列で取得
$kind_td_h=array();
$question_td_h=array();
$answer_td_h=array();

// $userID_quizz_pastテーブルの行数を取得
$sql6="SELECT COUNT(*) FROM '".$userID_quizz_past."';";
$result6=$conn->query($sql6);    
$userID_quizz_past_line_after=$result6->fetchColumn();
    

// $userID_quizz_pastテーブルの全ての行の各列の値を配列に代入
if($userID_quizz_past_line_after>=1) {

    for($c=0; $c<$userID_quizz_past_line_after; $c++) {

            $sql7="SELECT * FROM '".$userID_quizz_past."' WHERE id='".$c."';";
            $result7=$conn->query($sql7);
            $x7=array();
            $x7 = $result7->fetch();
            

            /*
            if($x7[1]=="uml") {
                $kind_td_h_value="UML";
            } else {
                $kind_td_h_value="整列法のアルゴリズム";
            }
            */     


            $sql_add1="SELECT * FROM quizz WHERE kind='".$x7[1]."';";
            $result_add1=$conn->query($sql_add1);
            $x_add1=array();
            $x_add1=$result_add1->fetch();
            $kind_td_h_value=$x_add1[4];


            $kind_td_h[$c]=$kind_td_h_value;
            $question_td_h[$c]=$x7[2];
            $answer_td_h[$c]=$x7[3];
    }
?>


        <h1 class="title"><?php echo $count ?>間違えた問題は以下の通りです。<br>この中から出題します</h1>

        <table border="1" class="reg_table">
                <tr>
                    <th>No.</th>
                    <th>ジャンル</th>
                    <th>単語</th>
                    <th>意味</th>                    
                </tr>
                <?php for($d=0; $d<$userID_quizz_past_line_after; $d++) {
                            $d1=$d+1;   
                ?>
                <tr>
                    <td><?php echo $d1;?> </td>
                    <td><?php echo $kind_td_h[$d];?> </td>
                    <td><?php echo $question_td_h[$d];?> </td>
                    <td><?php echo $answer_td_h[$d];?> </td>                        
                </tr>
                <?php } ?>
            </table>
        
             

        <form method="POSt" action="quiz_reg.php" class="position">
        <input type="hidden" name="userID" value="<?php echo $userID?>">
        <input type="submit" class="start_button" value="スタート">
        </form>
        <br>

<?php 
} else {
           $message=$count."間違えた問題はありません"; ?>
            <h1 class="title"><?php echo $message; ?></h1>
<?php 
}?>
        <br>

        
        <form  method="POST" action="reg_quiz.php" class="position">
        <input type="hidden" name="q_table" value="<?php echo $q_table ?>">
        <input type="hidden" name="userID" value="<?php echo $userID ?>">
        <input type="submit" class="back_button" value="戻る">
        </form>
        <br>

        <form  method="POST" action="home.php" class="position">
            <input type="hidden" name="q_table" value="<?php echo $q_table ?>">
            <input type="hidden" name="userID" value="<?php echo $userID?>">
            <input type="submit"  class="home_button" value="ホームへ">
        </form>

    </center>
</body>

</html>