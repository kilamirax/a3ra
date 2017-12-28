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


<div id="page-heading"><h1>Modificação de Geo-posicionamento</h1></div>


<?php
	error_reporting(0); //desabilitar as irritantes mesnagens de warnning
				
	include('banco.php'); 	
			
	$id = "";
	$nome= ""; 
	$texto= "";
	$lat= ""; 
	$lon= ""; 
	$tipo= ""; 
	
	if(!empty($_POST['mod'])){
		
		modificaGPS($_POST['nomeMod'], $_POST['textoMod'], $_POST['latMod'], $_POST['lonMod'],$_POST['tipoMod'], $_POST['idMod']);			
		$id = $_POST['idMod'];
		$nome = $_POST['nomeMod']; 
		$texto = $_POST['textoMod'];
		$lat = $_POST['latMod']; 
		$lon = $_POST['lonMod'] ; 
		$tipo = $_POST['tipoMod'] ; 

	}else{
		$dados = consultaGPSCampos("",$_POST['nome'], "", "","","");
		foreach($dados as $linha){	
			$id = $linha['idGEOPOS'];
			$nome = $linha['nome']; 
			$texto = $linha['texto'];
			$lat = $linha['latitude']; 
			$lon = $linha['longitude'] ; 
			$tipo = $linha['tipo'] ;
			$idResponsavel = $linha['USUARIOS_idUSUARIOS']; 
		}
	}
?>

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
	
	<table border="0" cellpadding="0" cellspacing="0">
	<tr valign="top">
    <td width="500">
    
    	<div id="mapa" width="400" height="400"></div>   
          
    </td>
	<td>
	
	<!-- start id-form -->
		
       <table width="340" border="0" cellpadding="0" cellspacing="0">
             <form action="../A3RA/gpsModifica.php" method="post">
             	 <tr>
                    <th valign="top"><label for="txIdMod">Identificador:</label></th>
                    <td><input type="text" readonly="true" name="idMod" id="idMod" class="inp-form" value="<?php echo $id;?>"/></td>
                    <td></td>
                  </tr>
                <tr>
                  <th valign="top"><label for="txNome">Nome:</label></th>
                  <td><input type="text" name="nomeMod" id="nomeMod" class="inp-form" maxlength="100" value="<?php echo $nome;?>"/></td>
                  <td></td>
                </tr>
                <tr>
                  <th valign="top"><label for="txTexto">Descrição:</label></th>
                  <td><textarea rows="" cols="" name="textoMod" id="textoMod"  maxlength="200" class="form-textarea"><?php echo $texto;?></textarea></td>
                  <td></td>
                </tr>
                <tr>
                  <th valign="top"><label for="txLat">Latitude:</label></th>
                  <td><input type="text" name="latMod" id="latMod" class="inp-form" maxlength="9" value="<?php echo $lat;?>"/></td>
                  <td></td>
                </tr>
				<tr>
                  <th valign="top"><label for="txLat">Longitude:</label></th>
                  <td><input type="text" name="lonMod" id="lonMod" class="inp-form" maxlength="9" value="<?php echo $lon;?>"/></td>
                  <td></td>
                </tr>
                <tr>
					<th valign="center">Tipo:</th>
					<td>
					<select name="tipoMod" id="tipoMod" class="styledselect_form_1" >
					<?php
					echo $tipo;
						if($tipo == "mapMarker"){
							echo "<option value=\"mapMarker\" selected>mapMarker</option>";
							echo "<option value=\"informativo\" >informativo</option>";
							echo "<option value=\"feedback\">feedback</option>";
						}
						if($tipo == "informativo"){
							echo "<option value=\"mapMarker\">mapMarker</option>";
							echo "<option value=\"informativo\" selected>informativo</option>";
							echo "<option value=\"feedback\">feedback</option>";
						}
						if($tipo == "feedback"){
							echo "<option value=\"mapMarker\" >mapMarker</option>";
							echo "<option value=\"informativo\" >informativo</option>";
							echo "<option value=\"feedback\" selected>feedback</option>";
						}						
					?>
					</select>
					</td>
					<td></td>
				</tr> 
					 
                <tr>
                  <th><input type="hidden" name="mod" id="mod" value="mod"/></th>
                  <td>
                  		<input type="submit" class="form-modificar" />
                  </form>
                  
                  <form action="../A3RA/gpsConsulta.php" method="post">
						<input type="submit"  class="form-voltar" />
				  </form>
				  
                  </td>
                  <td></td>
                </tr>
                
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
	
 
	<!--  start related-activities -->
	<div id="related-activities">
		<div id="related-act-top">
		<img src="images/forms/header_related_act.gif" width="271" height="43" alt="" />
		</div>
		<div id="related-act-bottom">
			<div id="related-act-inner">
			
				<?php 
					informa ("voltar", "Cadastro","Explica aqui como cadastrar uma posição" ,array(
						"Nome: Nome do ponto de interesse em questão. Essa informação será usada em todo o sistema para identificação.",
						"Descrição: O que é esse ponto. Um campod e texto livre para ajudar o usuário a se organizar.",
						"Latitude: Informação coletada do mapa quando o usuário escolquer a localização. Clique no mapa para coletar a posição.",
						"Longitude: Informação coletada do mapa quando o usuário escolquer a localização. Clique no mapa para coletar a posição.",
						"Tipo: o tipo de POI a ser exibido como map marker (a seta em forma de gota invertida usada no google maps) ou como informativo. 
						Se for map marker o POI será exibido somente com o ícone e o seu nome na aplicação cliente, já o tipo informativo exibirá seu nome 
						e um balão de história em quadrinhos com a informação necessária, que sua descrição acima."));
				?>  

			</div>
			<div class="clear"></div>
		</div>
	</div>
	<!-- end related-activities -->

</td>
</tr>
<tr>
<td><img src="Template/images/shared/blank.gif" width="400" height="1" alt="blank" /></td>
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

        	
  