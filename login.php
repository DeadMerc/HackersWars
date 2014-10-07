<?php
include_once 'functions.php';
if (isset($_POST[request]) and $_POST[request] == 'auth') {
    $name = $_POST[login];
    $pass = md5($_POST[password] . 'naVode');
    include_once 'mysql.php';
    $db = new SafeMySQL();
    //   $data = array('name'=>$name,'pass'=>$pass);
    //   $sql = "INSERT INTO users SET ?u";
    //   $request = $db->query($sql,$data);
    $passDB = $db->getOne("SELECT pass FROM users WHERE name=?s", $name);
    $id = $db->getOne("SELECT id FROM users WHERE name=?s", $name);

    if ($name) {
        $pass = preg_replace('/a4/', '', $pass);
        echo $pass.'<br>';
        echo $passDB.'<br>';
        if ($pass == $passDB) {
            $hash = md5($_POST[password] . 'naVodeHash');
            $secret = md5($hash.'naVodeHasSecret');
            header("Location: setCook.php?id=" . $id . "&hash=" . $hash . "&go=mainGame.php&secret=".$secret." ");
        } else {
            echo 'Ошибка пароля или логина';
        }
    }
}
?>

<h3>Вход для разработчиков</h3>
<form method="POST" >
    <input type="hidden" name="request" value="auth">
    Логин:<br>
    <input type="text" name="login"><br>
    Пароль:<br>
    <input type="password" name="password"><br>
    <input type="submit" value="Войти">
</form>

