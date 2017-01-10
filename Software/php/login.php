<?php
require('../../conexion.php');
session_start();
$jsondata = array();	
	$usu = $_POST['usuario'];
	$pass = $_POST['password'];	
	//$usu = 'JosueTC94';
	//$pass = 'x';
	$jsondata['usu'] = $usu;
	$jsondata['pass'] = $pass;
	//$usu = "josuetc94";
	//$pass = "x";

	$sql = "SELECT * from tio_usuarios where password_usuario='$pass' AND user='$usu'";

    $result = mysqli_query($con,$sql) or die('Consulta fallida: ' . mysql_error());
	$num_rows = $result->num_rows;
    $row = mysqli_fetch_assoc($result);

	if($result->num_rows > 0)
	{
		$jsondata['numero_filas'] = $num_rows;
		$jsondata['ID_usuario'] = $row['ID_usuario'];
		$jsondata['nombre_usuario'] = $row['nombre_usuario'];
		$jsondata['apellidos_usuario'] = $row['apellidos_usuario'];
		$jsondata['correo_usuario'] = $row['correo_usuario'];
		$jsondata['usuario'] = $row['user'];
		$jsondata['detalles'] = $row['detalles'];
		$jsondata['numero_filas'] = $num_rows;
		$usuario_actual = $jsondata['usuario'];
		/*$_SESSION['ID_usuario'] = $row['ID_usuario'];
		$_SESSION['nombre_usuario'] = $row['nombre_usuario'];
		$_SESSION['apellidos_usuario'] = $row['apellidos_usuario'];
		$_SESSION['correo_usuario'] = $row['correo_usuario'];
		$_SESSION['usuario'] = $row['user'];
		$_SESSION['detalles'] = $row['detalles'];
		*/
		//setcookie("Usuario_actual",$usuario_actual);
		$_SESSION['user'] = $jsondata['usuario'];
		//$jsondata['probando'] = "Usuario->".$_COOKIE["Usuario_actual"];
		$jsondata['probando'] = "Usuario->" . $_SESSION['user'];
		$jsondata['respuesta'] = "El usuario es correcto";
		//$jsondata["cookies"] = var_dump($_COOKIE);
	}
	else
	{
		$jsondata['numero_filas'] = 0;
		$jsondata['respuesta'] = "El usuario no existe";
	}

$jsondata['error'] = error_get_last();	
header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);

?>