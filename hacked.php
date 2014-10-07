<?php
include 'tml/head.php';
include_once 'functions_hack.php';
//привязка к экшену
if (!$data[0][action]) {
    $db->query("UPDATE users SET action = '1' WHERE id = ?i ", $data[0][id]);
}
//получаем данные
$user_id = $data[0][id];
$dataTarget = $db->getAll("SELECT * FROM actions WHERE user_id = ?i", $id);
if (!$dataTarget) {
    if ($Party_id) {
        $dataTarget = $db->getAll("SELECT * FROM actions WHERE party = ?i", $Party_id);
    }
    if (empty($dataTarget)) {
        $db->query("UPDATE users SET action = '0' WHERE id = ?i ", $data[0][id]);
        header("Location: mainGame.php?target=notfound");
    }
}
global $Target_id;
$Target_id = $dataTarget[0][id];
$Target_type = $dataTarget[0][type];
$Target_time_start = $dataTarget[0][action_start];
$Target_ratio = $dataTarget[0][ratio];
$Target_hp_now = $dataTarget[0][hp_now];
$Target_hp_max = $dataTarget[0][hp_max];
$Target_reward = unserialize($dataTarget[0][reward]);
$Target_hp_percent = ($Target_hp_now / $Target_hp_max) * 100;
//Заморозка скилов
$Freezes = $db->getRow("SELECT * FROM basic_reload WHERE user_id = ?i ", $data[0][id]);
if (!$Freezes) {
    $db->query("INSERT INTO basic_reload SET user_id = ?i ", $data[0][id]);
    $Freezes = $db->getRow("SELECT * FROM basic_reload WHERE user_id = ?i ", $data[0][id]);
}

// ===============================================================================================
//расчёт времени.
$dateStart = new DateTime("$Target_time_start");
//$dateNow =date("Y-m-d H:i:s");
$dateNow = new DateTime("now");
$intervalStop = date_diff($dateStart, $dateNow);
$minitsRemain = $intervalStop->format('%I');
$secondsRemain = $intervalStop->format('%S');

//var_dump($minitsRemain . ':' . $secondsRemain);

if ($minitsRemain >= 10) {
    // Возврат канала
    if ($Target_reward[capacity]) {
        $data[0][capacity_now] = $data[0][capacity_now] - $Target_reward[capacity];
        $db->query("UPDATE users SET capacity_now = ?i WHERE id = ?i", $data[0][capacity_now], $data[0][id]);
    }
    $db->query("UPDATE `users` SET `action` = '0' WHERE `id` = ?i ", $data[0][id]);
    $sqlDelete = $db->query("DELETE FROM `actions` WHERE `user_id` = ?i", $data[0][id]);

    header("Location: mainGame.php?time=out");
}
echo "Осталось времени " . (9 - $minitsRemain) . ":" . (60 - $secondsRemain) . "<br> ";


