<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/quiz_after.css">
    <link rel="shortcut icon" href="favicon.ico">

</head>
<body>

<?php 
// quizz.listファイルから送られてきたuserIDを保持
if(isset($_POST['userID'])) {
    $userID=$_POST['userID'];
    $userID_result=$userID."result";
} else {
    header('Location: login.php');
}
?>

<form method="POST" action="home.php">
        <button class="home_btn">ホームヘ</button>
        <input type="hidden" name="userID" value="<?php echo $userID?>">
</form>


<center>


<?php
require("connect.php");
$final_q="最終問題";
$quizz="quizz";
$up0=0;
$up1=1;
$sel_final=array();



// 問題のテーブルを確定
if(isset($_POST['q_table'])) {
    $q_table=$_POST['q_table'];
} else {
    header('Location: login.php');  // 他のファイルから直接移動してきたときの対処
}



//問題文の答えを設定

// $q_tableテーブルの行数を取得
$sql01="SELECT COUNT(*) FROM '".$q_table."';";
$result01=$conn->query($sql01);
$q_table_line=$result01->fetchColumn();


//  $userID_resultテーブルの行数を取得
$sql02="SELECT COUNT(*) FROM '".$userID_result."';";
$result02=$conn->query($sql02);
$userID_result_line=$result02->fetchColumn();


// 問題番号を$quizz_numberに代入
$quizz_number=$userID_result_line+1;
  

// $userIDテーブルの行数を取得
$sql03="SELECT COUNT(*) FROM '".$userID."';";
$result03=$conn->query($sql03);
$userID_table_line=$result03->fetchColumn();

// 選択したジャンルの先頭idと最後尾idを取得
$sql04="SELECT * FROM quizz WHERE kind='".$q_table."';";
$result04=$conn->query($sql04);
$sql_h04 = $result04->fetch();
$start_id=$sql_h04[3];
$end_id=$start_id+$q_table_line-1;




//問題文の表示
if(!isset($_POST["sel"])) {

    $checked=0;

    // checked列が1のレコードがあるか確認
    for($a05=$start_id; $a05<=$end_id; $a05++) {

        $sql05="SELECT * FROM '".$userID."' WHERE id = '".$a05."';";
        $result05=$conn->query($sql05);
        $sql_h05 = $result05->fetch();

        if($sql_h05[6]==1) {      // 上で取得したレコードのchecked列の値が1であれば～
            $checked=1;
            break;       
        }
    }

    

    if($checked==0) {   // 正解選択肢を決定

        while(true) {
            $r_num1=rand($start_id, $end_id);

            // $sql_h10=$a01->SelectIdSQL($q_table, $r_num1);
            $sql06="SELECT * FROM '".$userID."' WHERE id = '".$r_num1."';";
            $result06=$conn->query($sql06);    
            $sql_h06 = $result06->fetch();
            

            if($sql_h06[4]==0) {      // q_num列の値が0であれば～
                $sql07="UPDATE '".$userID."' SET q_num = '".$up1."' WHERE id = '".$r_num1."';";
                $conn->query($sql07);

                $sql08="UPDATE '".$userID."' SET sel_num = '".$up1."' WHERE id = '".$r_num1."';";
                $conn->query($sql08);

                $sql09="UPDATE '".$userID."' SET checked = '".$up1."' WHERE id = '".$r_num1."';";
                $conn->query($sql09);

                break;
            }
        }


        $a10=0;
        while($a10<3) {   // 誤答選択肢を確定
            $r_num2=rand($start_id, $end_id);

            $sql10="SELECT * FROM '".$userID."' WHERE id = '".$r_num2."';";
            $result10=$conn->query($sql10);       
            $sql_h10 = $result10->fetch();


            if($sql_h10[5]==0) {    // sel_num列の値が0だったら～
                $sql11="UPDATE '".$userID."' SET sel_num = '".$up1."' WHERE id = '".$r_num2."';";
                $conn->query($sql11);
                $a10++;
            }
        }
    }



    // 問題文、答え、正解選択肢をそれぞれ変酢や配列に代入
    // checked列の値が1が答えのレコード
    $sql12="SELECT * FROM '".$userID."' WHERE checked = '".$up1."';";
    $result12=$conn->query($sql12);       
    $sql_h12 = $result12->fetch();

    $question=$sql_h12[2];
    $answer=$sql_h12[3];
    $sel_final[0]=$sql_h12[3];


    // 誤答選択肢を配列に代入
    $s=1;
    while($s<4) {

        for($s1=$start_id; $s1<=$end_id; $s1++) {

            // $sql_h17=$a01->SelectIdSQL($q_table, $s1);
            $sql13="SELECT * FROM '".$userID."' WHERE id = '".$s1."';";
            $result13=$conn->query($sql13);       
            $sql_h13 = $result13->fetch();

    
            if( ($sql_h13[5]==1) && ($sql_h13[6]==0) ) {    // sel_num==1 かつ checked==0
                $sel_final[$s]=$sql_h13[3];
                $s++;           
            }
        }
    }


    // 選択肢の順番をシャッフル
    for ($j = 0; $j<10; $j++) {
        $m=rand(0, 3);
        $n=rand(0, 3);
        
        $y=$sel_final[$m];
        $sel_final[$m]=$sel_final[$n];
        $sel_final[$n]=$y;
    }

    

    if ($quizz_number < $q_table_line) {?>
            <h1 class="question_number">第 <?php echo $quizz_number; ?>   問</h1>
            

    <?php } else { ?>
            <h1 class="question_number"><?php echo $final_q; ?></h1>
            
    <?php } ?>
    
    <h2 class="question_text">
        <?php 
        echo $question;
        ?>はどれ？
    </h2>
    
    <form  method="POST" action="quiz_after.php">
       <div class="radio_button">
       <?php foreach($sel_final as $value){ ?>
       <input type="radio" name="sel" value="<?php echo $value; ?>" required checked> <?php echo $value; ?>
       <?php } ?>
       </div>
       <br>
       <input type="hidden" name="answer" value="<?php echo $answer ?>">        <!-- 答えを送信 -->
       <input type="hidden" name="question" value="<?php echo $question ?>">
       <input type="hidden" name="q_table" value="<?php echo $q_table ?>">
       <input type="hidden" name="userID" value="<?php echo $userID?>">    
       <input type="submit"  class="kaito_button" value="回答する">
    </form>
<?php
} //「問題文表示」の直下のifの閉じかっこ
?>


    
    <?php // 選択肢を選んだら
