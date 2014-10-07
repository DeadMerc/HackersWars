<?php

include 'tml/headIndex.php';
if(isset($_GET[good])){
    echo '<h2>Успех</h2><br>';
}
?>

<div id="headContainer">
    
</div><br><br>
<div  style="float:left">
    
        <?php   include 'login.php'; ?>  
        
             <?php   include 'registration.php'; ?>  
    
</div>
<div >
         <?php   include 'news.php'; ?>  
    </div>
<?php






