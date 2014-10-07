<?php

//echo 'WTF';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
ini_set('display_errors', 1);
//error_reporting(E_ALL);


include_once 'mysql.php';
include_once 'functions.php';
//print_r($_SERVER);
if ($_SERVER[SCRIPT_NAME] != '/index.php') {
    //$db = new SafeMySQL();
    if ($_SERVER[SCRIPT_NAME] != '/news.php') {
        if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])) {
            $id = $_COOKIE['id'];
            $hash = $_COOKIE['hash'];
            $data = $db->getAll("SELECT * FROM users WHERE id=?i and hash=?s", $id, $hash);

            if (!empty($data)) {
                global $data;
                //md5Name
                $projectClosed = 1;
                if ($projectClosed == '1' and $data[0][name] !== 'max') {
                    die('The project is in development and is temporarily closed. Your suggestions:deadmerc25@gmail.com');
                }

                $md5Name = md5($data[0][name] . 'ПоВодеХодим' . $data[0][id]);
                //info
                global $user_info;
                $user_info = $db->getRow("SELECT * FROM info WHERE user_id = ?i", $data[0][id]);
                if (!$user_info) {
                    $db->query("INSERT INTO info SET user_id=?i", $data[0][id]);
                }
                //print_r($user_info); 
                //шанс крита
                $percentCrit = ($user_info[exp_lvl] + $user_info[caught]);
                //СЂР°Р·РЅРёС†Р° РІСЂРµРјРµРЅРё"now"
                $date1 = new DateTime($data[0][last_action]);
                //$date2 = new DateTime($date("Y-m-d H:i:s"));
                $date2 = new DateTime("now");
                $interval = $date2->diff($date1);
                $seconds = $interval->format("%s");
                $seconds = $seconds;
                //echo 'РџРѕСЃР»РµРґРЅРµРµ РґРµР№СЃС‚РІРёРµ Р±С‹Р»Рѕ '.$seconds.' СЃРµРєСѓРЅРґ РЅР°Р·Р°Рґ';
                //echo 'РџРѕСЃР»РµРґРЅРµРµ РґРµР№СЃС‚РІРёРµ Р±С‹Р»Рѕ '.$seconds.' СЃ РЅР°Р·Р°Рґ ';
                //СЂР°Р·РЅРёС†Р° РІСЂРµРјРµРЅРё
                $db->query("UPDATE users SET last_action = NOW() WHERE id = ?i", $data[0][id]);
                //print_r($data[0][action]);

                partyHard($data[0][name]);
                $Party_names = $db->getRow("SELECT * FROM partys WHERE users_name LIKE ?s ", '%"' . $data[0][name] . '"%');


                if ($data[0][invite_party]) {
                    $you_have_invite = $data[0][invite_party];
                    echo "Вы приглашены в пати, согласиться<a href=\"party.php?yes=$you_have_invite\">Р”Р°</a>&nbsp<a href=\"party.php?no=$you_have_invite\">Нет</a> ";
                }

                if ($Party_names) {
                    $Party_id = $Party_names[id];
                    $Party_names = $Party_names[users_name];
                }



                if ($data[0][action] == '1' and $_SERVER[SCRIPT_NAME] != '/hacked.php') {
                    header("Location: hacked.php");
                    exit;
                }
                if (preg_match('/hacked.php/', $data[0][action])) {
                    header("Location:" . $data[0][action] . " ");
                }

                if ($data[0][mystery] < '0' and $data[0][name] !== 'max') {
                    $db->query("UPDATE users SET mystery='0' WHERE id = ?i ", $data[0][id]);
                    header("Location: mainGame.php ");
                }
                if ($data[0][capacity_now] < '0') {
                    $db->query("UPDATE users SET capacity_now='0' WHERE id = ?i ", $data[0][id]);
                    //header("Location: mainGame.php ");
                }
                // print_r($data);
                if ($data[0][action]) {
                    $act = unserialize($data[0]['action']);
                    // print_r($act);


                    if ($act[type] == 'quest' and !empty($act[id]) and $_SERVER[SCRIPT_NAME] != '/quest_do.php' and $_SERVER[SCRIPT_NAME] != '/hacked.php') {
                        header("Location: quest_do.php?id=" . $act[id] . "&run=true ");
                    }
                }
            } else {
                goBack('fuckCook');
            }
        } else {
            goBack('WhoAreYOU');
        }
    }
}