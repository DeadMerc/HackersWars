<?php
include 'check.php';
?>
<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="tml/styles.css">
 <script src="tml/scripts.js"></script>
  <script src="http://code.jquery.com/jquery-latest.js"></script>
  <title>Hackers Wars</title>
  
  
  <body>  
<div id="MainContainer">
<meta  name="viewport" content="width=320,user-scalable=false" />
<div id="statsBlock">
  
    <table>
        <tr>
            <td id="posLeft"><a href="cpu.php"><?=$data[0][capacity_now]?>/<?=$data[0][capacity_max]?> cpu</a> </td>
            <td id="posCenter">Message<a href="messages.php"> (<?=$data[0][message_new]?>)</a></td>
            <td id="posRight"><?=$data[0][mystery]?>%</td>
        </tr>
    </table>
    
</div>
<br>
<div class="row">
