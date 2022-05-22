<?php
    session_start();
    require_once("conn.php");
    require_once("utils.php");


    //要登入才能進來
    if(!($_SESSION['username'])) {
        header("Location: login.php");
        die();
    }
    

    //抓身分資料
    $username = $_SESSION['username'];
    $row = getUserFromUsername($username);

    //只有管理者可以進來
    if(!($row['role']==='admin')){
        header("Location: index.php?errCode=51");
        die('趕快回火星去吧!');
    }

    //抓資料嚕
    $sql ="SELECT ID, username, nickname, role FROM cokecode_w9_users";
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute();
    if(!$result){
        die('ERROR:' . $conn->error);
    }

    $result = $stmt->get_result();
  
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
                <h1 class='board__title'>使用者權限管理頁面</h1>
                <div class='board__btns'>
                    <a class='board__btn' href="index.php">回首頁</a>
                </div>
            </div>  
            <div class='board__greeting'>日安管理員~祝您有美好的一天</div>

            <div class='broad__hr'></div>
            <section class='card'>
                <table class='table__user__edit'>
                    <tr>
                        <th>User ID</th>
                        <th>Nickname</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Edit</th>
                    </tr>
                
                    <?php while($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo escape($row['ID']); ?></td>
                            <td><?php echo escape($row['nickname']); ?></td>
                            <td><?php echo escape($row['username']); ?></td>
                            <td><?php echo escape($row['role']); ?></td>
                            <td class='edit__user__btn'>
                                <a href='handle_edit_user_status.php?role=admin&ID=<?php echo escape($row['ID']); ?>'>Admin</a>
                                <a href='handle_edit_user_status.php?role=normal&ID=<?php echo escape($row['ID']); ?>'>Normal</a>
                                <a href='handle_edit_user_status.php?role=banned&ID=<?php echo escape($row['ID']); ?>'>Banned</a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </section>

  </body>
</html>