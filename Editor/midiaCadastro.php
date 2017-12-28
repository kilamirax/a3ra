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

<div class="clear"></div>
<!--  start nav-outer -->
</div>
<!--  start nav-outer-repeat................................................... END -->
 
 <div class="clear"></div>
 
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>Cadastro de arquivos multimídia</h1></div>


<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
<tr>
	<th rowspan="3" class="sized"><img src="Template/images/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
	<th class="topleft"></th>
	<td id="tbl-border-top">&nbsp;</td>
	<th class="topright"></th>
	<th rowspan="3" class="sized"><img src="Template/images/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
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

        <div id="table-content">
              <table width="616" border="0" cellpadding="0" cellspacing="0">
                 <form method="post" action="midiaUpload.php" enctype="multipart/form-data">
                  <tr>
                    <th width="70" height="40">Arquivo</th>
                    <td width="280"><input type="file" name="arquivo" class="file_1"/></td>
                    <td width="266">
                        <div class="bubble-left"></div>
       					<div class="bubble-inner">qualquer arquivo multimídia</div>
        				<div class="bubble-right"></div>
                    </td>
                  </tr>
                  <tr>
                    <th height="42"></th>
                    <td><input type="submit"  class="form-submit" /></td>
                    <td></td>
                  </tr>
                </form>
                <tr>
                    <th></th>
                    <td>
                    <?php 
						//error_reporting(0); //desabilitar as irritantes mesnagens de warnning
					
						include('banco.php'); 	
						// A sessão precisa ser iniciada em cada página diferente
						if (!isset($_SESSION)) session_start();
						
						if(!isset($_SESSION['erroCadastroArquivo'])){
							$_SESSION['erroCadastroArquivo']="";
						}
						if(!isset($_SESSION['arquivoCadastro'])){
							$_SESSION['arquivoCadastro']="";
						}
						
						if($_SESSION['erroCadastroArquivo']=="Nome já existente"){
							mensagemVermelha("Arquivo com esse nome já existe no servidor."); 
							$_SESSION['erroCadastroArquivo']="";
						}
						if($_SESSION['erroCadastroArquivo']=="não foi possivel"){
							mensagemVermelha("Não foi possível enviar o arquivo, tente novamente");
							$_SESSION['erroCadastroArquivo']="";
						}
						if($_SESSION['arquivoCadastro']=="cadastrado"){
							mensagemVerde("Seu upload de arquivo foi realizado com sucesso.");
							$_SESSION['arquivoCadastro']="";
						}		
					?> 
                    </td>
                    <td></td>
                 </tr>
              </table>
        
	<!-- end id-form  -->

	</td>
	<td>
	
	<!--  start related-activities -->
	<div id="related-activities">
		<!--  start related-act-top -->
		<div id="related-act-top">
		<img src="images/forms/header_related_act.gif" width="271" height="43" alt="" />
		</div>
		<!-- end related-act-top -->
		<!--  start related-act-bottom -->
		<div id="related-act-bottom">
			<!--  start related-act-inner -->
			<div id="related-act-inner">
			
				<?php 					
					informa ("voltar", "Upload de Arquivos","Preocauções" ,array(
						"Os arquivos no protótipo devem ter no max 2MB",
						"Evite caracteres dirente das letras do alfabeto e numeros no nome do arquivo"
						));
				?> 

			</div>
			<!-- end related-act-inner -->
			<div class="clear"></div>
		</div>
		<!-- end related-act-bottom -->
	</div>
	<!-- end related-activities -->

</td>
</tr>
<tr>
<td><img src="Template/images/shared/blank.gif" width="695" height="1" alt="blank" /></td>
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
  <div class="clear">&nbsp;3</div>
</div>
<!-- end footer -->

</body>
</html>