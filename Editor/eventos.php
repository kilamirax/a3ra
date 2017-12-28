<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>A3RA</title>
<link rel="stylesheet" href="css/screen.css" type="text/css" media="screen" title="default">
<link rel="icon" href="images/shared/icone.jpg" type="image/x-icon">
<link rel="shortcut icon" href="images/shared/icone.jpg" type="image/x-icon">
</head>


<body >	


<div class="clear"></div>
<!--  start nav-outer -->
</div>
<!--  start nav-outer-repeat................................................... END -->
 
 <div class="clear"></div>
 
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>Gerenciamento de Eventos</h1></div>


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
		
       <table width="810" border="0" cellpadding="0" cellspacing="0">
         <form id="formEventos" action="../A3RA/eventos.php" method="post">
         	<tr>
            	<td idth="100" height="25">Projeto</td>
                <td width="202"align="center">
                <select name="opcoesProjeto" id="opcoesProjeto" class="styledselect_form_1" >
                  <?php
				  	//error_reporting(0); //desabilitar as irritantes mesnagens de warnning
				  	include('banco.php');
				  	// A sessão precisa ser iniciada em cada página diferente
				  	if (!isset($_SESSION)) session_start();
				  	
                    $dadosProj = consultaProjetoCampos("","","","", $_SESSION['UsuarioID'],"");
                    foreach($dadosProj as $linhaProj) {
						if(!empty($_POST)){
							if($_POST['opcoesProjeto'] == $linhaProj['idPROJETOS']){
								echo "<option value=\"".$linhaProj['idPROJETOS']."\" selected=\"selected\">".$linhaProj['nome']."</option>";
							}else{
								echo "<option value=\"".$linhaProj['idPROJETOS']."\">".$linhaProj['nome']."</option>";
							}
						}else{
                        	echo "<option value=\"".$linhaProj['idPROJETOS']."\">".$linhaProj['nome']."</option>";
						}
                    }
                ?>	
                  </select>  
              	</td>
                <td>
                	<p><input type="submit"  class="form-selecionar"><p>
                </td>
                <td></td>
                <td></td>
            </tr>
            <tr>
            	<td>
                	<p>&nbsp;</p>
            	  	<p>&nbsp;</p>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
             <?php
                if(!empty($_POST)){
                    if(isset($_POST['opcoesProjeto'])){
						$idProjeto = $_POST['opcoesProjeto'];
                        echo"<tr><td width=\"100\" height=\"25\">Evento:</td>
                            <td width=\"202\"align=\"center\"><p>Objeto <br>
                            <select name=\"opcoesObjetos1\" id=\"opcoesObjetos1\" class=\"styledselect_form_1\">";
							echo "<option value=\"vazio\"> </option>"; //sempre deve vir como vazio para que o usuário tenha que escolher
							$dadoObjSistema ="";
							$linhaObjSistema ="";
							$dadosProjObj1 ="";
							$linhaProjObj1 ="";
							$dadoObj1 ="";
							$linhaObj1 ="";

							$dadoObjSistema =  consultaObjetosCampos("", "", "1","");//coleta os objetos cadastrados pelo sistema
							foreach($dadoObjSistema as $linhaObjSistema) {
								echo "<option value=\"".$linhaObjSistema['idOBJETO']."\">".$linhaObjSistema['nome']."</option>";
							}
                            
                            $dadosProjObj1 = consultaProjeto_ObjetosCampos($idProjeto, "");//soma aos objetos so sistema com os objetos do projeto
                            foreach($dadosProjObj1 as $linhaProjObj1) {
                                $dadoObj1 =  consultaObjetosCampos($linhaProjObj1['OBJETO_idOBJETO'], "", "","");
                                foreach($dadoObj1 as $linhaObj1) {
                                    echo "<option value=\"".$linhaObj1['idOBJETO']."\">".$linhaObj1['nome']."</option>";
                                }
                            }
            
                         echo "</select></td>
                                <td width=\"243\" align=\"center\">Ação <br>
                                    <select name=\"opcoesAcoes\" id=\"opcoesAcoes\" class=\"styledselect_form_1\" >";
                            $dadosAct = consultaAcao();
                            foreach($dadosAct as $linhaAct ) {
                                echo "<option value=\"".$linhaAct['idACOES']."\">".$linhaAct['nome']."</option>";
                            }
              
                        echo"</select></td>
                             <td width=\"204\" align=\"center\">Objeto <br>
                            <select name=\"opcoesObjetos2\" id=\"opcoesObjetos2\" class=\"styledselect_form_1\" >";
							echo "<option value=\"vazio\"> </option>"; //sempre deve vir como vazio para que o usuário tenha que escolher
								$dadoObjSistema ="";
								$linhaObjSistema="";
								$dadosProjObj2="";
								$linhaProjObj2="";
								$dadoObj2="";
								$linhaObj2="";

								$dadoObjSistema =  consultaObjetosCampos("", "", "1","");//coleta os objetos cadastrados pelo sistema
								foreach($dadoObjSistema as $linhaObjSistema) {
									echo "<option value=\"".$linhaObjSistema['idOBJETO']."\">".$linhaObjSistema['nome']."</option>";
								}
                                $dadosProjObj2 = consultaProjeto_ObjetosCampos($idProjeto, "");//soma aos objetos so sistema com os objetos do projeto
                                foreach($dadosProjObj2 as $linhaProjObj2) {
                                    $dadoObj2 =  consultaObjetosCampos($linhaProjObj2['OBJETO_idOBJETO'], "", "","");
                                    foreach($dadoObj2 as $linhaObj2) {
                                        echo "<option value=\"".$linhaObj2['idOBJETO']."\">".$linhaObj2['nome']."</option>";
                                    }
                                }
                        echo"</select></td><td  valign=\"center\">&nbsp;</td></tr>";
                    }
					if(isset($_POST['opcoesObjetos1']) && isset($_POST['opcoesObjetos2'])){
						if($_POST['opcoesObjetos1'] !="vazio" && $_POST['opcoesObjetos2'] !="vazio"){
							cadastraEventos($_POST['opcoesObjetos1'], $_POST['opcoesAcoes'], $_POST['opcoesObjetos2'], $idProjeto);
						}
					}
                }
			?>

         	<tr>
          		<td height="57"></td>
          		<td align="center" colspan="3">
            		<p><input type="submit"  class="form-cadastrar"><p><input type="reset"  class="form-reset"></p>
          		</td>
          		<td></td>
      		</tr>       
         </form> <!--final do formEventos-->
       </table> 
        
	<!-- end id-form  -->
    
	<!--área de consulta-->
	 <?php
		//cabeçalho da tabela
		echo "<table border=\"0\" width=\"810\" cellpadding=\"0\" cellspacing=\"0\" id=\"product-table\">";
		echo "<tr>";
		echo "<th class=\"table-header-repeat line-left minwidth-1\"><a>Objeto</a> </th>";
		echo "<th class=\"table-header-repeat line-left\"><a>Ação</a></th>";
		echo "<th class=\"table-header-repeat line-left \"><a>Objeto</a></th>";
		echo "<th class=\"table-header-repeat line-left\"><a>Opções</a></th>";
		echo "</tr>";
		
		 if(!empty($_POST)){
			$idProjeto = $_POST['opcoesProjeto'];
			$dadosEve =  consultaEventosCampos("", "", "", $idProjeto);
		 
			$cinza = false; //para chaverar o fundo cinza*/
			$idEvento = "";

			//corpo da tabela
			if (sizeof($dadosEve) >= 1) {
				foreach($dadosEve as $linha){						
					if($cinza){
						echo " <tr class=\"alternate-row\">";
					$cinza = false;
					}else{//sem fundo cinza
						echo "<tr>";
						$cinza = true;
					}



					//echo "<form action=\"../A3RA/eventosModifica.php\" method=\"post\">";

					$idEvento = $linha['idEVENTOS'];

					$dadoObj =  consultaObjetosCampos($linha['OBJETO_idOBJETO'], "", "","");
					foreach($dadoObj as $linhObj) {
						echo  "<td><input type=\"hidden\" name=\"objeto1\" id=\"objeto1\" value=\"".$linhObj['idOBJETO']."\"/>".$linhObj['nome']."</td>";
						$obj = $linhObj['idOBJETO'];
					}
					
					$dadoAct = consultaAcaoCampos("", "", "", $linha['ACOES_idACOES']);
					foreach($dadoAct as $linhaAct) {
						echo  "<td><input type=\"hidden\" name=\"nomeAct\" id=\"nomeAct\" value=\"".$linhaAct['idACOES']."\"/>".$linhaAct['nome']."</td>";
						$act = $linhaAct['idACOES'];
					}

					$dadoObj2 =  consultaObjetosCampos($linha['gatilho'], "", "","");
					foreach($dadoObj2 as $linhObj2) {
						echo  "<td><input type=\"hidden\" name=\"nomeObj\" id=\"nomeObj\" value=\"".$linhObj2['idOBJETO']."\"/>".$linhObj2['nome']."</td>";
						$obj2 = $linhObj2['idOBJETO'];
					}
					
					echo  "<td>";
										
					/*echo  "<input type=\"submit\" class=\"form-submit-icon-1\"></input>
					   </form>";
					*/
					

					echo  "<form action=\"../A3RA/eventosDeleta.php\" method=\"post\">
								<input type=\"hidden\" name=\"idEvento\" id=\"idEvento\" value=\"".$idEvento."\"/>
								<input type=\"submit\" class=\"form-submit-icon-2\"></input>
						  </form>
						  </td>
						 </tr>";
				}
			}
		 }
	  echo "</table>";
	  
	?>
	</td>
	<td>
	
	
	<div id="related-activities">
		<div id="related-act-top">
		<img src="images/forms/header_related_act.gif" width="271" height="43" alt="">
		</div>
		<div id="related-act-bottom">
			<div id="related-act-inner">
			
				<?php 
				
					informa ("voltar", "Cadastro","Precauções" ,array(
						"Nome: Nome do evento em questão. Essa informação será usada na tela de gerencia de eventos e na tela de projetos para identificação.",
						"Ação: Ação que um objeto realiza no outro. Essa realização chamamos de gatilho, que aciona essa ação.",
						"Gatilho: O gatilho é controlado pelo sistema, simplesmente o primeiro objeto atua sobre o segundo objeto e o segundo objeto sofre ação do primeiro objeto."));
						
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
  <div id="footer-left"> Thiago Zamborlini Fraga &copy; Copyright James Warlock. <span id="spanYear"></span> <a href="www.jameswarlock.com.br">www.jameswarlock.com.br</a>. Todos direitos reservados.</div>
  <!--  end footer-left -->
  <div class="clear">&nbsp;</div>
</div>
<!-- end footer -->

</body>
</html>