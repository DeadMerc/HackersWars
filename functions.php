<?php
include_once 'mysql.php';
global $db;
$db = new SafeMySQL();

/* function SendMessage($message,$user_id,$from) {
    $user_id = (int) $user_id;
    $db = new SafeMySQL();
    $numMessages =  $db->getAll("SELECT message_new FROM users WHERE id = ?i",$user_id);
    $numMessages = $numMessages[0][message_new] + 1;
    $db->query("UPDATE users SET message_new = ?i",$numMessages);
    $db->query("INSERT INTO messages SET message=?s, user_id=?i,from = ?s ",$message,$user_id,$from);
}
*/
function rareToSecond($rare) {
    global $user_info;
    if($rare == 'common'){
        $second = 864;
    }elseif($rare == 'uncommon'){
        $second = 7776;
    }elseif($rare == 'rare'){
        $second = 25920;
    }elseif($rare == 'unique'){
        $second = 51840;
    }elseif($rare == 'arcana'){
        $second = 86400;
    }else{
        $second = 99999;
    }
    if($user_info['profession'] == 'decoder'){
        //print_r($user_info[profession]);
        // $seconds = $second;
        $second * 0.7;
    }
    return $second;
}
// type period nums id
function action_long($params) {
    global $db,$data;
    $dateNow = new DateTime("now");
    $dateStop = $dateNow->add(new DateInterval('P0Y0M0DT0H0M'.$params[period].'S'));
    $dateStop = $dateStop->format('Y-m-d H:i:s');
    //$dateFreezeRemainPrepare = $dateFreeze->add(new DateInterval('P0Y0M0DT0H' . $Freeze[period] . 'M0S'));
    if($params[type] == 'decode'){
        $reward = serialize(array('rare'=>$params[rare],'nums'=>$params[nums])); 
    }
    $toBd = array('user_id'=>$data[0][id],'type'=>$params[type],'action_stop'=>$dateStop,'reward'=>$reward);
    $well = $db->query("INSERT INTO actions_long SET `action_start`=NOW(),?u ",$toBd);
    if($well){
        $htmlEcho = 'Успех';
        $thisNum = $params[inventory_num] - $params[nums];
        $db->query("UPDATE inventorys SET `num` = ?i WHERE `id` = ?i",$thisNum,$params[id]);
    }
}


function timeDecode($nums,$rare) {
    if($rare == 'rare'){
        $time = 25920 * $nums;
        $minits = $time / 60;
        return $minits;
    }
}

function getBorderColor($type) {
    switch ($type) {
        case 'rare':
            $color = '#4B69FF';
            break;

        default:
            $color = '#B0C3D9';
            break;
    }
    return $color;
}
function timeDiffView($dateOne,$dateTwo,$params = 0) {
    $dateOne = new DateTime("now");
    $dateTwo = new DateTime("$dateTwo");
    $intervalDiff = $dateOne->diff($dateTwo);
    $remainTime = $intervalDiff->format("%d дней(я) %h:%i:%s");
    return $remainTime;
}

function timeDiff($dateOne,$user_id,$type) {
    $dateNow = new DateTime("now");
    $dateDiff = new DateTime("$dateOne");
    $intervalDiff = $dateDiff->diff($dateNow);
    $remainTime = $intervalDiff->format("%i:%s");
    if($dateNow >= $dateDiff){
       
       global $db;
       $prepareData = array(''.$type.''=>null);
       $db->query("UPDATE `basic_reload` SET ?u WHERE `user_id` = ?i",$prepareData,$user_id);
       header("Location: hacked.php");
       return('Reload');
    }else{
        return $remainTime;    
    }
    
}
function issetRowBotnet() {
    global $db,$data;
    $infoBotnet = $db->getRow("SELECT * FROM botnet WHERE user_id = ?i",$data[0][id]);
    if(!$infoBotnet){
        $db->query("INSERT INTO botnet SET user_id = ?i",$data[0][id]);
        $infoBotnet = null;
        return $infoBotnet;
    }else{
        return $infoBotnet;
    }
}

function partyHard($data_name){
    if(isset($_GET[createparty])){
        $db = new SafeMySQL();
        $dontParty = $db->getRow("SELECT * FROM partys WHERE users_name LIKE  ?s ",'%'.$data_name.'%');
        if(!$dontParty){
            $names = serialize(array($data_name));
            $dataSql = array('users_name'=>  $names);
            $db->query("INSERT INTO partys SET ?u",$dataSql);
            return true;
        }else{
            return false;
        }
    }
}

function changeLvl($lvl){
    switch ($lvl) {
        case 2:
            $sent[exp_max]= 1080;
            break;
        case 3:
            $sent[exp_max]= 2430;
            break;
        case 4:
            $sent[exp_max]= 4320;
            break;
        case 5:
            $sent[exp_max]= 6750;
            break;
        case 6:
            $sent[exp_max]= 9720;
            break;
        case 7:
            $sent[exp_max]= 13230;
            break;
        case 8:
            $sent[exp_max]= 17280;
            break;
        case 9:
            $sent[exp_max]= 21870;
            break;
        case 10:
            $sent[exp_max]= 27000;
            break;
        case 11:
            $sent[exp_max]= 36000;
            break;
        case 12:
            $sent[exp_max]= 42000;
            break;
        case 13:
            $sent[exp_max]= 48000;
            break;
        
    }
    return $sent[exp_max];
}


function setCook($id,$hash){
    setcookie("id", "$id", time()+60*60*24*30);
    setcookie("hash", "$hash", time()+60*60*24*30); 
    if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])){
        return true;
    }else{
        return false;
    }
}
function goBack($arg){
    header("Location: index.php?".$arg."=true");
}