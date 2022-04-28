<?php
    require_once("conn.php");

    function generateToken() {
        $s ='';
        for($i=1; $i<=16; $i++) {
            $s .=chr(rand(65,90));
        }
        return $s;
    }

    function getUserFromUsername($username) {
        global $conn; // 要在 function 裡面用 $conn 的話要，先這樣宣告說：我要用"全域的變數 $conn" 不然會找不到

        // 帶上面找到的 username 去查其他的資料
        $sql = sprintf(
            "select * from cokecode_w9_users where username ='%s'",
            $username
        );
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        echo($row);
        return $row;
    }


?>