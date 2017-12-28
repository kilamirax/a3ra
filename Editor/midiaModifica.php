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


<div id="page-heading"><h1>Modificação dos dados da midia</h1></div>


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
	$nome= ""; 
	$endereco= "";
	$extensao= ""; 
	$data= ""; 
	$idResponsavel="";
	$responsavel= ""; 
	
	if(!empty($_POST['mod'])){
		$linha = "";

		modificaMidia($_POST['nomeMod'], $_POST['endMod'], $_POST['extMod'], $_POST['dataMod'], $_POST['idMod']);			
		$id = $_POST['idMod'];
		$nome = $_POST['nomeMod']; 
		$endereco = $_POST['endMod'];
		$extensao = $_POST['extMod']; 
		$data= $_POST['dataMod'] ; 
		$idResponsavel = $_POST['idRespMod'];
		$responsavel = $_POST['nomeRespMod'];

	}else{
		$dados = consultaArquivosCampos($_POST['id'],"", "","");
		foreach($dados as $linha){	
			$id = $linha['idARQUIVOS'];
			$nome = $linha['nome']; 
			$endereco = $linha['endereco'];
			$extensao = $linha['extensao']; 
			$data = $linha['data'] ; 
			$idResponsavel = $linha['USUARIOS_idUSUARIOS']; 
		}
		
		$dados =  consultaUsuariosCampos("", "", "", "", "", $idResponsavel);
		foreach($dados as $linha){
			$responsavel = $linha['nome'];
		}
	}	
?>
        	
    
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
	<td>
	
	<!-- start id-form -->
		<div id="table-voltar">
           	<table width="340" border="0" cellpadding="0" cellspacing="0">
           		<form action="../A3RA/midiaConsulta.php" method="post">
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
                 <form action="../A3RA/midiaModifica.php" method="post">
                  <tr>
                    <th valign="top"><label for="txIdMod">Identificador:</label></th>
                    <td><input type="text" readonly="true" name="idMod" id="txIdMod" class="inp-form" value="<?php echo $id;?>"/></td>
                    <td></td>
                  </tr>
                  <tr>
                    <th valign="top"><label for="txNomeMod">Nome:</label></th>
                    <td><input type="text" readonly="true" name="nomeMod" id="txNomeMod" maxlength="100" class="inp-form" value="<?php echo $nome;?>"/></td>
                    <td></td>
                  </tr>
                  <tr>
                    <th valign="top"><label for="txendMod">Endereço:</label></th>
                    <td><input type="text" readonly="true" name="endMod" id="txendMod" maxlength="45" class="inp-form" value="<?php echo $endereco;?>"/></td>
                    <td></td>
                  </tr>
                  <tr>
                    <th valign="top"><label for="txextMod">Extensão:</label></th>
                    <td><input type="text" readonly="true" name="extMod" id="txextMod" maxlength="45" class="inp-form" value="<?php echo $extensao;?>"/></td>
                    <td></td>
                  </tr>
                  <tr>
                    <th valign="top"><label for="txdataMod">Dt Cadastro:</label></th>
                    <td><input type="text" name="dataMod" readonly="true" id="txdataMod" maxlength="100" class="inp-form" value="<?php echo $data;?>"/></td>
                    <td></td>
                  </tr>
                  <tr>
                    <th valign="top" ><label for="txidrespMod">Id Resp.:</label></th>
                    <td><input type="text" readonly="true" name="idRespMod" id="txidrespMod" maxlength="1" class="inp-form" value="<?php echo $idResponsavel;?>"/></td>
                    <td></td>
                  </tr>
                  <tr>
                    <th valign="top"><label for="txnomerespMod">Responsavel:</label></th>
                    <td><input type="text" readonly="true" name="nomeRespMod" id="txnomerespMod" maxlength="1" class="inp-form" value="<?php echo $responsavel;?>"/></td>
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