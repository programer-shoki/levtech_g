<?php
//セッションをスタート
session_start();

// ログアウトボタンを押された時の処理
if(isset($_POST["logout"]) && $_POST["logout"] == "yes"){//押されているならば
	//セッションを削除する
	session_unset();
	$conn=null;
}

// セッションデータ内に残されているアカウントと氏名を変数に記録
if(isset($_SESSION["id"])){ //残されているならば
	$session_id = $_SESSION["id"];//変数に代入
}

// フォームから送信されたアカウントとパスワードを変数に記録
if(isset($_POST["userID"]) && isset($_POST["password"])){ //アカウントとパスワードが送信されているならば
	$userID = $_POST["userID"]; //変数に代入
	$password = $_POST["password"]; //変数に代入
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="css/login.css">
<link rel="shortcut icon" href="favicon.ico">  
</head>
<body>
	<center>

<?php
// セッションデータにアカウントが残っていない（＝ログイン中ではない）ならば…
	// フォームからの送信値（アカウントとパスワード）がなければ…
if(empty($_POST["userID"]) && empty($_POST["password"])){  	?>

	<!-- ログインフォームを表示 -->
	<form action='login.php' method='POST'>
		<table>
			<tr>
				<td class="form_left">ID</td>
				<td class="form_right"><input type='text' class="input_space" name='userID' required></td>
			</tr>
			<tr>
				<td class="form_left">パスワード</td>
				<td class="form_right"><input type='password' class="input_space" name='password' required></td>
			</tr>
		</table>
		<input type='submit' class="btn-flat-double-border" value='ログイン'>
	</form>
	<br>
	<a class="top_replace" href="index.html">トップヘ</a>

	<hr>

<?php
	// フォームからの送信値があれば…
}else{ // (39行目のifに対するelse)
		
		// 送信されたuserID,passwordがusersテーブルにあれば，ログイン成功。
		// なければログイン失敗⇒エラーメッセージを出す。

		// データベースに接続する
		require("connect.php");

		$sql="SELECT * FROM users2 WHERE userID='".$userID."' AND password='".$password."';";
    	$result=$conn->query($sql);
		$r = $result->fetch();
		
		// 結果に応じて、ログイン成功または失敗
		if(isset($r[0])) { //ログイン成功
			
			 //検索結果のレコードを配列で取得
			$message = $r[1].'さん、ようこそ！'; 				
			?>
		<h1><?php echo $message; ?></h1>
			<form class="replace_home" method="POST" action="home.php">
                <input type="hidden" name="userID" value="<?php echo $r[1] ?>">
                <input type="submit" class="home" value="ホームへ">
            </form><br>

		<form class="replace_logout" method="POST" action="login.php">
		<input type="hidden" name="logout" value="yes">		
		<input type="submit" class="logout" value="ログアウト">
		</form>
		
		<?php
		} else { //ログイン失敗
			$message = "ログインできませんでした"; ?>
			<h1 class="login_NG"><?php echo $message; ?></h1>
			<?php $conn = null; ?>
			<br>
			<a class="replace_login" href="login.php">ログイン画面へ</a>
		<?php
		}
}
?>

	</center>
</body>
</html>