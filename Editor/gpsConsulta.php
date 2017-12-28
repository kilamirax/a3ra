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

<!-- start content-outer ........................................................................................................................START -->
<div id="content-outer"> 
  <!-- start content -->
  <div id="content"> 
    
    <!--  Nome da pagina -->
    <div id="page-heading">
      <h1> Consulta de Geo-posicionamento</h1>
    </div>
    <!-- end page-heading -->
    
    <table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
      <tr>
        <th rowspan="3" class="sized"><img src="images/shared/side_shadowleft.jpg" width="20" height="400" alt="" /></th>
        <th class="topleft"></th>
        <td id="tbl-border-top">&nbsp;</td>
        <th class="topright"></th>
        <th rowspan="3" class="sized"><img src="images/shared/side_shadowright.jpg" width="20" height="400" alt="" /></th>
      </tr>
      <tr>
        <td id="tbl-border-left"></td>
        <td><!--  start content-table-inner ...................................................................... START -->
          
          <div id="content-table-inner"> 
            
            <!--  start table-content  -->
            
          <div id="table-content">
            <form action="../A3RA/gpsConsulta.php" method="post">
              <table width="340" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <th valign="top"><label for="txNome">Nome:</label></th>
                  <td><input type="text" name="nome" id="txNome" class="inp-form" maxlength="100"/></td>
                  <td></td>
                </tr>
                <tr>
                  <th valign="top"><label for="txlatitude">Latitude:</label></th>
                  <td><input type="text" name="latitude" id="txlatitude" class="inp-form" maxlength="9"/></td>
                  <td></td>
                </tr>
                <tr>
                  <th valign="top"><label for="txlongitude">Longitude:</label></th>
                  <td><input type="text" name="longitude" id="txlongitude" class="inp-form" maxlength="9" /></td>
                  <td></td>
                </tr>
                <tr>
                  <th></th>
                  <td><input type="submit" class="form-submit" /><input type="reset"  class="form-reset" /></td>
                  <td></td>
                </tr>
              </table>
            </form>
            <!-- end id-form  --> 
            
          
          <?php
			error_reporting(0); //desabilitar as irritantes mesnagens de warnning
			include('banco.php');
			// A sessão precisa ser iniciada em cada página diferente
			if (!isset($_SESSION)) session_start();
						
			if($_SESSION['gpsDeletado']=="deletado"){
				mensagemVerde("geo-posicionamento deletado");
				$_SESSION['gpsDeletado']="";
			}
			 			
			
			if(!empty($_POST)){
				//caso nã seja preenchido nenhum campo a consulta será completa, senão será feita pelos campos preenchidos
				if ((empty($_POST['latitude']) && empty($_POST['nome'])&& empty($_POST['longitude']))) {
					$dados = consultaGPS();
				}else{
					$dados = consultaGPSCampos("",$_POST['nome'], $_POST['latitude'], $_POST['longitude'],"");
				}
					$cinza = false; //para chaverar o fundo cinza*/
					
					//cabeçalho da tabela
                	echo "<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" id=\"product-table\">";
                  	echo "<tr>";
                    echo "<th class=\"table-header-repeat line-left minwidth-1\"><a href=\"\">Nome</a> </th>";
					 echo "<th class=\"table-header-repeat line-left minwidth-1\"><a href=\"\">Descrição</a></th>";
                    echo "<th class=\"table-header-repeat line-left minwidth-1\"><a href=\"\">Latitude</a></th>";
                    echo "<th class=\"table-header-repeat line-left\"><a href=\"\">Longitude</a></th>";
					echo "<th class=\"table-header-repeat line-left\"><a href=\"\">Tipo</a></th>";
					echo "<th class=\"table-header-repeat line-left\"><a href=\"\">Opções</a></th>";
                  	echo "</tr>";
					
					//corpo da tabela
					foreach($dados as $linha){
						if($cinza){
							echo " <tr class=\"alternate-row\">";
							$cinza = false;
						}else{//sem fundo cinza
							echo "<tr>";
							$cinza = true;
						}
						echo "<form action=\"../A3RA/gpsModifica.php\" method=\"post\">
							  <input type=\"hidden\" name=\"id\" id=\"id\" value=\"".$linha['idGEOPOS']."\"/>
						      <td><input type=\"hidden\" name=\"nome\" id=\"nome\" value=\"".$linha['nome']."\"/>".$linha['nome']."</td>
						      <td><input type=\"hidden\" name=\"texto\" id=\"texto\" value=\"" .$linha['texto']."\"/>".$linha['texto']."</td>
						      <td><input type=\"hidden\" name=\"lat\" id=\"lat\" value=\"" .$linha['latitude']."\"/>".$linha['latitude']."</td>
							  <td><input type=\"hidden\" name=\"lon\" id=\"lon\" value=\"" .$linha['longitude']."\"/>".$linha['longitude']."</td>
							  <td><input type=\"hidden\" name=\"lon\" id=\"lon\" value=\"" .$linha['tipo']."\"/>".$linha['tipo']."</td>
						      <td><input type=\"submit\" class=\"form-submit-icon-1\"></input>
						      </form>
							  <form action=\"../A3RA/gpsDeleta.php\" method=\"post\">
							  		<input type=\"hidden\" name=\"id\" id=\"id\" value=\"".$linha['idGEOPOS']."\"/>
									<input type=\"hidden\" name=\"nome\" id=\"nome\" value=\"".$linha['nome']."\"/>
									<input type=\"hidden\" name=\"user\" id=\"user\" value=\"".$linha['USUARIOS_idUSUARIOS']."\"/>
									<input type=\"submit\" class=\"form-submit-icon-2\"></input>
							  </form>
							  </td>
						     </tr>";
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