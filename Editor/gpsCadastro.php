<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>A3RA</title>
    <link rel="stylesheet" href="css/screen.css" type="text/css" media="screen" title="default">
    <link rel="icon" href="images/shared/icone.jpg" type="image/x-icon">
    <link rel="shortcut icon" href="images/shared/icone.jpg" type="image/x-icon">
     <style type="text/css">
    	#mapa{
	    	width:400px;
	    	height:400px;	
    	}
    
    </style>
    
</head>
<?php	
	//error_reporting(0); //desabilitar as irritantes mesnagens de warnning
	include('banco.php');
	
	if (!isset($_SESSION)) session_start();
	
	//echo $_SESSION['UsuarioID'];
	$dados = consultaGPSCampos("","", "", "", "", $_SESSION['UsuarioID']);
	
	$ultimaLatitude = 0;
	$ultimaLongitude = 0;
	
	if(isset($dados )){
		foreach($dados as $linha){
			$ultimaLatitude = $linha['latitude'];
			$ultimaLongitude = $linha['longitude'];
		}
	}else{
		$ultimaLatitude = -20.27902;
		$ultimaLongitude = -40.30377;
	}
	
	//echo $ultimaLatitude;
	//echo $ultimaLongitude;
	
?>	
	
<script src="//maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyCsZCByCZFG1eHIiD3GfK5xMHjAgUNwDY4" async defer type="text/javascript"></script>
    <script type="text/javascript" >
		var map = null; 
    	function carregar(){
			//var latlng = new google.maps.LatLng(-20.27902,-40.30377);
			var latlng = new google.maps.LatLng(<?php print $ultimaLatitude?>,<?php print $ultimaLongitude?>);
			
    		var myOptions = {
      		zoom: 17,
      		center: latlng,
      		mapTypeId: google.maps.MapTypeId.ROADMAP
    		};
		
			//criando o mapa
    		map = new google.maps.Map(document.getElementById("mapa"), myOptions);
  			
  			google.maps.event.addListener(map, 'click', function(event) {
    			//alert(event.latLng);
				document.getElementById("latitude").value = event.latLng.lat();
				document.getElementById("longitude").value = event.latLng.lng();
  			});
		
    	}
    </script>

<body onload="carregar()">	

<div class="clear"></div>
<!--  start nav-outer -->
</div>
<!--  start nav-outer-repeat................................................... END -->
 
 <div class="clear"></div>
 
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>Cadastro de Geo-posicionamento


</h1></div>


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
	
	<table border="0" cellpadding="0" cellspacing="0">
	<tr valign="top">
    <td width="500">
    
    	<div id="mapa" width="400" height="400"></div> 
          
    </td>
	<td>
	
	<!-- start id-form -->
		
       <table width="340" border="0" cellpadding="0" cellspacing="0">
             <form action="../A3RA/gpsCadastro.php" method="post">
                <tr>
                  <th valign="center">Nome:</th>
                  <td><input type="text" name="nome" id="txNome" class="inp-form" maxlength="100"></td>
                  <td></td>
                </tr>
                <tr>
                  <th valign="center">Descrição:</th>
                  <td><textarea rows="" cols="" name="texto" id="texto"  maxlength="200" class="form-textarea"></textarea></td>
                  <td></td>
                </tr>
                <tr>
                  <th valign="center">Latitude:</th>
                  <td><input type="text" name="lat" id="latitude" class="inp-form" maxlength="9"></td>
                  <td></td>
                </tr>
                <tr>
                  <th valign="center">Longitude:</th>
                  <td><input type="text" name="lon" id="longitude" class="inp-form" maxlength="9"></td>
                  <td></td>
                </tr>  
				<tr>
					<th valign="center">Tipo:</th>
					<td>
					<select name="tipoGPS" id="tipoGPS" class="styledselect_form_1" >
						<option value="mapMarker"> map marker </option>
						<option value="informativo"> informativo </option>
						<option value="Modelo3D"> Modelo3D </option>
					</select>
					</td>
					<td></td>
				</tr> 
                <tr>
                  <th></th>
                  <td valign="center"><input type="submit"  class="form-cadastrar"><input type="reset"  class="form-reset"></td>
                  <td></td>
                </tr>
                </form>
                 <tr height="30">
                  <th></th>
                  <td>
                  <?php	
					if (!isset($_SESSION)) session_start();			
					if(!empty($_POST)){
						if ((empty($_POST['lon']) OR empty($_POST['lat'])OR empty($_POST['nome']))) {
							mensagemVermelha("Há campos em branco que precisam ser preenchidos."); 
						}else{ 
							cadastraGPS($_POST['nome'], $_POST['texto'], $_POST['lat'], $_POST['lon'] ,$_POST['tipoGPS'] , $_SESSION['UsuarioID']);
							$ultimaLatitude = $_POST['lat'];
							$ultimaLongitude = $_POST['lon'];
							echo "<script> carregar(); </script>";
						}
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
		<img src="images/forms/header_related_act.gif" width="271" height="43" alt="">
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
<td><img src="Template/images/shared/blank.gif" width="400" height="1" alt="blank"></td>
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

//no final da pagina
<?php
ob_end_flush();
?>
</html>