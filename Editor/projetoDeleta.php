﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sem título</title>
</head>

<body>
<?php
	include('banco.php');

	deletaProjeto_Objetos($_POST['id']);
	deletaProjeto_Grupos($_POST['id']);
	deletaProjeto_Usuario($_POST['id']);
	deletaProjeto($_POST['id']);
	
    header("Location: ../A3RA/usuarioConsulta.php"); exit;
?>
</body>
</html>