<?php
	include('banco.php');
	echo $_POST['id'];
	deletaObjetos($_POST['id']);
		
	header("Location: ../A3RA/objetoConsulta.php"); exit;
?>
