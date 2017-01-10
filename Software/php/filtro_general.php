<?php

require('../../conexion.php');

$jsondata = array();

    $filtro_ = $_POST['buscando'];
    //$filtro_ = 'lapas';
    $filtro = strtolower($filtro_);
    $sql = "SELECT * from tio_imagenes";

    	$result = mysqli_query($con,$sql) or die('Consulta fallida: ' . mysql_error());
        $num_rows = $result->num_rows;

        if($result->num_rows > 0)
        {
        $jsondata['probando'] = "prob";
		$jsondata['imagenes'] = array();
		$jsondata['id'] = array();
		$count = 0;
		$control = false;
        while($row = $result->fetch_array())
		{
			$string = strtolower($row['titulo_imagen']) . " " . strtolower($row['descripcion_imagen']);
			$token = strtok($string," ");
			
			while($token !== false)
			{
				if(strcmp($token, $filtro) == 0)
				{
                                    $jsondata['imagenes'][] = $row;
									$jsondata['id'][] = $row['id_imagen'];
                                    $count += 1;    
                                    $control = true;                         	
                                    break;	
				}
				else
				{
                                        $token = strtok(" ");
				}
			}
		}  
			if($control == true)
			{
				$jsondata['resultados'] = $count;
		   		$jsondata['id_minimo'] = min($jsondata['id']);
				$jsondata['id_maximo'] = max($jsondata['id']);
			}
			else
			{
				$jsondata['resultados'] = 0;
				$jsondata['mensaje_respuesta'] = "No se han encontrado resultados";
			}
        }
	else
        {
			$jsondata['mensaje_respuesta'] = "No se han encontrado resultados";
            $jsondata['resultados'] = 0;
        }

$jsondata['error'] = error_get_last();
header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);

?>
