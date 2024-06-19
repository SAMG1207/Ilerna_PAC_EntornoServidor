<?php
require_once 'conexion.php';
	
     
	function tipoUsuario(string $nombre, string $correo){
    try{
		if(esSuperadmin($nombre, $correo)){
			return "super";
		}else{
			if(filter_var($correo,FILTER_VALIDATE_EMAIL)){
				$con = new Conexion();
				$sql = "SELECT enabled FROM user WHERE email = ? AND full_name = ?";
                $stmt = $con->crearConexion()->prepare($sql);
				$stmt->bindParam(1,$correo);
				$stmt->bindParam(2,$nombre);
				$stmt->execute();
				$con->cerrarConexion();
				$row = $stmt->fetch()["enabled"];
				if($row == 0){
					return "registrado";
				}else if($row == 1){
					return "autorizado";
				}else{
					return "no autorizado";
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


	function cambiarPermisos():bool {
	try{
		$con = new Conexion();
		$sql = "UPDATE user
		SET enabled = CASE
			WHEN enabled = 1 THEN 0
			WHEN enabled = 0 THEN 1
			ELSE enabled
		END";
		$stmt=$con->crearConexion()->prepare($sql);
		$stmt->execute();
		return true;
	}catch(Exception $e){
		print_r($e->getMessage());
		return false;
	}
	

	}


	function getCategorias() {
	
	}


	function getListaUsuarios() {
	try{
		$con = new Conexion();
		$sql = "SELECT full_name, email, enabled FROM user";
		$stmt =$con->crearConexion()->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll();
		return $rows;
	}catch(Exception $e){
		print_r($e->getMessage());
	}
     
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

