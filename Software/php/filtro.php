<?php

require('../../conexion.php');

$jsondata = array();

	$filtro = $_POST['buscando'];
    $sql = "SELECT COUNT(distinct id_imagen) as photos from tio_imagenes WHERE usuario like '$filtro'";

        $result = mysqli_query($con,$sql) or die('Consulta fallida: ' . mysql_error());
        $num_rows = $result->num_rows;
        $row = mysqli_fetch_assoc($result);

        if($result->num_rows > 0)
        {
		        $jsondata['resultados'] = $result->num_rows;
                $jsondata['mensaje_respuesta'] = "Se han encontrado ".$row['photos']." fotos del usuario ".$filtro;	              
        }
        else
        {
                $jsondata['resultados'] = 0;
                $jsondata['mensaje_respuesta'] = "No se han encontrado imagenes para el usuario " . $filtro;
        }

     $sql5 = "SELECT * FROM tio_imagenes WHERE usuario like '$filtro'";
     $result5 = mysqli_query($con,$sql5) or die('Consulta fallida: ' . mysql_error());
     $rowcount5 = $result5->num_rows;
     if($rowcount5 > 0)
     {
             //$row = $result->fetch_assoc();
             $jsondata['imagenes'] = array();
             while($row5 = mysqli_fetch_assoc($result5))
             {
                    $jsondata['imagenes'][] = $row5;
             }
     }
     else
     {
                $jsondata['resultados'] = 0;
                $jsondata['mensaje_respuesta'] = "No se han encontrado imagenes para el usuario " . $filtro;
                $jsondata['num_imagenes'] = 0;
     }

     $sql6 = "SELECT MIN(id_imagen) as id_minimo from tio_imagenes WHERE usuario like '$filtro'";

     $result6 = mysqli_query($con,$sql6) or die('Consulta fallida: ' . mysql_error());
     $num_rows6 = $result6->num_rows;
     $row6 = $result6->fetch_assoc();

     if($result6->num_rows > 0)
     {
             $jsondata['id_minimo'] = $row6['id_minimo'];
     }
     else
     {
             $jsondata['id_minimo'] = -1;
     }
     $sql7 = "SELECT MAX(id_imagen) as id_maximo from tio_imagenes WHERE usuario like '$filtro'";

     $result7 = $con->query($sql7);
     $num_rows7 = $result7->num_rows;
     $row7 = $result7->fetch_assoc();

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
