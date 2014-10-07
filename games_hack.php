<?php

include 'tml/head.php';
if(isset($_GET[url])){
    if($_GET[url] = 'one'){
        $hp_now = '0';
        $hp_max = rand(900000, 1100000);
        //$hp_max = rand(9, 11);
        $prepareReward = array();
        $prepareReward['exp'] = '10000';
        $prepareReward['money'] = '30000';
        print_r($prepareReward);
        //$prepareReward[object] = array('type'=>'rare','nums'=>'1','chance'=>);
        $reward = serialize($prepareReward);
        $dataSql = array('user_id'=>$data[0][id],'type'=>'site','hp_max'=>$hp_max,'reward'=>$reward,'party'=>$Party_id);
        $db->query("INSERT INTO actions SET ?u",$dataSql);
        header("Location: hacked.php");
    }
}

if(isset($_POST[site])){
    if($_POST[site] = 'vk'){
        
    }elseif($_POST[site] = 'ya'){
        
    }else{
        
    }
}
