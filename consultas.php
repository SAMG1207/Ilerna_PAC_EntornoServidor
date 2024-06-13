<?php
require_once 'conexion.php';

	function tipoUsuario($nombre, $correo){
		$con=crearConexion();
		//Revisamos quién es el tipo de usuario, descartamos primero que sea el super usuario
		
		if(esSuperadmin($nombre,$correo)){
			return 'super_user';
		}else{
			//Si no es, hacemos una tabla virtual en el que el nombre y el correo sean los mismos que los que están en la bbdd
		$query = "SELECT * FROM user WHERE full_name = '$nombre' AND email ='$correo';";
		
        $sql=mysqli_query($con, $query);
		//ese resultado lo introducimos en una variable de tipo array, el valor [3] del array es el "enabled"
		$autorized= mysqli_fetch_array($sql);
		//si hay valor en autorize[3] igual al de los permisos entonces estaras o no autorizado.
		if(isset($autorized)){
            if($autorized[3] == getPermisos()){
			return 'autorizado';
		}
		   else if($autorized[3] != getPermisos()){
			return 'registrado';
		}
		}else return 'no_registrado';
	}
}


	function esSuperadmin($nombre, $correo){
		$con=crearConexion();
		$query="SELECT * FROM user INNER JOIN setup ON user.id = setup.superadmin_id WHERE user.email = '$correo' and user.full_name='$nombre';";
		$sql=mysqli_query($con, $query);
		$datos = mysqli_num_rows($sql);
		if($datos > 0){
		    return true;
		}else{
		    return false;}
//en este método el valor debe coincidr con el id de la tabla superadmin, entonces haremos un inner join
	}


	function getPermisos() {
		$con=crearConexion();
		$sql="SELECT management FROM setup";
		$resultado = mysqli_fetch_assoc(mysqli_query($con,$sql));
		cerrarConexion($con);
		return $resultado['management'];
		//esta funcion devuelve el valor management que es igual al valor que deben tener los autorizados en su columna enabled
		//este valor se puede cambiar en la funcion siguiente
	}


	function cambiarPermisos() {
		$con = crearConexion();
		if(getPermisos() == 1){
			$query = "UPDATE setup SET management = 0";
			
			
		}else if(getPermisos() == 0){
			$query = "UPDATE setup SET management = 1;";
			
		}	
		mysqli_query($con,$query);
		cerrarConexion($con);
	}


	function getCategorias() {
		$con = crearConexion();
		$query = "SELECT * FROM category;";
		$sql = mysqli_query($con,$query);
		cerrarConexion($con);
		return  $sql;
	}


	function getListaUsuarios() {
		$con = crearConexion();
		$query = "SELECT email, full_name, enabled FROM user;";
		$sql = mysqli_query($con,$query);
		cerrarConexion($con);
		return  $sql;
	}


	function getProducto($ID) {
		$con = crearConexion();
		$query = "SELECT * FROM product where id = '$ID';";
		if($query){
			$sql = mysqli_query($con,$query);
			cerrarConexion($con);
			return  $sql;
		}else{
			return "ID no encontrado"; 
		}
		
	}


	function getProductos($orden) {
		$con = crearConexion();
		$query= "SELECT product.id, product.name, product.cost, product.price, product.category_id, category.name as nombre FROM product INNER JOIN category WHERE product.category_id = category.id ORDER BY $orden";
		// Si no se cambia el nombre en category.name el programa no diferencia entre los dos name cuando se llame la funcion en la lista de productos
		$sql = mysqli_query($con,$query);
		cerrarConexion($con);
		return $sql;
		}


	function anadirProducto($nombre, $coste, $precio, $categoria) {
		$con = crearConexion();
		$query = "INSERT INTO product (name, cost, price, category_id) values ('$nombre', '$coste', '$precio', '$categoria');";
		$sql = mysqli_query($con,$query);
		cerrarConexion($con);
		return  $sql;
	}


	function borrarProducto($id) {
		$con = crearConexion();
		$query = "DELETE FROM product WHERE id = '$id';";
		if($query){
			$sql = mysqli_query($con,$query);
			cerrarConexion($con);
			return  $sql;
		}else{
			return "no existe ese id";
		}		
	}


	function editarProducto($id, $nombre, $coste, $precio, $categoria) {
		$con = crearConexion();
		$query = "UPDATE product SET name = '$nombre', cost = '$coste', price = '$precio', category_id = '$categoria' WHERE id = '$id';";
		if($query){
			$sql = mysqli_query($con,$query);
			cerrarConexion($con);
			return  $sql;
		}else{
			return "No es ha podido hacer la actualización";
		}
	}

?>