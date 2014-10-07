<?php

include 'tml/head.php';
if ($_GET[delete] == 1 and isset($_GET[id])) {
    $itemId = (int) $_GET['id'];
    $issetItem =  $db->query("DELETE FROM inventorys WHERE id = ?i ",$itemId);
    
    $htmlEcho = ($issetItem ? 'Удалено':'Not Found');
    
} elseif ($_GET['decode'] == 1 and isset($_GET[id])) {
    //86400
    if ($_GET['nums']) {
        $itemId = (int) $_GET['id'];
        $itemInfo = $db->getRow("SELECT * FROM inventorys WHERE user_id = ?i and id = ?i", $data[0][id], $itemId);
        if ($itemInfo) {
            //print_r($itemInfo);
            if($itemInfo['num'] < $_GET['nums']){
                $htmlEcho =  'Кол-во ваших данных меньше,чем вы хотите раскодировать';
            }else{
                $timeRemain = timeDecode($itemInfo[num], $itemInfo[rare]);
                $htmlEcho = 'Раскодирование началось и займёт '.$timeRemain.' минут'; 
                $params[type] = 'decode';
                $params[period] = rareToSecond($itemInfo[rare]) * $_GET['nums'];
                $params[nums] =(int) $_GET['nums'];
                $params[id] = (int) $itemInfo[id];
                $params[rare] = $itemInfo[rare];
                $params[inventory_num] = $itemInfo[num];
                action_long($params);
                
                
            }
                       
        }
    } else {
        $htmlEcho = 'Раскодирование информации занимает определённое время:(в секундах за единицу данных).<br>'
                . 'По качеству<br>'
                . 'Common:0.01 дня:(864 с)<br>'
                . 'UnCommon:0.09 дня:(7776 с)<br>'
                . 'Rare:0.30 дня:(25920 с)<br>'
                . 'Unique:0.60 дня:(51840 с)<br>'
                . 'Arcana:1 день:(86400 с)<br>'
                . '<form method="GET">Введите кол-во<br>'
                . '<input name="decode" type="hidden" value="' . $_GET['decode'] . '"><input name="id" id="id" type="hidden" value="' . $_GET['id'] . '">'
                . '<input name="nums" id="userNums" onchange="howmuch()" type="text">Примерное время<input type="text" value="???" disabled id="timeRemain"> часа<br>'
                . '<input type="submit" value="Начать расшифровку"> </form>';
    }
} else {
    $inventory = $db->getAll("SELECT * FROM inventorys WHERE user_id = ?i", $data[0][id]);
}
?>
<table border="1">
    <tr>
        <td id="picContainer" ><img src="tml/images.jpg" width="100%" height="100%"> </td>
    </tr>
</table>
<div id="gameContainer">
<?php

if ($inventory) {
    foreach ($inventory as $value) {
        echo "<table class=\"inventoryImg\" bgcolor=\"" . getBorderColor($value['rare']) . "\" styles=\"border-color:" . getBorderColor($value['rare']) . ";float:left;\" border=\"1\" width=\"32px\" height=\"32px\" > </table> ";
        echo "<FONT color=\"" . getBorderColor($value['rare']) . "\"> $value[type]</FONT>[$value[num]]";
        //echo "<p>pic</p>";
        echo "<p>Действия:<a href=\"inventory.php?delete=1&id=$value[id]\">Удалить</a>";
        if ($value['type'] == 'needDecode') {
            echo "<a href=\"inventory.php?decode=1&id=$value[id]\">Раскодировать</a>";
        }
        echo '</p><br><br>';
    }
} else {
    if (!$htmlEcho) {
        echo 'У вас пусто';
    } else {
        echo $htmlEcho;
    }
}
echo '</div>';
include 'tml/footer.php';
?>