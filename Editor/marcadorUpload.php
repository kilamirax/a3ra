<?php	
	require_once 'HTTP/Request2.php';
	require_once '/vuforiaweb/SignatureBuilder.php';
	include('banco.php');
	require_once '/vuforiaweb/PostNewTarget.php';
	
	// A sessão precisa ser iniciada em cada página diferente
	if (!isset($_SESSION)) session_start();

	$_UP['pasta'] = 'C:/wamp64/www/A3RA/vuforiaweb/';
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
	  die("Não foi possível fazer o upload, erro:" . $_UP['erros'][$_FILES['arquivo']['error']]);
	  exit; // Para a execução do script
	}
	
	// Faz a verificação do tamanho do arquivo
	if ($_UP['tamanho'] < $_FILES['arquivo']['size']) {
	  echo "O arquivo enviado é muito grande, envie arquivos de até 2Mb.";
	  exit;
	}
	
	//consulta marcadores já existentes
	$dados =  consultaMarcadoresCampos("", $_FILES['arquivo']['name'], "", "");
	
	if (sizeof($dados) >= 1) {
		$_SESSION['mensagemCadastroMarcador']="não foi possivel cadastrar o marcador";
		header("Location: ../A3RA/marcadorCadastro.php"); exit;
	} else {
		$targetName = $_FILES['arquivo']['name'];
		$imageLocation = $_UP['pasta'] . $targetName;
		
		//move o arquivo para o servidor local primeiro
		if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta'] . $targetName)) {
			//cria espaço no server vulforia e leva a imagem para lá
			$instance = new PostNewTarget();
			$instance->postaMarcador($imageLocation, $targetName);
			
			//coleta o targetId criado no server vuforia
			$targetID = $instance->targetIdCriado();
			
			//cadastra no banco o marcador criado no server vulforia
			cadastraMarcadores($targetName, $targetID, $_FILES['arquivo']['size'],"320",$_SESSION['UsuarioID']);	
		}
		$_SESSION['mensagemCadastroMarcador']="foi";
        header("Location: ../A3RA/marcadorCadastro.php"); exit;
	}

?>

</body>
</html>