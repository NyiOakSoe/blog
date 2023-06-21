<?php
    $option=[
        PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING,
        //PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_OBJ,
    ];
    $pdo=new PDO('mysql:dbhost=localhost;dbname=blog','root','',$option);
?>
