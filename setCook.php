<?php
//print_r($_GET);exit;
include 'tml/head.php';

if (isset($_GET[id]) and isset($_GET[hash]) and isset($_GET[go]) and isset($_GET[secret])) {
    $secret = md5($hash . 'naVodeHasSecret');
    if ($_GET[secret] = $secret) {
        $id = $_GET[id];
        $hash = $_GET[hash];
        $isSet = setCook($id, $hash);
        $db = new SafeMySQL();
        $db->query("UPDATE users SET hash=?s WHERE id=?i",$hash,$id);
        header("Location: ".$_GET[go]." ");
    }else{
        header("Location: index.php");
    }
}else{
     header("Location: index.php?fail=cook");
}
