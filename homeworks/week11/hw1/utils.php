<?php
    require_once("conn.php");

    
    function escape($str) {
        return htmlspecialchars($str, ENT_QUOTES);
    }


    function getUserFromUsername($username) {
        global $conn; // 要在 function 裡面用 $conn 的話要，先這樣宣告說：我要用"全域的變數 $conn" 不然會找不到

        // 帶上面找到的 username 去查其他的資料
        $sql = "select * from cokecode_w9_users where username =?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s',$username);
        $result = $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row;
    }


    function getUserStatus($username){
        global $conn;

        //先查身分
        $row = getUserFromUsername($username);
        $role = $row['role'];
    
        //查身分可以做甚麼操作
        $sql = "SELECT * FROM cokecode_w9_users_status WHERE role =?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s',$role);
        $result = $stmt->execute();
    
        $result = $stmt->get_result();
        $row_status = $result->fetch_assoc();
        return $row_status;
    }




        function checkCreat($row_status, $row, $username) {
            switch($row_status['creat']){
                case 'true':
                    return true;
                    break;
                case 'need_checked':
                    if($row['username'] === $username){
                        return true;
                    }else {
                        return false;
                    }
                    break;   
                default:
                    return false;
            }
        }

        function checkUpdateOthers($row_status, $row, $username) {
            switch($row_status['update-others']){
                case 'true':
                    return true;
                    break;
                case 'need_checked':
                    if($row['username'] === $username){
                        return true;
                    }else {
                        return false;
                    }
                    break;   
                default:
                    return false;
            }
        }

        function checkUpdateSelf($row_status, $row, $username) {
            switch($row_status['update-self']){
                case 'true':
                    return true;
                    break;
                case 'need_checked':
                    if($row['username'] === $username){
                        return true;
                    }else {
                        return false;
                    }
                    break;   
                default:
                    return false;
            }
        }

        function checkDeleteOthers($row_status, $row, $username) {
            switch($row_status['delete-others']){
                case 'true':
                    return true;
                    break;
                case 'need_checked':
                    if($row['username'] === $username){
                        return true;
                    }else {
                        return false;
                    }
                    break;   
                default:
                    return false;
            }
        }

        function checkDeleteSelf($row_status, $row, $username) {
            switch($row_status['delete-self']){
                case 'true':
                    return true;
                    break;
                case 'need_checked':
                    if($row['username'] === $username){
                        return true;
                    }else {
                        return false;
                    }
                    break;   
                default:
                    return false;
            }
        }


?>