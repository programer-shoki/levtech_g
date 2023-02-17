<!--
<h1><a href="method.php">test01.php</a></h1>
<h1><a href="index.html">index.html</a></h1>
-->
<?php 
    /*
    class Test {
        public $a=5;
    }

    $testa = new Test();
    echo $testa->a;
    */
        

    class use_SQL {

        
        // $table_name01 = テーブル名,     $id_value01 = id列の値
        //  テーブルの列数を取得
        public static function CountColumnSQL($table_name01, $id_value01, ) {
            $conn01 = new PDO('sqlite:quizz10.sqlite3');

            $sql01="SELECT * FROM '".$table_name01."' WHERE id='".$id_value01."';";
            $result01=$conn01->query($sql01);        
            $x01 = $result01->fetch();
            $y01=count($x01)/2;
            return $y01;
        }
        
        
        
        // $table_name02 = テーブル名,      $id_value02 = id列の値
        //  id列を検索して一致するレコードの値を取得
        public static function SelectIdSQL($table_name02, $id_value02) {
            $conn02 = new PDO('sqlite:quizz10.sqlite3');

            $sql02="SELECT * FROM '".$table_name02."' WHERE id = '".$id_value02."';";
            $result02=$conn02->query($sql02);       
            $x02 = $result02->fetch();
            return $x02;
        }
        

        
        
        / $table_name03 = テーブル名,      $up03 = 0 or 1,       $id_value03 = kind列の値
        


        // テーブルの行数を取得
        // $table_name05にテーブル名を代入
        public static function CountLineSQL($table_name05) {
            $conn05 = new PDO('sqlite:quizz10.sqlite3');
            $sql05="SELECT COUNT(*) FROM '".$table_name05."';";
            $result05=$conn05->query($sql05);
            $count05=$result05->fetchColumn();
            return $count05;
        }
        

        // $table_name06 = テーブル名,      $id_value06 = id列の値
        //  checked列を検索して一致するレコードの値を取得
        public static function SelectCheckedSQL($table_name06, $checked_value06) {
            $conn06 = new PDO('sqlite:quizz10.sqlite3');

            $sql06="SELECT * FROM '".$table_name06."' WHERE checked = '".$checked_value06."';";
            $result06=$conn06->query($sql06);       
            $x06 = $result06->fetch();
            return $x06;
        }

        
    }

    $a01=new use_SQL();

    /*      テーブルの列数を取得
    $id=2;
    $a=new use_SQL();
    $b=$a->CountColumnSQL($table, $id);
    echo $b;
    */


    /*      id列を検索して一致するレコードの値を取得
    $v02=2;
    $b02=$a->SelectIdSQL($table, $v02);
    echo $b02[0];
    echo $b02[1];
    */


    /*      id列を検索してchecked列の値を更新
    $table="quizz";
    $num1=1;
    $up1=1;

    $a01->UpdateChecked_idSQL($table, $up1 ,$num1);
    */


    /*          kind列を検索してchecked列の値を更新
    $table="quizz";
    $q_table="uml";
    $up1=1;

    $a01->UpdateChecked_kindSQL($table, $up1 ,$q_table);
    */

    /*      テーブルの行数を取得
    $q_table="uml";
    $c05=$a01->CountLineSQL($q_table);
    echo $c05;
    */

    
?>