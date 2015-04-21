<?php
require_once 'utils/class.Picture.php';
    
    $file_path = "../Pictures/";

    $file_path = $file_path . basename( $_FILES['uploaded_file']['name']);

    $head = unserialize(file_get_contents("../Pictures/data.Head.php"));

    $newHead = new Picture($file_path);
    $newHead->setNext($head);

    $objData = serialize($newHead);
    $file = fopen("../Pictures/data.Head.php", "w");
    fwrite($file, $objData);
    fclose($file);

    if (move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $file_path)) {
        echo "success";
    } else{
        echo "fail";
    }
?>
