<?php
require_once 'utils/class.Picture.php';
require_once 'utils/class.PacaDb.php';
    
    $db = new PacaDb();
    
    $fileName = basename( $_FILES['uploaded_file']['name']);
    $filePath = "../Pictures/" . $fileName;
    
    if (move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $filePath)) {
        $db->insertPicture($fileName, "timestamp", 100, 200);
        echo "success";
    } else{
        echo "fail";
    }
    
    $db->close();
    
?>
