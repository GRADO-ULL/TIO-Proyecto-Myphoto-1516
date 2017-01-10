<?php

require('../../conexion.php');
session_start();
$jsondata = array();

        $categoria = $_POST['buscando'];
        //$categoria = 'viajes';
    $sql = "SELECT * from tio_imagenes WHERE categoria like '$categoria'";

        $result = mysqli_query($con,$sql) or die('Consulta fallida: ' . mysql_error());
        $num_rows = $result->num_rows;
       // $row = $result->fetch_assoc();

        if($result->num_rows > 0)
        {
             //$row = $result->fetch_assoc();
             $jsondata['imagenes'] = array();
             while($row = $result->fetch_array())
             {
                $jsondata['imagenes'][] = $row;
             }
        }
        else
        {
	        $jsondata['mensaje_respuesta'] = "No se han encontrado imagenes";
            $jsondata['resultados'] = 0;
        }


     $sql6 = "SELECT MIN(id_imagen) as id_minimo from tio_imagenes WHERE categoria like '$categoria'";

     $result6 = mysqli_query($con,$sql6) or die('Consulta fallida: ' . mysql_error());
     $num_rows6 = $result6->num_rows;
     $row6 = mysqli_fetch_assoc($result6);

     if($result6->num_rows > 0)
     {
             $jsondata['id_minimo'] = $row6['id_minimo'];
     }
     else
     {
             $jsondata['id_minimo'] = -1;
     }
     $sql7 = "SELECT MAX(id_imagen) as id_maximo from tio_imagenes WHERE categoria like '$categoria'";

     $result7 = mysqli_query($con,$sql7) or die('Consulta fallida: ' . mysql_error());
     $num_rows7 = $result7->num_rows;
     $row7 = mysqli_fetch_assoc($result7);

     if($result7->num_rows > 0)
     {
             $jsondata['id_maximo'] = $row7['id_maximo'];
     }
     else
     {
             $jsondata['id_maximo'] = -1;
     }

$jsondata['error'] = error_get_last();
header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);

?>
