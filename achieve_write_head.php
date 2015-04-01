<?php

require_once 'class.Picture.php';

    $allPictures = scandir('../Pictures');
    $head = new Picture($allPictures[10]);
    $current = $head;
    foreach($allPictures as $picture) {
        $pathinfo = pathinfo($picture);
        if ($pathinfo['extension'] == 'jpg') {
            $next = new Picture($picture);
            $current->setNext($next);
            $current = $next;
        }
    }

    $objData = serialize($head);
    $file = fopen("../Pictures/data.Head.php", "w");
    fwrite($file, $objData);
    fclose($file);

?>
