<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.ico">
</head>
<body>
    <center>

<?php
require("connect.php");
$users2="users2";

// users2テーブルの行数を取得
$sql01="SELECT COUNT(*) FROM '".$users2."';";
$result01=$conn->query($sql01);
$users2_line=$result01->fetchColumn();
$users2_new_line=$users2_line+1;



$error_h=array();
$error1="使える文字は「a~zのアルファベット」と「0~9の数字」だけです";
$error2="大文字のアルファベットは使えません";
$error3="ID, パスワードはともに4文字以上8文字以内で入力してください";
$error4="IDの先頭は必ず「a~zのアルファベット」にしてください";
$error5="そのIDは他の方が既に登録しているので使用できません";



if( isset($_POST["userID"]) && isset($_POST["password"]) ) {
	//POSTされたデータの取得
	$userID = $_POST["userID"];
	$password = $_POST["password"];

    // userIDとパスワードの文字数を取得
    $userID_count=strlen($userID);
    $password_count=strlen($password);

     // userIDとパスワードのアルファベットを取得
    $userID_alpha = mb_ereg_replace('[^a-zA-Z]', '', $userID);
    $password_alpha = mb_ereg_replace('[^a-zA-Z]', '', $password);


    $userID_num0=substr($userID, 0, 1);


    // $pass_maskはパスワードを「*」で表現するための変数
    $pass_mask=str_repeat('*', strlen($password));



    if( !ctype_alnum($userID) || !ctype_alnum($password) ) {  // 英字・数字でない文字が一つでもあれば
        $e1=count($error_h);
        $error_h[$e1]=$error1;
    }

    if( !ctype_lower($userID_alpha) || !ctype_lower($password_alpha) ) {  // 小文字でない文字が一つでもあれば
        
        if(!is_numeric($password)) {
            $e2=count($error_h);
            $error_h[$e2]=$error2;
        }
    }

    if( (4>$userID_count || $userID_count>8) || (4>$password_count || $password_count>8) ) {
        $e3=count($error_h);
        $error_h[$e3]=$error3;
    } 
    
    if( !ctype_alpha($userID_num0) ) {
        $e4=count($error_h);
        $error_h[$e4]=$error4;
    }

    // 既に登録したIDと被ったときの対処
    $userID_already=0;
    if(count($error_h)==0) {

        for($id_u=1; $id_u<=$users2_line; $id_u++) {
            $sql02="SELECT * FROM '".$users2."' WHERE id='".$id_u."';";
            $result02=$conn->query($sql02);        
            $users2_h02 = $result02->fetch();
            
            if($userID==$users2_h02[1]) {
                $userID_already=1;
                break;
            }  
        }

        if($userID_already==1) {
            $e5=count($error_h);
            $error_h[$e5]=$error5;
        }


    }
    


        
    if( count($error_h) >0 ) {  ?>

        <h1>
            以下の理由によりID, パスワードを登録することができませんでした
        </h1>
        <?php
        for($e_me=0; $e_me<count($error_h); $e_me++) { 
            ?>

            <p class="error_text">
                <?php echo $error_h[$e_me]; ?>
            </p>
            <br>
        <?php
        }

    } else { 

	    // アカウントを追加
	    $sql03=$conn->prepare('INSERT INTO users2 (id, userID, password, quizznow) VALUES (:id, :userID, :password, :quizznow)');
	    $sql03->bindValue(':id', $users2_new_line);
        $sql03->bindValue(':userID', $userID);
	    $sql03->bindValue(':password', $password);
        $sql03->bindValue(':quizznow', 'NULL');
        $sql03->execute();

	
	    // ユーザの間違えた回数を記録するテーブルを新規作成
	    $id="id";
        $kind="kind";
        $question="question";
        $answer="answer";
        $q_num="q_num";
        $sel_num="sel_num";
        $checked="checked";
        $mistake="mistake";

        $userID_result=$userID."result";
        $tf="tf";
        $user_ans="user_ans";
        $model_ans="model_ans";

        $userID_quizz_past=$userID."quizz_past";

        $quizz="quizz";
        $kind_h=array();
        $question_h=array();
        $answer_h=array();
        $num0=0;




        // ユーザのクイズ出題と間違えた回数を記録するテーブルを作成
        $sql04="CREATE TABLE '".$userID."' (
            '".$id."'	INTEGER NOT NULL,
            '".$kind."'	TEXT NOT NULL,
            '".$question."'	TEXT NOT NULL,
            '".$answer."'	TEXT NOT NULL,
            '".$q_num."'	INTEGER NOT NULL,
            '".$sel_num."'	INTEGER NOT NULL,
            '".$checked."'	INTEGER NOT NULL,
            '".$mistake."'	INTEGER NOT NULL,
            PRIMARY KEY('id')
        )";
        $conn->query($sql04);

        

        
        // ユーザの回答結果を表示するためのテーブル
        $sql04_add01="CREATE TABLE '".$userID_result."' (
            '".$id."'	INTEGER NOT NULL,
            '".$tf."'	TEXT NOT NULL,
            '".$kind."'	TEXT NOT NULL,
            '".$question."'	TEXT NOT NULL,
            '".$user_ans."'	TEXT NOT NULL,
            '".$model_ans."'	TEXT NOT NULL,
            PRIMARY KEY('id')
        )";
        $conn->query($sql04_add01);
        



        // 間違えた回数ごとに問題を出題するためのテーブル
        $sql04_add02="CREATE TABLE '".$userID_quizz_past."' (
            '".$id."'	INTEGER NOT NULL,
            '".$kind."'	TEXT NOT NULL,
            '".$question."'	TEXT NOT NULL,
            '".$answer."'	TEXT NOT NULL,
            '".$q_num."'	INTEGER NOT NULL,
            '".$checked."'	INTEGER NOT NULL,
            PRIMARY KEY('id')
        )";
        $conn->query($sql04_add02);


        
        // $quizz_table_lineにquizzテーブルの行数を取得
        // $quizz_table_line=$a01->CountLineSQL($quizz);
        $sql05="SELECT COUNT(*) FROM '".$quizz."';";
        $result05=$conn->query($sql05);
        $quizz_table_line=$result05->fetchColumn();

    
        for($a=1; $a<=$quizz_table_line; $a++) {

            // $janruにジャンルを代入
            // $x3=$a01->SelectIdSQL($quizz, $a);
            $sql06="SELECT * FROM '".$quizz."' WHERE id = '".$a."';";
            $result06=$conn->query($sql06);     
            $x6 = $result06->fetch();
            $janru=$x6[1];


            // 各ジャンルのテーブル行数を取得
            // $janru_line=$a01->CountLineSQL($janru);
            $sql07="SELECT COUNT(*) FROM '".$janru."';";
            $result07=$conn->query($sql07);
            $janru_line=$result07->fetchColumn();


            // $kind_h, $question_h, $answer_h配列に値をセット
            for($b=0; $b<$janru_line; $b++) {
                $h_count=count($answer_h);

                // $set_h=$a01->SelectIdSQL($janru, $b);
                $sql08="SELECT * FROM '".$janru."' WHERE id = '".$b."';";
                $result08=$conn->query($sql08);       
                $set_h = $result08->fetch();
            
                $kind_h[$h_count]=$janru;
                $question_h[$h_count]=$set_h[1];
                $answer_h[$h_count]=$set_h[2];
            }      
        }

    
        // 値をセットする
        $count3=count($answer_h);
        for($d=1; $d<=$count3; $d++) {
            $dd=$d-1;        
            $sql09=$conn->prepare('INSERT INTO '.$userID.' (id, kind, question, answer, q_num, sel_num, checked, mistake) VALUES (:id, :kind, :question, :answer, :q_num, :sel_num, :checked, :mistake)');
            $sql09->bindValue(':id', $d);
            $sql09->bindValue(':kind', $kind_h[$dd]);
            $sql09->bindValue(':question', $question_h[$dd]);
            $sql09->bindValue(':answer', $answer_h[$dd]);
            $sql09->bindValue(':q_num', $num0);
            $sql09->bindValue(':sel_num', $num0);
            $sql09->bindValue(':checked', $num0);
            $sql09->bindValue(':mistake', $num0);
            $sql09->execute();
        }
        
?>


        <h1>アカウントの作成が完了しました!</h1>
        <div class="form-content"> 
            <p class="name-a"> ID:<?php echo $userID; ?> </p>
            <p class="name-b"> パスワード<?php echo $pass_mask; ?> </p>
        </div>

<?php 
    }
?>
<div class="login">
            <button onclick="location.href='index.html'">トップへ</button>
        </div>
<?php	
} else {
    header('Location: index.html');
}
?>

</center>

</body>
</html>