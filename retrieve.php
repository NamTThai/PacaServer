<?php

require_once 'utils/class.Picture.php';
require_once 'utils/class.PacaDb.php';
    
    $db = new PacaDb();
    
    $addresses = $db->retrievePictures(100, 200);

    $allPictures = array();
    
    for ($i = 0; $i < count($addresses); $i++) {
        array_push($allPictures, $addresses[$i]['address']);
    }

    echo json_encode($allPictures);
    
    $db->close();

?>