// ===============================================================================================
//  скрытность
if ($data[0][mystery] > 50 and $data[0][safe_mode] = '1') {
    $db->query("UPDATE users SET action ='0' WHERE id = ?i ", $data[0][id]);
    $db->query("DELETE FROM actions WHERE user_id = ?i", $data[0][id]);
    if ($Target_reward[capacity]) {
        $data[0][capacity_now] = $data[0][capacity_now] - $Target_reward[capacity];
        $db->query("UPDATE users SET capacity_now = ?i WHERE id = ?i", $data[0][capacity_now], $data[0][id]);
    } else {
        //$db->query("UPDATE users SET capacity_now = '-1' WHERE id = ?i", $data[0][id]);
    }
    header("Location: mainGame.php?safe=true");
}
// обрыв соединения
if ($_GET['do'] == 'exit') {
    $db->query("DELETE FROM actions WHERE user_id = ?i", $data[0][id]);
    if ($Target_reward[capacity]) {
        $data[0][capacity_now] = $data[0][capacity_now] - $Target_reward[capacity];
        $db->query("UPDATE users SET capacity_now = ?i WHERE id = ?i", $data[0][capacity_now], $data[0][id]);
    }
    header("Location: mainGame.php");
}
//атака
//разведка
if ($_GET['step'] == '1' and $_GET['type'] == 'web') {
    //print_r($_SERVER);
    if ($_GET['confirm'] == 'true') {
        $dateFreeze = new DateTime("now");
        //print_r($dateFreeze->format('Y-m-d H:i:s'));
        $dateFreezeRemainPrepare = $dateFreeze->add(new DateInterval('P0Y0M0DT0H10M0S'));
        //print_r($dateFreezeRemainPrepare->format('Y-m-d H:i:s'));
        $dateFreeze = $dateFreezeRemainPrepare->format('Y-m-d H:i:s');
        $ratioNew = $Target_ratio + rand(10, 30);
        //print_r($ratioNew);
        //var_dump(':'.  rand(1,10)/100);
        $db->query("UPDATE actions SET ratio = ?i WHERE id = ?i ", $ratioNew, $Target_id);
        //Фризим
        $db->query("UPDATE basic_reload SET web = ?s WHERE user_id = ?i", $dateFreeze, $data[0][id]);
        header("Location: hacked.php?welldone");
        exit;
    } else {
        $htmlEcho = '<FORM method="GET" action="' . $_SERVER[REQUEST_URI] . '"><br>'
                . '<input type="hidden" name="hash" value="' . $md5Name . '">'
                . '<input type="hidden" name="step" value="' . $_GET['step'] . '">'
                . '<input type="hidden" name="type" value="' . $_GET['type'] . '">'
                . '<input type="hidden" name="confirm" value="true">'
                . '<input type="submit" value="Начать разведку"></FORM>';
        $htmlEcho .= '<br>';
    }
}
//sql injection
if (($_GET['step'] == '1' and $_GET['type'] == 'sql') or ($_GET['step'] == '2') and $_GET['type'] == 'sql') {
    if ($_GET['modif']) {
        $chanceDo = rand(1, 100);
        // шанс 
        $Freeze[type] = 'sql';
        $Freeze[period] = '10';
        if ($chanceDo <= '90') {
            //echo 'Hack:' . $damage;
            //print_r('HP_NOW:' . $Target_hp_now . ':HP_MAX:' . $Target_hp_max);
            if ($_GET[hash] == $hash) {
                $increaseDamageMin = 5;
                $increaseDamageMax = 15;
                $damageResult = damage($seconds, $Target_hp_now, $Target_ratio, $increaseDamageMin, $increaseDamageMax, $Freeze);
                header("Location: hacked.php");
                //echo 'TRUE';
            } else {
                //echo 'FATAL';
            }
        } else {
            $htmlEcho = 'Уязвимость не найдена';
            FreezeSkil($Freeze);
        }
    } else {
        $htmlEcho = "<p><a href=\"hacked.php?do=attack&step=2&type=sql&modif=sql&hash=$hash\">Внедрение операторов Sql Injection[30%]</a></p>"
                . "<p><a href=\"hacked.php?do=attack&step=2&type=sql&modif=blindsql&hash=$hash\">Слепое внедрение операторов Blind Sql Injection[30%] </a></p>"
                . "<p><a href=\"hacked.php?do=attack&step=2&type=sql&modif=doubleblindsql&hash=$hash\">Слепое внедрение операторов Double Blind Sql Injection[30%]</a> </p>";
    }
}
//ddos
if($_GET['step'] == '1' and $_GET[type] == 'ddos'){
    $infoBotnet = issetRowBotnet();
    if(isset($_GET['confirm']) and $hash == $_GET['hash']){
        $Freeze['type'] = 'ddos';
        $Freeze['period'] = 30;
        $increaseDamageMin = rand($infoBotnet['nums']*0.80,$infoBotnet['nums']);
        $damageResult = damage($seconds, $Target_hp_now, $Target_ratio, $increaseDamageMin, $increaseDamageMax,$Freeze);
    }else{
        //$infoBotnet = issetRowBotnet();
        $htmlEcho = 'Ваш ботнет насчитывает:'. ($infoBotnet['nums']  ?  $infoBotnet['nums'].' ботов'  :  '0 ботов')
                . '<FORM method="GET" action="' . $_SERVER[REQUEST_URI] . '"><br>'
                . '<input type="hidden" name="hash" value="' . $hash . '">'
                . '<input type="hidden" name="step" value="' . $_GET['step'] . '">'
                . '<input type="hidden" name="type" value="' . $_GET['type'] . '">'
                . '<input type="hidden" name="confirm" value="true">'
                . '<input type="submit" '.($infoBotnet['nums'] == '0'?'disabled':'').' value="Начать ddos"></FORM>';
        $htmlEcho .= '<br>';
    }
}
//Снифинг пакетов
//http://maxim-milchakov.myjino.ru/hacked.php?do=attack&step=1&type=sniffer
if($_GET['step'] == '1' and $_GET['type'] == 'sniffer'){
    if(isset($_GET['confirm'])){
        
    }else{
        $htmlEcho = ''
                . '<FORM method="GET" action="' . $_SERVER[REQUEST_URI] . '"><br>'
                . '<input type="hidden" name="hash" value="' . $hash . '">'
                . '<input type="hidden" name="step" value="' . $_GET['step'] . '">'
                . '<input type="hidden" name="type" value="' . $_GET['type'] . '">'
                . '<input type="hidden" name="confirm" value="true">'
                . '<input type="submit" value="Начать перехват пакетов"></FORM>';
        $htmlEcho .= '<br>';
    }
}


