<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sem título</title>
</head>

<body>
<?php
	include('banco.php');
	
/*	$dados = consultaArquivosCampos($_POST['nome'], $_POST['extensao']);
	$linha = mysql_fetch_assoc($dados);
		
	$id = $linha['idARQUIVOS']; 
	$endereco = $linha['endereco'];
	$nome = $linha['nome'];
	$idResponsavel = $linha['USUARIOS_idUSUARIOS']; 
*/
	
	
	// Script para deletar arquivos,  unlink -> função do php para deletar arquivo 
	$arquivo = $_POST['endereco'].$_POST['nome'];
	echo $arquivo;
	if (!unlink($arquivo)){
	  echo ("Erro ao deletar $arquivo");
	}else{
	  echo ("Deletado $arquivo com sucesso!");
	}
	deletaMidia($_POST['id']);
	header("Location: ../A3RA/midiaConsulta.php"); exit;
	
?>
</body>
</html>