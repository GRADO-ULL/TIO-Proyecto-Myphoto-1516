<?php

require('../../conexion.php');

$jsondata = array();
session_start();


	$user = $_POST['user'];
	$pass = $_POST['pass'];
	$apellidos_registro = $_POST['apellidos_registro'];
	$nombre_registro = $_POST['nombre_registro'];
	$email_registro = $_POST['email_registro'];
	$descripcion = $_POST['detalles'];
    $jsondata['probando'] = "eaaaa";

    /*    $user = "Josue";
        $pass = "1";
        $apellidos_registro = "1";
        $nombre_registro = "1";
        $email_registro = "1";
        $descripcion = "1";
*/
	//$sql = "INSERT INTO tio_usuarios(user,nombre_usuario,password_usuario,apellidos_usuario,correo_usuario,detalles) VALUES('$user','$nombre_registro','$pass','$apellidos_registro','$email_registro','$descripcion')";

    $sql = "INSERT INTO `tio_usuarios` (`ID_usuario`, `nombre_usuario`, `apellidos_usuario`, `correo_usuario`, `password_usuario`, `detalles`, `user`) VALUES (NULL, '$nombre_registro', '$apellidos_registro', '$email_registro', '$pass', '$descripcion', '$user')";
//	$jsondata['conexion'] = $conn->query($sql);
    $result = mysqli_query($con,$sql) or die('Consulta fallida: ' . mysql_error());

    if($result != null)
    {
        $jsondata['success'] = "El usuario " . $user . "se ha registrado correctamente";
    }
    else
    {
        $jsondata['success'] = "El usuario no se ha podido registrar " . $conn->error;
    }
/*    if ($conn->query($sql) === TRUE) {
        $jsondata['success'] = "El usuario se ha registrado correctamente";
    } else {
        $jsondata['success'] = "El usuario no se ha podido registrar " . $conn->error;   
    }*/

$jsondata['error'] = error_get_last();	
header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);

?>