//Авто-взлом
if (isset($_GET['do']) and $_GET['do'] = 'attack' and !isset($_GET['step'])) {
    /*  if ($seconds <= '10') {
      $seconds = $seconds / 10;
      $damage = $seconds * (rand($data[0][stats_attack] - 100, $data[0][stats_attack] / 5)) * ($Target_ratio / 100);
      $Target_hp_now = $Target_hp_now + (abs($damage));
      } else {
      $damage = rand($data[0][stats_attack] - 100, $data[0][stats_attack] / 5) * ($Target_ratio / 100);
      $Target_hp_now = $Target_hp_now + (abs($damage));
      }

     */
    if ($_GET[hash] === $hash) {
        $damageInfo = damage($seconds, $Target_hp_now, $Target_ratio);
        echo 'Hack:' . $damageInfo[damage];
        //print_r('HP_NOW:' .  $damageInfo[target_hp_now] . ':HP_MAX:' . $Target_hp_max);
    } else {
        //echo '<p>Слишком долго</p>';
    }
}



// ===============================================================================================
// всякие условие на награду и победу
// рефакторинг

if ($Target_hp_now > $Target_hp_max) {
	/*
    if ($Target_reward[quest]) {
        $users_preformed = $db->getAll("SELECT users_performed FROM quests WHERE id = ?i ", $Target_reward[quest]);
        $users_preformed[0][users_performed] .= $data[0][name];
        print_r($users_preformed);
        $db->query("UPDATE quests SET users_performed = ?s WHERE id = ?i", $users_preformed[0][users_performed], $Target_reward[quest]);
    }
    if ($Target_reward[money]) {
        $Now_Money = $data[0][money] + $Target_reward[money];
        $db->query("UPDATE users SET money = ?i where id = ?i", $Now_Money, $data[0][id]);
    }
    if ($Target_reward[exp]) {
        $Now_Exp = $db->getAll("SELECT exp_now FROM info WHERE user_id = ?i", $data[0][id]);
        $Now_Exp = $Now_Exp[0][exp_now] + $Target_reward[exp];
        $db->query("UPDATE info SET exp_now = ?i WHERE user_id = ?i", $Now_Exp, $data[0][id]);
    }
    if ($Target_reward[capacity]) {
        $data[0][capacity_now] = $data[0][capacity_now] - $Target_reward[capacity];
        $db->query("UPDATE users SET capacity_now = ?i WHERE id = ?i", $data[0][capacity_now], $data[0][id]);
    } else {
        $db->query("UPDATE users SET capacity_now = '-1' WHERE id = ?i", $data[0][id]);
    }
	*/
    $db->query("UPDATE users SET action ='0' WHERE id = ?i ", $data[0][id]);
    $db->query("DELETE FROM actions WHERE user_id = ?i", $data[0][id]);
    $db->query("UPDATE info SET `hacks` = `hacks` + 1 WHERE user_id = ?i", $data[0][id]);
	
	if($user_info[quest_type] == $Target_type){
		$footerTermsInfo = unserialize($user_info[quest_terms]);
		if($footerTermsInfo[to] > $footerTermsInfo[from]){
			$footerTermsInfo[from] ++;
			$footerTermsInfo = serialize($footerTermsInfo);
			$db->query("UPDATE info SET quest_terms = ?s WHERE user_id = ?i",$footerTermsInfo,$data[0][id]);
		}
	}
	if($user_info[quest_do]){
		header("Location: mainGame.php?quest=continue");
	}else{
		header("Location: mainGame.php?doit=true");
	}

    
}
?>
<p>
    Цель:<?= $Target_type ?>
