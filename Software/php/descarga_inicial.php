<?php
require('../../conexion.php');
session_start();     
     $jsondata = array();
     
     //$jsondata['usuario_actual'] = $_COOKIE["Usuario_actual"]; 
     $jsondata['user'] = $_SESSION['user'];
     $sql = "SELECT COUNT(user) as users from tio_usuarios";
 
     $result = mysqli_query($con,$sql) or die('Consulta fallida: ' . mysql_error());
     $num_rows = $result->num_rows;
     $row = mysqli_fetch_assoc($result);

     if($result->num_rows > 0)
     {
          $jsondata['numero_cliente'] = $row['users']." usuarios";
     }
     else
     {
          $jsondata['numero_cliente'] = 0;
     }

     $sql2 = "SELECT COUNT(distinct id_imagen) as photos from tio_imagenes";

     $result2 = mysqli_query($con,$sql2) or die('Consulta fallida: ' . mysql_error());
     $num_rows2 = $result2->num_rows;
     $row2 = mysqli_fetch_assoc($result2);

     if($result2->num_rows > 0)
     {
            $jsondata['numero_fotos'] = $row2['photos']." imagenes";
     }
     else
     {
             $jsondata['numero_fotos'] = 0;
     }

     $sql3 = "select count(id_imagen) as cuenta from tio_imagenes where (latitud_imagen <> 0) AND (longitud_imagen <> 0)";

     $result3 = mysqli_query($con,$sql3) or die('Consulta fallida: ' . mysql_error());
     $num_rows3 = $result3->num_rows;
     $row3 = mysqli_fetch_assoc($result3);

     if($result3->num_rows > 0)
     {
             $jsondata['numero_loc'] = $row3['cuenta']." localizaciones";
     }
     else
     {
             $jsondata['numero_loc'] = 0;
     }

    // $user = $_COOKIE["Usuario_actual"];
    $user = $_SESSION['user'];
     $sql4 = "select * from tio_usuarios where user = '$user'";

     $result4 = mysqli_query($con,$sql4) or die('Consulta fallida: ' . mysql_error());
     $num_rows4 = $result4->num_rows;
     $row4 = mysqli_fetch_assoc($result4);

     if($result4->num_rows > 0)
     {
             $jsondata['user_perfil'] = $row4['user'];
             $jsondata['nombre_perfil'] = $row4['nombre_usuario'];
             $jsondata['apellidos_perfil'] = $row4['apellidos_usuario'];
             $jsondata['email_perfil'] = $row4['correo_usuario'];
             $jsondata['descripcion_perfil'] = $row4['detalles'];
             $jsondata['password_perfil'] = $row4['password_usuario'];
     }
     else
     {
             $jsondata['success'] = "Fallo durante la seleccion del usuario";
     }

     $sql6 = "SELECT MIN(id_imagen) as id_minimo from tio_imagenes";
 
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
     $sql7 = "SELECT MAX(id_imagen) as id_maximo from tio_imagenes";

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

     $sql5 = "SELECT * FROM TIO_IMAGENES";
     $result5 = mysqli_query($con,$sql5) or die('Consulta fallida: ' . mysql_error());
     $rowcount5 = $result5->num_rows;
     if($result5->num_rows > 0)
     {
             //$row = $result->fetch_assoc();
	     $jsondata['num_imagenes'] = $result5->num_rows;
	     $jsondata['imagenes'] = array();
	     while($row5 = $result5->fetch_array())
	     {	     
		      $jsondata['imagenes'][] = $row5;   
	     }
     }
     else
     {
	    $jsondata['mensaje_respuesta'] = "No se han encontrado imagenes";
        $jsondata['num_imagenes'] = 0;
     }

     $sql10= "SELECT DISTINCT categoria FROM tio_imagenes";
     $result10 = mysqli_query($con,$sql10) or die('Consulta fallida: ' . mysql_error());
     $rowcount10 = $result10->num_rows;
     if($result10->num_rows > 0)
     {
             //$row = $result->fetch_assoc();
             $jsondata['num_categorias'] = $rowcount10;
             $jsondata['categoria'] = array();
             while($row10 = $result10->fetch_array())
             {
                $jsondata['categoria'][] = $row10;
             }
     }
     else
     {
             $jsondata['num_categorias'] = 0;
     }
  	 
    $jsondata['error'] = error_get_last();
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($jsondata, JSON_FORCE_OBJECT);
?>