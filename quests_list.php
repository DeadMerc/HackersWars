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
if(isset($_GET[doit])){
    echo 'Поздравляю, взлом выполнен награда уже у вас.<br>';
    
}

$lvl = $db->getOne("SELECT exp_lvl FROM info WHERE user_id=?i",$data[0][id]);
//Условие  на повторение
//$quests = $db->getAll("SELECT * FROM `quests` WHERE  `min_exp_lvl`<='?i' and `users_performed` NOT LIKE ?s ", $lvl,'%'.$data[0][name].'%');
$quests = $db->getAll("SELECT * FROM `quests` WHERE  `min_exp_lvl`<='?i' and `users_performed`  LIKE ?s  ORDER BY min_exp_lvl ASC ", $lvl,'%%');

if (!$quests) {
    echo 'Заданий для вас не найдены, посмотрите позже';
} else {
    foreach ($quests as $quest) {
       // print_r($quest);
       // $reward = unserialize($quest[reward]);
       // $terms = unserialize($quest[terms]);
        echo "<a href=\"quest_info.php?id=".$quest[id]."\">$quest[name][$quest[min_exp_lvl]]</a><br>";
    }
}
?>



</div>
<?php

include 'tml/footer.php';
?>