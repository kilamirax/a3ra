<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>A3RA</title>
<link rel="stylesheet" href="css/screen.css" type="text/css" media="screen" title="default">

<link rel="icon" href="images/shared/icone.jpg" type="image/x-icon">
<link rel="shortcut icon" href="images/shared/icone.jpg" type="image/x-icon">

<style type="text/css">
#apDiv1 {
	position:absolute;
	left:521px;
	top:466px;
	width:139px;
	height:80px;
	z-index:1;
}
#apDiv2 {
	position:absolute;
	left:364px;
	top:157px;
	width:140px;
	height:56px;
	z-index:1;
}
#login-bg #login-holder #loginbox #login-inner form table tr td a {
	font-weight: bold;
}
#login-bg #login-holder #loginbox #login-inner form table tr th a {
	text-align: right;
}
</style>
</head>
<body link="#161616" vlink="#161616" alink="#161616" id="login-bg">
<div id="login-holder">
  <div id="logo-login">
   <table width="491" border="0" cellpadding="0" cellspacing="0" >
      <tr>
        <td width="206">&nbsp;</td>
        <td width="285">&nbsp;</td>
      </tr width="100%">
       <tr>
        <td>
        </td>
        <td></td>
      </tr>
   <tr>
        <td>
        <a href="../A3RA/loginValidacao.php"><img src="images/shared/logo.png" alt="" width="199" height="54"></a>
        </td>
        <td><a href="jameswarlock.com.br/"><img src="images/shared/James Warlock lado nome156x80.png" alt="" width="156" height="80" align="right"></a></td>
      </tr>
   </table>
  </div>
  <div class="clear"></div>
  <div id="loginbox">
    <div id="login-inner">
      <form action="../A3RA/loginValidacao.php" method="post">
        <table width="340" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <th width="133"><label for="txUsuario">Usuário</label></th>
            <td width="207"><input type="text" name="usuario" id="txUsuario" class="login-inp"></td>
          </tr>
          <tr>
            <th><label for="txSenha">Senha</label></th>
            <td><input type="password" name="senha" id="txSenha" class="login-inp"></td>
          </tr>
          <tr>
            <th></th>
            <td><input type="hidden" name="login" id="login" class="login-inp"></td>
          </tr>
          <tr>
            <th></th>
            <td><input type="submit"  class="submit-login"></td>
          </tr>
          <tr>
            <th>  <a href="" >Novo usuário?</a> 
			</th>
             <td> <a href="#"> Esqueceu a senha?</a></td>
          </tr>
        </table>
      </form>
      <table width="311">
          <tr>
            
          </tr>
        </table>
    </div>
    <div class="clear"></div>
  </div>

  <blockquote>&nbsp;	</blockquote>
</div>
    <div id="login-erro">
	<?php
	include('mensagens.php');
	// Se a sessão não existir, inicia uma
	if (!isset($_SESSION)) session_start();
	
	$_SESSION['loginCadastro'] = "cadastro no login";
	$_SESSION['erroCadastro']="" ;

	if (isset($_SESSION['login'])) {
		if ($_SESSION['login'] == "invalido") {
			mensagemVermelha("Login inválido.");
			$_SESSION['login'] ="";
		}
		if ($_SESSION['login'] == "faltaDados") {
			mensagemVermelha("Usuário ou senha sem informação.");
			$_SESSION['login'] ="";
		}
	}
	
	
    ?>
    </div>
</body>
//no final da pagina
<?php
ob_end_flush();
?>
</html>