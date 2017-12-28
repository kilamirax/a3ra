<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>A3RA</title>
<link rel="stylesheet" href="css/screen.css" type="text/css" media="screen" title="default" />
<link rel="icon" href="images/shared/icone.jpg" type="image/x-icon" />
<link rel="shortcut icon" href="images/shared/icone.jpg" type="image/x-icon" />

</head>
<body>

<!-- Start: page-top-outer -->
<div id="page-top-outer"> 
  
  <!-- Start: page-top -->
  <div id="page-top"> 
    <table width="100%" height="91" border="0">
  <tr>
    <td width="24%" height="10" >&nbsp;</td>
    <td width="46%" >&nbsp;</td>
    <td width="28%" >&nbsp;</td>
    <td width="2%" >&nbsp;</td>
  </tr>
  <tr>
    <td height="46" valign="middle">
    	<a href="PrincipalMain.php" target="mainFrame"><img src="images/shared/logo.png" width="156" height="40" alt=""/></a>
    </td>
    <td>&nbsp;</td>
    <td align="right"><img src="images/shared/James Warlock lado nome100x51.png" alt="" width="100" height="52" /></td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="21">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">
      <p class="frase">
        <?php
		if (!isset($_SESSION)) session_start();		
		echo "Olá ".$_SESSION['UsuarioNome'];
				
	?>
        </p> 
    </td>
    </tr>
</table>
    <!-- start logo -->
   <!-- <div id="logo"><a href="PrincipalMain.php" target="mainFrame"></a></div>-->
    <!-- end logo -->

    
  </div>
  <!-- End: page-top --> 
  
</div>
<!-- End: page-top-outer -->

<div class="clear">&nbsp;</div>

<!--  start nav-outer-repeat................................................................................................. START -->
<div class="nav-outer-repeat">
<!--  start nav-outer -->
<div class="nav-outer">

<!-- start nav-right -->
<div id="nav-right">
  <div class="nav-divider">&nbsp;</div>
  <div class="showhide-account"><img src="images/shared/nav/nav_myaccount.gif" width="93" height="14" alt="" /></div>
  <div class="nav-divider">&nbsp;</div>
  <a href="logout.php" id="logout" target="_parent"><img src="images/shared/nav/nav_logout.gif" width="64" height="14" alt="" /></a>
  <div class="clear">&nbsp;</div>
</div>
<!-- end nav-right --> 

