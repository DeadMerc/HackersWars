<?php
include 'tml/head.php';
if($_GET['do'] == 'quests'){
    header("Location: quests_list.php");
}elseif($_GET['do'] == 'sites'){
    header("Location: sites_list.php");
}elseif($_GET['do'] == 'games'){
    header("Location: games_list.php");
}elseif($_GET['do'] == 'servers'){
    header("Location: servers_list.php");
}elseif($_GET['do'] == 'world'){
    header("Location: world_list.php");
}else{
    header("Location: mainGame.php");
}
?>





<?php
include 'tml/footer.php';
?>
