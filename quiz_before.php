<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" name="viewport" content="width=device-width">
    <link rel="stylesheet" href="css/quiz_before.css">
    <link rel="shortcut icon" href="favicon.ico">
    <script>
        window.onload = function() {
            notTransitions();

            // カウントダウンする秒数をh1タグの文字列を数値にして取得
            let sec = document.getElementById("countTimer").innerText;

            // 1秒おきにカウントダウン
            let cnt = sec;
            let id = setInterval(function() {
                cnt--;
                if (cnt <= 0) { //指定した～秒後にフォームの要素を自動送信
                    //"QuizForm"は選択肢を表示するフォームのname要素に変更して
                    document.getElementById("QuizForm").submit();
                }

                //秒数cntを文字列に変換してh1のclass"countTimer"の値として埋め込む
                document.getElementById("countTimer").innerText = cnt;
            }, 1000);
        }

        function notTransitions() {
            history.pushState(null, null, location.href);
            window.addEventListener("popstate", (e) => {
                history.go(1);
            });
        }
        
    </script>
</head>


<body>

<form action="index.html">
    <button class="top_btn">トップヘ</button>
</form>
<center>
    
<?php 
// どんな時も使うもの　[start]
session_start();
$final_q="最終問題";
$up0=0;
$up1=1;
$quizz="quizz";
$result="result";

require("connect.php");
// require("method.php");

if(isset($_POST['q_table'])) {
    $q_table=$_POST['q_table'];

    $sql01="UPDATE quizz SET checked = '".$up1."' WHERE kind = '".$q_table."';";
    $conn->query($sql01);
}



// 更新ボタンを押されたとき、$q_tableは空になるなので、その対処
/*
$sql_h02=$connect_function->SelectCheckedSQL($quizz, $up1);
$q_table=$sql_h02[1];
*/
$sql02="SELECT * FROM '".$quizz."' WHERE checked = '".$up1."';";
$result02=$conn->query($sql02);     
$x02 = $result02->fetch();
$q_table=$x02[1];




// $q_tableテーブルの行数を$q_table_lineに代入
// $q_table_line=$connect_function->CountLineSQL($q_table);
$sql03="SELECT COUNT(*) FROM '".$q_table."';";
$result03=$conn->query($sql03);
$q_table_line=$result03->fetchColumn();




// quizzテーブルの行数を$quizz_lineに代入　（更新ボタンをおしたときのため)
// $quizz_line=$connect_function->CountLineSQL($quizz);
$sql04="SELECT COUNT(*) FROM '".$quizz."';";
$result04=$conn->query($sql04);
$quizz_line=$result04->fetchColumn();




// resultテーブルの行数を$quizz_numberに代入
// $quizz_number=$connect_function->CountLineSQL($result);
$sql05="SELECT COUNT(*) FROM '".$result."';";
$result05=$conn->query($sql05);
$quizz_number=$result05->fetchColumn();




// $user_ansTFはクイズ画面か正誤画面の判定のための変数
/*
$sql06_h=$connect_function->SelectIdSQL($result, $up0);
$user_ansTF=$sql06_h[3];
*/
$sql06="SELECT * FROM '".$result."' WHERE id = '".$up0."';";
$result06=$conn->query($sql06);       
$sql06_h = $result06->fetch();
$user_ansTF=$sql06_h[3];




// 正誤画面からクイズ画面に移動したとき
if(isset($_POST['from_seigo'])) {
    $sql07="UPDATE '".$result."' SET user_ans = '".$up0."' WHERE id = '".$up0."';";
    $conn->query($sql07);
}


// どんな時も使うもの　[end]


