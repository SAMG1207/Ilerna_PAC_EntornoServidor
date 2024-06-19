<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
	include_once 'consultas.php';
	$user = htmlspecialchars($_POST['full_name']);
	$correo = $_POST['email'];
	$userType= tipoUsuario($user,$correo);
    
	setcookie("userData",$userType, time()+84600);

	switch($userType){
		case 'super':
		echo "<br> Bienvenido, ".$user. " para entrar en la seccion de usuarios pincha <a href='usuarios.php'>¡aquí!</a>";
		break;
	
		case'autorizado':
				echo "<br>Hola ".$user ." pulsa para entrar en los <a href='articulos.php'>artículos</a> ";
			break;
	
		case 'registrado':
			echo "<br> Bienvenido " .$user ." no tienes permisos de acceso, no puedes acceder";
			break;
	
		default: 
		echo "usuario no registrado";
		break;
	   }
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Index.php</title>
</head>
<body>

<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
<label for="usuario"> Usuario: </label>
<input type="text" name="full_name" id="usuario"><br>
<br>
<label for="correo">Correo: </label>
<input type="text" name="email" id="correo"><br>
<br>
<input type="submit" value="Enviar">

</body>
</html>