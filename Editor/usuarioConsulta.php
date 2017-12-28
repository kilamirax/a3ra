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
      <h1> Consulta de Usuário </h1>
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
            <form action="../A3RA/usuarioConsulta.php" method="post">
              <table width="340" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <th valign="top"><label for="txNome">Nome:</label></th>
                  <td><input type="text" name="nome" id="txNome" class="inp-form" maxlength="100"/></td>
                  <td></td>
                </tr>
                <tr>
                  <th valign="top"><label for="txUsuario">Usuário:</label></th>
                  <td><input type="text" name="usuario" id="txUsuario" class="inp-form" maxlength="25"/></td>
                  <td></td>
                </tr>
                <tr>
                  <th valign="top"><label for="txEmail">E-mail:</label></th>
                  <td><input type="text" name="email" id="txEmail" class="inp-form" maxlength="100" /></td>
                  <td></td>
                </tr>
                <tr>
                  <th valign="top">Grupo</th>
                  <td><input type="text" name="grupo" id="txGrupo" class="inp-form" maxlength="45" /></td>
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
			//error_reporting(0); //desabilitar as irritantes mesnagens de warnning
			include('banco.php');
			// A sessão precisa ser iniciada em cada página diferente
			if (!isset($_SESSION)) session_start();
			
			if(!isset($_SESSION['usuarioDeletado'])){
				$_SESSION['usuarioDeletado']="";
			}
							
			if($_SESSION['usuarioDeletado']=="deletado"){
				mensagemVerde("Usuário deletado");
				$_SESSION['usuarioDeletado']="";
			}
	
			
			if(!empty($_POST)){
				//caso não seja preenchido nenhum campo a consulta será completa, senão será feita pelos campos preenchidos
				if ((empty($_POST['usuario']) && empty($_POST['nome'])&& empty($_POST['email'])&& empty($_POST['grupo']))) {
					$dados = consultaUsuarios();
				}else{
					if((empty($_POST['usuario']) && empty($_POST['nome'])&& empty($_POST['email']))&& isset($_POST['grupo'])){
						$dadosGrupo = consultaGrupoCampos($_POST['grupo'], "", "");
						if (sizeof($dadosGrupo) == 1) {
							foreach($dadosGrupo as $linhaG){
								$linhaGrupo = $linhaG;
							}
							$dados = consultaUsuariosCampos($_POST['nome'], $_POST['usuario'], "",$_POST['email'],$linhaGrupo['idGRUPOS'],"");
						}	
					}else{
						$dados = consultaUsuariosCampos($_POST['nome'], $_POST['usuario'], "",$_POST['email'],"","");
					}
				}
					$cinza = false; //para chaverar o fundo cinza*/
				
					//cabeçalho da tabela
                	echo "<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" id=\"product-table\">";
                  	echo "<tr>";
                    echo "<th class=\"table-header-repeat line-left minwidth-1\"><a href=\"\">Nome</a> </th>";
                    echo "<th class=\"table-header-repeat line-left \"><a href=\"\">Usuário</a></th>";
					echo "<th class=\"table-header-repeat line-left \"><a href=\"\">Grupo</a></th>";
                    echo "<th class=\"table-header-repeat line-left\"><a href=\"\">Email</a></th>";
					echo "<th class=\"table-header-repeat line-left\"><a href=\"\">Opções</a></th>";
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
							
							$dadosGrupo = consultaGrupoCampos("", "",$linha['GRUPOS_idGRUPOS']);
							foreach($dadosGrupo as $linhaG){
								$linhaGrupo = $linhaG;
							}
							
							echo "<form action=\"../A3RA/usuarioModifica.php\" method=\"post\">
								  <td><input type=\"hidden\" name=\"nome\" id=\"nome\" value=\"".$linha['nome']."\"/>".$linha['nome']."</td>
								  <td><input type=\"hidden\" name=\"usuario\" id=\"usuario\" value=\"" .$linha['usuario']."\"/>".$linha['usuario']."</td>
								  
								  <td><input type=\"hidden\" name=\"grupo\" id=\"grupo\" value=\"" .$linha['GRUPOS_idGRUPOS']."\"/>".$linhaGrupo['nome']."</td>
	
								  <td><input type=\"hidden\" name=\"email\" id=\"email\" value=\"" .$linha['email']."\"/>".$linha['email']."</td>
								  <td><input type=\"submit\" class=\"form-submit-icon-1\"></input>
								  </form>
								  <form action=\"../A3RA/usuarioDeleta.php\" method=\"post\">
								  		<input type=\"hidden\" name=\"id\" id=\"id\" value=\"".$linha['idUSUARIOS']."\"/>
										<input type=\"hidden\" name=\"nome\" id=\"nome\" value=\"".$linha['nome']."\"/>
										<input type=\"hidden\" name=\"usuario\" id=\"usuario\" value=\"" .$linha['usuario']."\"/>
										<input type=\"hidden\" name=\"grupo\" id=\"grupo\" value=\"" .$linha['GRUPOS_idGRUPOS']."\"/>
										<input type=\"hidden\" name=\"grupo\" id=\"grupo\" value=\"" .$linhaGrupo['nome']."\"/>
										<input type=\"hidden\" name=\"email\" id=\"email\" value=\"" .$linha['email']."\"/>
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