// デバッグ1    (クイズの途中で違うファイルに移動して戻ってくるとき)
// $q_tableテーブルのq_num, sel_num, checked列の値を全て0にする     (一問目から始まるようにする)
if( isset($_POST["first"]) ) {

        // quizzテーブルのchecked列のすべての値を0にする
        for($a03=0; $a03<$quizz_line; $a03++) {
            $sql08="UPDATE quizz SET checked = '".$up0."' WHERE id = '".$a03."';";
            $conn->query($sql08);                         
        }

        // quizzテーブルのkind列のうち、$q_tableと一致するレコードのchecked列の値を1にする
        $sql09="UPDATE quizz SET checked = '".$up1."' WHERE kind = '".$q_table."';";
        $conn->query($sql09);
                

        // resultテーブルの「id=0」以外のレコードを全て消去
        // resultテーブルの行数を$result_lineに代入
        // $result_line=$connect_function->CountLineSQL($result);
        
        $sql10="SELECT COUNT(*) FROM '".$result."';";
        $result10=$conn->query($sql10);
        $result_line=$result10->fetchColumn();




        for($a05=1; $a05<=$result_line; $a05++) {
            $sql11="DELETE FROM result WHERE id='".$a05."';";
            $conn->query($sql11);
        }

        // クイズ画面が表示されるように設定
        $sql12="UPDATE '".$result."' SET user_ans = '".$up0."' WHERE id = '".$up0."';";
        $conn->query($sql12);

        /*
        $sql13_h=$connect_function->SelectIdSQL($result, $up0);
        $user_ansTF=$sql13_h[3];
        */
        $sql13="SELECT * FROM '".$result."' WHERE id = '".$up0."';";
        $result13=$conn->query($sql13);       
        $sql13_h = $result13->fetch();
        $user_ansTF=$sql13_h[3];
        

        
        for($a678=0; $a678<$q_table_line; $a678++) {
            $sql14="UPDATE '".$q_table."' SET q_num = '".$up0."' WHERE id = '".$a678."';";
            $conn->query($sql14);          

            $sql15="UPDATE '".$q_table."' SET sel_num = '".$up0."' WHERE id = '".$a678."';";
            $conn->query($sql15);
            
            $sql16="UPDATE '".$q_table."' SET checked = '".$up0."' WHERE id = '".$a678."';";
            $conn->query($sql16);
        }


}       // 「if(isset($_POST["first1"]) || isset($_POST["first2"]))」の閉じかっこ



