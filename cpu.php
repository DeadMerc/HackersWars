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

    if (isset($_GET['getReward']) and $md5Name == $_GET['hash']) {
        $actionId = (int) $_GET['getReward'];
        $action = $db->getRow("SELECT * FROM actions_long WHERE user_id = ?i and id = ?i ", $data[0][id], $actionId);
        if ($action) {
            $dateNow = new DateTime("now");
            $dateStop = new DateTime($action[action_stop]);
            if ($dateNow > $dateStop) {
                if ($action[type] == 'decode') {
                    $reward = unserialize($action[reward]);
                    print_r($reward);
                    //echo 'Функция временно недоступна';
                    $issetItem = $db->getRow("SELECT * FROM `inventorys` WHERE `user_id` = '?i' and `type` = ?s and `rare` = ?s ", $data[0][id], 'decode', $reward[rare]);
                    if (!$issetItem) {
                        $prepareData = array('user_id' => $data[0][id], 'type' => 'decode', 'rare' => $reward[rare], 'num' => $reward[nums]);
                        $db->query("INSERT INTO inventorys SET ?u", $prepareData);
                    } else {
                        //print_r($issetItem);
                        $issetItem[num] = $issetItem[num] + $reward[nums];
                        $db->query("UPDATE inventorys SET num = ?i WHERE id = ?i and `type` = ?s and `rare` = ?s", $issetItem[num], $issetItem[id], 'decode', $reward[rare]);
                    }
                }
            }
        }
    }


    $decode = $db->getAll("SELECT * FROM actions_long WHERE user_id = ?i and type = 'decode'", $data[0][id]);
    if ($decode) {
        echo 'Расшифрока данных<br>';
        echo '<table border="1"><tr><th>Начало</th><th>Конец</th><th>Осталось</th><th>Расшифровывается</th><th>Действия</th></tr>';
        foreach ($decode as $action) {
            $reward = unserialize($action[reward]);


            if ($dateNow > $dateStop) {
                $echoActions .= '<a href="cpu.php?getReward=' . $action[id] . '&hash=' . $md5Name . '">Получить</a> ';
            }
            echo '<tr><th>' . $action[action_start] . '</th><th>' . $action[action_stop] . '</th><th>' . timeDiffView($action[action_start], $action[action_stop]) . '</th><th>' . $reward[rare] . '(' . $reward[nums] . ')</th><th>' . $echoActions . '</th></tr>';
        }
        echo '</table>';
    }


    echo '</div>';
    include 'tml/footer.php';
    ?>