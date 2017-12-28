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
<div class="clear"></div>
 
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>Modificação de Projetos</h1></div>

<script language="JavaScript" type="text/javascript">

var arrayObjetos = [];
var arrayUserGrupos = [];
var arrayUserNomes = [];

function addAllInputs(divName, inputType){
	var newdiv = document.createElement('div');
	switch(inputType) {
		case 'objetos':
			var nome = "Obj"+document.getElementById('objetos').value ;
			var e = document.getElementById('objetos');
				
			if (arrayObjetos.indexOf(e.value) != -1) { //para não se inserir valores iguais
				alert("não se pode inserir valores iguais.");
			}else{
				newdiv.setAttribute("id", "objeto"+e.value);
				var referencia = "'" + divName + "', 'objeto" + e.value + "', '"+e.value+"', 'obj'";
				var btDelete = '<input type="button" id="bt'+nome+'" class="form-subtratir" onclick="removeLinha('+referencia+')">'; 	
				newdiv.innerHTML = btDelete +"<label valign='middle'>" + e.options[e.selectedIndex].text + "<label>" +
						"<input type='hidden' name='" + nome + "' id='" + nome +"' value='" + e.value + "'/>";
				arrayObjetos.push(e.value);	
			}
		break;
		
		case 'usuariosGrupos':
			var nome = "Gru"+document.getElementById('opcoesUserGrupo').value ;
			var e = document.getElementById('opcoesUserGrupo');
				
			if (arrayUserGrupos.indexOf(e.value) != -1) { //para não se inserir valores iguais
				alert("não se pode inserir valores iguais.");
			}else{
				newdiv.setAttribute("id", "escolhaUserGrupo"+e.value);
				var referencia = "'" + divName + "', 'escolhaUserGrupo" + e.value + "', '"+e.value+"', 'grupo'";
				var btDelete = '<input type="button" id="bt'+nome+'" class="form-subtratir" onclick="removeLinha('+referencia+')">'; 	
				newdiv.innerHTML = btDelete +"<label valign='middle'>" + e.options[e.selectedIndex].text + "<label>" +
						"<input type='hidden' name='" + nome + "' id='" + nome +"' value='" + e.value + "'/>";
				arrayUserGrupos.push(e.value);	
			}

		break;
		
		case 'usuariosNome':
			var nome = "Nom" + document.getElementById('opcoesUserNome').value ;
			var e = document.getElementById('opcoesUserNome');
			
			if (arrayUserNomes.indexOf(e.value) != -1) { //para não se inserir valores iguais
				alert("não se pode inserir valores iguais.");
			}else{
				newdiv.setAttribute("id", "escolhaUserNome"+e.value);
				var referencia = "'" + divName + "', 'escolhaUserNome" + e.value + "', '"+e.value+"', 'nome'";
				var btDelete = '<input type="button" id="bt'+nome+'" class="form-subtratir" onclick="removeLinha('+referencia+')">'; 	
				newdiv.innerHTML = btDelete +'<label valign="middle">' + e.options[e.selectedIndex].text + '<label>' +
						'<input type="hidden" name="' + nome + '" id="' + nome +'" value="' + e.value + '"/>';
				arrayUserNomes.push(e.value);	
			}
		break;
	}
    document.getElementById(divName).appendChild(newdiv);
	//alert(arrayObjetos);
}

function  removeLinha(divPai,div,valor,vetor){
	//alert(divPai+","+div);
	if(vetor =='obj'){
		alert (vetor.indexOf(valor));
		//arrayObjetos.splice(vetor.indexOf(valor), 1);//retira o valor do vetor
		
		for(var i=0;i<arrayObjetos.length;i++){
			alert(arrayObjetos[i]);
		}
	}
	if(vetor =='grupo'){
		//alert ('grupo');
		arrayUserGrupos.splice(vetor.indexOf(valor), 1);//retira o valor do vetor
	}
	if(vetor =='nome'){
		//alert ('nome');
		arrayUserNomes.splice(vetor.indexOf(valor), 1);//retira o valor do vetor
	}
	//remove a div criada com o label e o botão junto
	//document.getElementById(divPai).removeChild(document.getElementById(div));
}

