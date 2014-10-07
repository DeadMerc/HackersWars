<?php
if (isset($_POST[request]) and $_POST[request] == 'reg') {
    $name = $_POST[login];
    $pass = md5($_POST[password] . 'naVode');
    if (!empty($_POST[login]) and !empty($_POST[password])) {
        include_once 'mysql.php';
        $db = new SafeMySQL();
        $data = array('name' => $name, 'pass' => $pass);
        $sql = "INSERT INTO users SET ?u";
        $issetName = $db->getOne("SELECT name FROM users WHERE name = ?s", $name);
        if (!$issetName) {
            $request = $db->query($sql, $data);
            if ($request) {
                echo 'Успешная регистрация';
                $hash = md5($pass . 'naVodeHash');
                $secret = md5($hash . 'naVodeHasSecret');
                //    header("Location: setCook.php?id=" . $id . "&hash=" . $hash . "&go=mainGame.php&secret=".$secret." ");
                header("Location: index.php?good=true");
            }
        } else {
            echo 'Такой логин уже существует';
        }
    }else{
        echo 'Введите данные';
    }
}
?>

<h3>Запись на альфа-тест</h3>
<form method="POST" >
    <input type="hidden" name="request" value="reg">
    Логин:<br>
    <input type="text"  name="login"><br>
    Пароль:<br>
    <input type="password" name="password"><br>
    Повторите пароль:<br>
    <input type="password" name="password2"><br>
    <input type="submit" value="Регистрация">
</form>

