<?php

//エスケープ処理
function h($var){
  if(is_array($var)){
    return array_map('h', $var);
  } else {
    //特殊文字をHTMLエンティティに変換→XXS対策
    return htmlspecialchars($var, ENT_QUOTES, 'UTF-8');
  }
}

//入力値の不正なデータのチェック
function checkInput($var){
  if(is_array($var)){
    return array_map('checkInput', $var);
  } else {
    //NULLバイト攻撃対策
    if(preg_match('/\0/', $var)){
      die('不正な値です')
    }
    //文字のエンコードチェック
    if(!mb_check_encoding($var, 'UTF-8')){
      die('不正な値です')
    }
    return $var;
  }
}
