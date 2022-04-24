<?php
    session_start();
    require_once('conn.php');
    require_once("utils.php");

    if (
        empty($_POST['content'])
    ) {
        header('Location: index.php?errCode=1');
        die('資料不齊全');
    }


    
    $user = getUserFromUsername($_SESSION['username']);
    $nickname = $user['nickname'];


    $content = $_POST['content'];
    $sql = sprintf(
        "insert into cokecode_w9_comments(nickname, content) values('%s','%s')",
        $nickname,
        $content
    );

    $result = $conn->query($sql);
    if(!$result) {
        die($conn->error);
    }

    header("Location: index.php");
?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>留言板</title>
    <link rel="stylesheet" href="./style.css">
  </head>
  <body>
      <header class='warning'>
          <strong>注意!本網站為練習用網站，因教學用途刻意忽略資安的操作，註冊時請勿使用任何真實的帳號或密碼。</strong>
      </header>
      <main class='board'>
          <h1 class='board__title'>Comments</h1>
          <form class='board__form' method="POST" action="handle_add_comment.php">
              <div class='form__nickname'>
                  <span class ='nickname__title'>暱稱:</span>
                  <input class ='nickname__input' type="text" placeholder ='該怎麼稱呼您'>
              </div>
              <div class ='broad__content'>
                  <textarea name ='content' row='3' placeholder ='請輸入您的留言...'></textarea>
              </div>
              <input class='form__submit' type='submit' value='送出'> 
          </form>
          <div class='broad__hr'></div>
          
          <?php
             while($row = $result->fetch_assoc()) {
          ?>
          <!-- php while 開-->
          <section class='card'>
              <div class='card__avatar'></div>
              <div class='card__info'>
                  <span class='card__nickname'><?php echo $row['nickname']; ?></span>
                  <span class='card__createdAt'><?php echo $row['created_at']; ?></span>
                  <p class='card__content'><?php echo $row['content']; ?></p>
            </div>
          </section>
          <?php } ?>
      <!-- php while 關 -->
      <!-- 
           注意!!開跟關的位置會決定新增的資料有誰，然後會新增到哪!!! -->
      </main>
  </body>
</html>