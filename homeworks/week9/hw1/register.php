<?php
    require_once("conn.php");
?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>阿摟哈留言板</title>
    <link rel="stylesheet" href="./style.css">
  </head>
  <body>
      <header class='warning'>
          <strong>注意!本網站為練習用網站，因教學用途刻意忽略資安的操作，註冊時請勿使用任何真實的帳號或密碼。</strong>
      </header>
      <main class='board'>
        <div class='board__top'>
            <h1 class='board__title'>阿摟哈留言板 - Register</h1>
            <div class='board__btns'>
                <a class='board__btn' href="index.php">回留言板</a>
                <a class='board__btn' href="login.php">登入</a>
            </div>
        </div>

          <?php
            if(!empty($_GET['errCode'])) {
                $code = $_GET['errCode']; //檢查errCode帶的是啥
                $msg = 'Error';           // 預設錯誤訊息
                if ($code === '1') {
                    $msg = '錯誤:資料不齊全!';
                }else if ($code === '2') {
                    $msg = '錯誤:帳號已被註冊!';
                    }
                echo'<div class="error__message">'. $msg . '</div>';
            }
          ?>
          <form class='board__form' method="POST" action="handle_register.php">
              <div class=''>
                <div class='form__inpt-block'>
                    <span class ='form__block__title'>暱稱:</span>
                    <input name='nickname' class ='form__block__input' type="text" placeholder ='該怎麼稱呼您'>
                <!-- 要記得幫 input '指定name' 不然程式會不知道要指向資料庫的哪個欄位-->
                </div>
                <div class='form__block'>
                    <span class ='form__block__title'>帳號:</span>
                    <input name='username' class ='form__block__input' type="text" placeholder ='登入時的帳號'>
                </div>
                <div class='form__block'>
                    <span class ='form__block__title'>密碼:</span>
                    <input name='password' class ='form__block__input' type="password" placeholder ='登入時的密碼'>
                </div>
                <input class='form__submit' type='submit' value='註冊'>
              </div>
          </form>
          
      </main>
  </body>
</html>