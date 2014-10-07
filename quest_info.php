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
if(isset($_GET[id])){
    $id = (int) $_GET[id];
    $quest = $db->getAll("SELECT * FROM quests WHERE id=?i",$id);
    $terms = unserialize($quest[0][terms]);
    $reward = unserialize($quest[0][reward]);
    echo "<i>Название квеста:</i>".$quest[0][name]."<br>";
    echo "<i>Полное описание:</i>".$quest[0][full_name]."<br>";
    //print_r($reward)
    echo "<i>Награда:</i>". ($reward[money]?"Деньги:".$reward[money]."&nbsp":"").
            ($reward[exp]?"Опыт:".$reward[exp]."&nbsp":"")."<br>".
            ($reward[item]?"Предметы:".($reward[item][type]=='needDecode'?"Закодированные,".($reward[item][rare]?"Качество:".$reward[item][rare].",Кол-во:".$reward[item][nums]:"")."&nbsp":"Раскодированные,&nbsp")."&nbsp":"").
            "<br>";
    //print_r($terms)
    echo "<i>Условия победы:</i>Взломать $terms[type],Сложностью $terms[complexity], $terms[nums] раз(а)<br>";
    echo "<a href=\"quest_do.php?id=".$quest[0][id]."\">Выполнить</a>&nbsp;</div>";
    
    
}
include 'tml/footer.php';
?>
