<?php
include 'tml/head.php';
echo 'Отправка сообщений закрыта';
die;
if (isset($_POST[to])) {
    $to_id = $db->getRow("SELECT id FROM users WHERE name = ?s", $_POST[to]);
    //print_r($to_id);
    if ($to_id) {
        $to_id =  $to_id[id];
        $numMessages = $db->getAll("SELECT message_new FROM users WHERE id = ?i", $to_id);
        $numMessages = $numMessages[0][message_new] + 1;
        $db->query("UPDATE users SET message_new = ?i WHERE id = ?i" , $numMessages,$to_id);
        $db->query("INSERT INTO messages SET `message`=?s, `user_id`=?i,`from` = ?s ", $_POST[message], $to_id, $data[0][name]);
        echo 'Сообщение отправлено<br>';
    } else {
        echo 'Персонаж не найдено<br>';
    }
}
?>
<form method="POST" action="messages_sent.php">


    Введите имя:<br>
    <input type="text" maxlength="300" name="to"><br>
    Введите сообщение:<br>
    <input type="text" maxlength="300" name="message"><br>
    <input type="submit" value="Отправить">
</form>







<?php
include 'tml/footer.php';
?>
