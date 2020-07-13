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
        exit();
      }
    } else {
      flash('error', '不正なアクセスです。');
      header('Location: ../index.php');
      exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // フォームから送信されたデータを各変数に格納
        $name = trim(isset($_POST['name']) ? $_POST['name']: NULL );
        $email = trim( isset( $_POST[ 'email' ] ) ? $_POST[ 'email' ] : NULL );
        $email_check = trim( isset( $_POST[ 'email_check' ] ) ? $_POST[ 'email_check' ] : NULL );
        $tel = trim( isset( $_POST[ 'tel' ] ) ? $_POST[ 'tel' ] : NULL );
        $subject = trim( isset( $_POST[ 'subject' ] ) ? $_POST[ 'subject' ] : NULL );
        $contact = trim ( isset( $_POST[ 'contact' ] ) ? $_POST[ 'contact' ] : NULL );

        $_SESSION["name"] = $name;
        $_SESSION["email"] = $email;
        $_SESSION["email_check"] = $email_check;
        $_SESSION["tel"] = $tel;
        $_SESSION["subject"] = $subject;
        $_SESSION["contact"] = $contact;
      }

      if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $_POST = checkInput( $_POST );

        //エラーメッセージを保存する配列の初期化
        $error = array();

        if ( $name == '' ) {
          $error['name'] = '*名前を入力してください。';
        } elseif ( preg_match( '/\A[[:^cntrl:]]{1,30}\z/u', $name ) == 0 ) {
          //[:cntrl:]→制御文字 [:^cntrl:]→制御文字を含まない /u→パターン修飾子
          $error['name'] = '*名前は30文字以内です。';
        }

        if ( $email == '' ) {
          $error['email'] = '*メールアドレスを入力してください。';
        } elseif ( preg_match( "/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/", $email) == 0) {
          $error['email'] = 'メールアドレスの形式が正しくありません。';
        }
        if ( $email_check == '' ) {
          $error['email_check'] = '*確認用メールアドレスに入力してください。';
        } elseif( $email_check !== $email ) {
          $error['email_check'] = '*メールアドレスが一致しません。';
        }

        if ( $tel != '' && preg_match( '/\A\(?\d{2,5}\)?[-(\.\s]{0,2}\d{1,4}[-)\.\s]{0,2}\d{3,4}\z/u', $tel ) == 0 ) {
          $error['tel'] = '*電話番号の形式は正しくありません。';
        } elseif ( $tel == '' ) {
          $error['tel'] = '*電話番号を入力してください';
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
      }

//class ErrorSession {
//  public function setValue($i){
//  $_SESSION["error_{$i}"] = $error["{$i}"];
//  }
//}
//      $error_name = new ErrorSession();
//      $error_name->setValue("name");
     if (!empty($error)){
      $_SESSION["error_name"] = $error['name'];
      $_SESSION["error_email"] = $error['email'];
      $_SESSION["error_email_check"] = $error['email_check'];
      $_SESSION["error_tel"] = $error['tel'];
      $_SESSION["error_subject"] = $error['subject'];
      $_SESSION["error_contact"] = $error['contact'];
    }

      if ( $error != array() )
      { header('Location: ../index.php'); }
    // 送信ボタンが押されたら

    if (isset($_POST["submit"])) {
        // 送信ボタンが押された時に動作する処理をここに記述する

            mb_language("ja");
        mb_internal_encoding("UTF-8");

        //mb_send_mail("kanda.it.school.trial@gmail.com", "メール送信テスト", "メール本文");

            // 件名を変数titleに格納
            $title = "［自動送信］お問い合わせ内容の確認";

            // メール本文を変数bodyに格納
        $body = <<< EOM
{$name}　様

お問い合わせありがとうございます。
以下のお問い合わせ内容を、メールにて確認させていただきました。

===================================================
【 お名前 】
{$name}

【 メール 】
{$email}

【 電話番号 】
{$tel}

【 項目 】
{$subject}

【 内容 】
{$contact}
===================================================

内容を確認のうえ、回答させて頂きます。
しばらくお待ちください。
EOM;

        // 送信元のメールアドレスを変数fromEmailに格納
        $fromEmail = "nottak0409@gmail.com";

        // 送信元の名前を変数fromNameに格納
        $fromName = "お問い合わせテスト";

        // ヘッダ情報を変数headerに格納する
        $header = "From: " .mb_encode_mimeheader($fromName) ."<{$fromEmail}>";

        // メール送信を行う
        mb_send_mail($email, $title, $body, $header, $fromemail);

        // complete.phpに画面遷移させる
        header("Location: complete.php");
        exit;
    }
?>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>お問い合わせフォーム</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
<link rel="stylesheet" href="./stylesheet.css">
<body>
<div class = "container">
    <form action="complete.php" method="post">
            <input type="hidden" name="name" value="<?php echo $name; ?>">
            <input type="hidden" name="email" value="<?php echo $email; ?>">
            <input type="hidden" name="tel" value="<?php echo $tel; ?>">
            <input type="hidden" name="subject" value="<?php echo $subhect; ?>">
            <input type="hidden" name="contact" value="<?php echo $contact; ?>">
            <h1 class="contact-title">お問い合わせ 内容確認</h1>
            <p>お問い合わせ内容はこちらで宜しいでしょうか？<br>よろしければ「送信する」ボタンを押して下さい。</p>
            <div>
                <div>
                    <label>お名前</label>
                    <p class="form-control"><?php echo $name; ?></p>
                </div>
                <div>
                    <label>メールアドレス</label>
                    <p class="form-control"><?php echo $email; ?></p>
                </div>
                <div>
                    <label>電話番号</label>
                    <p class="form-control"><?php echo $tel; ?></p>
                </div>
                <div>
                    <label>お問い合わせ項目</label>
                    <p class="form-control"><?php echo $subject; ?></p>
                </div>
                <div>
                    <label>お問い合わせ内容</label>
                    <p class="form-control"><?php echo nl2br($contact); ?></p>
                </div>
            </div>
        <input type="hidden" name="ticket" value="<?= h($ticket); ?>">
        <input type="button" value="内容を修正する" onclick="history.back(-1)" class="btn btn-secondary">
        <button type="submit" name="submit" class="btn btn-primary">送信する</button>
    </form>
</div>
</body>
</html>
