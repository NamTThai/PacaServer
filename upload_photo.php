<?php
require_once 'utils/class.Picture.php';
    
    $fileName = md5(basename( $_FILES['uploaded_file']['name'])).".jpg";
    $filePath = "../Pictures/" . $fileName;
    
    if (move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $filePath)) {
        echo $fileName;
    } else {
        echo (int) false;
    }
    
?>
