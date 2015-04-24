<?php
    
require_once "utils/class.PacaDb.php";

    $db = new PacaDb();

    $db->insert_picture("abc", "def", 1243412, 2432234);

    $db->close();

?>
