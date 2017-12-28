<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>A3RA</title>
<link rel="stylesheet" href="css/screen.css" type="text/css" media="screen" title="default">
<link rel="icon" href="images/shared/icone.jpg" type="image/x-icon">
<link rel="shortcut icon" href="images/shared/icone.jpg" type="image/x-icon">
</head>
<body>

<div class="clear"></div>
<!--  start nav-outer -->
</div>
<!--  start nav-outer-repeat................................................... END -->
 
 <div class="clear"></div>
 
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>Cadastro de Grupos</h1></div>

<?php	
	error_reporting(0); //desabilitar as irritantes mesnagens de warnning
	include('banco.php');
	
	// Se a sessão não existir, inicia uma
	if (!isset($_SESSION)) session_start();
				
	if(!empty($_POST)){
		if (empty($_POST['nome']) OR empty($_POST['nivel'])) {
			mensagemVermelha("Há campos em branco que precisam ser preenchidos."); 
		}else{ 
			cadastraGrupos($_POST['nome'], $_POST['nivel']);
		}
	}

	if(!isset($_SESSION['erroCadastro'])){
		$_SESSION['erroCadastro']="";
	}					
	if($_SESSION['erroCadastro']=="Grupo já existente" ){
		mensagemVermelha("erroCadastro"); 
		$_SESSION['erroCadastro']="";
	}

?>

<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
<tr>
	<th rowspan="3" class="sized"><img src="Template/images/shared/side_shadowleft.jpg" width="20" height="300" alt=""></th>
	<th class="topleft"></th>
	<td id="tbl-border-top">&nbsp;</td>
	<th class="topright"></th>
	<th rowspan="3" class="sized"><img src="Template/images/shared/side_shadowright.jpg" width="20" height="300" alt=""></th>
</tr>
<tr>
	<td id="tbl-border-left"></td>
	<td>
	<!--  start content-table-inner -->
	<div id="content-table-inner">
	
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
	<td>
	
	<!-- start id-form -->
		
       <table width="340" border="0" cellpadding="0" cellspacing="0">
             <form action="../A3RA/grupoCadastro.php" method="post">
                <tr>
                  <th valign="middle">Nome:</th>
                  <td><input type="text" name="nome" id="nome" class="inp-form" maxlength="100"></td>
                  <td></td>
                </tr>
                <tr>
                  <th valign="middle">Nível:</th>
                  <td><input type="text" name="nivel" id="nivel" class="inp-form" maxlength="1"></td>
                  <td></td>
                </tr>
                <tr>
                  <th></th>
                  <td><input type="submit"  class="form-cadastrar"><input type="reset"  class="form-reset"></td>
                  <td></td>
                </tr>
                </form>
                 <tr height="30">
                  <th></th>
                  <td>
                  </td>
                  <td>
                  </td>
                </tr>
              </table> 
        
	<!-- end id-form  -->

	</td>
	<td>
	
 
	<div id="related-activities">
		<div id="related-act-top">
		<img src="images/forms/header_related_act.gif" width="271" height="43" alt="">
		</div>
		<div id="related-act-bottom">
			<div id="related-act-inner">
			
				<?php 
					informa ("voltar", "Cadastro","Preocauções" ,array(
						"Nome: Nome do grupo em questão. Essa informação será usada em todo o sistema para identificação do grupo.",
						"Nível: O nível de acesso é usados para liberar funcionalidades no sistema autoral e no sistema cliente, delegação de funçoes internas. O professor com acesso de administrador no projeto pode delegar um acesso de administrador para um certo aluno enquanto os outros são de somente leitura. "
						));
				?> 

			</div>
			<div class="clear"></div>
		</div>
	</div>
	<!-- end related-activities -->

</td>
</tr>
<tr>
<td><img src="Template/images/shared/blank.gif" width="695" height="1" alt="blank"></td>
<td></td>
</tr>
</table>
 
<div class="clear"></div>
 

</div>
				
				

<!--  end content-table-inner  -->
</td>
<td id="tbl-border-right"></td>
</tr>
<tr>
	<th class="sized bottomleft"></th>
	<td id="tbl-border-bottom">&nbsp;</td>
	<th class="sized bottomright"></th>
</tr>
</table>









 





<div class="clear">&nbsp;</div>

</div>
<!--  end content -->
<div class="clear">&nbsp;</div>
</div>
<!--  end content-outer........................................................END -->

<div class="clear">&nbsp;</div>

<!-- start footer -->
<div id="footer"> 
  <!--  start footer-left -->
  <div id="footer-left"> Thiago Zamborlini Fraga &copy; Copyright James Warlock. <span id="spanYear"></span> <a href="">www.jameswarlock.com.br</a>. Todos direitos reservados.</div>
  <!--  end footer-left -->
  <div class="clear">&nbsp;</div>
</div>
<!-- end footer -->

</body>
</html>