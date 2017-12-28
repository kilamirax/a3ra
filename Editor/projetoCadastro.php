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


<div id="page-heading"><h1>Cadastro de Projetos</h1></div>

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
				//alert(referencia);
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
		//alert ('obj');
		/*
		for(var i=0;i<arrayObjetos.length;i++){
			alert(arrayObjetos[i]);
		}
		*/
		arrayObjetos.splice(vetor.indexOf(valor), 1);//retira o valor do vetor
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
	document.getElementById(divPai).removeChild(document.getElementById(div));
}

window.onload = function(){
		document.getElementById('tipoUser').style.display = "none"; 
		document.getElementById('btUserGrupo').style.display = "none"; 
		document.getElementById('opcoesUserNome').style.display = "none"; 
		document.getElementById('opcoesUserGrupo').style.display = "none"; 
		document.getElementById('btUserNome').style.display = "none"; 	
		document.getElementById('divUser').style.display = "none"; 
		document.getElementById('divGrupo').style.display = "none";
}

function  habilitarCamposUsuario(){
	//1° check se é privado ou publico
	if(document.getElementById('publico').checked){
		document.getElementById('tipoUser').style.display = "none"; 
		document.getElementById('btUserGrupo').style.display = "none"; 
		document.getElementById('opcoesUserNome').style.display = "none"; 
		document.getElementById('opcoesUserGrupo').style.display = "none"; 
		document.getElementById('btUserNome').style.display = "none"; 	
		document.getElementById('divUser').style.display = "none"; 
		document.getElementById('divGrupo').style.display = "none";
	}
	if(document.getElementById('privado').checked){
		document.getElementById('tipoUser').style.display = "inline"; 
		//segundo check para ver se é por grupo ou por nome
		if(document.getElementById('grupo').checked){
			document.getElementById('btUserGrupo').style.display = "inline"; 
			document.getElementById('opcoesUserNome').style.display = "none"; 
			document.getElementById('opcoesUserGrupo').style.display = "inline"; 
			document.getElementById('btUserNome').style.display = "none"; 	
			document.getElementById('divUser').style.display = "none"; 
			document.getElementById('divGrupo').style.display = "inline";
		}
		if(document.getElementById('nome').checked){
			document.getElementById('btUserGrupo').style.display = "none"; 
			document.getElementById('opcoesUserNome').style.display = "inline"; 
			document.getElementById('opcoesUserGrupo').style.display = "none"; 
			document.getElementById('btUserNome').style.display = "inline"; 	
			document.getElementById('divUser').style.display = "inline"; 
			document.getElementById('divGrupo').style.display = "none";
		}
	}
	
	

}
</script>