window.onload = function(){}


</script>

<?php

	error_reporting(0); //desabilitar as irritantes mesnagens de warnning
	include('banco.php');
	// A sessão precisa ser iniciada em cada página diferente
	if (!isset($_SESSION)) session_start();
	
	$id = "";
	$nome= ""; 
	$tipo= "";
	$texto= ""; 
	$acesso= ""; 
	$user= ""; 
	$nivel="";
	
	if(!empty($_POST['mod'])){
		$linha = "";
		modificaProjeto($_POST['idMod'], $_POST['nomeMod'],$texto,$_POST['tipoMod'], $_SESSION['UsuarioID'],$_POST['acessoMod']);
			
		$id = $_POST['idMod'];
		$nome = $_POST['nomeMod']; 
		$tipo = $_POST['tipoMod'];
		$acesso = $_POST['acessoMod']; 

		modificaProjeto_UsuarioCampos($id, $user, $_POST['nivelMod']);
		
	}else{
		//user está entrando na consulta como vazio mas quando for implementar o controle de acesso ele deve ser determinante
		$dados = consultaProjetoCampos($_POST['id'], "","","", "","");
		foreach($dados as $linha){
			$id = $linha['idPROJETOS'];
			$nome = $linha['nome']; 
			$texto = $linha['texto'];
			$tipo = $linha['tipo']; 
			$acesso = $linha['acesso']; 
			$user = $linha['USUARIOS_idUSUARIOS']; 
		}
		$dados = consultaProjeto_UsuarioCampos($id, $user, "");
		foreach($dados as $linha){
			$nivel = $linha['nivel'];
		}
	}	
	
?>
<div id="table-voltar">
	<table width="340" border="0" cellpadding="0" cellspacing="0">
		<form action="../A3RA/projetoConsulta.php" method="post">
			<tr>
			<th width="87"></th>
			<td><input type="submit"  class="form-voltar"></td>
			<td></td>
		  </tr>
		</form>
	</table>
