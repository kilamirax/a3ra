<?php
	error_reporting(0); //desabilitar as irritantes mesnagens de warnning				
	include('banco.php');
	
	// A sessão precisa ser iniciada em cada página diferente
	if (!isset($_SESSION)) session_start();
	//para poder trabalhar vamos marretar o id
	if(!isset($_SESSION['UsuarioID'])){
		echo "não tem usuário";
		//$_SESSION['UsuarioID'] = "1";
	}

	$_UP['pasta'] = 'multimidia/';
  	$_UP['renomeia'] = true;
	$_UP['tamanho'] = 1024 * 1024 * 2; // 2Mb
	// Array com os tipos de erros de upload do PHP
	$_UP['erros'][0] = 'Não houve erro';
	$_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
	$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
	$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
	$_UP['erros'][4] = 'Não foi feito o upload do arquivo';
	
	// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
	if ($_FILES['arquivo']['error'] != 0) {
	  die("Não foi possível fazer o upload, erro: " . $_UP['erros'][$_FILES['arquivo']['error']]);
	  echo "<br><form action=\"../A3RA/midiaCadastro.php\" method=\"post\">";
	  echo "	<input type=\"submit\"  class=\"form-voltar\" />";
	  echo "</form>";
	  exit; // Para a execução do script
	}
	
	// Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar
	// Primeiro verifica se deve trocar o nome do arquivo
	if ($_UP['renomeia'] == true) {
	  $frase = $_FILES['arquivo']['name'];
	  //$nome_final = str_replace(" ", "_", $frase);	  
	  $nome_final = $frase;	  
	} else {
	  // Mantém o nome original do arquivo
	  $nome_final = $_FILES['arquivo']['name'];
	}
/*
	// Faz a verificação do tamanho do arquivo
	if ($_UP['tamanho'] < $_FILES['arquivo']['size']) {
	  echo "O arquivo enviado é muito grande, envie arquivos de até 2Mb.<BR><BR>";
	  echo "<form action=\"../A3RA/midiaCadastro.php\" method=\"post\">";
	  echo "	<input type=\"submit\"  class=\"form-voltar\" />";
	  echo "</form>";
	  exit;
	}
*/
	$dados = consultaArquivosCampos("",$frase, "","");
	foreach($dados as $linha) {
		$achei = $linha;
	}
	if($achei['nome'] == $frase){
		mensagemVermelha("O arquivo já existe.");
		$_SESSION['erroCadastroArquivo']=="Nome já existente";
		header("Location: ../A3RA/midiaCadastro.php"); exit;
	}else{
	
		 //O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
		if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta'] . $nome_final)) {
		  echo "Upload efetuado com sucesso!";
		  
		  $extensao= strtolower(end(explode('.',$_FILES['arquivo']['name'])));
		  cadastraArquivo($_FILES['arquivo']['name'], $_UP['pasta'], $extensao, $_FILES['arquivo']['size'] ,$_SESSION['UsuarioID']);
		  
		 header("Location: ../A3RA/midiaCadastro.php"); exit;
		} else {
		  $_SESSION['erroCadastroArquivo']=="não foi possivel";
		}
	}
?>

</body>
</html>