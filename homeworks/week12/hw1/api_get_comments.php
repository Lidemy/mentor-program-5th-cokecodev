<?php
    require_once("conn.php");
    header('Content-type:application/json;charset=utf-8');
    header('Access-Control-Allow-Origin: *');

    if(
        empty($_GET['site_key'])
    ){
        $json = array(
            "ok" => false,
            "message" =>"Please put site_key in url."
        );

        $response = json_encode($json);
        echo $response;
        die();
    }


    $site_key = $_GET['site_key'];
    if(!empty($_GET['before'])) {
        $before = $_GET['before'];
    }
    
    if(empty($_GET['before'])) {
        $sql = 'SELECT id, nickname, content,created_at FROM cokecode_w12_discussions WHERE site_key = ? ORDER BY id DESC LIMIT 5';
    } else {
        $sql = 'SELECT id, nickname, content,created_at FROM cokecode_w12_discussions WHERE site_key = ? AND id < ? ORDER BY id DESC LIMIT 5';
    }
    $stmt = $conn->prepare($sql);

    if(empty($_GET['before'])) {
        $stmt->bind_param('s', $site_key);
    } else {
        $stmt->bind_param('si', $site_key, $_GET['before']);
    }
    $result = $stmt->execute();

    if(!$result){
        $json = array(
            "ok" => false,
            "message" =>$conn->error
        );
        $response = json_encode($json);
        echo $response;
        die();
    }

    $result = $stmt->get_result();
    $discussions = array();
    while($row = $result->fetch_assoc()){
        array_push($discussions, array(
            "id" => $row["id"],
            "nickname" => $row["nickname"],
            "content" => $row["content"],
            "created_at" => $row["created_at"]
        ));
    }

    $json = array(
        "ok" => true,
        "discussions" => $discussions
    );

    $response = json_encode($json);
    echo $response;

?>
