<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<style>
    
	.replace_list {
    margin-top: 80px;
    }
    .list {
    width: 216px;
    height: 48px;
    font-size: 32px;
    }

    .replace_reg {
        margin-top: 80px;
    }
    .reg {
    width: 216px;
    height: 48px;
    font-size: 32px;
    }

    .replace_logout {
    margin-top: 80px;
    }
    .logout {
       width:120px;
       height: 32px;
       font-size: 20px;
    }
</style>
<link rel="shortcut icon" href="favicon.ico">
</head>
<body>
<center>

<?php 
if(isset($_POST['userID'])) {        
        $userID=$_POST['userID'];
        $userID_result=$userID."result";
        $userID_quizz_past=$userID."quizz_past";
} else {
        header('Location: login.php');
}


require("connect.php");
$up0=0;


// $userID_resultテーブルのレコードを削除
$sql01="SELECT COUNT(*) FROM $userID_result;";
$result01=$conn->query($sql01);
$userID_result_line=$result01->fetchColumn();

for($a02=1; $a02<=$userID_result_line; $a02++) {
    $sql02="DELETE FROM '".$userID_result."' WHERE id='".$a02."';";
    $conn->query($sql02);
}



// $userID_quizz_pastテーブルのレコードを削除
$sql03="SELECT COUNT(*) FROM '".$userID_quizz_past."';";
$result03=$conn->query($sql03);
$userID_quizz_past_line=$result03->fetchColumn();

for($a04=0; $a04<$userID_quizz_past_line; $a04++) {
        $sql04="DELETE FROM '".$userID_quizz_past."' WHERE id='".$a04."';";
        $conn->query($sql04);
}



// $userIDテーブルのq_num, sel_num. checked列の値を全て0にする
$sql03_add1="SELECT COUNT(*) FROM '".$userID."';";
$result03_add1=$conn->query($sql03_add1);
$userID_line=$result03_add1->fetchColumn();

for($a04_add1=1; $a04_add1<=$userID_line; $a04_add1++) {

    $sql04_add2="UPDATE '".$userID."' SET q_num = '".$up0."' WHERE id = '".$a04_add1."';";
    $conn->query($sql04_add2);

    $sql04_add3="UPDATE '".$userID."' SET sel_num = '".$up0."' WHERE id = '".$a04_add1."';";
    $conn->query($sql04_add3);

    $sql04_add4="UPDATE '".$userID."' SET checked = '".$up0."' WHERE id = '".$a04_add1."';";
    $conn->query($sql04_add4);
}
       
?>

<h1>ホーム</h1>
    <form  method="POST" action="list_after.php" class="replace_list">        
        <input type="hidden" name="userID" value="<?php echo $userID ?>">
        <input type="submit" class="list" value="クイズリスト">
    </form><br>


    <form  method="POST" action="reg.php" class="replace_reg">        
        <input type="hidden" name="userID" value="<?php echo $userID ?>">
        <input type="submit" class="reg" value="回答記録">
    </form><br>

<?php 
    if(isset($_POST["logout"]) && $_POST["logout"] == "yes"){//押されているならば
        //セッションを削除する
        session_unset();
    }
?>

<form action="login.php" method="POST" class="replace_logout">
<input type="hidden" name="logout" value="yes">
<input type="submit" class="logout" value="ログアウト">
</form>
<center>
</body>