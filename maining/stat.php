<?php
session_start();
if(isset($_SESSION['cook'])){
    $cook = $_SESSION['cook'];
}else{
    die('Ошибка печенек');
}

if ($curl = curl_init()) {
    curl_setopt($curl, CURLOPT_URL, 'http://gameminer.ru/account');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0');
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_COOKIEFILE, $_SERVER['DOCUMENT_ROOT']."/maining/users/$cook.txt");
    curl_setopt($curl, CURLOPT_COOKIEJAR, $_SERVER['DOCUMENT_ROOT']."/maining/users/$cook.txt");
    $html = curl_exec($curl);
    //echo $html;
    curl_close($curl);
    if(!preg_match('/Войти/i', $html)){
        preg_match('/<title>(.*) \/ Проф/i', $html,$name);
        $stat[name] = $name[1];
        //echo $name;
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'http://gameminer.ru/');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0');
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_COOKIEFILE, $_SERVER['DOCUMENT_ROOT']."/maining/users/$cook.txt");
    curl_setopt($curl, CURLOPT_COOKIEJAR, $_SERVER['DOCUMENT_ROOT']."/maining/users/$cook.txt");
    $html = curl_exec($curl);
    preg_match("/coal\">(.*)<\/span> уг/i", $html, $output_array);
    $stat['coal'] = $output_array[1];
    $_SESSION['coal'] = $stat['coal'];
    echo json_encode($stat);
    
    }else{
        echo 'Авторизируйтесь заново';
    }
    
}else{
    echo 'Curl лёг, лул :D';
}

