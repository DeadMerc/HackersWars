<?php

include 'tml/head.php';

if (isset($_GET[yes])) {
     if (!$Party_id) {
        $party_data = $db->getRow("SELECT * FROM partys WHERE id = ?i ", $_GET[yes]);
        //print_r($party_data);
        $party_users = $party_data[users_name];
        $party_users = unserialize($party_users);
        //print_r($party_users); exit;
        $party_users[] = $data[0][name];
        $dataSql = array('users_name' => serialize($party_users));
        $db->query("UPDATE partys SET ?u WHERE id = ?i ", $dataSql, $_GET[yes]);
        $db->query("UPDATE users SET invite_party = '' WHERE id = ?i ", $data[0][id]);
        header("Location: mainGame.php");
    }else{
        $db->query("UPDATE users SET invite_party = '' WHERE id = ?i ", $data[0][id]);
        echo 'Вы уже в пати';
        
    }
}
if(isset($_GET['exit'])){
    $Party_names_exit = $db->getRow("SELECT * FROM partys WHERE users_name LIKE ?s ", '%"' . $data[0][name] . '"%');
    $partyId = $Party_names_exit[id];
    $Party_names_exit = unserialize($Party_names_exit[users_name]);
    $Party_names_exit = array_flip($Party_names_exit); //Меняем местами ключи и значения
    unset($Party_names_exit[$data[0][name]]);
    $Party_names_exit = array_flip($Party_names_exit);
    $dataSql = array('users_name' => serialize($Party_names_exit));
    $db->query("UPDATE partys SET ?u WHERE id = ?i ", $dataSql, $partyId);
}



include 'tml/footer.php';
?>
