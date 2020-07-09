<?php

require_once('../lib/functions.php');

$name = trim(isset($_POST['name']) ? $_POST['name']: NULL );
$email = trim( isset( $_POST[ 'email' ] ) ? $_POST[ 'email' ] : NULL );
$email_check = trim( isset( $_POST[ 'email_check' ] ) ? $_POST[ 'email_check' ] : NULL );
$tel = trim( isset( $_POST[ 'tel' ] ) ? $_POST[ 'tel' ] : NULL );
$subject = trim( isset( $_POST[ 'subject' ] ) ? $_POST[ 'subject' ] : NULL );
$contact = trim ( isset( $_POST[ 'contact' ] ) ? $_POST[ 'contact' ] : NULL );

if (isset($_POST['submitted'])) {

  $_POST = checkInput( $_POST );

  //エラーメッセージを保存する配列の初期化
  $error = array();

  $section = 0;

  if ( $name == '' ) {
    $error['name'] = '*名前を入力してください。';
  } elseif ( preg_match( '/\A[[:^cntrl:]]{1,30}\z/u', $name ) == 0 ) {
    //[:cntrl:]→制御文字 [:^cntrl:]→制御文字を含まない /u→パターン修飾子
    $error['name'] = '*名前は30文字以内です。';
  }

  if ( $email == '' ) {
    $error['email'] = '*メールアドレスを入力してください。';
  }

  if ( $email_check == '' ) {
    $error['email_check'] = '確認用メールアドレスに入力してください。';
  } elseif( $email_check !== $email ) {
    $error['email_check'] = 'メールアドレスが一致しません。';
  }

  if ( $tel != '' && preg_match( '/\A\(?\d{2,5}\)?[-(\.\s]{0,2}\d{1,4}[-)\.\s]{0,2}\d{3,4}\z/u', $tel ) == 0 ) {
    $error['tel'] = '*電話番号の形式は正しくありません。';
  }

  if ( $subject == '' ) {
    $error['subject'] = '*件名を入力してください。';
  } elseif( preg_match( '/\A[[:^cntrl:]]{1,100}\z/u', $subject ) == 0 ) {
   $error['subject'] = '*件名は100文字以内です。';
  }

  if( $contact == '' ) {
    $error['contact'] = '*内容を入力してください';
  } elseif ( preg_match( '/\A[\r\n\t[:^cntrl:]]{1,1050}\z/u', $contact ) == 0 ) {
    $error['contact'] = '*内容は1000文字以内です。';
  }
  else
  { $section == "true"; }
}
 ?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>contact</title>
<link rel="stylesheet" href="../lib/style.css">
<link rel="bootstrap" href="../lib/bootstrap.html">
</head>
<body>
  <div class = "container">
    <h2 class="">問い合わせフォーム</h2>
    <p>以下のフォームからお問い合わせください</p>
    <form id="form" action="<?php if ($section == "true") {echo "confirm.php" ;} ?>" method="post" name="form" onsubmit="return validate()">
      <div class="form-group">
        <label for="name">お名前（30文字以内)(必須)
          <span class="error"><?php if (isset ($error['name'] ) ) echo h($error['name']); ?></span>
        </label>
        <input type="text" class="form-control" id="name" name="name" placeholder="氏名" value="<?php echo h($name) ?>">
      </div>
      <div class="form-group">
        <label for="email">メールアドレス(必須)
          <span class="error"><?php if (isset ($error['email'] ) ) echo h($error['email']); ?></span>
        </label>
        <input type="text" class="form-control" id="email" name="email" placeholder="メールアドレス" value="<?php echo h($email) ?>">
      </div>
      <div class="form-group">
        <label for="email_check">メールアドレス(確認)
          <span class="error"><?php if (isset ($error['email_check'] ) ) echo h($error['email_check']); ?></span>
        </label>
        <input type="text" class="form-control" id="email_check" name="email_check" placeholder="メールアドレス(確認)" value="<?php echo h($email_check) ?>">
      </div>
      <div class="form-group">
        <label for="tel">お電話番号(半角英数字)(必須)
          <span class="error"><?php if (isset ($error['tel'] ) ) echo h($error['tel']); ?></span>
        </label>
        <input type="text" class="form-control" id="tel" name="tel" placeholder="電話番号" value="<?php echo h($tel) ?>">
      </div>
      <div class="form-group">
        <label for="subject">件名(必須)
          <span class="error"><?php if (isset ($error['subject'] ) ) echo h($error['subject']); ?></span>
        </label>
        <input type="text" class="form-control" id="subject" name="subject" placeholder="件名" value="<?php echo h($subject) ?>">
      </div>
      <div class="form-group">
        <label for="contact">お問い合わせ内容(必須)
          <span class="error"><?php if (isset ($error['contact'] ) ) echo h($error['contact']); ?></span>
        </label>
        <textarea class="form-control" id="contact" name="contact" placeholder="お問い合わせ内容（1000文字まで)(必須)" row=3><?= h($contact); ?></textarea>
      </div>
      <button name="submitted" type="submit" class="btn btn-primary">送信</button>
    </form>
  </div>
</body>
</html>
