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

<!-- start content-outer ........................................................................................................................START -->
<div id="content-outer"> 
  <!-- start content -->
  <div id="content"> 
    
    <!--  Nome da pagina -->
    <div id="page-heading">
      <h1> Consulta de objetos </h1>
    </div>
    <!-- end page-heading -->
    
    <table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
      <tr>
        <th rowspan="3" class="sized"><img src="images/shared/side_shadowleft.jpg" width="20" height="400" alt=""></th>
        <th class="topleft"></th>
        <td id="tbl-border-top">&nbsp;</td>
        <th class="topright"></th>
        <th rowspan="3" class="sized"><img src="images/shared/side_shadowright.jpg" width="20" height="400" alt=""></th>
      </tr>
      <tr>
        <td id="tbl-border-left"></td>
        <td><!--  start content-table-inner ...................................................................... START -->
          
          <div id="content-table-inner"> 
            
            <!--  start table-content  -->
            
          <div id="table-content">
            <form action="../A3RA/objetoConsulta.php" method="post">
              <table width="340" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <th valign="top">Nome:</th>
                  <td><input type="text" name="nome" id="nome" class="inp-form" maxlength="100"></td>
                  <td></td>
                </tr>
                <tr>
                  <th></th>
                  <td><input type="submit" class="form-submit"><input type="reset"  class="form-reset"></td>
                  <td></td>
                </tr>
              </table>
            </form>
            <!-- end id-form  --> 
            
          
          <?php
			include('banco.php');
			// A sessão precisa ser iniciada em cada página diferente
			if (!isset($_SESSION)) session_start();
			
			if(!isset($_SESSION['objetoDeletado'])){
				$_SESSION['objetoDeletado']="";
			}			
			if($_SESSION['objetoDeletado']=="deletado"){
				mensagemVerde("Objeto deletado");
				$_SESSION['objetoDeletado']="";
			}
			
			if(!empty($_POST)){
				//caso não seja preenchido nenhum campo a consulta será completa, senão será feita pelos campos preenchidos
				if (empty($_POST['nome'])) {
					$dados = consultaObjetos();
				}else{
					$dados = consultaObjetosCampos("",$_POST['nome'], $_SESSION['UsuarioID'],"");
				}
					$cinza = false; //para chaverar o fundo cinza*/
					
					//cabeçalho da tabela
                	echo "<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" id=\"product-table\">";
                  	echo "<tr>";
                    echo "<th class=\"table-header-repeat line-left minwidth-1\"><a href=\"\">Nome</a> </th>";
                    echo "<th class=\"table-header-repeat line-left minwidth-1\"><a href=\"\">Texto</a></th>";
                    echo "<th class=\"table-header-repeat line-left\"><a href=\"\">Marcador</a></th>";
					echo "<th class=\"table-header-repeat line-left\"><a href=\"\">Geo-posição</a></th>";
					echo "<th class=\"table-header-repeat line-left\"><a href=\"\">Arquivo</a></th>";
					echo "<th class=\"table-header-repeat line-left\"><a href=\"\">Responsavel</a></th>";
					echo "<th class=\"table-header-repeat line-left\"><a href=\"\">Oções</a></th>";
                  	echo "</tr>";
					
					//corpo da tabela
					if (sizeof($dados) >= 1) {
						foreach($dados as $linha){
							if($cinza){
								echo " <tr class=\"alternate-row\">";
								$cinza = false;
							}else{//sem fundo cinza
								echo "<tr>";
								$cinza = true;
							}
							
							$marcador ="";
							$arquivo ="";
							$geo ="";
							if(isset($linha['MARCADORES_idMARCADORES'])){
								$dadosMarc = consultaMarcadoresCampos($linha['MARCADORES_idMARCADORES'], "","", "");
								foreach($dadosMarc as $linhaM){
									$linhaMarc = $linhaM;
								}
								$marcador = $linhaMarc['nome'];
							}
							if(isset($linha['GEOPOS_idGEOPOS'])){
								$dadosGeo = consultaGPSCampos($linha['GEOPOS_idGEOPOS'], "", "", "", "", "");
								foreach($dadosGeo as $linhaG){
									$linhaGeo = $linhaG;
								}
								$geo = $linhaGeo['nome'];
							}
							if(isset($linha['ARQUIVOS_idARQUIVOS'])){
								$dadoArq = consultaArquivosCampos($linha['ARQUIVOS_idARQUIVOS'], "", "", "");
								foreach($dadoArq as $linhaA){
									$linhaArq = $linhaA;
								}
								$arquivo = $linhaArq['nome'];
							}
						
							$idMarcador = $linha['MARCADORES_idMARCADORES'];
							$idGeo = $linha['GEOPOS_idGEOPOS'];
							$idArquivo = $linha['ARQUIVOS_idARQUIVOS'];
							
							
							echo "
								<form action=\"../A3RA/objetoModifica.php\" method=\"post\">
								  <td><input type=\"hidden\" name=\"nome\" id=\"nome\" value=\"".$linha['nome']."\"/>".$linha['nome']."</td>
								  <td><input type=\"hidden\" name=\"texto\" id=\"texto\" value=\"" .$linha['texto']."\"/>".$linha['texto']."</td>
								  <td><input type=\"hidden\" name=\"MARCADORES_idMARCADORES\" id=\"MARCADORES_idMARCADORES\" value=\"$idMarcador\"/>$marcador<br>
																														".$linha['TARGETID']."</td>
								  <td><input type=\"hidden\" name=\"GEOPOS_idGEOPOS\" id=\"GEOPOS_idGEOPOS\" value=\"$idGeo\"/>$geo</td>
								  <td><input type=\"hidden\" name=\"ARQUIVOS_idARQUIVOS\" id=\"ARQUIVOS_idARQUIVOS\" value=\"$idArquivo\"/>$arquivo</td>
								  <td><input type=\"hidden\" name=\"usuario\" id=\"usuario\" value=\"" .$linha['usuario']."\"/>".$linha['usuario']."
								  <input type=\"hidden\" name=\"id\" id=\"id\" value=\"".$linha['idOBJETO']."\"/></td>
								  <td>";
								  
								  
								  
								  //<input type=\"submit\" class=\"form-submit-icon-1\"></input>
								  
								 
								
							echo "</form>
								  <form action=\"../A3RA/objetoDeleta.php\" method=\"post\">
								 		<input type=\"hidden\" name=\"id\" id=\"id\" value=\"".$linha['idOBJETO']."\"/>
										<input type=\"submit\" class=\"form-submit-icon-2\"></input>
								  </form>
								  
								  </td>
								 </tr>";
						}
					}else{
						mensagemAmarela("Não há registros para essa consulta.");
					}
					echo "</table>";
			}
		?>
            </div>
            <!--  end content-table  -->
           
          </div>
          
          <!--  end content-table-inner ............................................END  --></td>
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