// 問題文表示
// if(!isset($_POST["sel"])) {
if(!isset($_POST['sel'])) {

    // デバッグ2    (クイズ出題画面で更新ボタンを押したとき)
    $checked=0;

    // checked列が1のレコードがあるか確認
    for($a09=0; $a09<$q_table_line; $a09++) {

        // $sql_h9=$connect_function->SelectIdSQL($q_table, $a09);
        $sql17="SELECT * FROM '".$q_table."' WHERE id = '".$a09."';";
        $result17=$conn->query($sql17);       
        $sql_h9 = $result17->fetch();
        


        if($sql_h9[5]==1) {      // 上で取得したレコードのchecked列の値が1であれば～
            $checked=1;         
        }
    }

    if($checked==0) {       // $q_tableテーブルのchecked列が全て0であれば、新しく問題文、答え、誤答選択肢を確定
        
        while(true) {   //  $q_tableテーブルを参照して問題文と答えを確定
            $r_num1=rand(0, $q_table_line-1);

            // $sql_h10=$connect_function->SelectIdSQL($q_table, $r_num1);
            $sql18="SELECT * FROM '".$q_table."' WHERE id = '".$r_num1."';";
            $result18=$conn->query($sql18);       
            $sql_h10 = $result18->fetch();
            
            

            if($sql_h10[3]==0) {      // q_num列の値が0であれば～
                $sql19="UPDATE '".$q_table."' SET q_num = '".$up1."' WHERE id = '".$r_num1."';";
                $conn->query($sql19);

                $sql20="UPDATE '".$q_table."' SET sel_num = '".$up1."' WHERE id = '".$r_num1."';";
                $conn->query($sql20);

                $sql21="UPDATE '".$q_table."' SET checked = '".$up1."' WHERE id = '".$r_num1."';";
                $conn->query($sql21);

                break;
            }
        }

        $a=0;
        while($a<3) {   // 誤答選択肢を確定
            $r_num2=rand(0, $q_table_line-1);

            // $sql_h14=$connect_function->SelectIdSQL($q_table, $r_num2);
            $sql22="SELECT * FROM '".$q_table."' WHERE id = '".$r_num2."';";
            $result22=$conn->query($sql22);       
            $sql_h14 = $result22->fetch();


            if($sql_h14[4]==0) {
                $sql23="UPDATE '".$q_table."' SET sel_num = '".$up1."' WHERE id = '".$r_num2."';";
                $conn->query($sql23);
                $a++;
            }
        }

    }   // 「if(checked==0){}」の閉じかっこ


    $sel_final=array();     // 選択肢の配列

    // checked列の値が1のレコードを取得 (問題文、答え、正解選択肢をそれぞれ変酢や配列に代入)
    for($q1=0; $q1<$q_table_line; $q1++) {

        // $sql_h16=$connect_function->SelectIdSQL($q_table, $q1);
        $sql24="SELECT * FROM '".$q_table."' WHERE id = '".$q1."';";
        $result24=$conn->query($sql24);       
        $sql_h16 = $result24->fetch();
        


        if($sql_h16[5]==1) {      // 上で取得したレコードのchecked列の値が1であれば～
            $question=$sql_h16[1];
            $answer=$sql_h16[2];
            $sel_final[0]=$sql_h16[2];
            break;     
        }
    }

    // 誤答選択肢を配列に代入
    $s=1;
    while($s<4) {
        for($s1=0; $s1<$q_table_line; $s1++) {

            // $sql_h17=$connect_function->SelectIdSQL($q_table, $s1);
            $sql17="SELECT * FROM '".$q_table."' WHERE id = '".$s1."';";
            $result17=$conn->query($sql17);       
            $sql_h17 = $result17->fetch();
            

    
            if( ($sql_h17[4]==1) && ($sql_h17[5]==0) ) {      // 上で取得したレコードのchecked列の値が1であれば～
                $sel_final[$s]=$sql_h17[2];
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
?>
    
 
    <?php 
    // ↓問題文の表示
    ?>


        <?php if ($quizz_number < $q_table_line) {?>
                
                    <h1 class="question_number">
                        第 <?php echo $quizz_number; ?>   問
                    </h1>
                    <p id="countTimer">10</p>
                <?php } else { ?>
                
                    <h1 class="question_number">
                        <?php echo $final_q; ?>
                    </h1>
                    <p id="countTimer">10</p>
                <?php } ?>
    
    <h2 class="question_text">
        <?php     echo $question; ?>はどれ？
    </h2>

    
    <form  method="POST" id="QuizForm" action="quiz_before.php">
       <div class="radio_button">
            <?php foreach($sel_final as $value){ ?>
            <input type="radio" name="sel" value="<?php echo $value; ?>" required checked> <?php echo $value; ?><span class="for-750"></span>
            <?php } ?>
       </div>
       <br>
       <input type="hidden" name="answer" value="<?php echo $answer ?>">        <!-- 答えを送信 -->
       <input type="hidden" name="question" value="<?php echo $question ?>">                   
       <input type="hidden" name="q_table" value="<?php echo $q_table ?>">    <!-- 問題文を送信 -->
       <input type="submit"  class="kaito_button" value="回答する">
    
    </form>
</center>
<?php 
} //「if( !isset($_POST["sel"]) ){}」の閉じかっこ
?>
    


    
<?php // 選択肢を選んだら
if( isset($_POST["sel"]) ) { 
        
        $q_table=$_POST['q_table'];
        $question1 = $_POST['question'];
        $sel1 = $_POST['sel']; //ラジオボタンの内容を受け取る
        $answer1 = $_POST['answer'];   //hiddenで送られた正解を受け取る


        // 正誤画面が表示されるように設定
        $sql26="UPDATE '".$result."' SET user_ans = '".$up1."' WHERE id = '".$up0."';";
        $conn->query($sql26);

        /*
        $user_ans_h11=$connect_function->SelectIdSQL($result, $up0);
        $user_ansTF=$user_ans_h11[3];
        */
        $sql27="SELECT * FROM '".$result."' WHERE id = '".$up0."';";
        $result27=$conn->query($sql27);       
        $user_ans_h11 = $result27->fetch();
        $user_ansTF=$user_ans_h11[3];
        

        
        

        // 選択肢のリセット　＝＞　sel_num列の値を全て0にする
        for($b=0; $b<$q_table_line; $b++) {
            $sql28="UPDATE '".$q_table."' SET sel_num = '".$up0."' WHERE id = '".$b."';";
            $conn -> query($sql28);
        }
    
        
        // answer列のうち、$answer1と一致するレコードのchecked列の値を0にUPDATEする
        $sql29="UPDATE '".$q_table."' SET checked = '".$up0."' WHERE answer = '".$answer1."';";
        $conn->query($sql29);


        //結果の判定
        if($sel1 == $answer1){
            $result01="〇";
        }else{
            $result01="×";
        }
        

        // デバッグ　更新ボタンを押したときの対処
        // $result_bottom0はresultテーブルの行数が1かどうか判定するための変数
        $bottom_id= $quizz_number-1;

            /*
            $check_question_h=$connect_function->SelectIdSQL($result, $bottom_id);
            $check_question=$check_question_h[2];
            */
            $sql30="SELECT * FROM '".$result."' WHERE id = '".$bottom_id."';";
            $result30=$conn->query($sql30);       
            $check_question_h = $result30->fetch();
            $check_question=$check_question_h[2];
            
        

        if( ($check_question != $question1) || ($bottom_id==$q_table_line) ) {
            //  正誤の結果をresultテーブルに代入
            $sql31=$conn->prepare('INSERT INTO result (id, tf, question, user_ans, model_ans) VALUES(:id, :tf, :question, :user_ans, :model_ans)');
            $sql31->bindValue(':id', $quizz_number);
            $sql31->bindValue(':tf', $result01);
            $sql31->bindValue(':question', $question1);
            $sql31->bindValue(':user_ans', $sel1);
            $sql31->bindValue(':model_ans', $answer1);
            $sql31->execute();
        }
?>


<?php

    // 正誤の表示を確定
    // resultテーブルの一番下の行の情報を$result_bottom_h配列に代入
    // $result_table_line=$connect_function->CountLineSQL($result);
    $sql32="SELECT COUNT(*) FROM '".$result."';";
    $result32=$conn->query($sql32);
    $result_table_line=$result32->fetchColumn();
    

    $result_bottom_id=$result_table_line-1;

    // $result_bottom_h=$connect_function->SelectIdSQL($result, $result_bottom_id);
    $sql33="SELECT * FROM '".$result."' WHERE id = '".$result_bottom_id."';";
    $result33=$conn->query($sql33);       
    $result_bottom_h = $result33->fetch();
    

    
    if($result_bottom_h[1]=="〇") {
        $result_text = "正解！";
    } else {
        $result_text = "不正解...。正解は".$result_bottom_h[4]."です";
    }
    ?>

    <center>
    <h2 class="result_text">
        <?php   echo $result_text;  // 正誤結果を表示   ?>
    </h2>    

    <?php 

    if($result_bottom_id < $q_table_line) { ?>

            <form  method="POST" action="quiz_before.php">
                <input type="hidden" name="q_table" value="<?php echo $q_table?>">
                <input type="hidden" name="from_seigo" value="ＮＵＬＬ">
                <input type="submit" class="next_button" value="次の問題へ">
            </form>
        
    <?php } //trueの閉じかっこ
        else {   session_unset();
            // $_SESSION["count"]=1;
        
        // 問題文の設定　＝＞　umlテーブルのq_num列の値を全て0にする
            for($k=0; $k<$q_table_line; $k++) {
                $num_end4=0;
                $sql34="UPDATE '".$q_table."' SET q_num = '".$num_end4."' WHERE id = '".$k."';";
                $conn -> exec($sql34);
            } ?>
        
        
        <form  method="POST" action="result_before.php">
            <input type="submit"  class="result_button" value="結果発表">
        </form>
    <?php
        }
}   // 選択肢を選んだ時の最初のifの閉じかっこ
    ?>
    </center>
</body>
</html>