<?php

session_start();
session_unset();
session_destroy();
//unset($_COOKIE['Usuario_actual']);
//session_unregister($_COOKIE['Usuario_actual']);
//setcookie("Usuario_actual"," ",time()-3600);
header("Location: ../inicio_sesion/index.php");
?>
