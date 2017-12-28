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


<div id="page-heading"><h1>Modificação de objetos</h1></div>


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
<?php
	//error_reporting(0); //desabilitar as irritantes mesnagens de warnning
				
	include('banco.php'); 	
			
	$id = "";
	$nome = ""; 
	$marcador = "";
	$geo = ""; 
	$arquivo = ""; 
	$texto = ""; 
	$responsavel= ""; 
	
	if(!empty($_POST['mod'])){
		$linha = "";
		modificaObjetos($_POST['nomeMod'],$_POST['marcadorMod'],$_POST['geoMod'],$_POST['arquivoMod'],$_POST['textoMod'],$_POST['responsavelMod'],$_POST['idMod']);
		
		$id = $_POST['idMod'];
		$nome = $_POST['nomeMod']; 
		$marcador = $_POST['marcadorMod'];
		$geo = $_POST['geoMod']; 
		$arquivo = $_POST['arquivoMod']; 
		$texto = $_POST['textoMod']; 
		$responsavel= $_POST['responsavelMod']; 
	}else{
		$dados = consultaObjetosCampos("",$_POST['nome'],$_POST['usuario']);

		foreach($dados as $linha){
			$id = $linha['idOBJETO'];
			$nome = $linha['nome']; 
			$marcador = $linha['MARCADORES_idMARCADORES'];
			$geo = $linha['GEOPOS_idGEOPOS']; 
			$arquivo = $linha['ARQUIVOS_idARQUIVOS']; 
			$texto = $linha['texto']; 
			$responsavel= $linha['usuario']; 
		}

	}	
?>
        	
    
    
    
    
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
	<td>
	
	<!-- start id-form -->
		<div id="table-voltar">
           	<table width="340" border="0" cellpadding="0" cellspacing="0">
           		<form action="../A3RA/objetoConsulta.php" method="post">
                	<tr>
                    <th width="87"></th>
                    <td><input type="submit"  class="form-voltar" /></td>
                    <td></td>
                  </tr>
				</form>
            </table>
		  </div>
          
        <div id="table-content">
              <table width="340" border="0" cellpadding="0" cellspacing="0">
           
                 <form action="../A3RA/objetoModifica.php" method="post">
                  <tr>
                    <th valign="center">Identificador:</th>
                    <td><input type="text" readonly="true" name="idMod" id="txIdMod" class="inp-form" value="<?php echo $id;?>"/></td>
                    <td></td>
                  </tr>
                  <tr>
                    <th valign="center">Nome:</th>
                    <td><input type="text" name="nomeMod" id="nomeMod" maxlength="100" class="inp-form" value="<?php echo $nome;?>"/></td>
                    <td></td>
                  </tr>
                  <tr>
                    <th valign="center">Marcador:</th>
                    <td>
                    <select name="marcadorMod" id="marcadorMod" class="styledselect_form_1" value="<?php echo $marcador;?>">
						 <?php
							$dados1 = consultaMarcadoresCampos("", "", "",  $responsavel);	
							echo "<option value=\"\"></option>";					
							foreach($dados1 as $linha1) {
								if($marcador == $linha1['idMARCADORES']){
									echo "<option value=\"".$linha1['idMARCADORES']."\" selected=\"selected\">".$linha1['nome']."</option>";
								}else{
									echo "<option value=\"".$linha1['idMARCADORES']."\">".$linha1['nome']."</option>";
								}
                            }
                         ?>
                      </select>
                    </td>
                    <td></td>
                  </tr>
                  <tr>
                    <th valign="center">Geo-posição:</th>
                    <td>
                    <select name="geoMod" id="geoMod" class="styledselect_form_1" value="<?php echo $geo;?>">
						 <?php		
							$dados2 = consultaGPSCampos("","","","","", $responsavel);
							echo "<option value=\"NULL\"></option>";
                            foreach($dados2 as $linha2) {
								if($geo == $linha2['idGEOPOS']){
									echo "<option value=\"".$linha2['idGEOPOS']."\" selected=\"selected\">".$linha2['nome']."</option>";
								}else{
									echo "<option value=\"".$linha2['idGEOPOS']."\">".$linha2['nome']."</option>";
								}
                            }
                         ?>
                      </select> 
                    </td>
                    <td></td>
                  </tr>
                  <tr>
                    <th valign="center">Arquivo:</th>
                    <td>
                    <select name="arquivoMod" id="arquivoMod" class="styledselect_form_1"  value="<?php echo $arquivo;?>">
						 <?php									
                            $dados3 = consultaArquivosCampos("", "","", $responsavel);
							echo "<option value=\"\"></option>";
                            foreach($dados3 as $linha3) {
								if($arquivo == $linha3['idARQUIVOS']){
									echo "<option value=\"".$linha3['idARQUIVOS']."\" selected=\"selected\">".$linha3['nome']."</option>";
								}else{	
									echo "<option value=\"".$linha3['idARQUIVOS']."\">".$linha3['nome']."</option>";
								}
                            }
                         ?>
                      </select> 
                    </td>
                    <td></td>
                  </tr>        
                  <tr>
                    <th valign="center" >Responsável:</th>
                    <td><input type="text" name="responsavelMod" readonly="true"id="responsavelMod" maxlength="1" class="inp-form" value="<?php echo $responsavel ;?>"/></td>
                    <td></td>
                  </tr>
             		<tr>
                    <th valign="center">Texto:</th>
                    <td><textarea  rows="" cols="" name="textoMod" maxlength="200" class="form-textarea" id="textoMod"><?php echo $texto;?></textarea></td>
                    <td></td>
                  </tr>
                  <tr>
                    <th><input type="hidden" name="mod" id="mod" value="mod"/></th>
                    <td><input type="submit"  class="form-modificar" /></td>
                    <td></td>
                  </tr>
                </form>
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
					informa ("voltar", "Cadastro","Precauções" ,array(
						"Nome: nome do objeto em questão. Essa informação será usada em todo o sistema para identificação. O nome deve ser simples e de fácil entendimento já que no projeto a descrição não é apresentada.",
						"Descrição: A descrição é um texto que será exibido pelo objeto quando acionado pelo usuário quando estiver vivenciando o projeto.",
						"Tipo: O tipo são as características possíveis de um objeto. Ele pode possuir um arquivo multimídia, pontos de interesse, marcadores ou textos. Se nenhum tipo for selecionado para o objeto o sistema entenderá que é um objeto de texto e usará somente a descrição como conteúdo multimídia. Os tipos deverão ser cadastrados previamente para depois serem selecionados para o objeto."));
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
  <div class="clear">&nbsp;</div>
</div>
<!-- end footer -->

</body>
</html>