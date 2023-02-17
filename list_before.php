<?php
  require("connect.php");
  //  require("method.php");
  $result_name="result";
  
  
  //  $count_r=$a01->CountLineSQL($result_name);
  $sql_add1="SELECT COUNT(*) FROM '".$result_name."';";
  $result_add1=$conn->query($sql_add1);
  $count_r=$result_add1->fetchColumn();
  
  
  $up0=0;
  $up1=1;

    // resultテーブルのデータを削除
    for($r=1; $r<$count_r; $r++) {
      $sql10="DELETE FROM result WHERE id='".$r."';";
      $conn->query($sql10);
    }


    $sql_add1="UPDATE quizz SET checked = '".$up0."' WHERE checked = '".$up1."';";
    $conn->query($sql_add1);


?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/accordion.css">
  <link rel="stylesheet" href="css/wordquiz.css">
  <link rel="shortcut icon" href="favicon.ico">
  <title>リスト選択</title>
</head>

<body>
  <div>
    <a href="index.html" class="location_btn">トップへ</a>
  </div>
  <div>
    <!--インデントは【Alt + Shift + F】-->
    <h2 class="explain">CHECK!をクリックするとリストの詳細が表示されます</h2>
  </div>

  <div class="container"> <!--1列目のリスト-->
    <label class="accordion accordion--1" for="open-1">
      <input class="accordion__open" id="open-1" type="radio" name="accordion-1">
      <input class="accordion__close" id="close-1" type="radio" name="accordion-1">
      <div class="accordion__tab">CHECK!</div>
      <div class="accordion__wrapper">
        <dl class="accordion__box">
          <dt class="accordion__partition">
            <span class="accordion__number">01</span>
            <span class="accordion__title">UML　(6問)</span>
            <form method="POST" action="quiz_before.php">
              <input type="hidden" name="q_table" value="uml">
              <input type="hidden" name="first" value="first1">
              <input type="submit" id="1" class="send__btn" value="選択">
            </form>

          </dt>
          <dd class="accordion__text">オブジェクト指向設計で用いられる標準的な表記法</dd>
        </dl>
      </div>
      <label for="close-1" class="accordion__button">
        <span class="accordion__buttonText">CLOSE</span>
      </label>
    </label>



    <label class="accordion accordion--2" for="open-2">
      <input class="accordion__open" id="open-2" type="radio" name="accordion-2">
      <input class="accordion__close" id="close-2" type="radio" name="accordion-2">
      <div class="accordion__tab">CHECK!</div>
      <div class="accordion__wrapper">
        <dl class="accordion__box">
          <dt class="accordion__partition">
            <span class="accordion__number">02</span>
            <span class="accordion__title">整列法のアルゴリズム<br>(6問)</span>

            <form method="POST" action="quiz_before.php">
              <input type="hidden" name="q_table" value="algorithm">
              <input type="hidden" name="first" value="first2">
              <input type="submit" id="2" class="send__btn" value="選択">
            </form>
          </dt>

          <dd class="accordion__text">色々なデータを整列させる方法</dd>
        </dl>
      </div>
      <label for="close-2" class="accordion__button">
        <span class="accordion__buttonText">CLOSE</span>
      </label>
    </label>



    <label class="accordion accordion--3" for="open-3">
      <input class="accordion__open" id="open-3" type="radio" name="accordion-3">
      <input class="accordion__close" id="close-3" type="radio" name="accordion-3">
      <div class="accordion__tab">CHECK!</div>
      <div class="accordion__wrapper">
        <dl class="accordion__box">
          <dt class="accordion__partition">
            <span class="accordion__number">03</span>
            <span class="accordion__title">レジスタ　(5問)</span>
            
            <form method="POST" action="quiz_before.php">
              <input type="hidden" name="q_table" value="register">
              <input type="hidden" name="first" value="first3">
              <input type="submit" id="3" class="send__btn" value="選択">
            </form>
          </dt>

          <dd class="accordion__text">CPUの内部にある記憶装置</dd>
        </dl>
      </div>
      <label for="close-3" class="accordion__button">
        <span class="accordion__buttonText">CLOSE</span>
      </label>
    </label>
  </div>



  <div class="container"> <!--2列目のリスト-->
    <label class="accordion accordion--4" for="open-4">
      <input class="accordion__open" id="open-4" type="radio" name="accordion-4">
      <input class="accordion__close" id="close-4" type="radio" name="accordion-4">
      <div class="accordion__tab">CHECK!</div>
      <div class="accordion__wrapper">
        <dl class="accordion__box">
          <dt class="accordion__partition">
            <span class="accordion__number">04</span>
            <span class="accordion__title">メモリ　(5問)</span>

            <form method="POST" action="quiz_before.php">
              <input type="hidden" name="q_table" value="memory">
              <input type="hidden" name="first" value="first4">
              <input type="submit" id="4" class="send__btn" value="選択">
            </form>
          </dt>

          <dd class="accordion__text">ROMやRAMなどの記憶装置</dd>
        </dl>
      </div>
      <label for="close-4" class="accordion__button">
        <span class="accordion__buttonText">CLOSE</span>
      </label>
    </label>



    <label class="accordion accordion--5" for="open-5">
      <input class="accordion__open" id="open-5" type="radio" name="accordion-5">
      <input class="accordion__close" id="close-5" type="radio" name="accordion-5">
      <div class="accordion__tab">CHECK!</div>
      <div class="accordion__wrapper">
        <dl class="accordion__box">
          <dt class="accordion__partition">
            <span class="accordion__number">05</span>
            <span class="accordion__title">データベースの回復処理　(4問)</span>

            <form method="POST" action="quiz_before.php">
              <input type="hidden" name="q_table" value="recovery">
              <input type="hidden" name="first" value="first5">
              <input type="submit" id="3" class="send__btn" value="選択">
            </form>
          </dt>

          <dd class="accordion__text">リカバリ処理の仕組みと方式</dd>
        </dl>
      </div>
      <label for="close-5" class="accordion__button">
        <span class="accordion__buttonText">CLOSE</span>
      </label>
    </label>


    
    <label class="accordion accordion--6" for="open-6">
      <input class="accordion__open" id="open-6" type="radio" name="accordion-6">
      <input class="accordion__close" id="close-6" type="radio" name="accordion-6">
      <div class="accordion__tab">CHECK!</div>
      <div class="accordion__wrapper">
        <dl class="accordion__box">
          <dt class="accordion__partition">
            <span class="accordion__number">06</span>
            <span class="accordion__title">ネットワーク機器　(4問)</span>

            <form method="POST" action="quiz_before.php">
              <input type="hidden" name="q_table" value="osi">
              <input type="hidden" name="first" value="first6">
              <input type="submit" id="6" class="send__btn" value="選択">
            </form>
          </dt>
          <dd class="accordion__text">OSI参照モデルの各層の機器</dd>
        </dl>
      </div>
      <label for="close-6" class="accordion__button">
        <span class="accordion__buttonText">CLOSE</span>
      </label>
    </label>
  </div>



  <div class="container"> <!--3列目のリスト-->
    <label class="accordion accordion--7" for="open-7">
      <input class="accordion__open" id="open-7" type="radio" name="accordion-7">
      <input class="accordion__close" id="close-7" type="radio" name="accordion-7">
      <div class="accordion__tab">CHECK!</div>
      <div class="accordion__wrapper">
        <dl class="accordion__box">
          <dt class="accordion__partition">
            <span class="accordion__number">07</span>
            <span class="accordion__title">プロトコル1　(4問)</span>

            <form method="POST" action="quiz_before.php">
              <input type="hidden" name="q_table" value="protocol1">
              <input type="hidden" name="first" value="first7">
              <input type="submit" id="6" class="send__btn" value="選択">
            </form>
          </dt>

          <dd class="accordion__text">役割について</dd>
        </dl>
      </div>
      <label for="close-7" class="accordion__button">
        <span class="accordion__buttonText">CLOSE</span>
      </label>
    </label>



    <label class="accordion accordion--8" for="open-8">
      <input class="accordion__open" id="open-8" type="radio" name="accordion-8">
      <input class="accordion__close" id="close-8" type="radio" name="accordion-8">
      <div class="accordion__tab">CHECK!</div>
      <div class="accordion__wrapper">
        <dl class="accordion__box">
          <dt class="accordion__partition">
            <span class="accordion__number">08</span>
            <span class="accordion__title">プロトコル2　(8問)</span>

            <form method="POST" action="quiz_before.php">
              <input type="hidden" name="q_table" value="protocol2">
              <input type="hidden" name="first" value="first8">
              <input type="submit" id="6" class="send__btn" value="選択">
            </form>
          
          </dt>

          <dd class="accordion__text">ポート番号について</dd>
        </dl>
      </div>
      <label for="close-8" class="accordion__button">
        <span class="accordion__buttonText">CLOSE</span>
      </label>
    </label>



    <label class="accordion accordion--9" for="open-9">
      <input class="accordion__open" id="open-9" type="radio" name="accordion-9">
      <input class="accordion__close" id="close-9" type="radio" name="accordion-9">
      <div class="accordion__tab">CHECK!</div>
      <div class="accordion__wrapper">
        <dl class="accordion__box">
          <dt class="accordion__partition">
            <span class="accordion__number">09</span>
            <span class="accordion__title">損益計算書　(4問)</span>

            <form method="POST" action="quiz_before.php">
              <input type="hidden" name="q_table" value="benefit">
              <input type="hidden" name="first" value="first9">
              <input type="submit" id="6" class="send__btn" value="選択">
            </form>

          </dt>

          <dd class="accordion__text">利益の名称</dd>
        </dl>
      </div>
      <label for="close-9" class="accordion__button">
        <span class="accordion__buttonText">CLOSE</span>
      </label>
    </label>
  </div>
</body>

</html>