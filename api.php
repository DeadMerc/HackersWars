<?php

include_once 'mysql.php';
include_once 'functions.php';

if(isset($_GET['itemRare'])){
    $rare = $db->getRow("SELECT rare FROM inventorys WHERE id = ?i ",$_GET['itemRare']);
    
    $time = rareToSecond($rare[rare]);
    echo $time;       
}
