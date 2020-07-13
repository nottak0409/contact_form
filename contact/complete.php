<?php
require_once('../lib/functions.php');

session_start();

$flash = isset($_SESSION['flash']) ? $_SESSION['flash'] : array();
unset($_SESSION['flash']);

if (isset($_POST['ticket']) && isset($_SESSION['ticket'])) {
  $ticket = $_POST['ticket'];
  if ($ticket != $_SESSION['ticket']) {
    flash('error', '不正なアクセスです。');
    header('Location: ../index.php');
    exit();}
  } else {
    flash('error', '不正なアクセスです。');
    header('Location: ../index.php');
    exit();
  }

if(isset($_POST['submit'])) {
  $_SESSION = array();
  session_destroy();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>お問い合わせフォーム</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
<link rel="stylesheet" href="./stylesheet.css">
</head>
<body>
<div class = "container">
        <div>
		<h1>お問い合わせ 送信完了</h1>
		<p>
		お問い合わせありがとうございました。<br>
		内容を確認のうえ、回答させて頂きます。<br>
		しばらくお待ちください。
		</p>
		<a href="../index.php">
			<button type="button" class="btn btn-info" >お問い合わせに戻る</button>
		</a>
	</div>
</div>
</body>
</html>
