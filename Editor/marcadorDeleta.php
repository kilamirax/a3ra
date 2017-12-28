<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
<?php
	require_once 'HTTP/Request2.php';
	require_once '/vuforiaweb/SignatureBuilder.php';
	include('banco.php');
	require_once '/vuforiaweb/DeleteTarget.php';
	
	$instance = new DeleteTarget();
	$instance->deletaTarget($_POST['targetID']);
	
	deletaMarcadores($_POST['id']);
	
	// Script para deletar arquivos,  unlink -> função do php para deletar arquivo 
	if (!unlink('C:/wamp64/www/A3RA/vuforiaweb/' . $_POST['nome'])){
		$_SESSION['mensagemCadastroMarcador']="Erro ao deletar arquivo";
	}else{
	  echo ("Deletado $arquivo com sucesso!");
	}
	header("Location: ../A3RA/marcadorConsulta.php"); exit;
	
?>
</body>
</html>