</p>
<p>
    Процент Взлома:<br>
    <progress  value="<?= $Target_hp_now ?>" max="<?= $Target_hp_max ?>"></progress><?= round($Target_hp_percent, 3) ?>%
    <br>
    Множитель:<?= $Target_ratio / 100 ?>(<?= $Target_ratio ?>%)
    <br>
    

</p>
<p>
    <a href="hacked.php">Главная взлома</a>&nbsp;<a href="#" onclick="location.reload();">Обновить</a>
</p>
<?php
//Вывод инфы выше
if ($htmlEcho) {
    echo $htmlEcho;
}
?>
<p>
    <?php
    if (!$_GET[step]) {

        echo "<p><i><a href=\"hacked.php?do=attack&hash=$hash\">Авто-взлом</a></i></p>";
        if ($Freezes[web]) {
            echo "<p>Сетевая разведка[" . timeDiff($Freezes[web], $data[0][id], 'web') . "]</p>";
        } else {
            echo "<p><a href=\"hacked.php?do=attack&step=1&type=web\">Сетевая разведка</a></p>";
        }
        if ($Freezes[sql]) {
            echo "<p>Sql Инъекция[" . timeDiff($Freezes[sql], $data[0][id], 'sql') . "]</p>";
        } else {
            echo "<p><a href=\"hacked.php?do=attack&step=1&type=sql\">Sql Инъекция</a></p>";
        }


        echo "<p><a href=\"hacked.php?do=attack&step=1&type=ddos\">DDenial of Service</a></p>";
        echo "<p><a href=\"hacked.php?do=attack&step=1&type=sniffer\">Сниффер пакетов[dont work]</a></p>";
        //echo "<p><a href=\"#\">Сниффер пакетов[dont work]</a></p>";
        echo "<p><a href=\"hacked.php?do=attack&step=1&type=ip\">IP-спуфинг[dont work]</a></p>";
        echo "<p><a href=\"hacked.php?do=attack&step=1&type=brute\">Brute force attack[dont work]</a></p>";
        echo "<p><a href=\"hacked.php?do=attack&step=1&type=shell\">Shell[dont work]</a></p>";
        echo "<hr><p><a href=\"hacked.php?do=exit\">Оборвать соединение</a></p>";
    }
    ?>  

</p>




<?php
include 'tml/footer.php';
?>
