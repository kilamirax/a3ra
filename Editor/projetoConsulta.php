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

<?php
	//error_reporting(0); //desabilitar as irritantes mesnagens de warnning
	include('banco.php');
	// A sessão precisa ser iniciada em cada página diferente
	if (!isset($_SESSION)) session_start();
?>

<!-- start content-outer ........................................................................................................................START -->
<div id="content-outer"> 
  <!-- start content -->
  <div id="content"> 
    
    <!--  Nome da pagina -->
    <div id="page-heading">
      <h1>Consulta de Projeto</h1>
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
            <form action="../A3RA/projetoConsulta.php" method="post">
              <table width="340" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <th valign="center">Nome:</th>
                  <td><input type="text" name="nome" id="nome" class="inp-form" maxlength="100"/></td>
                  <td></td>
                </tr>
                <tr>
                  <th valign="center">Tipo:</th>
                  <td><select name="tipo" id="tipo" class="styledselect_form_1">
                  	  	<option value=""></option>
                        <option value="RA">Realidade Aumentada</option>
             			<option value="VA">Virtualidade Aumentada</option>
                      </select>
                  <td></td>
                </tr>
				<tr>
                  <th valign="center">Acesso:</th>
                  <td><select name="acesso" id="acesso" class="styledselect_form_1">
                  	  	<option value=""></option>
                        <option value="publico">Público</option>
             			<option value="privado">Privado</option>
                      </select>
                  <td></td>
                </tr>
                <tr>
                  <th valign="center">Grupo:</th>
                  <td><input type="text" name="grupo" id="grupo" class="inp-form" maxlength="100" /></td>
                  <td></td>
                </tr>
                <tr>
                  <th valign="center">Usuário:</th>
                  <td><input type="text" name="usuario" id="usuario" class="inp-form" maxlength="100" /></td>
                  <td></td>
                </tr>
                <tr>
                  <th valign="center">Objeto:</th>
                  <td>
					  <select name="objeto" id="objeto" class="styledselect_form_1">
						<option value=""></option>
						 <?php	     
							$dados = consultaObjetosCampos("", "", $_SESSION['UsuarioID'],"");									 
							if(sizeof($dados) >= 1)	{					
								foreach($dados as $linha) {
									echo "<option value=\"".$linha['idOBJETO']."\">".$linha['nome']."</option>";
								}
							}
						 ?>
					  </select> 
				  </td>
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
			
			if(!isset($_SESSION['projetoDeletado'])){
				$_SESSION['projetoDeletado']="";
			}
						
			if($_SESSION['projetoDeletado']=="deletado"){
				mensagemVerde("Projeto deletado com sucesso.");
				$_SESSION['projetoDeletado']="";
			}
			 			
			
			if(!empty($_POST)){
				$linhaGrupo = "";
				$linhaUsuario = "";
				$linhaObjeto = "";
				$dadosGrupo = "";
				$dadosUser = "";
				$dadosObjeto = "";
				//caso não seja preenchido nenhum campo a consulta será completa, senão será feita pelos campos preenchidos
				if (empty($_POST['tipo']) && empty($_POST['nome'])&& empty($_POST['grupo'])&& empty($_POST['usuario'])&& empty($_POST['objeto'])) {
					$dados = consultaProjeto();
				}else{	
					if(isset($_POST['tipo'])&&isset($_POST['nome'])&&empty($_POST['grupo'])&& empty($_POST['usuario'])&& empty($_POST['objeto'])) {
						$dados = consultaProjetoCampos("", $_POST['nome'],"",$_POST['tipo'], "","");				
					}else{
						
					}
					
				}
					$cinza = false; //para chaverar o fundo cinza*/
					
					//cabeçalho da tabela
                	echo "<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" id=\"product-table\">";
                  	echo "<tr>";
					 echo "<th class=\"table-header-repeat line-left minwidth-1\"><a>Id</a></th>";
                    echo "<th class=\"table-header-repeat line-left minwidth-1\"><a>Nome</a></th>";
                    echo "<th class=\"table-header-repeat line-left minwidth-1\"><a>Tipo</a></th>";
					echo "<th class=\"table-header-repeat line-left minwidth-1\"><a>Acesso</a></th>";
					echo "<th class=\"table-header-repeat line-left minwidth-1\"><a>Texto</a></th>";
                    echo "<th class=\"table-header-repeat line-left\"><a>Grupos</a></th>";
					echo "<th class=\"table-header-repeat line-left\"><a>Usuários</a></th>";
					echo "<th class=\"table-header-repeat line-left\"><a>Objetos</a></th>";
					echo "<th class=\"table-header-repeat line-left\"><a>Opções</a></th>";
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
						echo "<form action=\"../A3RA/projetoModifica.php\" method=\"post\">
							  <td><input type=\"hidden\" name=\"id\" id=\"id\" value=\"".$linha['idPROJETOS']."\"/>".$linha['idPROJETOS']."</td>
						      <td><input type=\"hidden\" name=\"nome\" id=\"nome\" value=\"".$linha['nome']."\"/>".$linha['nome']."</td>
						      <td><input type=\"hidden\" name=\"tipo\" id=\"tipo\" value=\"" .$linha['tipo']."\"/>".$linha['tipo']."</td>
							  <td><input type=\"hidden\" name=\"acesso\" id=\"acesso\" value=\"" .$linha['acesso']."\"/>".$linha['acesso']."</td>
							  <td><input type=\"hidden\" name=\"texto\" id=\"texto\" value=\"" .$linha['texto']."\"/>".$linha['texto']."</td>";
						
						$dadosGrupos = consultaProjeto_GruposCampos($linha['idPROJETOS'], "", "");
						$contador = 0;
						echo  "<td>";
						foreach($dadosGrupos as $linhaGrupos){
							$contador++;
							$dadosGrupo = consultaGrupoCampos("", "", $linhaGrupos['GRUPOS_idGRUPOS']);
							foreach($dadosGrupo as $linhaGrupo){
								echo "<input type=\"hidden\" name=\"".$contador."grupo\" id=\"".$contador."grupo\" value=\"" .$linhaGrupo['nome']."\"/>".$linhaGrupo['nome'];
							}
							echo  "<br>";
						}
						echo "</td>";
						
						$dadosUsuarios = consultaProjeto_UsuarioCampos($linha['idPROJETOS'], "", "");
						$contador = 0;
						echo  "<td>";
						foreach($dadosUsuarios as $linhaUsuarios){
							$contador++;
							$dadosUsuario = consultaUsuariosCampos("", "", "", "", "", $linhaUsuarios['USUARIOS_idUSUARIOS']);
							foreach($dadosUsuario as $linhaUsuario){
								echo "<input type=\"hidden\" name=\"".$contador."usuario\" id=\"".$contador."usuario\" value=\"" .$linhaUsuario['nome']."\"/>".$linhaUsuario['nome'];
							}
							echo  "<br>";
						}
						echo "</td>";
						
						$dadosObjetos = consultaProjeto_ObjetosCampos($linha['idPROJETOS'], "");
						$contador = 0;
						echo  "<td>";
						foreach($dadosObjetos as $linhaObjetos){
							$contador++;    
							$dadosObjeto = consultaObjetosCampos($linhaObjetos['OBJETO_idOBJETO'], "", "","");
							foreach($dadosObjeto as $linhaObjeto){
								echo "<input type=\"hidden\" name=\"".$contador."objeto\" id=\"".$contador."objeto\" value=\"" .$linhaObjeto['nome']."\"/>".$linhaObjeto['nome'];
							}
							echo  "<br>";
						}
						echo "</td>";
						//echo  "<td><input type=\"submit\" class=\"form-submit-icon-1\"></input>
						echo  "<td>
						      </form>";
							  
						echo  "<form action=\"../A3RA/projetoDeleta.php\" method=\"post\">
									<input type=\"hidden\" name=\"id\" id=\"id\" value=\"".$linha['idPROJETOS']."\"/>
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