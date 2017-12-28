<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>A3RA</title>
<link rel="stylesheet" href="css/screen.css" type="text/css" media="screen" title="default" />

<link rel="icon" href="images/shared/icone.jpg" type="image/x-icon" />
<link rel="shortcut icon" href="images/shared/icone.jpg" type="image/x-icon" />
<frameset rows="171,*" cols="*" framespacing="0" frameborder="no" border="0">
  <frame src="principalTop.php" name="topFrame" scrolling="No" noresize="noresize" id="topFrame" title="topFrame" />
  <frame src="principalMain.php" name="mainFrame" id="mainFrame" title="mainFrame" />
</frameset>
<noframes><body>
</body></noframes>

<?php

// A sessão precisa ser iniciada em cada página diferente
if (!isset($_SESSION)) session_start();

$_SESSION['loginCadastro'] = "principal";

/*controle de nivel.
Os niveis para o protótipo
nivel 0 - Administrador
nivel 1 - criador de projeto / criador de usuário / criador demarcadores / gerente de multimidia
nivel 2 - visualiza

*/
/*$nivel_necessario = 0;

// Verifica se não há a variável da sessão que identifica o usuário
if ($_SESSION['UsuarioNivel'] <= $nivel_necessario) {
	// Destrói a sessão por segurança
	session_destroy();
	// Redireciona o visitante de volta pro login
	//header("Location: login.php"); exit;
	
}else{
	header("Location: ../A3RA/principal.php"); exit;
}*/

?>

</html>
