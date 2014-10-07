 <?php 
$config = array(); // óêàçûâàåì, ÷òî ïåðåìåííàÿ $config ýòî ìàññèâ 
$config['server'] = "localhost"; //ñåðâåð MySQL. Îáû÷íî ýòî localhost 
$config['login'] =""; //ïîëüçîâàòåëü MySQL 
$config['passw'] = ""; //ïàðîëü îò ïîëüçîâàòåëÿ MySQL 
$config['name_db'] = "_game"; //íàçâàíèå íàøåé ÁÄ 

$connect = mysql_connect($config['server'], $config['login'], $config['passw']) or die("Error!"); // ïîäêëþ÷àåìñÿ ê MySQL èëè, â ñëó÷àèè îøèáêè, ïðåêðàùàåì âûïîëíåíèå êîäà 
mysql_select_db($config['name_db'], $connect) or die("Error!"); // âûáèðàåì ÁÄ  èëè, â ñëó÷àèè îøèáêè, ïðåêðàùàåì âûïîëíåíèå êîäà 

?> 