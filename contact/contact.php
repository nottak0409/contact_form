<?php

require_once('../lib/functions.php')

$name = trim( isset( $_POST[ 'name' ] ) ? $_POST[ 'name' ] : NULL; )
$email = trim( isset( $_POST[ 'email' ] ) ? $_POST[ 'email' ] : NULL; )
$email_check = trim( isset( $_POST[ 'email_check' ] ) ? $_POST[ 'email_check' ] : NULL; )
$tel = trim( isset( $_POST[ 'tel' ] ) ? $_POST[ 'tel' ] : NULL; )
$subject = trim( isset( $_POST[ 'subject' ] ) ? $_POST[ 'subject' ] : NULL; )
$contact = trim ( isset( $_POST[ 'contact' ] ) ? $_POST[ 'contact' ] : NULL; )

if (isset($_POST['submitted'])) {

  $_POST = checkInput( $_POST );

  //エラーメッセージを保存する配列の初期化
  $error = array();

  if ( $name == '' ) {
    $error['name'] = '*名前を入力してください。';
  } elseif ( preg_match( '/\A[[:^cntrl:]]{1,30}\z/u', $name ) == 0 ){
    //[:cntrl:]→制御文字 [:^cntrl:]→制御文字を含まない /u→パターン修飾子
    $error['name'] = '*名前は30文字以内です。';
  }
  if ( $email == '' ) {
    $error['email'] = '*メールアドレスを入力してください。';
  } else { //正規表現でメールアドレスのチェック
    $pattern = '^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$';
    if ( !preg_match( $pattern, $email ) ) {
      $error['email'] = '*メールアドレスの形式が正しくありません。';
    }
  }
  
}

 ?>
