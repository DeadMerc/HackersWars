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
if(isset($_GET[select])){
  if($_GET[hash] == $hash){
    if($_GET[select] == 'hacker'){
      $db->query("UPDATE info SET profession = 'hacker' WHERE user_id = ?i",$data[0][id]);
    }elseif($_GET[select] == 'decoder'){
        $db->query("UPDATE info SET profession = 'decoder' WHERE user_id = ?i",$data[0][id]);
    }elseif($_GET[select] == 'seller'){
        $db->query("UPDATE info SET profession = 'seller' WHERE user_id = ?i",$data[0][id]);
    }
  
  
  }
}
if(isset($_GET[view])){
	if($_GET[view] == 'hacker'){
			echo '<i>Информация</i><p></p>
		<p> 
		Специализация говорит сама за себя, прирождённый взломщик.
		В будущем сможет стать экспертом по sql инъекциям или ботнету.
		
		</p>
		<i>Бонусы</i>
		<p>
		<FONT color="green" >+30%</FONT> найти уязвимость
		</p>
		<i>Слабые места</i>
		<p>
		<FONT color="red" >+50%</FONT> скорости дешифровки,<FONT color="red">+20%</FONT> потери данных
		</p>
		<p>
		<a href="profession.php?select=hacker&hash='.$hash.' " >Выбираю эту специализацию</a>
		</p>
		';
	}
	if($_GET[view] == 'decoder'){
			echo '<i>Информация</i><p></p>
		<p> 
		C этой специализацией вы сможет расшифровывать текст намного быстрее других и при этом без потерь.
		Однако есть небольшие трудности с прямым взломом.
		
		</p>
		<i>Бонусы</i>
		<p>
		<FONT color="green" >+30%</FONT> скорость дешифровки
		</p>
		<i>Слабые места</i>
		<p>
		<FONT color="green" >-25%</FONT> потери данных,<FONT color="red">-10%</FONT> шанс взлома
		</p>
		<p>
		<a href="profession.php?select=decoder&hash='.$hash.' " >Выбираю эту специализацию</a>
		</p>
		';
	}
	if($_GET[view] == 'seller'){
			echo '<i>Информация</i><p></p>
		<p> 
		Этот человек всегда будет при деньгах благодаря своей харизме и умениям продавать.
		
		</p>
		<i>Бонусы</i>
		<p>
		<FONT color="green" >+15%</FONT> денег при продаже,<FONT color="green" >-15%</FONT> стоимость покупок
		</p>
		<i>Слабые места</i>
		<p>
		<FONT color="red">+50%</FONT> потери данных
		</p>
		<p>
		<a href="profession.php?select=seller&hash='.$hash.' " >Выбираю эту специализацию</a>
		</p>
		';
	}
}

if(!$user_info['profession'] and !isset($_GET['view'])){
    echo 'Выберите специализацию: 
    <table class="textLeft" border="1"><tr><th><p><a href="profession.php?view=hacker">Хакер</a>[<FONT color="green" >+30%</FONT> найти уязвимость,<FONT color="red" >+50%</FONT> скорости дешифровки,<FONT color="red">+20%</FONT> потери данных]</p></th></tr>
    <tr><th><p class="textLeft"><a href="profession.php?view=decoder">Декодер</a>[<FONT color="green" >+30%</FONT> скорость дешифровки,<FONT color="green" >-25%</FONT> потери данных,<FONT color="red">-15%</FONT> шанс взлома]</p></th></tr>
    <tr><th><p><a href="profession.php?view=seller">Продавец</a>[<FONT color="green" >+15%</FONT> денег при продаже,<FONT color="green" >-15%</FONT> стоимость покупок,<FONT color="red">+50%</FONT> потери данных]</p></th></tr>
    <tr><th><p class="textLeft"><a href="profession.php?view=dontknow">???</a>[<FONT color="green" >+30%</FONT> ???,<FONT color="green" >-25%</FONT> ???,<FONT color="red">-15%</FONT> ???]</p></th></tr></table>';
}else{
    if(!$_GET['view']){
        echo 'Ваша специализация:'.$user_info['profession'];
    }
    
}



include 'tml/footer.php';
?>
    