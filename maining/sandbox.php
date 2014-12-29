 <meta charset="utf-8">
<?php
set_time_limit(300);
session_start();
if(isset($_SESSION['cook'])){
    $cook = $_SESSION['cook'];
    $coal = $_SESSION['coal'];
    $agent = $_SESSION['agent'];
    $succes = 0;
    $start = (int) $_GET['start'];
    $stop = (int) $_GET['stop'];
    $raz = $stop - $start;
    if($stop <= 20 and $raz >= 1 and $raz <= 10){
        
    }else{
        
        die('Страницы укажите правильно, разницой не больше 10');
    }
    
    for($i=$start;$i<$stop;$i++){
        $html = getPage($i);
        $data = json_decode($html, true);
        //print_r($data);
        $nums = count($data[giveaways]);
        //echo $nums;
        
        for($num=0;$num<$nums;$num++){
            if(!empty($data[giveaways][$num][code]) and $coal >= $data[giveaways][$num][price]){
                $code = $data[giveaways][$num][code];
                $xsrf = $_SESSION['xsrf'];
                $enter = postIt($code,$xsrf,$cook);
                //var_dump($enter);
                //$enter = json_decode($enter,true);
                //var_dump($enter);
                if(preg_match('/status/i', $enter)){
                    $succes++;
                    $buys[] = 'Успешно:'.$data[giveaways][$num][game][name].'<br>';
                }elseif(preg_match('/already_in_giveaway/i', $enter)){
                    $buys[] = 'Уже в очереди:'.$data[giveaways][$num][game][name].'<br>';
                }else{
                    $buys[] = 'Ошибка['.$enter.']:'.$data[giveaways][$num][game][name].'<br>';
                }
                
                /*
                if($enter['status'] == 'ok'){
                    $buys[] = $data[giveaways][$num][game][name].'<br>';
                }else{
                    $buys[] = 'Ошибка'.  print_r($enter).'&nbsp'.$data[giveaways][$num][game][name].'<br>';
                }
                */
                
                sleep(rand(1,3));
                //die;
            }
        }
        
    }
    //print_r($buys);
    echo 'Успешно:'.$succes.'<br>';
    if(is_array($buys)){
        foreach ($buys as $value) {
        echo $value;
        }
    }else{
        echo 'Ошибка,используйте другие страницы';
    }
    
    
    
}else{
    die('Ошибка печенек');
}

function postIt($code,$xsrf,$cook){
    
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'http://gameminer.ru/giveaway/enter/'.$code.'');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_AUTOREFERER, true);
    curl_setopt($curl, CURLOPT_USERAGENT, $agent);
    $header = array(
               'Accept:application/json, text/javascript, */*; q=0.01',
'Accept-Encoding:gzip,deflate,sdch',
'Accept-Language:ru,en-US;q=0.8,en;q=0.6,zh-TW;q=0.4,zh;q=0.2',
'Connection:keep-alive',
'Content-Type:application/x-www-form-urlencoded',
'Host:gameminer.ru',
'Origin:http://gameminer.ru',
'Referer:http://gameminer.ru/',
''.$agent.'',
'X-Requested-With:XMLHttpRequest'
        );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    //curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    //curl_setopt($curl, CURLOPT_HEADER, true);
    curl_setopt($curl, CURLOPT_REFERER, 'http://gameminer.ru/');
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, "_xsrf=$xsrf&json=true");
    curl_setopt($curl, CURLOPT_COOKIEFILE, $_SERVER['DOCUMENT_ROOT']."/maining/users/$cook.txt");
    curl_setopt($curl, CURLOPT_COOKIEJAR, $_SERVER['DOCUMENT_ROOT']."/maining/users/$cook.txt");
    $html = curl_exec($curl);
    return $html;
    
}

function getPage($num){
    global $cook;
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'http://gameminer.ru/api/giveaways/sandbox?page='.$num.'&count=8&q=&type=any&sortby=finish&order=asc');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($curl, CURLOPT_USERAGENT, $agent);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_COOKIEFILE, $_SERVER['DOCUMENT_ROOT']."/maining/users/$cook.txt");
    curl_setopt($curl, CURLOPT_COOKIEJAR, $_SERVER['DOCUMENT_ROOT']."/maining/users/$cook.txt");
    $html = curl_exec($curl);
    return $html;

}

