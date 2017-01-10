<?php

require('../../conexion.php');

session_start();
$jsondata = array();

    $nombre_usuario = $_POST['nombre_perfil'];
	$apellidos_usuario = $_POST['apellidos_perfil'];
	$correo_usuario = $_POST['email_perfil'];
	$password_usuario = $_POST['password_perfil'];
//	$user = $_POST['usuario_perfil'];
	$detalles = $_POST['detalles_perfil'];

	$usuario_actual = $_SESSION['user'];

        $sql = "UPDATE tio_usuarios set nombre_usuario = '$nombre_usuario',apellidos_usuario='$apellidos_usuario',correo_usuario='$correo_usuario',password_usuario='$password_usuario', detalles='$detalles' WHERE user = '$usuario_actual'";

    	//Actualizamos datos de sesión, habría que comprobar si el usuario ya está cogido

    $result = mysqli_query($con,$sql) or die('Consulta fallida: ' . mysql_error());
    if ($result != null) {
        $jsondata['success'] = "Su perfil se ha sido actualizado correctamente";
    } else {
        $jsondata['success'] = "Su perfil no se ha actualizado correctamente";
    }
    $jsondata['usuario'] = $usuario_actual;

$jsondata['error'] = error_get_last();
header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);

?>
