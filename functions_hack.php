<?php

function damage($seconds, $Target_hp_now, $Target_ratio, $increaseDamageMin = 1, $increaseDamageMax = 1, $Freeze = 0) {
    global $db, $data, $id,$Target_id;
    //print_r($data);

    $prepareMinDamage = $data[0][stats_attack] * 0.85;
    if ($seconds <= '10' and $Freeze == 0) {
        $seconds = $seconds / 10;
        $damage =($Target_ratio/100) * $seconds * rand($prepareMinDamage * $increaseDamageMin, $data[0][stats_attack] * $increaseDamageMax);
        $Target_hp_now = $Target_hp_now + (abs($damage));
    } else {
        $damage =($Target_ratio/100)* rand($prepareMinDamage * $increaseDamageMin, $data[0][stats_attack] * $increaseDamageMax);
        $Target_hp_now = $Target_hp_now + (abs($damage));
    }
    $data[0][mystery] = $data[0][mystery] + rand(0, 1);
    $damageInfo[damage] = $damage;
    $damageInfo[target_hp_now] = $Target_hp_now;
    $queryMystery = $db->query("UPDATE users SET mystery = ?i WHERE id=?i ", $data[0][mystery], $id);
    $queryHpSet = $db->query("UPDATE actions SET hp_now = ?i WHERE id=?i ", $Target_hp_now, $Target_id);
    $damageInfo[queryMystery] = $queryMystery;
    $damageInfo[queryHpSet] = $queryHpSet;
    //Фризим если надо $Freeze[period],$Freeze[type]
    if ($Freeze !== 0) {
        FreezeSkil($Freeze);
    }
    return $damageInfo;
}

function FreezeSkil($Freeze) {
    global $db, $data, $id;
    $dateFreeze = new DateTime("now");
    $dateFreezeRemainPrepare = $dateFreeze->add(new DateInterval('P0Y0M0DT0H' . $Freeze[period] . 'M0S'));
    $dateFreeze = $dateFreezeRemainPrepare->format('Y-m-d H:i:s');
    $db->query("UPDATE `basic_reload` SET `$Freeze[type]`  = ?s WHERE `user_id` = ?i", $dateFreeze, $data[0][id]);
}
