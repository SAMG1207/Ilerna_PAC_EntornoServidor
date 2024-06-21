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


	function getPermisos():int {
	try{
		$con = new Conexion();
		$sql = "SELECT management FROM setup";
		$stmt = $con->crearConexion()->prepare($sql);
		$stmt->execute();
		$value = $stmt->fetch();
		$con->cerrarConexion();
		return $value;
	}catch(Exception $e){
		print_r($e->getMessage());
		return 0;
	}
}


	function cambiarPermisos():bool {
		//ESTA TAMBIEN PUEDE HACERSE CON getPermisos
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


	function getCategorias():array {
		try{
			$con = new Conexion();
			$sql = "SELECT * FROM category";
			$stmt=$con->crearConexion()->prepare($sql);
			$stmt->execute();
			$rows = $stmt->fetchAll();
			return $rows;
		}catch(Exception $e){
			echo $e->getMessage();
			return[];
		}
	
	}


	function getListaUsuarios():array {
	try{
		$con = new Conexion();
		$sql = "SELECT full_name, email, enabled FROM user";
		$stmt =$con->crearConexion()->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll();
		$con->cerrarConexion();
		return $rows;
	}catch(Exception $e){
		print_r($e->getMessage());
		return[];
	}
     
	}


	function getProducto($ID):array {
      try{
		$sql = "SELECT * FROM product WHERE id = ?";
		$con = new Conexion();
		$stmt=$con->crearConexion()->prepare($sql);
		$stmt->bindParam(1, $ID);
		$stmt->execute();
		$row = $stmt->fetch();
		$con->cerrarConexion();
	    if ($row) {
            return $row; 
        }
        return [];
	  }catch(Exception $e){
		print_r($e->getMessage());
		return[];
	}
		
	}


	function getProductos($orden):array {
		try{
			$con = new Conexion();
			$sql ="SELECT p.id, p.name, p.cost, p.price, c.name
			FROM category c
			INNER JOIN product p
			ON c.id = p.category_id
			ORDER BY ? ";
			$stmt=$con->crearConexion()->prepare($sql);
			$stmt->bindParam(1, $orden);
			$stmt->execute();
			$rows = $stmt->fetchAll();
			$con->cerrarConexion();
			if($rows){
			   return $rows;
			}return [];
		}catch(Exception $e){
			print_r($e->getMessage());
			return[];
		}
		}


	function anadirProducto($nombre, $coste, $precio, $categoria):bool {
       try{
          $nombre = htmlspecialchars($nombre);
		  $coste = doubleval($coste)?$coste:null;
		  $precio = doubleval($precio)?$precio:null;
          $categoria = intval($categoria)?$categoria:null;
		  if($categoria > 0 && $categoria <5){
			$con = new Conexion();
			$sql ="INSERT INTO products(name, cost, price, category_id) values(?,?,?;,?)";
			$stmt=$con->crearConexion()->prepare($sql);
			$stmt->bindParam(1, $nombre);
			$stmt->bindParam(2, $coste);
			$stmt->bindParam(3, $price);
			$stmt->bindParam(4, $categoria);
			$stmt->execute();
			$con->cerrarConexion();
			return true;
		  }return false;
	   }catch(Exception $e){
			print_r($e->getMessage());
			return false;
		}
	}


	function borrarProducto($id):bool {
	try{
		
		$con = new Conexion();
		$sql = "DELETE FROM products WHERE id = ?";
		if(filter_var($id, FILTER_VALIDATE_INT)){
			$existe = count(getProducto($id))>0;
			if($existe){
				$stmt = $con->crearConexion()->prepare($sql);
				$stmt->bindParam(1, $id, PDO::PARAM_INT);
				$stmt->execute();
				return true;
			}echo"producto no existe en la base de datos";
			return false;
		}return false;
	}catch(Exception $e){
		print_r($e->getMessage());
		return false;
	}
	
	}


	function editarProducto($id, $nombre, $coste, $precio, $categoria) {
	
	}

