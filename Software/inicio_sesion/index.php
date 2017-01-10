<?php
session_start();
/*if(isset($_COOKIE['Usuario_actual']) == true)
{
      header("location: ../inicio_filtro.php");
}*/
/*if(isset($_SESSION['user']) == true)
{
      header("location: ../inicio_filtro.php");
}*/
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="assets/img/favicon.png">

    <title>Myphoto</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/bootstrap-theme.css" rel="stylesheet">

    <!-- siimple style -->
    <link href="css/style.css" rel="stylesheet">
    
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script type="text/javascript" src="js/index.js"></script>
  </head>

  <body>
    <!-- Fixed navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Myphoto</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><button id="form_inicio" name="form_inicio" type="submit" style="margin-top:8px;display:none;" class="btn btn-theme">Iniciar sesión</button></li>
	    <li><button id="form_registro" name="form_registro" type="submit" style="margin-top:8px;" class="btn btn-theme">Registrarme</button></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

	<div id="header">
		<div class="container">
			<div class="row">
                                <div class="col-lg-6" style="display:none" id="formulario_registro">
					<h1 style="color:black;margin-top:-20px;">Formulario de registro</h1>
                                        <h2 class="subtitle" style="color:black">Introduce tus datos de usuario</h2>

                                        <form role="form" action="" method="POST">
                                                <div class="form-group">
                                                <label for="nombre">Nombre:</label>
                                                <input type="text" class="form-control" name="nombre_registro" id="nombre_registro" placeholder=""></input>
                                                </div>
                                                <div class="form-group">
                                                <label for="apellidos">Apellidos:</label>
                                                <input type="text" class="form-control" name="apellidos_registro" id="apellidos_registro" placeholder="">
                                                </div>
                                                <div class="form-group">
                                                <label for="usuario">Usuario:</label>
                                                <input type="text" class="form-control" name="user" id="usuario_registro" placeholder="">
                                                </div>
                                                <div class="form-group">
                                                <label for="password">Password:</label>
                                                <input type="password" class="form-control" name="pass" id="password_registro" placeholder="">
                                                </div>
                                                <div class="form-group">
                                                <label for="apellidos">Confirmar password:</label>
                                                <input type="password" class="form-control" id="confirmar_password_registro" placeholder="">
                                                </div>
                                                <div class="form-group">
                                                <label for="email">Email:</label>
                                                <input type="email" class="form-control" name="email_registro" id="email_registro" placeholder="">
                                                </div>
						<div class="form-group">
                                                <label for="email">Descripción:</label>
                                                <textarea id="descripcion" rows="5" cols="67" placeholder="" name="descripcion"></textarea>
						</div>
                                                <button style="margin-bottom:20px;" id="registro" type="submit" class="btn btn-theme pull-right">Enviar</button>
						</form>
						<div id="mensaje_respuesta_registro"></div>

                                </div>
				<div class="col-lg-6" id="inicio_sesion">
					<h1 style="color:black">Inicio de sesión</h1>
					<h2 class="subtitle" style="color:black">Introduce tus datos de usuario</h2>
					<form class="form-inline signup" role="form"  method="POST" action="">
					  <div class="form-group">
					    <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Usuario">
                        <input type="password" class="form-control" name="contrasenia" id="contrasenia" placeholder="Contraseña">
					  </div>
					  <button id="login" type="submit" class="btn btn-theme">Inicia sesión</button>
				</form>					
				<div id="mensaje_respuesta"></div>
				</div>
			
				<div class="col-lg-5 col-lg-offset-1">
					<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
					  <ol class="carousel-indicators">
						<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
						<li data-target="#carousel-example-generic" data-slide-to="1"></li>
						<li data-target="#carousel-example-generic" data-slide-to="2"></li>
					  </ol>					
					  <!-- slides -->
					  <div class="carousel-inner">
						<div class="item active">
						  <img src="images/gps.jpg" style="width:100%;height:400px;" alt="">
						</div>
						<div class="item">
						  <img src="images/mapa2.jpg" style="width:100%;height:400px;" alt="">
						</div>
						<div class="item">
						  <img src="images/mapa3.jpg" style="width:100%;height:400px;" alt="">
						</div>
					  </div>
					</div>		
				</div>
				
			</div>
		</div>
	</div>

    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
