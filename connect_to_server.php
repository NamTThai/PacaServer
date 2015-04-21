<?php

require_once "utils/class.PacaDb.php";
echo "1";
    $db = new PacaDb();

    echo "2\n";
    $db = $db->getDb();
    
    echo "Connection succeed!";

    $db->close();

?>
