<?php
include_once 'mysql.php';
$db = new SafeMySQL();
$db->query("UPDATE users SET `mystery` = `mystery` - 5");
?>