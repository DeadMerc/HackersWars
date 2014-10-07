<?php
include 'tml/head.php';

//global $data;
//print_r($data);
$info = $db->getAll("SELECT * FROM info WHERE user_id=?i",$data[0][id]);
if(!$info){
    $db->query("INSERT INTO info SET user_id=?i",$data[0][id]);
    header("Location:person.php");
}else{
    if($info[0][exp_now]>$info[0][exp_max]){
        $info[0][exp_lvl]=$info[0][exp_lvl]+1;
        $info[0][temp_now]=abs($info[0][exp_max]-$info[0][exp_now]);
        $newExp_max = changeLvl($info[0][exp_lvl]);
     //   print_r($newExp_max.'<-MaxEXP:'.$info[0][temp_now].'<-TempNOW:'.$info[0][exp_lvl].'<-lvl');
        $db->query("UPDATE info SET exp_lvl=?i,exp_now=?i,exp_max=?i ",$info[0][exp_lvl],$info[0][temp_now],$newExp_max);
        header("Location:person.php");
    }
}
if(isset($_GET[invite_person])){
    $invite = $db->query("UPDATE users SET invite_party = ?i WHERE name = ?s ",$Party_id,$_GET[invite_person]);
    if($invite){
        echo 'Успех';
    }
}
?>
<table border="1">
        <tr>
            <td id="picContainer" ><img src="tml/images.jpg" width="100%" height="100%"> </td>
        </tr>
    </table>
<div id="gameContainer">
    
    
    <p>
        <a href="inventory.php">Инвентарь</a>
    </p>
    <p>
        <a href="skills.php">Навыки</a>
    </p>
    <p>
        <a href="profession.php">Профессия</a>
    </p>
    <p>
 <?php
 if(!$Party_names){
     echo '<a href="person.php?createparty=1">Создать пати</a>';
 }else{
     echo 'В группу<br><form method="GET" action="">
        <input type="text" name="invite_person">
        <input type="submit" value="Пригласить">
    </form>';
 }
 
 ?>
   
      
    
    </p>
    <p>
    <h3>Характеристики</h3>
    </p>
    <p>
        Мастерство:<?=$data[0][stats_attack]?>
    </p>
    <p>
        Защита(фаервол):<?=$data[0][stats_defence]?>
    </p>
    <p>
        Сумма статов:<?=$data[0][stats_sum]?>
    </p>
    <p>
    <h3>Информация</h3>
    </p>
    <p>
        Ваши деньги:<?=$data[0][money]?>
    </p>
    <p>
        Взломов:<?=$info[0][hacks]?>
    </p>
    <p>
        Атак:<?=$info[0][attacks]?>
    </p>
    <p>
        Защит:<?=$info[0][defences]?>
    </p>
    <p>
        Пойман:<?=$info[0][caught]?>
    </p>
    <hr>
    <p>
        Уровень:<?=$info[0][exp_lvl]?>(<?=$info[0][exp_now]?>/<?=$info[0][exp_max]?>exp)
    </p>
    
   
</div>

<?php
include 'tml/footer.php';
?>