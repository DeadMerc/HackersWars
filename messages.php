<?php
include 'tml/head.php';

$db->query("UPDATE users SET message_new='0' WHERE id = ?i",$data[0][id]);
$Messages = $db->getAll("SELECT * FROM messages WHERE view ='0' and user_id = ?i ORDER by id DESC",$data[0][id]);
if(!$Messages){
    echo '<h3>Новых сообщений нету</h3>';
}else{
     echo '<h3>Новые сообщение</h3><br>';
    
    foreach ($Messages as $value) {
        echo 'Сообщение:'.$value[message].'<br>';
        echo 'От:'.$value[from].'<br><br>';
    }
}
$MessagesOld = $db->getAll("SELECT * FROM messages WHERE view ='1' and user_id = ?i ORDER by id DESC",$data[0][id]);
if($MessagesOld){
    echo '<h3>Старые сообщение</h3><br>';
    foreach ($MessagesOld as $value) {
        echo 'Сообщение:'.$value[message].'<br>';
         echo 'От:'.$value[from].'<br><br>';
    }
}
$db->query("UPDATE messages SET view='1' WHERE user_id = ?i",$data[0][id]);
?>



<?php
include 'tml/footer.php';
?>