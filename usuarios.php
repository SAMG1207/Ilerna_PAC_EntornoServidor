<?php 
  include_once 'funciones.php';
  $_SERVER["REQUEST_METHOD"]==="POST"?cambiarPermisos():null;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Usuarios</title>
</head>
<body>
    <?php
    if(!isset($_COOKIE['userData']) || $_COOKIE['userData']!='super'){
       echo"<p>No tiene permisos de acceso a esta página <a href = 'index.php'> Volver </a></p>";
    }else{
      pintaTablaUsuarios();
        
    } 
    
    ?>
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
        <input type="submit" value="cambiar permisos">
    </form>
</body>
</html>