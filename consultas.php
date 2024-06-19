<?php
require_once 'conexion.php';
	
     
	function tipoUsuario(string $nombre, string $correo){
    try{
		if(esSuperadmin($nombre, $correo)){
			return "super";
		}else{
			if(filter_var($correo,FILTER_VALIDATE_EMAIL)){
				$con = new Conexion();
				$sql = "SELECT id FROM user WHERE email = ? AND full_name = ?";
                $stmt = $con->crearConexion()->prepare($sql);
				$stmt->bindParam(1,$correo);
				$stmt->bindParam(2,$nombre);
				$stmt->execute();
				$con->cerrarConexion();
				$row = $stmt->fetch()["id"];
				if($row == 0){
					return "na";
				}else if($row == 1){
					return "a";
				}else{
					return false;
				}
			}return false;
		}

	}catch(PDOException $e){
		print_r($e->getMessage());
		return false;
	   }
    }


	function esSuperadmin(string $nombre, string $correo):bool{
	try{
		if(filter_var($correo,FILTER_VALIDATE_EMAIL)){
			$con = new Conexion();
			$sql = "SELECT s.superadmin_id, u.email, u.full_name 
			FROM user u
			INNER JOIN setup s ON s.superadmin_id = u.id
			WHERE u.email = ?
			AND u.full_name=?";
			$stmt = $con->crearConexion()->prepare($sql);
			$stmt->bindParam(1,$correo);
			$stmt->bindParam(2,$nombre);
			$stmt->execute();
			$con->cerrarConexion();
			return $stmt->rowCount() > 0;
			}else{
				return false;
			}
	}catch(PDOException $e){
		print_r($e->getMessage());
		return false;
	}
		
	}


	function getPermisos() {

	}


	function cambiarPermisos() {
	
	}


	function getCategorias() {
	
	}


	function getListaUsuarios() {

	}


	function getProducto($ID) {

		
	}


	function getProductos($orden) {

		}


	function anadirProducto($nombre, $coste, $precio, $categoria) {

	}


	function borrarProducto($id) {
	
	}


	function editarProducto($id, $nombre, $coste, $precio, $categoria) {
	
	}