<?php
	error_reporting(0); //desabilitar as irritantes mesnagens de warnning
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
	
    <!--table form que tem que funcionar pelo amor de dio-->
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
	<td><form id="form1" method="post" action="../A3RA/projetoCadastro.php">
      <table width="837" height="309" border="0">
        <tr>
          <td width="63" height="24">Nome:</td>
          <td width="195"><p>
            <input type="text" name="nome" id="nome3" class="inp-form" maxlength="100">
          </p></td>
          <td width="38">&nbsp;</td>
          <td width="481">&nbsp;</td>
        </tr>
        <tr>
          <td height="45">Tipo:</td>
          <td><p>
             <input type="radio" name="tipo" id="RA" value="RA" checked="checked">Realidade Aumentada</p>
            <p>
            <!--   <input readonly type="radio" name="tipo" id="VA" value="VA">Virtualidade Aumentada</p> -->
             </td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td rowspan="2">Usuários:</td>
          <td height="48"><p>
            <input type="radio" name="acesso" id="publico" value="publico" onChange="habilitarCamposUsuario()" checked="checked">Público</p>
            <p>
              <input type="radio" name="acesso" id="privado" value="privado" onChange="habilitarCamposUsuario()">Privado</p>
          </td>
          <td>&nbsp;</td>
          <td>
          	<div id="tipoUser">
                  <input type="radio" name="radTipoUser" id="grupo" value="grupo" onChange="habilitarCamposUsuario()">Grupos de usuários<br>
                  <input type="radio" name="radTipoUser" id="nome" value="nome" onChange="habilitarCamposUsuario()">Nomes de usuários
             </div>      
          </td>
        </tr>
        <tr height="auto">
          <td height="46"><p>
            <select name="opcoesUserGrupo" id="opcoesUserGrupo" class="styledselect_form_1" >
              <?php										
				 $dados1 = consultaGrupos();
				//print_r ($dados);	
				foreach($dados1 as $linha1) {
					echo "<option value=\"".$linha1['idGRUPOS']."\">".$linha1['nome']."</option>";
				}
			 ?>
              </select>
            </p>
            <p>
              <select name="opcoesUserNome" id="opcoesUserNome" class="styledselect_form_1" >
                <?php
					$dados2 = consultaUsuarios();
					foreach($dados2 as $linha2) {
						echo "<option value=\"".$linha2['idUSUARIOS']."\">".$linha2['nome']."</option>";
					}									
				?>
                </select>
            </p></td>
          <td><p>
            <input type="button" id="btUserGrupo" name="btUserGrupo" class="form-adicionar" 
                                onclick="addAllInputs('divGrupo','usuariosGrupos');">
          </p>
            <p>
              <input type="button" id="btUserNome" name="btUserNome" class="form-adicionar" 
                                onclick="addAllInputs('divUser','usuariosNome');">
            </p></td>
          <td>
         	 <div id="divUser"></div> 
             <div id="divGrupo"></div>
          </td>
        </tr>
        <tr>
          <td height="45">Objetos:</td>
          <td><p>
            <select name="objetos" id="objetos" class="styledselect_form_1">
				 <?php
					 $dados3  = consultaObjetosCampos("", "", $_SESSION['UsuarioID'],"");
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
          	<div id="divObjetos"></div>
          </td>
        </tr>
        <tr>
          <td height="25">Nível:</td>
          <td><p>
            <input type="text" name="nivel" id="nivel" class="inp-form" maxlength="1">
          </p>
          </td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="57">Descrição:</td>
          <td colspan="3"><p>
            <label for="obs"></label>
            <textarea name="obs" id="obs" cols="" rows="" class="form-textarea" maxlength="200"></textarea>
            </p>
            </td>
          </tr>
          <tr>
          <td height="57"></td>
          <td colspan="3"><p>
            <input type="submit"  class="form-cadastrar"><input type="reset"  class="form-reset">
            </p>
            </td>
          </tr>
      </table>
	</form>
    <!--fim da table form que tem que funcionar pelo amor de dio-->
     <?php	
		
		if(!empty($_POST)){
			
			/*pode ter vários valores de nome de usuário, grupos de usuarios e objetos,
			aqui eu trato esses valores e os separo em arrays
			*/
			$objetos = array();
			$userGrupos = array();
			$userNomes = array();
			
			$temp = $_POST;
			foreach($_POST as $valor) {
				if(substr(key($temp),0,3) =="Obj"){
					array_push($objetos, $valor);
					//echo key($temp)." = ". $valor."<br>";
				}
				if(substr(key($temp),0,3) =="Gru"){
					array_push($userGrupos, $valor);
				}
				if(substr(key($temp),0,3) =="Nom"){
					array_push($userNomes, $valor);
				}
				next($temp );
			}
			
			if (empty($_POST['nivel']) OR empty($_POST['nome']) OR (count($objetos) == 0)) {
				mensagemVermelha("Há campos em branco que precisam ser preenchidos."); 
			}else{ 
				if($_POST['acesso'] == "privado"){
					if($_POST['radTipoUser'] == "nome"){
						cadastraProjetos($_POST['nome'], $_POST['tipo'], $_POST['acesso'], "", $userNomes, $objetos, $_POST['nivel'], $_POST['obs'],$_SESSION['UsuarioID'], $_POST['acesso']);
					}
					if($_POST['radTipoUser'] == "grupo"){
						cadastraProjetos($_POST['nome'], $_POST['tipo'], $_POST['acesso'], $userGrupos, "", $objetos, $_POST['nivel'], $_POST['obs'],$_SESSION['UsuarioID'], $_POST['acesso']);
					}
				}else{
					cadastraProjetos($_POST['nome'], $_POST['tipo'], $_POST['acesso'], "", "", $objetos, $_POST['nivel'], $_POST['obs'],$_SESSION['UsuarioID'], $_POST['acesso']);
				}
			}
				//var_dump($_POST);
		}	
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