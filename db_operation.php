<?php
require_once 'utils/class.PacaDb.php';
    
    $db = new PacaDb();
    
    $request_code = $_POST['request_code'];
    switch($request_code) {
        case "0":
            $file_name = $_POST['file_name'];
            $timestamp = $_POST['timestamp'];
            $lat = $_POST['lat'];
            $lng = $_POST['lng'];
            echo $db->insertPicture($file_name, $timestamp, $lat, $lng);
            break;
        case "1":
            $id = $_POST['id'];
            $likes = $_POST['likes'];
            echo $db->updateLikes($id, $likes);
            break;
    }
    
    $db->close();
    
?>