<!--  start nav -->
<div class="nav">
  <div class="table">
    <ul class="select">
      <li> <a href="#nogo"><b>Usuários</b><!--[if IE 7]><!--></a><!--<![endif]--> 
        <!--[if lte IE 6]><table><tr><td><![endif]-->
        <div class="select_sub">
          <ul class="sub">
            <li><a href="usuarioCadastro.php" target="mainFrame">Cadastro de Usuário</a></li>
            <li><a href="usuarioConsulta.php" target="mainFrame">Consulta\Controla Usuário</a></li>
            <li><a href="grupoCadastro.php" target="mainFrame">Cadastro de Grupos</a></li>
            <li><a href="grupoConsulta.php" target="mainFrame">Consulta\Controla Grupos</a></li>
          </ul>
        </div>
        <!--[if lte IE 6]></td></tr></table></a><![endif]--> 
      </li>
    </ul>
    
    <div class="nav-divider">&nbsp;</div>
    
    <ul class="select">
      <li><a href="#nogo"><b>Multimídia</b><!--[if IE 7]><!--></a><!--<![endif]--> 
        <!--[if lte IE 6]><table><tr><td><![endif]-->
        <div class="select_sub">
          <ul class="sub">
            <li><a href="midiaCadastro.php" target="mainFrame">Cadastra arquivo</a></li>
            <li><a href="midiaConsulta.php" target="mainFrame">Controla arquivo</a></li>
            <li><a href="marcadorCadastro.php" target="mainFrame">Cadastra marcadores</a></li>
            <li><a href="marcadorConsulta.php" target="mainFrame">Controla marcadores</a></li>
            <li><a href="gpsCadastro.php" target="mainFrame">Cadastra Geo-posicionamento</a></li>
            <li><a href="gpsConsulta.php" target="mainFrame">Controla Geo-posicionamento</a></li>
          </ul>
        </div>
        <!--[if lte IE 6]></td></tr></table></a><![endif]--> 
      </li>
    </ul>
    
    <div class="nav-divider">&nbsp;</div>
    
    <ul class="select">
      <li><a href="#nogo"><b>Objetos</b><!--[if IE 7]><!--></a><!--<![endif]--> 
        <!--[if lte IE 6]><table><tr><td><![endif]-->
        <div class="select_sub">
          <ul class="sub">
            <li><a href="">&nbsp;</a></li>
            <li><a href="">&nbsp;</a></li>
            <li><a href="">&nbsp;</a></li>
            <li><a href="">&nbsp;</a></li>
            <li><a href="">&nbsp;</a></li>
            <li><a href="">&nbsp;</a></li>
            <li><a href="">&nbsp;</a></li>
            <li><a href="">&nbsp;</a></li>
            <li><a href="">&nbsp;</a></li>
            <li><a href="objetoCadastro.php" target="mainFrame">Cadastra Objeto</a></li>
            <li><a href="objetoConsulta.php" target="mainFrame">Controla Objeto</a></li>
          </ul>
        </div>
        <!--[if lte IE 6]></td></tr></table></a><![endif]--> 
      </li>
    </ul>
    
    <div class="nav-divider">&nbsp;</div>

	<ul class="select">
      <li><a href="#nogo"><b>Projetos</b><!--[if IE 7]><!--></a><!--<![endif]--> 
        <!--[if lte IE 6]><table><tr><td><![endif]-->
        <div class="select_sub">
          <ul class="sub">
		    <li><a href="">&nbsp;</a></li>
            <li><a href="">&nbsp;</a></li>
          	<li><a href="">&nbsp;</a></li>
            <li><a href="">&nbsp;</a></li>
            <li><a href="">&nbsp;</a></li>
            <li><a href="">&nbsp;</a></li>
            <li><a href="">&nbsp;</a></li>
            <li><a href="">&nbsp;</a></li>
            <li><a href="">&nbsp;</a></li>
            <li><a href="">&nbsp;</a></li>
            <li><a href="">&nbsp;</a></li>
            <li><a href="">&nbsp;</a></li>
            <li><a href="">&nbsp;</a></li>
            <li><a href="projetoCadastro.php" target="mainFrame">Cadastra Projetos</a></li>
            <li><a href="projetoConsulta.php" target="mainFrame">Consulta\Controla Projetos</a></li>
			<li><a href="feedbackConsulta.php" target="mainFrame">Consulta Feedback Projetos</a></li>
          </ul>
        </div>
        <!--[if lte IE 6]></td></tr></table></a><![endif]--> 
      </li>
    </ul>
    
    <div class="nav-divider">&nbsp;</div> 
	
    <ul class="select">
      <li><a href="#nogo"><b>Eventos</b><!--[if IE 7]><!--></a><!--<![endif]--> 
        <!--[if lte IE 6]><table><tr><td><![endif]-->
        <div class="select_sub">
          <ul class="sub">
		    <li><a href="">&nbsp;</a></li>
            <li><a href="">&nbsp;</a></li>
            <li><a href="">&nbsp;</a></li>
            <li><a href="">&nbsp;</a></li>
            <li><a href="">&nbsp;</a></li>
            <li><a href="">&nbsp;</a></li>
            <li><a href="">&nbsp;</a></li>
            <li><a href="">&nbsp;</a></li>
            <li><a href="">&nbsp;</a></li>
            <li><a href="">&nbsp;</a></li>
            <li><a href="">&nbsp;</a></li>
            <li><a href="">&nbsp;</a></li>
            <li><a href="">&nbsp;</a></li>
            <li><a href="">&nbsp;</a></li>
            <li><a href="">&nbsp;</a></li>
            <li><a href="">&nbsp;</a></li>
            <li><a href="eventos.php" target="mainFrame">Gerenciamento de Eventos</a></li>
			<li><a href="acoesConsulta.php" target="mainFrame">Consulta Ações</a></li>
			<li><a href="indicesConsulta.php" target="mainFrame">Consulta Índices</a></li>
          </ul>
        </div>
        <!--[if lte IE 6]></td></tr></table></a><![endif]--> 
      </li>
    </ul>
    
    <div class="nav-divider">&nbsp;</div>
    
    <ul class="select">
      <li><a href="informa.php" target="mainFrame"><b>Informações</b><!--[if IE 7]><!--></a><!--<![endif]--> 
      </li>
    </ul>
    
    <div class="clear"></div>
  </div>
  <div class="clear"></div>
</div>
<!--  start nav -->
</body>
</html>