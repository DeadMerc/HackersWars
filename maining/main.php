
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
   

    <title>Theme Template</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="theme.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="js/ie-emulation-modes-warning.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/docs.min.js"></script>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body role="document">

    <!-- Fixed navbar 
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Бот</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Действия</a></li>
            
            
          </ul>
        </div>
      </div>
    </div>
-->
<script>
    function stat(){
    $.get( "stat.php", function( data ) {
    //$("#ans").text(data);
    var stat = jQuery.parseJSON( data );
    $("#stat").text('' + stat.name + ',у тебя:' + stat.coal + ' угля.');
  //alert( "Data Loaded: " + data );
});
}
$(document).ready(function() {
    setInterval(stat(), 60000);
    
}); 

    
function coal(){
    $("#ans").text('Ожидайте ответы сервера т.к. парсинг и эмуляция действий пользователя занимает время(около 1-2 минут)');
$.get( "test.php", function( data ) {
    $("#ans").html(data);
    //$("#stat").text('' + stat.name + ',у тебя:' + stat.coal + ' угля.');
  //alert( "Data Loaded: " + data );
});

}
function enterSandBox(){
   var start = $("#start").val(); 
   var stop = $("#stop").val(); 
  $("#ans").text('Ожидайте ответы сервера т.к. парсинг и эмуляция действий пользователя занимает время(около 2-4 минуты)');
$.get( "sandbox.php?start="+ start +"&stop="+ stop + " ", function( data ) {
    $("#ans").html(data);
    //$("#stat").text('' + stat.name + ',у тебя:' + stat.coal + ' угля.');
  //alert( "Data Loaded: " + data );
});

}  


function sandbox(){
    
    setInterval(enterSandBox(), 1800000);
}
</script>    
<?php
session_start();
if(!empty($_SESSION['cook'])){
    
    echo '<div class="page-header"><div class="alert alert-success" role="alert">
        <strong>Well done!</strong> Успешная авторизация
      </div></div>';
}else{
    echo '<div class="alert alert-warning" role="alert">
        <strong>Warning!</strong> Ошибка, как вы тут оказались?
      </div></div>';
}

?>
<div class="jumbotron">
    <h1>Привет</h1>
   
        <p id="stat">Надеюсь этот сайт поможет тебе :)</p>
        <button type="button" onclick="coal()" class="btn btn-primary">Потратить уголь</button><br>
        Для песочницы укажите с какой по какую страницу парсить(пример 1-10,10-20)<br>Стоит ограничение на 2.5 минуты выполнения скрипта, и ни#ера не увеличивается.<br>
        <input type="text" id="start" value="1"><input type="text" id="stop" value="10"><br><br>
        <button type="button" onclick="sandbox()" class="btn btn-info">Парсить песочницу каждые 30 минут</button>
      </div>
<div id="ans" class="jumbotron">
        
        <p>Ответы сервера смотри тут</p>
        
</div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    
  </body>
</html>



