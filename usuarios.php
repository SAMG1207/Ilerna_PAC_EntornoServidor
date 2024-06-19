<?php 
  include_once 'consultas.php';
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
      
        $usuarios = getListaUsuarios();
        $tabla = "<table>";
        $tabla .="<tr>";
        $tabla .="<td>Nombre</td>";
        $tabla .="<td>Email</td>";
        $tabla .="<td>Autorizado</td>";
        $tabla .="</tr>";
        foreach($usuarios as $usuario){
        $tabla.="<tr>";
        if($usuario["enabled"]==1){
            $tabla.="<td><b>".$usuario["full_name"]."</b></td>";
            $tabla.="<td><b>".$usuario["email"]."</b></td>";
            $tabla.="<td><b>".$usuario["enabled"]."</b></td>";
        }else{
            $tabla.="<td>".$usuario["full_name"]."</td>";
            $tabla.="<td>".$usuario["email"]."</td>";
            $tabla.="<td>".$usuario["enabled"]."</td>";
        }
        $tabla.="</tr>";
        }
        $tabla.="</table>";
        echo $tabla;
        
    } 
    
    ?>
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
        <input type="submit" value="cambiar permisos">
    </form>
</body>
</html>