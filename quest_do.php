<?php
include 'tml/head.php';
?>
<table border="1">
    <tr>
        <td id="picContainer" ><img src="tml/images.jpg" width="100%" height="100%"> </td>
    </tr>
</table>
<div id="gameContainer">
    <?php
    if (isset($_GET[quest])) {
        if ($_GET[quest] == 'continue') {
            
        }
    }

    if (isset($_GET[complete])) {
        if ($_GET[hash] = $hash) {
            if ($user_info[quest_do]) {


                echo "Получено<br>";
                $quest = $db->getRow("SELECT reward FROM quests WHERE id = ?i", $user_info[quest_do]);
                $quest = unserialize($quest[reward]);
                //print_r($quest);
                //денюшку даём
                if ($quest[money]) {
                    echo "Деньги:$quest[money]<br>";
                    $Now_Money = $data[0][money] + $quest[money];
                    $db->query("UPDATE users SET money = ?i where id = ?i", $Now_Money, $data[0][id]);
                }
                // expы
                if ($quest[exp]) {
                    echo "Опыт:$quest[exp]<br>";
                    $Now_Exp = $user_info[exp_now] + $quest[exp];
                    $db->query("UPDATE info SET exp_now = ?i WHERE user_id = ?i", $Now_Exp, $data[0][id]);
                }

                if (isset($quest[item])) {
                    echo "Предмет:" . $quest[item][type] . " [" . $quest[item][nums] . "]<br>";
                    $issetItem = $db->getRow("SELECT * FROM `inventorys` WHERE `user_id` = '?i' and `type` = ?s and `rare` = ?s ", $data[0][id], $quest[item][type], $quest[item][rare]);
                    if (!$issetItem) {


                        $prepareData = array('user_id' => $data[0][id], 'type' => $quest[item][type], 'rare' => $quest[item][rare], 'num' => $quest[item][nums]);
                        $db->query("INSERT INTO inventorys SET ?u", $prepareData);
                    } else {
                        //print_r($issetItem);
                        $issetItem[num] = $issetItem[num] + $quest[item][nums];
                        $db->query("UPDATE inventorys SET num = ?i WHERE id = ?i and `type` = ?s and `rare` = ?s", $issetItem[num], $issetItem[id], $quest[item][type], $quest[item][rare]);
                    }
                }
                $db->query("UPDATE `info` SET `quest_do` = '',`quest_terms` = '',`quest_type`='' WHERE  user_id = ?i ", $data[0][id]);
            }else{
                echo 'Использование дюпа';
            }
        }else{
            echo 'Использование дюпа';
        }
    }
    if (isset($_GET[id]) and !$_GET['complete']) {
        $id = (int) $_GET[id];
        $quest = $db->getAll("SELECT * FROM quests WHERE id=?i", $id);
        $terms = unserialize($quest[0][terms]);
        $reward = unserialize($quest[0][reward]);
        $reward[quest] = $id;
        $reward[capacity] = $terms[complexity];
        $capacity_free = $data[0][capacity_now] - $data[0][capacity_max];
        //print_r($reward); //exit;

        if ($terms[complexity] < $capacity_free) {
            echo 'Для взлома освободите канал';
            //die;
        } else {
            //$db->query("UPDATE users SET capacity_now =?i WHERE id = ?i", $terms[complexity], $data[0][id]);
        }
        // ===============================================================================================
        // для сервера

        if ($terms[type] == 'server') {
            $terms[complexity] = rand(90, 110) * $terms[complexity];
        }
        if ($terms[type] == 'game_server') {
            $terms[complexity] = rand(75, 130) * $terms[complexity];
        }

        //print_r($terms); exit;
        $action = serialize(array('type' => 'quest', 'id' => $id));
        $db->query("UPDATE users SET action=?s WHERE id=?i ", $action, $data[0][id]);
        $is = $db->getOne("SELECT * FROM actions WHERE   user_id = ?i ", $data[0][id]);

        if (!$is and !empty($terms)) {
            $reward = serialize($reward);
            $dataInsert = array('user_id' => $data[0][id], 'quest_id' => $id, 'type' => $terms[type],
                'hp_now' => '0', 'hp_max' => $terms[complexity], 'reward' => $reward);
            $db->query("INSERT INTO actions SET ?u,action_start=NOW() ", $dataInsert);
            if (!isset($_GET['continue'])) {

                $dataForInfoTerms = serialize(array('from' => 0, 'to' => $terms[nums]));
                $sql = $db->query("UPDATE `info` SET `quest_do`=?i,`quest_type`=?s,`quest_terms`=?s WHERE user_id = ?i ", $quest[0][id], $terms[type], $dataForInfoTerms, $data[0][id]);
            }
            if ($sql) {
                header("Location: hacked.php");
            } else {
                echo 'Ошибка';
            }
        } else {
            header("Location: hacked.php");
        }

        // ===============================================================================================
        // конец для сервера
    }
    ?>
</div>
<?php
include 'tml/footer.php';
?>