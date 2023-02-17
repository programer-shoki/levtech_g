<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/quiz_after.css">
    <link rel="shortcut icon" href="favicon.ico">
</head>
<body>

<?php
require("connect.php");
$final_q="最終問題";
$quizz="quizz";
$up0=0;
$up1=1;
$sel_final=array();


// q_table.phpファイルから送られてきたuserIDを保持
if(isset($_POST['userID'])) {
    $userID=$_POST['userID'];
    $userID_result=$userID."result";
    $userID_quizz_past=$userID."quizz_past";
} else {
    header('Location: login.php');  // 他のファイルから直接移動してきたときの対処
}

?>
<form method="POST" action="home.php">
        <button class="home_btn">ホームヘ</button>
        <input type="hidden" name="userID" value="<?php echo $userID?>">
</form>
<center>

<?php
//問題文の答えを設定

// $userID_quizz_pastテーブルの行数を取得
$sql01="SELECT COUNT(*) FROM '".$userID_quizz_past."';";
$result01=$conn->query($sql01);
$userID_quizz_past_line=$result01->fetchColumn();
$past_start_id=0;                        // 開始位置
$past_end_id=$userID_quizz_past_line-1;  // 終了位置

    
//  $userID_resultテーブルの行数を取得
$sql02="SELECT COUNT(*) FROM '".$userID_result."';";
$result02=$conn->query($sql02);
$userID_result_line=$result02->fetchColumn();


// 問題番号を$quizz_numberに代入
$quizz_number=$userID_result_line+1;

    
    
