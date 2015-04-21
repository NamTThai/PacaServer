<?php

require_once "utils/class.Picture.php";

    $head = unserialize(file_get_contents("../Pictures/data.Head.php"));

    $head->getAddress();

    $allPictures = array($head->getAddress());
    
    while ($head->hasNext()) {
        $head = $head->getNext();
        array_push($allPictures, $head->getAddress());
    }

    echo json_encode($allPictures);

?>
