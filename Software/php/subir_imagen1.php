<?php

require('../../conexion.php');

$jsondata = array();
session_start();

    $id_imagen = $_POST['id_imagen'];
	$titulo_imagen = $_POST['titulo_imagen'];
	$autor_imagen = $_POST['autor_imagen'];
	$detalles_foto = $_POST['detalles_imagen'];
	$palabra_clave = $_POST['palabra_clave'];
	$usuario = $_POST['autor_imagen'];
    
    $sql = "UPDATE tio_imagenes set titulo_imagen = '$titulo_imagen',descripcion_imagen = '$detalles_foto',categoria = '$palabra_clave',usuario = '$usuario' WHERE id_imagen = $id_imagen";

    $result = mysqli_query($con,$sql) or die('Consulta fallida: ' . mysql_error());

    if ($result != null) {
        $jsondata['success'] = "Su foto ha sido subida correctamente";
    } else {
        $jsondata['success'] = "Error en la carga" . $con->error;
    }

    $jsondata['imagen'] = $id_imagen;
$jsondata['error'] = error_get_last();
header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);

?>

