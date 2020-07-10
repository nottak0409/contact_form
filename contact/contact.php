<?php

require_once('../lib/functions.php');

session_start();

$flash = isset($_SESSION['flash']) ? $_SESSION['flash'] : array();
unset($_SESSION['flash']);

$ticket = md5(uniqid(rand(), TRUE));

$_SESSION['ticket'] = $ticket;

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>contact</title>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
<link rel="stylesheet" href="./stylesheet.css">
</head>
<header>
<?php

foreach(array('default', 'error', 'warning') as $key) {
    if(strlen(@$flash[$key])){
        ?>
            <h1 class="alert-danger text-center">
                <?php echo $flash[$key]; ?>
            </h1>
<?php }}  ?>
</header>
<body>
  <div class = "container">
    <h2 class="">問い合わせフォーム</h2>
    <p>以下のフォームからお問い合わせください</p>
    <form id="form" action="confirm.php" method="post" name="form" onsubmit="return validate()">
      <div class="form-group">
        <label for="name">お名前（30文字以内)(必須)
          <span class="error text-danger"><?php if (isset ($_SESSION["error_name"] ) ) echo h($_SESSION["error_name"]); ?></span>
        </label>
        <input type="text" class="form-control" id="name" name="name" placeholder="氏名" value="<?php echo h($name) ?>">
      </div>
      <div class="form-group">
        <label for="email">メールアドレス(必須)
          <span class="error text-danger"><?php if (isset ($_SESSION["error_email"] ) ) echo h($_SESSION["error_email"]); ?></span>
        </label>
        <input type="text" class="form-control" id="email" name="email" placeholder="メールアドレス" value="<?php echo h($email) ?>">
      </div>
      <div class="form-group">
        <label for="email_check text-danger">メールアドレス(確認)
          <span class="error text-danger"><?php if (isset ($_SESSION["error_email_check"] ) ) echo h($_SESSION["error_email_check"]); ?></span>
        </label>
        <input type="text" class="form-control" id="email_check" name="email_check" placeholder="メールアドレス(確認)" value="<?php echo h($email_check) ?>">
      </div>
      <div class="form-group">
        <label for="tel">お電話番号(半角英数字)(必須)
          <span class="error text-danger"><?php if (isset ($_SESSION["error_tel"] ) ) echo h($_SESSION["error_tel"]); ?></span>
        </label>
        <input type="text" class="form-control" id="tel" name="tel" placeholder="電話番号" value="<?php echo h($tel) ?>">
      </div>
      <div class="form-group">
        <label for="subject">件名(必須)
          <span class="error text-danger"><?php if (isset ($_SESSION["error_subject"])) echo h($_SESSION["error_subject"]); ?></span>
        </label>
        <input type="text" class="form-control" id="subject" name="subject" placeholder="件名" value="<?php echo h($subject) ?>">
      </div>
      <div class="form-group">
        <label for="contact">お問い合わせ内容(必須)
          <span class="error text-danger"><?php if (isset ($_SESSION["error_contact"] ) ) echo h($_SESSION["error_contact"]); ?></span>
        </label>
        <textarea class="form-control" id="contact" name="contact" placeholder="お問い合わせ内容（1000文字まで)(必須)" row=3><?= h($contact); ?></textarea>
      </div>
      <input type="hidden" name="ticket" value="<?= h($ticket); ?>">
      <button name="submitted" type="submit" class="btn btn-primary">送信</button>
    </form>
  </div>
</body>
</html>
