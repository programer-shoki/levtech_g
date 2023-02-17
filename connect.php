<?php
	$conn = new PDO('sqlite:quizz10.sqlite3');
           

    class use_SQL {

        // $table_name01 = テーブル名,      $id_value01 = id列の値
        //  id列を検索して一致するレコードを取得
        public static function SelectIdSQL($table_name01, $id_value01) {
			$conn1 = new PDO('sqlite:quizz10.sqlite3');
            $sql01="SELECT * FROM '".$table_name01."' WHERE id = '".$id_value01."';";
            $result01=$conn1->query($sql01);       
            $x01_h = $result01->fetch();
            return $x01_h;
        }
        

        // テーブルの行数を取得
        // $table_name02にテーブル名を代入
        public static function CountLineSQL($table_name02) {
            $conn2 = new PDO('sqlite:quizz10.sqlite3');
            $sql02="SELECT COUNT(*) FROM '".$table_name02."';";
            $result02=$conn2->query($sql02);
            $table_line02=$result02->fetchColumn();
            return $table_line02;
        }
        

        // $table_name03 = テーブル名,      $id_value03 = id列の値
        //  checked列を検索して一致するレコードの値を取得
        public static function SelectCheckedSQL($table_name03, $checked_value03) {
			$conn3 = new PDO('sqlite:quizz10.sqlite3');
            $sql03="SELECT * FROM '".$table_name03."' WHERE checked = '".$checked_value03."';";
            $result03=$conn3->query($sql03);       
            $x03_h = $result03->fetch();
            return $x03_h;
        }

        
    }

    $connect_function=new use_SQL();
	$quizz="quizz";

    
    // id列を検索して一致するレコードの値を取得
    /*
    $v1=1;
    $a_h1=$function->SelectIdSQL($quizz, $v1);
    echo $a_h1[4];
    */


    // テーブルの行数を取得
    /*
    $a2=$function->CountLineSQL($quizz);
    echo $a2;
    */
    

	// checked列を検索して一致するレコードの値を取得
    /*
	$v3=1;
    $a_h3=$function->SelectCheckedSQL($quizz, $v3);
    echo $a_h3[4];
    */
    
?>