</div>
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
	
    <!--table form que tem que funcionar pelo amor de dio-->
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
	<td><form id="form1" method="post" action="../A3RA/projetoCadastro.php">
      <table width="837" height="479" border="0">
		<tr>
			<th valign="top"><label for="txIdMod">Identificador:</label></th>
			<td><input type="text" readonly name="idMod" id="idMod" class="inp-form" value="<?php echo $id;?>"/></td>
			<td></td>
		</tr>
		<tr>
          <td width="63" height="24">Nome:</td>
          <td width="195"><p>
            <input type="text" name="nomeMod" id="nomeMod" class="inp-form" maxlength="100"value="<?php echo $nome;?>"/>
          </p></td>
          <td width="38">&nbsp;</td>
          <td width="481">&nbsp;</td>
        </tr>
        <tr>
          <td height="45">Tipo:</td>
          <td><p>
			<select name="tipoMod" id="tipoMod" class="styledselect_form_1">
				<?php 
				//echo $_POST['tipo'];
					if($_POST['tipo']=="RA"){
						echo "<option value=\"RA\" selected=\"selected\">Realidade Aumentada</option>";
						echo "<option value=\"VA\">Virtualidade Aumentada</option>";
					}else{
						echo "<option value=\"RA\">Realidade Aumentada</option>";
						echo "<option value=\"VA\" selected=\"selected\">Virtualidade Aumentada</option>";
					} 
					
				?>
            </select>
            <p>
             </td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
		<tr>
          <td height="45">Acesso:</td>
          <td><p>
			<select name="acessoMod" id="acessoMod" class="styledselect_form_1">
				<?php 
					if($_POST['acesso']=="publico"){
						echo "<option value=\"publico\" selected=\"selected\">Público</option>";
						echo "<option value=\"privado\">Privado</option>";
					}
					if($_POST['acesso']=="privado"){
						echo "<option value=\"publico\">Público</option>";
						echo "<option value=\"privado\" selected=\"selected\">Privado</option>";
					} 
				?>
            </select>
            <p>
          </td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
       
        <tr height="auto">
          <td height="37">Usuários:</td>
          <td height="37"><select name="opcoesUserNome" id="opcoesUserNome" class="styledselect_form_1" >
            <?php
					echo "<option value=\"\"></option>";
					$dados2 = consultaUsuarios();
					foreach($dados2 as $linha2) {
						echo "<option value=\"".$linha2['idUSUARIOS']."\">".$linha2['nome']."</option>";
					}									
				?>
          </select></td>
          <td></td>
          <td>
          <hr>
		  <input type="button" id="btUserNome" name="btUserNome" class="form-adicionar" 
                                onclick="addAllInputs('divUser','usuariosNome');">
            <?php
				
				$dadosUsuarios = consultaProjeto_UsuarioCampos($id, "", "");
				$contador = 0;
				foreach($dadosUsuarios as $linhaUsuarios){
					$contador++;
					$dadosUsuario = consultaUsuariosCampos("", "", "", "", "", $linhaUsuarios['USUARIOS_idUSUARIOS']);
					foreach($dadosUsuario as $linhaUsuario){
						$referencia = "'divUser', 'escolhaUserNome'".$linhaUsuario['idUSUARIOS']."', '".$linhaUsuario['idUSUARIOS']."', 'nome'";
						$nome = "Nom".$linhaUsuario['idUSUARIOS'];
						echo "<div id=\"escolhaUserNome\"".$linhaUsuario['idUSUARIOS'].">";
						echo 	"<input type=\"button\" id=\"bt".$nome."\" class=\"form-subtratir\" onclick=\"removeLinha($referencia)\">";
						echo 	"<label valign=\"middle\"> ".  $linhaUsuario['nome']."  </label>";
						echo 	"<input type=\"hidden\" name=\"$nome\" id=\"$nome\" value=\"".$linhaUsuario['idUSUARIOS']."\"/>";
						echo "</div>";
						
						echo "<script> arrayUserNomes.push(".$linhaUsuario['idUSUARIOS'].");</script>";
					}
				}
			 ?></td>
        </tr>
        <tr height="auto">
		  <td height="45">Grupos:
		  </td>
          <td height="46">
		    <p>
		      <select name="opcoesUserGrupo" id="opcoesUserGrupo" class="styledselect_form_1" >
		        <?php								
				echo "<option value=\"\"></option>";
				 $dados1 = consultaGrupos();
				//print_r ($dados);	
				foreach($dados1 as $linha1) {
					echo "<option value=\"".$linha1['idGRUPOS']."\">".$linha1['nome']."</option>";
				}
			 ?>
		        </select>
            </p></td>
          <td><p>
            <input type="button" id="btUserGrupo" name="btUserGrupo" class="form-adicionar" 
                                onclick="addAllInputs('divGrupo','usuariosGrupos');">
            </p></td>
          <td>
		  
         	 <div id="divUser">
				<label valign="middle">
				</label>
         	 </div> 
			 
             <div id="divGrupo">
			  <hr>
				<label valign="middle"></label>
			  <?php
				$dadosGrupos = consultaProjeto_GruposCampos($linha['idPROJETOS'], "", "");
				$contador = 0;
				foreach($dadosGrupos as $linhaGrupos){
					$contador++;
					$dadosGrupo = consultaGrupoCampos("", "", $linhaGrupos['GRUPOS_idGRUPOS']);
					foreach($dadosGrupo as $linhaGrupo){
						$referencia =  "'divGrupo', 'escolhaUserGrupo".$linhaGrupo['idGRUPOS']."', '".$linhaGrupo['idGRUPOS']."', 'grupo'";
						$nome = "Gru".$linhaGrupo['idGRUPOS'];
						echo "<div id=\"escolhaUserGrupo".$linhaGrupo['idGRUPOS']."\">";
						echo 	"<input type=\"button\" id=\"bt".$nome."\" class=\"form-subtratir\" onclick=\"removeLinha($referencia)\">";
						echo 	"<label valign=\"middle\">  ".$linhaGrupo['nome']."   </label>";
						echo 	"<input type=\"hidden\" name=\"$nome\" id=\"$nome\" value=\"".$linhaGrupo['idGRUPOS']."\"/>";
						echo "</div>";
						
						echo "<script> arrayUserGrupos.push(".$linhaGrupo['idGRUPOS'].");</script>";
					}
				}
			 ?>
             <hr>
			 </div>
          </td>
        </tr>
        <tr>
          <td height="45" valign="middle">Objetos:</td>
		   <hr>
          <td><p>
            <select name="objetos" id="objetos" class="styledselect_form_1">
				 <?php
					echo "<option value=\"\"></option>";
					 $dados3  = consultaObjetosCampos("", "", $_SESSION['UsuarioID']);
					foreach($dados3 as $linha3) {
						 echo "<option value=\"".$linha3['idOBJETO']."\">".$linha3['nome']."</option>";
					}										
                 ?>
            </select>
          </p>
          </td>
          <td><input type="button" value="" id="addObjeto" name="addObjeto" class="form-adicionar" 
                                        onclick="addAllInputs('divObjetos','objetos');"></td>
          <td>
          	<div id="divObjetos">
			<label valign="middle"></label>
			<?php
				
				$dadosProjObj = consultaProjeto_ObjetosCampos($linha['idPROJETOS'], "");
				$contador = 0;
				foreach($dadosProjObj as $linhaProjObj){
					$contador++;
					$dadosObj = consultaObjetosCampos($linhaProjObj['OBJETO_idOBJETO'], "", "");
					foreach($dadosObj as $linhaObj){
						$referencia = "'divObjetos', 'objeto".$linhaObj['idOBJETO']."', '".$linhaObj['idOBJETO']."', 'obj'";
						$nome = "Obj".$linhaObj['idOBJETO'];
						echo "<div id=\"objeto".$linhaObj['idOBJETO']."\">";
						echo 	"<input type=\"button\" id=\"bt".$nome."\" class=\"form-subtratir\" onclick=\"removeLinha($referencia)\">";
						echo 	"<label valign=\"middle\"> ".$linhaObj['nome']." </label>";
						echo 	"<input type=\"hidden\" name=\"$nome\" id=\"$nome\" value=\"".$linhaObj['idOBJETO']."\"/>";
						echo "</div>";
						
						array_push($objetos, $linhaObj['idOBJETO']);
					}
				}	
			 ?>
             <hr>
			</div>
          </td>
		  
		  <script> 
			var temp = <?php echo json_encode($objetos); ?>;
			for(var i=0;i<temp.length;i++){
				//if(temp[i]!='-1'){
					arrayObjetos.push(temp[i]);
					alert(arrayObjetos[i]);
				//}  
				
			}
			
		  </script>;
		  
        </tr>
        <tr>
          <td height="25">Nível:</td>
          <td><p>
            <input type="text" name="nivelMod" id="acessoMod" class="inp-form" maxlength="1" value="<?php echo $nivel;?>">
          </p>
          </td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="57">Descrição:</td>
          <td colspan="3"><p>
            <label for="obs"></label>
            <textarea name="obsMod" id="obsMod" cols="" rows="" class="form-textarea" maxlength="200">"<?php echo $texto;?>"</textarea>
            </p>
            </td>
          </tr>
          <tr>
          <td height="57"></td>
          <td colspan="3"><p>
            <input type="submit"  class="form-modificar">
            </p>
            </td>
          </tr>
      </table>
	</form>

	
     <?php	
		
		
		
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
					informa ("voltar", "Cadastro","Preocauções" ,array(
						"Nome: Nome do projeto que será criado. Essa informação será usada em todo o sistema para identificação, inclusive no sistema cliente.",
						"Descrição: O projeto deve ser uma área para o autor escrever informações sobre o projeto. Essas informações serão exibidas no cliente para que o projeto seja identificado.",
						"Acesso: Para ser de acesso público ou privado. Sendo público o projeto pode ser acessado por qualquer usuário com o sistema cliente. Sendo privado somente os usuários ou grupos de usuários cadastrados no projeto poderão acessa-lo. Os usuários deverão ser cadastrados previamente para depois serem selecionados para o projeto.",
						"o	Objetos: Os objetos são uma parte muito importante do sistema e o projeto pode cadastrar tantos quanto for necessário. Os objetos deverão ser cadastrados previamente para depois serem selecionados para o projeto."));
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