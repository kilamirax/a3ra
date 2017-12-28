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


<div id="page-heading"><h1>Cadastro de Usuário</h1></div>

<?php
	//error_reporting(0); //desabilitar as irritantes mesnagens de warnning
	include('banco.php');
	// A sessão precisa ser iniciada em cada página diferente
	if (!isset($_SESSION)) session_start();
?>
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
		
       <table width="340" border="0" cellpadding="0" cellspacing="0">
             <form action="../A3RA/usuarioCadastro.php" method="post">
                <tr>
                  <th valign="middle"><label for="txNome">Nome:</label></th>
                  <td><input type="text" name="nome" id="txNome" class="inp-form" maxlength="100"></td>
                  <td></td>
                </tr>
                <tr>
                  <th valign="middle"><label for="txUsuario">Usuário:</label></th>
                  <td><input type="text" name="usuario" id="txUsuario" class="inp-form" maxlength="25"></td>
                  <td></td>
                </tr>
                <tr>
                  <th valign="middle"><label for="txSenha">Senha:</label></th>
                  <td><input type="password" name="senha" id="txSenha" class="inp-form" maxlength="40"></td>
                  <td></td>
                </tr>
                <tr>
                  <th valign="middle"><label for="txEmail">E-mail:</label></th>
                  <td><input type="text" name="email" id="txEmail" class="inp-form" maxlength="100"></td>
                  <td></td>
                </tr>
                <tr>
                  <th valign="middle">Grupo:</th>
                  <td>
                  	<select name="grupo" id="grupo" class="styledselect_form_1">
						  <?php										
                            $dados = consultaGrupos();
							//print_r ($dados);	
							foreach($dados as $linha) {
								echo "<option value=\"".$linha['idGRUPOS']."\">".$linha['nome']."</option>";
							}
                         ?>
                     </select>
                  </td>
                  <td></td>
                </tr>
                <tr>
                  <th valign="middle"><label for="txObs">Observações:</label></th>
                  <td><textarea rows="" cols="" name="obs" id="obs"  maxlength="200" class="form-textarea"></textarea></td>
                  <td></td>
                </tr>
                <tr>
                  <th></th>
                  <td><input type="submit"  class="form-cadastrar"><input type="reset"  class="form-reset"></td>
                  <td></td>
                </tr>
                </form>
                 <tr height="30">
                  <th></th>
                  <td>
                  <?php	
							
					if(!empty($_POST)){
						if ((empty($_POST['usuario']) OR empty($_POST['senha'])OR empty($_POST['nome'])OR empty($_POST['email']))) {
							mensagemVermelha("Há campos em branco que precisam ser preenchidos."); 
						}else{ 
							if(empty($_POST['grupo']) OR $_POST['grupo'] == ""){
								cadastraGrupos('Sem grupo','5');
								$dados = consultaGrupoCampos('Semgrupo', "", "");
								foreach($dados as $resultado){
									$linha = $resultado;
								}
								cadastraUsuarios($_POST['nome'], $_POST['usuario'], $_POST['senha'], $_POST['email'] ,$linha['idGRUPOS'], $_POST['obs']);
							}else{
								cadastraUsuarios($_POST['nome'], $_POST['usuario'], $_POST['senha'], $_POST['email'] , $_POST['grupo'], $_POST['obs']);
							}
						}
					}

					if(!isset($_SESSION['erroCadastro'])){
						$_SESSION['erroCadastro']="";
					}
										
					if($_SESSION['erroCadastro']=="Usuário já existente" )
						mensagemVermelha("Usuário já existente"); 
					if($_SESSION['erroCadastro']=="E-mail já existente")
						mensagemVermelha("E-mail já existente"); 
					
					if ($_SESSION['loginCadastro'] == "cadastro no login") {
						echo "<form action=\"../A3RA/login.php\" method=\"post\">";
						echo "	<input type=\"submit\"  class=\"form-voltar\" />";
						echo "</form>";
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
	
	
	<div id="related-activities">
		<div id="related-act-top">
		<img src="images/forms/header_related_act.gif" width="271" height="43" alt="">
		</div>
		<div id="related-act-bottom">
			<div id="related-act-inner">
			
				<?php 
					informa ("voltar", "Cadastro","Precauções" ,array(
						"Nome: Nome do usuário em questão. Essa informação será usada em todo o sistema para identificação do usuário.",
						"Login: o login não necessariamente é igual ao nome e será usado para o acesso ao sistema. Será usando para acessar tanto o sistema autoral quanto o sistema cliente. É interessante que não seja muito longo e não tenha caracteres especiais.",
						"Senha: Senha de acesso ao sistema autoral e o sistema cliente.",
						"Email: O email para comunicação com o usuário para itens relevantes e referentes ao sistema.",
						"Grupo: Grupo de usuários que este usuário será incluído. O grupo é obrigatório para cada usuário."));
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