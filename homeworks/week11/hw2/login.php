<?php
    session_start();
    require_once("conn.php");
    require_once("utils.php");
    require_once("utils_session.php");
?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>存放技術之地</title>
    <link rel="stylesheet" href="./style.css">
  </head>
  <body>
    <?php
        require_once('section_nav.php');
        require_once('section_banner.php');
    ?>

    <section class ='cards'>
        <div class ='login__card'>
            <div class ='login__wapper'>
                <h1 class ='login__card__title'>Log in</h1>

                <?php
                    if(!empty($_GET['errCode'])) {
                        $code = $_GET['errCode']; //檢查errCode帶的是啥
                        $msg = 'Error';           // 預設錯誤訊息
                        if ($code === '1') {
                            $msg = '錯誤:資料不齊全!';
                        }else if ($code === '2') {
                            $msg = '錯誤:帳號錯誤!';
                        }else if ($code === '3') {
                                $msg = '錯誤:密碼錯誤!';
                                }
                        echo'<div class="error__message">'. $msg . '</div>';
                    }
                ?>

                <form method ='POST' action ='handle_login.php'>
                    <div class ='input__block'>
                        <div class ='login__form__title'>USERNAME</div>
                        <input name ='username' type ='text'/>
                    </div>
                    <div class ='input__block'>
                        <div class ='login__form__title'>PASSWORD</div>
                        <input name ='password' type ='password'/>
                    <div>
                    <input class ='sign-in__btn' type='submit' value='SIGN IN'/>
                </form>
            </div>
        </div>

    </section>




    <footer>
        <div class ='footer__mes'>Copyright © 2020 Who's Blog All Rights Reserved.</div>
    </footer>
  </body>
</html>