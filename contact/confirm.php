<?php
    // フォームのボタンが押されたら
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // フォームから送信されたデータを各変数に格納
        $name = trim(isset($_POST['name']) ? $_POST['name']: NULL );
        $email = trim( isset( $_POST[ 'email' ] ) ? $_POST[ 'email' ] : NULL );
        $email_check = trim( isset( $_POST[ 'email_check' ] ) ? $_POST[ 'email_check' ] : NULL );
        $tel = trim( isset( $_POST[ 'tel' ] ) ? $_POST[ 'tel' ] : NULL );
        $subject = trim( isset( $_POST[ 'subject' ] ) ? $_POST[ 'subject' ] : NULL );
        $contact = trim ( isset( $_POST[ 'contact' ] ) ? $_POST[ 'contact' ] : NULL );
      }
    // 送信ボタンが押されたら
    if (isset($_POST["submit"])) {
        // 送信ボタンが押された時に動作する処理をここに記述する

        // 日本語をメールで送る場合のおまじない
            mb_language("ja");
        mb_internal_encoding("UTF-8");

        //mb_send_mail("kanda.it.school.trial@gmail.com", "メール送信テスト", "メール本文");

            // 件名を変数subjectに格納
            $subject = "［自動送信］お問い合わせ内容の確認";

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
        $fromEmail = "contact@dream-php-seminar.com";

        // 送信元の名前を変数fromNameに格納
        $fromName = "お問い合わせテスト";

        // ヘッダ情報を変数headerに格納する
        $header = "From: " .mb_encode_mimeheader($fromName) ."<{$fromEmail}>";

        // メール送信を行う
        mb_send_mail($email, $subject, $body, $header);

        // complete.phpに画面遷移させる
        header("Location: complete.php");
        exit;
    }
?>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>お問い合わせフォーム</title>
<link rel="stylesheet" href="../lib/style.css">
<body>
<div><h2>お問い合わせ</h2></div>
<div>
    <form action="confirm.php" method="post">
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
                    <p><?php echo $name; ?></p>
                </div>
                <div>
                    <label>メールアドレス</label>
                    <p><?php echo $email; ?></p>
                </div>
                <div>
                    <label>電話番号</label>
                    <p><?php echo $tel; ?></p>
                </div>
                <div>
                    <label>お問い合わせ項目</label>
                    <p><?php echo $subject; ?></p>
                </div>
                <div>
                    <label>お問い合わせ内容</label>
                    <p><?php echo nl2br($contact); ?></p>
                </div>
            </div>
        <input type="button" value="内容を修正する" onclick="history.back(-1)">
        <button type="submit" name="submit">送信する</button>
    </form>
</div>
</body>
</html>