//問題文の表示
if(!isset($_POST["sel"])) {

    $checked=0;

    // checked列が1のレコードがあるか確認
    for($a04=$past_start_id; $a04<=$past_end_id; $a04++) {

        $sql04="SELECT * FROM '".$userID_quizz_past."' WHERE id = '".$a04."';";
        $result04=$conn->query($sql04);
        $sql_h04 = $result04->fetch();

        if($sql_h04[5]==1) {      // 上で取得したレコードのchecked列の値が1であれば～
            $checked=1;
            break;   
        }
    }


    if($checked==0) { // checked列が1のレコードが一つもないとき、答えを確定させる

        while(true) {
            $r_num1=rand($past_start_id, $past_end_id);

            $sql05="SELECT * FROM '".$userID_quizz_past."' WHERE id = '".$r_num1."';";
            $result05=$conn->query($sql05);    
            $sql_h05 = $result05->fetch();
        

            if($sql_h05[4]==0) {      // q_num列の値が0であれば～

                // $userID_quizz_pastテーブルのq_num, checked列の値を1にする
                $sql06="UPDATE '".$userID_quizz_past."' SET q_num = '".$up1."' WHERE id = '".$r_num1."';";
                $conn->query($sql06);

                $sql07="UPDATE '".$userID_quizz_past."' SET checked = '".$up1."' WHERE id = '".$r_num1."';";
                $conn->query($sql07);


                // $userID_テーブルのchecked列の値を1にする
                $sql07_add1="SELECT * FROM '".$userID_quizz_past."' WHERE id='".$r_num1."';";
                $result07_add1=$conn->query($sql07_add1);        
                $x07_add1=$result07_add1->fetch();
                
                $sql07_add2="UPDATE '".$userID."' SET checked = '".$up1."' WHERE answer = '".$x07_add1[3]."';";
                $conn->query($sql07_add2);



                // $userIDテーブルのsel_num列の値を1にする
                $sql08="SELECT * FROM '".$userID_quizz_past."' WHERE checked = '".$up1."';";
                $result08=$conn->query($sql08);    
                $sql_h08 = $result08->fetch();

                $sql09="UPDATE '".$userID."' SET sel_num = '".$up1."' WHERE answer = '".$sql_h08[3]."';";
                $conn->query($sql09);



                // 問題のジャンルを確定させて、先頭idと最後尾idの値を取得する
                $q_table=$sql_h08[1];

                $sql10="SELECT COUNT(*) FROM '".$q_table."';";
                $result10=$conn->query($sql10);
                $q_table_line=$result10->fetchColumn();

                $sql11="SELECT * FROM quizz WHERE kind='".$q_table."';";
                $result11=$conn->query($sql11);
                $sql_h11 = $result11->fetch();
                $start_id=$sql_h11[3];
                $end_id=$start_id+$q_table_line-1;

                break;
            }
        }


        $a12=0;
        while($a12<3) {   // 誤答選択肢を確定
            $r_num2=rand($start_id, $end_id);

            $sql12="SELECT * FROM '".$userID."' WHERE id = '".$r_num2."';";
            $result12=$conn->query($sql12);       
            $sql_h12 = $result12->fetch();


            if($sql_h12[5]==0) {    // sel_num列の値が0だったら～
                $sql13="UPDATE '".$userID."' SET sel_num = '".$up1."' WHERE id = '".$r_num2."';";
                $conn->query($sql13);
                $a12++;
            }
        }
    }



    // 問題文、答え、正解選択肢をそれぞれ変酢や配列に代入
    // checked列の値が1が答えのレコード
    $sql14="SELECT * FROM '".$userID_quizz_past."' WHERE checked = '".$up1."';";
    $result14=$conn->query($sql14);       
    $sql_h14 = $result14->fetch();




    // 更新ボタンを押されたときに備えて、値をもう一度をセット
    $q_table=$sql_h14[1];   // ジャンルを取得

    $sql15="SELECT COUNT(*) FROM '".$q_table."';";
    $result15=$conn->query($sql15);
    $q_table_line=$result15->fetchColumn();

    $sql16="SELECT * FROM quizz WHERE kind='".$q_table."';";
    $result16=$conn->query($sql16);
    $sql_h16 = $result16->fetch();
    $start_id=$sql_h16[3];                  // 先頭id
    $end_id=$start_id+$q_table_line-1;      // 最後尾id



    // 問題文、答え、正解選択肢をそれぞれ変数や配列に代入
    $question=$sql_h14[2];
    $answer=$sql_h14[3];
    $sel_final[0]=$sql_h14[3];



    // 誤答選択肢を配列に代入
    $a17=1;
    for($b1=$start_id; $b1<=$end_id; $b1++) {

            $sql17="SELECT * FROM '".$userID."' WHERE id = '".$b1."';";
            $result17=$conn->query($sql17);    
            $sql_h17 = $result17->fetch();

            /*
            $sql18="SELECT * FROM '".$userID_quizz_past."' WHERE answer = '".$sql_h17[3]."';";
            $result18=$conn->query($sql18);
            $sql_h18 = $result18->fetch();
            */

            
    
            if( ($sql_h17[5]==1) && ($sql_h17[6]==0) ) {    // sel_num==1 かつ checked==0
                $sel_final[$a17]=$sql_h17[3];
                $a17++;
                // echo $sql_h17[5];
            }

            if($a17==4) {
                break;
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



    if ($quizz_number < $userID_quizz_past_line) {?>
        <h1 class="question_number">第 <?php echo $quizz_number; ?>   問</h1>
            <?php } else { ?>
                <h1 class="question_number"><?php echo $final_q; ?></h1>
        <?php } ?>

    <h2 class="question_text">
        <?php 
        echo $question;
        ?>はどれ？
    </h2>

        
    
    <form  method="POST" action="quiz_reg.php">
       <div class="radio_button">
       <?php foreach($sel_final as $value){ ?>
       <input type="radio" class="radio-button" name="sel" value="<?php echo $value; ?>" required checked> <?php echo $value; ?>
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
    
    
    <!-- 
        「input radio」と「input hidden」に入れた値が一致しているか
        判定するために「value=""」が必要
    -->
    
    

    <?php // 選択肢を選んだら
if( isset($_POST["sel"]) ) { 
        
    //answer.php
    $q_table=$_POST['q_table'];
    $userID=$_POST['userID'];
    $question1 = $_POST['question'];
    $sel1 = $_POST['sel'];          //ラジオボタンの内容を受け取る
     $answer1 = $_POST['answer'];    //hiddenで送られた正解を受け取る


    //結果の判定
    if($sel1 == $answer1){
        $result = "正解";
        $result01="〇";
    }else{
        $result = "不正解";
        $result01="×";
    }



    // 更新ボタンを押したときの対処1　(1度だけの処理)
    $checked17_add1=0;
    for($a17_add1=0; $a17_add1<=$userID_quizz_past_line-1; $a17_add1++) {

        $sql17_add2="SELECT * FROM '".$userID_quizz_past."' WHERE id = '".$a17_add1."';";
        $result17_add2=$conn->query($sql17_add2);
        $sql_h17_add2=array();      
        $sql_h17_add2 = $result17_add2->fetch();

        if($sql_h17_add2[5]==1) {
            $checked17_add1=1;
            break;
        }  
    }

    if($checked17_add1==1) {

        // ジャンルを取得
        $sql18="SELECT * FROM '".$userID_quizz_past."' WHERE checked = '".$up1."';";
        $result18=$conn->query($sql18);       
        $sql_h18 = $result18->fetch();

        $q_table=$sql_h18[1];


        $sql19="SELECT COUNT(*) FROM '".$q_table."';";
        $result19=$conn->query($sql19);
        $q_table_line=$result19->fetchColumn();

        $sql20="SELECT * FROM quizz WHERE kind='".$q_table."';";
        $result20=$conn->query($sql20);
        $sql_h20 = $result20->fetch();
        $start_id=$sql_h20[3];                  // 先頭id
        $end_id=$start_id+$q_table_line-1;   // 最後尾id


                // 選択肢のリセット　＝＞　sel_num列の値を全て0にする
        for($a22=$start_id; $a22<=$end_id; $a22++) {
            $sql22="UPDATE '".$userID."' SET sel_num = '".$up0."' WHERE id = '".$a22."';";
            $conn -> query($sql22);
        }

        // $userID_quizz_pastテーブルのanswer==$answer1のレコードのchecked列の値を0にする
        $sql23="UPDATE '".$userID_quizz_past."' SET checked = '".$up0."' WHERE answer = '".$answer1."';";
        $conn -> query($sql23);


        // $userIDテーブルのanswer==$answer1のレコードのchecked列の値を0にする
        $sql23_add1="UPDATE '".$userID."' SET checked = '".$up0."' WHERE answer = '".$answer1."';";
        $conn -> query($sql23_add1);



        // $userID_resultテーブルに回答結果を記録
        $sql24=$conn->prepare('INSERT INTO '.$userID_result.' (id, tf, kind, question, user_ans, model_ans) VALUES (:id, :tf, :kind, :question, :user_ans, :model_ans)');
        $sql24->bindValue(':id', $quizz_number);
        $sql24->bindValue(':tf', $result01);
        $sql24->bindValue(':kind', $q_table);
        $sql24->bindValue(':question', $question1);
        $sql24->bindValue(':user_ans', $sel1);
        $sql24->bindValue(':model_ans', $answer1);
        $sql24->execute();


        // 間違えた回数を記録する
        if($result=="不正解") {          
            
            $sql25="SELECT * FROM '".$userID."' WHERE answer='".$answer1."';";
            $result25=$conn->query($sql25);
            $sql_h25 = $result25->fetch();             
            $up25=$sql_h25[7];
            $up26=(int)$up25+1;
            $sql27="UPDATE '".$userID."' SET mistake = '".$up26."' WHERE answer = '".$answer1."';";
            $conn->query($sql27);
        }
    }



    if($result=="正解") {
        $result_text = "正解！";
    } else {
        $result_text = "不正解...。正解は".$answer1."です";
    }


    // ラジオボタンを押した後の状態での$userID_result_lineテーブルの行数を取得
    $sql28="SELECT COUNT(*) FROM '".$userID_result."';";
    $result28=$conn->query($sql28);
    $userID_result_line_after=$result28->fetchColumn();


    ?>

    
<h1 class="result_text">
        <?php echo $result_text;    ?>
    </h1>

    
        <?php if($userID_result_line_after < $userID_quizz_past_line) { ?>
            <form  method="POST" action="quiz_reg.php">
                <input type="hidden" name="userID" value="<?php echo $userID?>">
                <input type="submit" class="next_button" value="次の問題へ">
            </form>
        
        <?php } //trueの閉じかっこ
        else {  
        
        // 問題文の設定　＝＞　q_num列の値を全て0にする
            for($a29=$past_start_id; $a29<=$past_end_id; $a29++) {
                
                $sql29="UPDATE '".$userID_quizz_past."' SET q_num = '".$up0."' WHERE id = '".$a29."';";
                $conn -> exec($sql29);
            } ?>
            <form  method="POST" action="result_reg.php">
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