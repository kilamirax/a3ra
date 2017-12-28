<?php
ob_start();
include('banco.php');
if (!isset($_SESSION)) session_start();

$_SESSION['UsuarioID'] = "";
$_SESSION['UsuarioNome'] = "";
$_SESSION['UsuarioNivel'] = "";

$servidor = servidor();

// Verifica se houve POST e se o usuário ou a senha é(são) vazio(s)
if (empty($_POST['usuario']) OR empty($_POST['senha'])) {
	$_SESSION['login'] = "faltaDados";
	header("Location: ../A3RA/login.php"); exit;
	//echo '<script>location.href="http://localhost/GoDaddy/A3RA/login.php";<script>';
}else{
	try {
		$conn = getConn();
		$query = "SELECT * FROM USUARIOS WHERE (usuario='".$_POST['usuario']."' and senha='".$_POST['senha']."')";
		$stmt = getConn()->query($query);
		$dados = $stmt->fetchAll();
		
		if (sizeof($dados)!= 1) {
			$_SESSION['login'] = "invalido";
			header("Location: ../A3RA/login.php"); exit();
		}else{
			foreach($dados as $resultado){
				$_SESSION['UsuarioID'] = $resultado['idUSUARIOS'];
				$_SESSION['UsuarioNome'] = $resultado['nome'];
				$_SESSION['UsuarioNivel'] = $resultado['nivel'];
				echo $_SESSION['UsuarioNome'];
			}
			// Redireciona o visitante
			header("Location: ../A3RA/principal.php"); exit();
		}
	}catch(PDOException $e){
		echo "Error: " . $e->getMessage();
		$_SESSION['login'] = "invalido";
		header("Location: ../A3RA/login.php"); exit();
	}
	closeConn();
}
	ob_end_flush();
?>