<?php
    require_once("conn.php");
    
    function escape($str) {
        return htmlspecialchars($str, ENT_QUOTES);
    }

    function getUserFromUsername($username) {
        global $conn;

        // 帶上面找到的 username 去查其他的資料
        $sql = "SELECT * FROM cokecode_w11_user WHERE username =?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s',$username);
        $result = $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row;
    }
?>