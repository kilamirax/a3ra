<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Documento sem título</title>
</head>

<body>
<?php
	include('banco.php');
	deletaGrupo($_POST['id']);
		
	header("Location: ../A3RA/grupoConsulta.php"); exit;
?>
</body>
</html>