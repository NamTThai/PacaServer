<?php

require_once 'utils/class.Picture.php';
require_once 'utils/class.PacaDb.php';
    
    $db = new PacaDb();
    
    $addresses = $db->retrievePictures($_GET['lat'], $_GET['lng']);

    echo json_encode($addresses);
    
    $db->close();

?>
