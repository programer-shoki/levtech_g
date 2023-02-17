<!DOCTYPE html>
<html>
    <title>間違えた回数ごとに問題を出題</title>
<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="favicon.ico">
    <style>
        .select_button {
            margin-top: 32px;
            width:168px;
            height: 48px;
            font-size: 32px;
            text-align: center;
        }

        .submit_button {
            margin-top: 64px;
            width: 120px;
            height: 48px;
            font-size: 24px;
        }

        .back_button {
            margin-top: 64px;
            width:120px;
            height: 32px;
            font-size: 20px;
        }

        .home_button {
            margin-top: 40px;
            width:120px;
            height: 32px;
            font-size: 20px;
        }

        .title {
            margin-bottom: 16px;
            font-size: 40px;
        }
    </style>
</head>

<?php if(isset($_POST['userID'])) {         // userIDを保持
            $userID=$_POST['userID'];
            $userID_quizz_past=$userID."quizz_past";
        } else {
            header('Location: login.php');
        }

        // q_table.phpファイルから離れた時にquizz_pastテーブルの行を全部削除する
            require("connect.php");
            $sql01="SELECT COUNT(*) FROM '".$userID_quizz_past."';";
            $result1=$conn->query($sql01);
            $count_column=$result1->fetchColumn();

            if($count_column>=1) {
                for($a=0; $a<$count_column; $a++) {
                    $sql02="DELETE FROM '".$userID_quizz_past."' WHERE id='".$a."';";
                    $conn->query($sql02);
                }
            }
?>

<body>
    <center>
        <h1 class="title">間違えた回数ごとに問題を出題</h1>

        <form method="POSt" action="q_table.php">
        <select name="mistake" class="select_button">
            <option value="0">0回</option>
            <option value="1">1回</option>
            <option value="2">2回</option>
            <option value="3">3回</option>
            <option value="more">4回以上</option>
        </select>
        <br>

        <input type="hidden" name="userID" value="<?php echo $userID?>">
        <input type="submit" class="submit_button" value="決定">
        </form>
        <br>

        <form  method="POST" action="reg.php" class="replace_reg">        
            <input type="hidden" name="userID" value="<?php echo $userID ?>">
            <input type="submit" class="back_button" value="戻る">
        </form>
        
    
        <form  method="POST" action="home.php" class="replace_home">        
            <input type="hidden" name="userID" value="<?php echo $userID ?>">
            <input type="submit" class="home_button" value="ホームへ">
        </form>    
    </center>



</body>

</html>