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


<div id="page-heading"><h1>Modificação de marcador</h1></div>


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
	error_reporting(0); //desabilitar as irritantes mesnagens de warnning
				
	include('banco.php'); 	
			
	$id = "";
	$nome= ""; 
	$usuario= "";
	$senha= ""; 
	$email= ""; 
	$nivel= ""; 
	$ativo= ""; 
	$cadastro= "";
	$obs= "";
	
	if(!empty($_POST['mod'])){
		$linha = "";
		modificaUsuarios($_POST['nomeMod'], $_POST['usuarioMod'], $_POST['senhaMod'], $_POST['emailMod'], 
						$_POST['nivelMod'], $_POST['ativoMod'], $_POST['dataMod'],$_POST['obsTensa'], $_POST['idMod']);			
		$id = $_POST['idMod'];
		$nome = $_POST['nomeMod']; 
		$usuario = $_POST['usuarioMod'];
		$senha = $_POST['senhaMod']; 
		$email = $_POST['emailMod']; 
		$nivel = $_POST['nivelMod']; 
		$ativo = $_POST['ativoMod']; 
		$cadastro = $_POST['dataMod'];
		$obs = $_POST['obsTensa'];

		/*echo "id=".$id  ."<p>";
		echo "nome=".$nome  ."<p>";
		echo "usuario=".$usuario ."<p>";
		echo "senha=".$senha ."<p>"; 
		echo "email=".$email ."<p>";
		echo "nivel=".$nivel  ."<p>";
		echo "ativo=".$ativo  ."<p>";
		echo "cadastro=".$cadastro ."<p>";
		echo "obs=".$obs  ."<p>";*/
	}else{
		
		/*echo "nome ".$_POST['nome']."</p>";
		echo "usuario ".$_POST['usuario']."</p>";
		echo "email ".$_POST['email']."</p>";*/
		
		$dados = consultaUsuariosCampos($_POST['nome'], $_POST['usuario'], $_POST['email']);
		$linha = mysql_fetch_assoc($dados);
		
		$id = $linha['idUSUARIOS'];
		$nome = $linha['nome']; 
		$usuario = $linha['usuario'];
		$senha = $linha['senha']; 
		$email = $linha['email']; 
		$nivel = $linha['nivel']; 
		$ativo = $linha['ativo']; 
		$cadastro = $linha['data'];
		$obs = $linha['obs'];
	}	
?>
        	
    
    
    
    
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
	<td>
	
	<!-- start id-form -->
		<div id="table-voltar">
           	<table width="340" border="0" cellpadding="0" cellspacing="0">
           		<form action="../A3RA/usuarioConsulta.php" method="post">
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
                 <form action="../A3RA/usuarioModifica.php" method="post">
                  <tr>
                    <th valign="top"><label for="txIdMod">Identificador:</label></th>
                    <td><input type="text" readonly="true" name="idMod" id="txIdMod" class="inp-form" value="<?php echo $id;?>"/></td>
                    <td></td>
                  </tr>
                  <tr>
                    <th valign="top"><label for="txNomeMod">Nome:</label></th>
                    <td><input type="text" name="nomeMod" id="txNomeMod" maxlength="100" class="inp-form" value="<?php echo $nome;?>"/></td>
                    <td></td>
                  </tr>
                  <tr>
                    <th valign="top"><label for="txUsuarioMod">Usuário:</label></th>
                    <td><input type="text" name="usuarioMod" id="txUsuarioMod" maxlength="45" class="inp-form" value="<?php echo $usuario;?>"/></td>
                    <td></td>
                  </tr>
                  <tr>
                    <th valign="top"><label for="txSenhaMod">Senha:</label></th>
                    <td><input type="text" name="senhaMod" id="txSenhaMod" maxlength="45" class="inp-form" value="<?php echo $senha;?>"/></td>
                    <td></td>
                  </tr>
                  <tr>
                    <th valign="top"><label for="txEmailMod">E-mail:</label></th>
                    <td><input type="text" name="emailMod" id="txEmailMod" maxlength="100" class="inp-form" value="<?php echo $email;?>"/></td>
                    <td></td>
                  </tr>
                  <tr>
                    <th valign="top" ><label for="txNivelMod">Nível:</label></th>
                    <td><input type="text" name="nivelMod" id="txNivelMod" maxlength="1" class="inp-form" value="<?php echo $nivel ;?>"/></td>
                    <td></td>
                  </tr>
                  <tr>
                    <th valign="top"><label for="txAtivoMod">Ativo:</label></th>
                    <td><input type="text" name="ativoMod" id="txAtivoMod" maxlength="1" class="inp-form" value="<?php echo $ativo;?>"/></td>
                    <td></td>
                  </tr>
                  <tr>
                    <th valign="top"><label for="txDataMod">Dt Cadastro:</label></th>
                    <td><input type="text" name="dataMod" id="txDataMod" maxlength="29" class="inp-form" value="<?php echo $cadastro;?>"/></td>
                    <td></td>
                  </tr>
                  <tr>
                    <th valign="top"><label for="txObsMod">Observações:</label></th>
                    <td><textarea  rows="" cols="" name="obsTensa" maxlength="200" class="form-textarea" id="obsTensa"><?php echo $obs;?></textarea></td>
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
					informa ("voltar", "Cadastro","Preocauções" ,array(
						"Quero",
						"testar",
						"sapoha"));
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