if( isset($_POST["sel"]) ) { 
        
        $question1 = $_POST['question'];
        $sel1 = $_POST['sel']; //ラジオボタンの内容を受け取る
        $answer1 = $_POST['answer'];   //hiddenで送られた正解を受け取る


        //結果の判定
        if($sel1 == $answer1){
            $result = "正解";
            $result01="〇";
        }else{
            $result = "不正解";
            $result01="×";
        }


        // 更新ボタンを押したときの対処
        $checked14=0;

        for($a14=$start_id; $a14<=$end_id; $a14++) {

            $sql14="SELECT * FROM '".$userID."' WHERE id = '".$a14."';";
            $result14=$conn->query($sql14);
            $sql_h14 = $result14->fetch();
    
            if($sql_h14[6]==1) {      // 上で取得したレコードのchecked列の値が1であれば～
                $checked14=1;
                break;       
            }
        }

        if($checked14==1) {

            // 選択肢のリセット　＝＞　sel_num列の値を全て0にする
            for($a15=$start_id; $a15<=$end_id; $a15++) {
                $sql15="UPDATE '".$userID."' SET sel_num = '".$up0."' WHERE id = '".$a15."';";
                $conn -> query($sql15);
            }

            // q_num==1 && checked==1のレコードのchecked列の値を0にする
            $sql16="UPDATE '".$userID."' SET checked = '".$up0."' WHERE q_num = '".$up1."' AND checked = '".$up1."';";
            $conn -> query($sql16);


            // $userID_resultテーブルに回答結果を記録
            $sql17=$conn->prepare('INSERT INTO '.$userID_result.' (id, tf, kind, question, user_ans, model_ans) VALUES (:id, :tf, :kind, :question, :user_ans, :model_ans)');
            $sql17->bindValue(':id', $quizz_number);
            $sql17->bindValue(':tf', $result01);
            $sql17->bindValue(':kind', $q_table);
            $sql17->bindValue(':question', $question1);
            $sql17->bindValue(':user_ans', $sel1);
            $sql17->bindValue(':model_ans', $answer1);
            $sql17->execute();


            // 間違えた回数を記録する
            if($result=="不正解") {          
                
                $sql18="SELECT * FROM '".$userID."' WHERE answer='".$answer1."';";
                $result18=$conn->query($sql18);
                $sql_h18 = $result18->fetch();             
                $up18=$sql_h18[7];
                $up19=(int)$up18+1;
                $sql19="UPDATE '".$userID."' SET mistake = '".$up19."' WHERE answer = '".$answer1."';";
                $conn->query($sql19);
            }
        }
           
    
    if($result=="正解") {
            $result_text = "正解！";
        } else {
            $result_text = "不正解...。正解は".$answer1."です";
        }



    // ラジオボタンを押した後の状態での$userID_result_lineテーブルの行数を取得
    $sql20="SELECT COUNT(*) FROM '".$userID_result."';";
    $result20=$conn->query($sql20);
    $userID_result_line_after=$result20->fetchColumn();
    ?>

 
    <h1 class="result_text">
        <?php echo $result_text;    ?>
    </h1>

    
        <?php if($userID_result_line_after < $q_table_line) { ?>
            <form  method="POST" action="quiz_after.php">
                <input type="hidden" name="q_table" value="<?php echo $q_table?>">
                <input type="hidden" name="userID" value="<?php echo $userID?>">
                <input type="submit" class="next_button" value="次の問題へ">
            </form>
        
        <?php } //trueの閉じかっこ
        else {  
        
        // 問題文の設定　＝＞　q_num列の値を全て0にする
            for($a21=$start_id; $a21<=$end_id; $a21++) {
                
                $sql21="UPDATE '".$userID."' SET q_num = '".$up0."' WHERE id = '".$a21."';";
                $conn -> exec($sql21);
            } ?>
            <form  method="POST" action="result_after.php">
                <input type="hidden" name="userID" value="<?php echo $userID?>">
                <input type="submit" class="result_button" value="結果発表">
            </form>            
    <?php
        }
}   // 選択肢を選んだ時の最初のifの閉じかっこ
    ?>

    </center>
</body>
</html>