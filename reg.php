<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/reg.css">
    <link rel="shortcut icon" href="favicon.ico">
</head>
</body>
    
    <?php if(isset($_POST['userID'])) {        // userIDを保持
            $userID=$_POST['userID'];
        } else {
            header('Location: login.php');
        }
    ?>

        <div class=main>
            <h1 class="title">回答記録</h1>
            <form  method="POST" action="reg_count.php">        
                <input type="hidden" name="userID" value="<?php echo $userID ?>">
                <input type="submit" class="reg_count_button"value="間違えた回数を閲覧">
            </form><br>

            <form  method="POST" action="reg_quiz.php">        
                <input type="hidden" name="userID" value="<?php echo $userID ?>">
                <input type="submit" class="reg_q_button"value="間違えた回数ごとに問題を出題" >
            </form><br>
 
            <form  method="POST" action="home.php">
                <input type="hidden" name="userID" value="<?php echo $userID?>">
                <input type="submit"  class="home_button" value="ホームへ">
            </form>
        </div>
</body>
</html>