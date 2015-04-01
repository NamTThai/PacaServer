<?php

require_once 'class.Picture.php';

    $allPictures = scandir('../Pictures');
    $head = new Picture($allPictures[10]);
    $current = $head;
    for ($i = 0; $i < 10; $i++) {
        $picture = $allPictures[$i];
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

    echo "works";

?>
