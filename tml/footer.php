<?php
include_once 'check.php';
?>
</div>
<div id="footerLinks">
    <?php
    if ($Party_names) {
        echo '<i>Ваша патька:</i>';
        //
        
        //print_r($Party_names);
        $names = unserialize($Party_names);
        if(is_array($names)){
            
            $nums = count($names);
            $i=0;
            foreach ($names as $name) {
                $i++;
                if($i == $nums){
                    echo $name;
                }else{
                    echo $name.',';
                }
                
            }
        }else{
            echo $Party_names;
        }
        echo '<a href="party.php?exit=1">[Выход]</a> ';
    }
    if($user_info[quest_do]){
        $footerTerms = unserialize($user_info[quest_terms]); 
        echo '<hr>';
        if($user_info[quest_type] == 'server' or $user_info[quest_type] == 'game_server'){
            echo "<a href=\"quest_do.php?continue=true&id=".$user_info[quest_do]." \"> Взломать $user_info[quest_type]</a> [$footerTerms[from]/$footerTerms[to]]";
        }
        if($footerTerms[from] == $footerTerms[to] and !empty($footerTerms[to])){
            echo "<br><a href=\"quest_do.php?complete=true&id=$user_info[quest_do]&hash=$hash\">Получит награду</a>";
        }
            
        
        echo '<hr>';
    }
     //$time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
    //echo '<p>Страница загружена за:'.round($time, 5).' с</p>';
    
    ?>
    <br>
    <a href="mainGame.php">Главная</a>&nbsp;<a href="person.php">Персонаж</a>&nbsp;
</div>


</body>
