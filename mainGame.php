<?php
include 'tml/head.php';

?>
 <div class="span9">
<table  border="0" >
        <tr>     
			<td id="picContainer" ><img src="tml/images.jpg" width="100%" height="100%"> </td> 
      
         </tr>
    </table>
</div>  
<div id="gameContainer" class="span8">
<?php
if($_GET[quest] == 'continue'){
	$remainHacks = unserialize($user_info[quest_terms]);
	//print_r($remainHacks);
	echo 'Осталось:'.($remainHacks[to]-$remainHacks[from]).' Продолжить взлом? <a href="quest_do.php?continue=true&id='.$user_info[quest_do].' ">Да</a>';
}
if($_GET[time] == 'out'){
    echo 'Время вышло, цель закрыла соединение';
    
}
if($_GET[target] == 'notfound'){
    echo 'Активный взлом не найден.';
}
if(isset($_GET[safe])){
    echo 'Взлом нельзя было продолжить т.к. ваша скрытность превысила отметку 50%<br>'
    . 'Если вы хотите превышать эту отметку вы должны убрать режим безопасность в настройках<br>';
}
if(isset($_GET[doit])){
    echo 'Поздравляю, взлом выполнен.<br>';
    
}



?>
<p>
    <a href="person.php">Персонаж</a>
</p>
<p>
    <a href="pc.php">Компьютер</a>
</p>
<p>
    <a href="hack.php">Взлом</a>
</p>
<p>
    <a href="safe.php">Безопасность</a>
</p>
<p>
    <a href="clan.php">Клан</a>
</p>
<p>
    <a href="social.php">Общение(!)</a>
</p>
<p>
    <a href="exit.php">Выход</a>
</p>
</div>

<?php
include 'tml/footer.php';