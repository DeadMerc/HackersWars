<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
if (!isset($_GET['tableNumStart'])) {
    $str = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
Введите размер таблицы(например 3х3);
<form method="GET" action="">
<input type="text" name="tableNumStart">x<input type="text" name="tableNumStop"><br>
Желаемые блоки для закраски через запятую(1,2,4,5)<br>
Первый блок<br>
<input type="text" name="oneBlock"><br>
Второй блок<br>
<input type="text" name="twoBlock"><br>
<input type="submit" value="Покеж таблицу">

</form>';
} else {


    $tableStart = $_GET['tableNumStart'];
    $tableStop = $_GET['tableNumStop'];
    $sumNubs = $tableStart * $tableStop;
    //print_r($_GET['oneBlock']);
    $oneBlock = explode(',', $_GET['oneBlock']);
    $twoBlock = explode(',', $_GET['twoBlock']);
    //print_r($oneBlock); cellspacing="0"
    $str = '<table border="1" cellpadding="7" >';
    $nums = '1';
    $howEcho = 0;
    $last = 0;
    //столбец
    $tpTemp = 0;
    $blockOne = 0;
    //$forEcho = '';
    for ($i = 0; $i < $tableStart; $i++) {
        $str.= '<tr>';
        //строка

        $temp = 0;



        for ($b = 0; $b < $tableStop; $b++) {
            //копим колспан на строку
            //echo $temp;
            $forEcho[] = $temp;
            if (in_array($nums, $oneBlock)) {

                if (($b + 1) == $tableStop) {
                    $temp++;
                    $str.= '<td colspan="' . $temp . '" bgcolor="green">a' . $nums . '</td>';
                } else {
                    $temp++;
                    $tpTemp++;
                }
            } else {

                if ($temp == 0) {
                    $str.= '<td  bgcolor="red">b' . $nums . '</td>';
                } elseif ($temp == 1) {
                    //$b--;
                    $str.= '<td styles="border-style:hidden"  bgcolor="green" >c' . ($nums - 1) . '</td>';
                    $str.= '<td bgcolor="red" >d' . ($nums ) . '</td>';
                } else {
                    //$str.= 'OTHER';
                    //$b = $b - $temp + ($temp - 1);;
                    if ($temp == $tableStop) {
                        $str.= '<td bgcolor="white" colspan="' . $temp . '" >e' . $nums . '</td>';
                    } else {
                        
                            $blockOne++;
                            $str.= '<td bgcolor="green" colspan="' . $temp . '" >f' . $nums . '</td>';
                            
                            $str.= '<td bgcolor="red">g' . ($nums + 1) . '</td>';
                        
                    }
                }
                /*
                  if($howEcho !== $tableStop){
                  for($z = $howEcho;$z<$tableStop;$z++){
                  $str.= '<td bgcolor="red">' . $z. '</td>';
                  }
                  }
                 */
                $temp = 0;
            }

            if ($last) {
                $str.= '<td bgcolor="white" colspan="' . $tpTemp . '" >' . $nums . '</td>';
            }
            $nums++;
        }
        $str.= '</tr>';
    }


    $str.= '</table><br>';
    //print_r(chunk_split($forEcho, $tableStop));
    $forEcho = array_chunk($forEcho, $tableStop);
    //print_r($forEcho);
    $rowSpan = 0;
    for ($l = 0; $l < $tableStart; $l++) {
        for ($n = 0; $n < $tableStop; $n++) {
            //$forEcho[$l][$n];
            if ($forEcho[$n][$l] == '1') {
                $rowSpan++;
            } else {
                echo $rowSpan;
                if ($rowSpan > 1) {
                    $str = preg_replace("/bgcolor=\"green\"/i", 'bgcolor="green" rowspan="' . ($rowSpan) . '" ', $str, 1);
                    //print_r($str);
                    if (preg_match_all("/bgcolor=\"green\" rowspan=\"[0-9]{1,2}\" >.[0-9]{1,2}<\/td>/i", $str)) {
                        echo 'YES';
                    } else {
                        echo 'NO';
                    }
                    //print_r($find);
                    //$str = preg_replace("/b4<\/td><td (.*)bgcolor=\"green\" >c5<\/td>/i", 'b4</td>', $str,1);
                    //$str = preg_replace("/bgcolor=\"green\"/i", 'bgcolor="green"  ', $str);
                }
                $rowSpan = 0;
            }
        }
    }
//preg_replace("/<td bgcolor=\"green\" >c1<\/td>/", "<td rowspan=\"2\" bgcolor=\"green\" >c1</td>", $str);
//$str = preg_replace("/bgcolor=\"green\"/i", 'bgcolor="green" rowspan="2" ', $str);
    print_r('<br>' . htmlspecialchars($str));
    echo $str;
    die;
    $splitIt = explode('</tr>', $str);
    for ($k = 0; $k < count($splitIt); $k++) {
        if (preg_match('/rowspan/i', $splitIt[$k])) {
            preg_match('/colspan=\"([0-9]{1})\"/i', $splitIt[$k], $matches);
            $matches = $matches[1];
            print_r($matches);
            for ($o = 0; $o < $matches; $o++) {
                $so = $k + 1;
                //$splitIt[$so] = preg_replace("/<td (.*)<\/td>/i", '', $splitIt[$so],2);
            }
        }
    }



//print_r($splitIt);
}
echo $str;






