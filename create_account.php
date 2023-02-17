<!-- <p>新規登録画面です</p> -->
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/create_account.css">
    <link rel="shortcut icon" href="favicon.ico">  
    <title>create.php</title>
</head>
<body>


    <p>※　ID, パスワードを登録する上での注意</p>

    <ul class="alart_text">
	    <li>使える文字は半角英数字の「a~zのアルファベット」と「0~9の数字」のみ</li>
        <li>ID, パスワードはともに4文字以上8文字以内</li>
        <li>IDの先頭は必ず半角英数字の「a~zのアルファベット」を使用</li>
    </ul>
    
<center>
    <form action='create_account_after.php' method='POST'>
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
		<input type='submit' class="btn-flat-double-border" value='登録'>
	</form>


	<a href="index.html">トップヘ</a>
</center>


</body>
</html>