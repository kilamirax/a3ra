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


<div id="page-heading"><h1>Cadastro de objeto</h1></div>


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
    
    <script type="text/javascript" >
		window.onload = function(){
			document.getElementById('opcoesMarc').style.display = "none"; 
			document.getElementById('opcoesGeo').style.display = "none"; 
			document.getElementById('opcoesArquivo').style.display = "none";
		}
	</script>
    
	<?php
    	//error_reporting(0); //desabilitar as irritantes mesnagens de warnning
		include('banco.php');
		// A sessão precisa ser iniciada em cada página diferente
		if (!isset($_SESSION)) session_start();
    ?>
    
	<!-- start id-form -->
		
       <table width="340" border="0" cellpadding="0" cellspacing="0">
             <form action="../A3RA/objetoCadastro.php" method="post">
                <tr>
                  <th valign="top">Nome:</th>
                  <td><input type="text" name="nome" id="txNome" class="inp-form" maxlength="100"></td>
                  <td></td>
                </tr>
                <tr>
                  <th valign="top">Descrição:</th>
                  <td><textarea rows="" cols="" name="obs" id="obs"  maxlength="1000" class="form-textarea"></textarea></td>
                  <td></td>
                </tr>
                
                <tr>
                  <th valign="top">Tipo:</th>
                  <td>
                  		<table width="376" height="97" border="0" >
							<tr>
                            	<td width="31"><input type="checkbox" name="marcador" id="marcador" class="ui-checkbox" onChange="habilitarMarc()">
                                <td width="153">Marcador de imagem</td>
                                <td width="178">
                                <script>
									function  habilitarMarc(){
										if(document.getElementById('marcador').checked){
											document.getElementById('opcoesMarc').style.display = "inline"; 
										}else{
											document.getElementById('opcoesMarc').style.display = "none"; 
										}
									}
								</script>
                                 <select name="opcoesMarc" id="opcoesMarc" class="styledselect_form_1">
									 <?php	
										$dados = consultaMarcadoresCampos("", "", "", $_SESSION['UsuarioID']);									 
										//print_r ($dados);	
										if(sizeof($dados) >= 1)	{					
											foreach($dados as $linha) {
												echo "<option value=\"".$linha['idMARCADORES']."\">".$linha['nome']."</option>";
											}
										}
                                     ?>
								  </select> 
                                </td>
                  			</tr>
							<tr>                  			
                  				<td width="31"><input type="checkbox" name="geo" id="geo"  class="ui-checkbox" onChange="habilitarGeo()"></td>
                  				<td>Marcador de geo-posição</td>
                                 <td width="178">
                                <script>
									function  habilitarGeo(){
										if(document.getElementById('geo').checked){
											document.getElementById('opcoesGeo').style.display = "inline"; 
										}else{
											document.getElementById('opcoesGeo').style.display = "none"; 
										}
									}
								</script>
                                 <select name="opcoesGeo" id="opcoesGeo" class="styledselect_form_1">
									 <?php										
										$dados1 = consultaGPSCampos("","", "", "","", $_SESSION['UsuarioID']);
										foreach($dados1 as $linha1) {
											echo "<option value=\"".$linha1['idGEOPOS']."\">".$linha1['nome']."</option>";
										}
                                     ?>
								  </select> 
                                </td>
                            </tr>    
							<tr>
                        		<td width="31"><input type="checkbox" name="arquivo" id="arquivo"  class="ui-checkbox" onChange="habilitarArq()" value = "off"></td>
                        		<td>Tem arquivo multimidia</td>
                                 <td width="178">
                                <script>
									function  habilitarArq(){
										if(document.getElementById('arquivo').checked){
											document.getElementById('opcoesArquivo').style.display = "inline"; 
										}else{
											document.getElementById('opcoesArquivo').style.display = "none"; 
										}
									}
								</script>
                                 <select name="opcoesArquivo" id="opcoesArquivo" class="styledselect_form_1">
									 <?php									
										$dados = consultaArquivosCampos("", "","", $_SESSION['UsuarioID']);
										foreach($dados as $linha) {
											echo "<option value=\"".$linha['idARQUIVOS']."\">".$linha['nome']."</option>";
										}
                                     ?>
								  </select> 
                                </td>
                            </tr>    
                  		</table>
                  </td>
                  <td></td>
                </tr>
                
                <tr>
                   <th><input type="hidden" name="mod" id="mod" value="mod"></th>
                  <td><input type="submit"  class="form-cadastrar"><input type="reset"  class="form-reset"></td>
                  <td></td>
                </tr>
                </form>
                 <tr height="30">
                  <th></th>
                  <td>
                  <?php	
					
					// Se a sessão não existir, inicia uma
        			if (!isset($_SESSION)) session_start();
					$marcadorMarcado = false;
					$geoMarcado = false;			
					$arquivoMarcado = false;
					
					if(isset($_POST['marcador'])) $marcadorMarcado = true;
					if(isset($_POST['geo']))$geoMarcado = true;
					if(isset($_POST['arquivo']))$arquivoMarcado = true;
		
								
					if(!empty($_POST['mod'])){
						
						$targetId = "";
						
						if (empty($_POST['nome'])) {
							mensagemVermelha("É necessário que pelo menos o nome seja preechido."); 
						}else{  
							$marc = "";
							$geo = "" ;
							$arq = "" ;
							if($marcadorMarcado){
								$marc =$_POST['opcoesMarc'];
								$dados = consultaMarcadoresCampos($marc, "", "", "");
								foreach($dados as $linha){
									$targetId = $linha['targetID'];
								}
							}else{
								$marc ="";
							}
							if($geoMarcado){
								$geo =$_POST['opcoesGeo'];
							}else{
								$geo ="";
							}
							if($arquivoMarcado){
								$arq =$_POST['opcoesArquivo'];
							}else{
								$arq ="";
							}
							
							if($marcadorMarcado){
								cadastraObjetos($_POST['nome'],$_POST['obs'],$marc,$geo,$arq,$_SESSION['UsuarioID'], $targetId);
							}else{
								cadastraObjetos($_POST['nome'],$_POST['obs'],$marc,$geo,$arq,$_SESSION['UsuarioID'], $targetId);
							}

							if (empty($_POST['obs']) && ($marcadorMarcado == false && $geoMarcado == false && $arquivoMarcado == false)) {
								mensagemAmarela("Objeto criado somente com nome, sem marcadores, gps ou arquivo, então é um objeto 
								de texto, mas ele está com a descrição em branco."); 
								mensagemAmarela("Para ser utilizado sugiro que corrija esse desvio na opção de modificação."); 
							}
						}
					}
					if(!isset($_SESSION['erroCadastroObjeto'])){
						$_SESSION['erroCadastroObjeto']="";
					}
					if(!isset($_SESSION['objetoCadastro'])){
						$_SESSION['objetoCadastro']="";
					}
										
					if($_SESSION['erroCadastroObjeto'] == "Objeto multimídia já existente"){
						mensagemVermelha("Objeto multimídia já existente"); 
						$_SESSION['erroCadastroObjeto']="";
					}
					
					if($_SESSION['objetoCadastro']=="cadastrado"){
						mensagemVerde("Objeto multimídia cadastrado"); 
						$_SESSION['objetoCadastro']="";
					}
					
				?>
                  </td>
                  <td>
                  </td>
                </tr>
              </table>
	<!-- end id-form  -->
    
   
	</td>
	<td>
	
	<!--  start related-activities -->
	<div id="related-activities">
		<div id="related-act-top">
		<img src="images/forms/header_related_act.gif" width="271" height="43" alt="" />
		</div>
		<div id="related-act-bottom">
			<div id="related-act-inner">
			
				<?php 
					informa ("voltar", "Cadastro","Precauções" ,array(
						"Nome: nome do objeto em questão. O nome deve ser simples e de fácil entendimento já que no projeto a descrição não é apresentada.",
						"Descrição: A descrição é um texto que será exibido pelo objeto quando acionado pelo usuário quando estiver vivenciando o projeto.",
						"Tipo: O tipo são as características possíveis de um objeto. Ele pode possuir um arquivo multimídia, pontos de interesse, marcadores ou textos. Se nenhum tipo for selecionado para o objeto o sistema entenderá que é um objeto de texto e usará somente a descrição como conteúdo multimídia."));
						informa ("editar", "Observações","" ,array(
						"Quanto a ser marcador: trata-se de uma imagem que ao ser detectado pelo sistema exibirá um elemento multimídia. Se juntamente com o marcador for marcado um arquivo, então esse arquivo será exibido quando o marcador for detectado, senão, será exibido o texto do objeto",
						"Quanto a ser Geo-posição: O sistema não está tratando geo-posição com marcador de imagem. Se arquivo estiver marcado junto só será exibido se o POI foi configurado para Modelo3D. O texto prioritário do geo-posicionamento é do POI.",
						"Quanto a ser Arquivo: A geo-posição e o marcador de imagem são pontos de detecção no sistema, o arquivo não, ele apenas acompanha tais marcadores para ser aumentado."));
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