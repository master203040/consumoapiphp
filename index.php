<?php


	include 'conexion.php';
	
	$pdo = new Conexion();
	
	//Listar registros y consultar registro
	if($_SERVER['REQUEST_METHOD'] == 'GET'){
		if(isset($_GET['id']))
		{
			$sql = $pdo->prepare("SELECT * FROM alumnos WHERE id=:id");
			$sql->bindValue(':id', $_GET['id']);
			$sql->execute();
			$sql->setFetchMode(PDO::FETCH_ASSOC);
			header("HTTP/1.1 200 hay datos");
			echo json_encode($sql->fetchAll());
			exit;				
			
			} else {
			
			$sql = $pdo->prepare("SELECT * FROM alumnos");
			$sql->execute();
			$sql->setFetchMode(PDO::FETCH_ASSOC);
			header("HTTP/1.1 200 hay datos");
			echo json_encode($sql->fetchAll());
			exit;		
		}
	}
	
	//Insertar registro
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		$sql = "INSERT INTO alumnos (nombre, apellido,direccion,cedula,telefono) VALUES(:nombre, :apellido, :direccion, :cedula, :telefono)";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':nombre', $_POST['nombre']);
		$stmt->bindValue(':apellido', $_POST['apellido']);
        $stmt->bindValue(':direccion', $_POST['direccion']);
        $stmt->bindValue(':cedula', $_POST['cedula']);
		$stmt->bindValue(':telefono', $_POST['telefono']);
		$stmt->execute();
		$idPost = $pdo->lastInsertId(); 
		if($idPost)
		{
			header("HTTP/1.1 200 Ok");
			echo json_encode($idPost);
			exit;
		}
	}
	
	//Actualizar registro
	if($_SERVER['REQUEST_METHOD'] == 'PUT')
	{		
		$sql = "UPDATE alumnos SET nombre=:nombre, apellido=:apellido, direccion=:direccion, cedula=:cedula ,telefono=:telefono WHERE id=:id";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':nombre', $_GET['nombre']);
		$stmt->bindValue(':apellido', $_GET['apellido']);
        $stmt->bindValue(':direccion', $_GET['direccion']);
        $stmt->bindValue(':telefono', $_GET['telefono']);
        $stmt->bindValue(':cedula', $_GET['cedula']);
		$stmt->bindValue(':id', $_GET['id']);
		$stmt->execute();
		header("HTTP/1.1 200 Ok");
		exit;
	}
	
	//Eliminar registro
	if($_SERVER['REQUEST_METHOD'] == 'DELETE')
	{
		$sql = "DELETE FROM alumnos WHERE id=:id";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':id', $_GET['id']);
		$stmt->execute();
		header("HTTP/1.1 200 Ok");
		exit;
	}
	
	//Si no corresponde a ninguna opción anterior
	header("HTTP/1.1 400 Bad Request");