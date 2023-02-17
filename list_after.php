<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        .select_button {
            margin-top: 32px;
            width:440px;
            height: 48px;
            font-size: 32px;
            text-align: center;
        }

        .submit_button {
            margin-top: 144px;
            width: 216px;
            height: 48px;
            font-size: 32px;
        }

        .home_button {
            margin-top: 100px;
            width:120px;
            height: 32px;
            font-size: 20px;
        }

        .title {
            margin-bottom: 24px;
            font-size: 40px;
        }
    </style>
    <link rel="shortcut icon" href="favicon.ico">
</head>


<?php if(isset($_POST['userID'])) {     //userIDを保持
            $userID=$_POST['userID'];
        } else {
            header('Location: login.php');
        }
        

        require("connect.php");
?>




<body>
<center>
<p class="title">クイズリスト</p>
<form method="POST" action="quiz_after.php">
        <select name="q_table" class="select_button">

            <?php 
            
                $sql1="SELECT COUNT(*) FROM quizz;";
                $result1=$conn->query($sql1);
                $quizz_table_line=$result1->fetchColumn();

                for($a2=1; $a2<=$quizz_table_line; $a2++) {
                    $sql2="SELECT * FROM quizz WHERE id='".$a2."';";
                    $result2=$conn->query($sql2);        
                    $x2 = $result2->fetch();
                ?>
                    <option value="<?php echo $x2[1]; ?>">
                        <?php echo $x2[4]; ?>
                    </option>

                <?php
                }
                
            ?>

        </select>
        <br>
        <input type="hidden" name="userID" value="<?php echo $userID?>">
        <input type="submit" class="submit_button" value="スタート">
    </form>


<form  method="POST" action="home.php">
    <input type="hidden" name="userID" value="<?php echo $userID?>">
    <input type="submit"  class="home_button" value="ホームへ">
</form>

</center>
</body>
</html>