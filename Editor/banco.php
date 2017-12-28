<?php
include('conexao.php');
include('mensagens.php');
/*
-------------------------------------------------------------------------------------------------------------------
USUÁRIOS
-------------------------------------------------------------------------------------------------------------------

*/
function consultaUsuarios(){
	$stmt = getConn()->query("SELECT * FROM USUARIOS");
	$dados = $stmt->fetchAll();
	closeConn();
	return $dados;
}


function cadastraUsuarios($nome, $usuario, $senha, $email , $grupo, $obs){
	$_SESSION['erroCadastro']="";
	if(!isset($_SESSION['loginCadastro'])){
		$_SESSION['loginCadastro']="";
	}	
	$dados = consultaUsuariosCampos("", $usuario, "", $email, "", "");
	
	if (sizeof($dados)>= 1) {
		if($dados['usuario'] == $usuario){
			$_SESSION['erroCadastro']="Usuário já existente"; 
		}
		if($dados['email'] == $email){
			$_SESSION['erroCadastro']="E-mail já existente";
		}
	} else{	
		try{
			//tem que rever a query depois de implantando controle de acesso	
			$nivel = '3';
			$ativo = '0';
			$dataHj = date(DATE_RFC822);

			// prepare sql and bind parameters
			$conn = getConn();
			$stmt = $conn->prepare("INSERT INTO USUARIOS  (nome, usuario, senha, email, nivel, ativo, data, obs, GRUPOS_idGRUPOS)  
							VALUES (:nome, :usuario, :senha, :email, :nivel, :ativo, :data, :obs, :GRUPOS_idGRUPOS)");
			$stmt->bindParam(':nome', $nome);
			$stmt->bindParam(':usuario', $usuario);
			$stmt->bindParam(':senha', $senha);
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':nivel', $nivel);
			$stmt->bindParam(':ativo', $ativo);
			$stmt->bindParam(':data', $dataHj);
			$stmt->bindParam(':obs', $obs);
			$stmt->bindParam(':GRUPOS_idGRUPOS', $grupo);
			$stmt->execute();
			mensagemVerde("Cadastro de usuário foi realizado com sucesso.");
			if ($_SESSION['loginCadastro'] == "cadastro no login"){
				mensagemAmarela("Aguarde o administrador configurar seu perfil.");
			}
			closeConn();
		}catch(PDOException $e){
			echo "Error: " . $e->getMessage();
		}
	}	
}

function consultaUsuariosCampos($nome, $usuario, $senha, $email, $grupo, $idUser){
	$colunas = array();
	$valores = array();
	
	if ($nome !=""){
		array_push($colunas, "nome");
		array_push($valores,$nome);
	}
	if ($grupo !=""){
		array_push($colunas, "GRUPOS_idGRUPOS");
		array_push($valores,$grupo);
	}
	if ($usuario !=""){ 
		array_push($colunas,"usuario");
		array_push($valores,$usuario);
	}
	if ($senha !=""){ 
		array_push($colunas,"senha");
		array_push($valores,$senha);
	}
	if ($email !=""){
		array_push($colunas,"email");
		array_push($valores,$email);
	}
	if ($idUser !=""){
		array_push($colunas,"idUSUARIOS");
		array_push($valores,$idUser);
	}
	
	$query = "SELECT * FROM A3RA1.USUARIOS WHERE (";
	$temp = "";
	for ($i = 0; $i < sizeof($colunas); $i++) {
		if(sizeof($colunas)-1 ==$i){
			$temp = $temp."USUARIOS.".$colunas[$i]."='".$valores[$i]."'";
		}else{
			$temp =  $temp."USUARIOS.".$colunas[$i]."='".$valores[$i]."') AND (";
		}
	}
	$query = $query.$temp.") ";
	//echo $query;
	
	// retorna e executa a query
	try {
		$stmt = getConn()->query($query);
		$dados = $stmt->fetchAll();
		closeConn();
		return $dados;
	}catch(PDOException $e){
		//echo "Error: " . $e->getMessage();
	}
}



function modificaUsuarios($nome, $usuario, $senha, $email, $nivel, $ativo, $cadastro, $obs, $grupo, $id){

	$sql = "update USUARIOS SET 
	USUARIOS.nome = '". $nome ."',
	USUARIOS.usuario = '". $usuario ."',
	USUARIOS.senha = '". $senha ."',
	USUARIOS.email = '". $email ."',
	USUARIOS.nivel = '". $nivel ."',
	USUARIOS.ativo = '". $ativo ."',
	USUARIOS.data = '". $cadastro ."',
	USUARIOS.obs = '".$obs."',
	USUARIOS.GRUPOS_idGRUPOS = '".$grupo."'
	WHERE USUARIOS.idUSUARIOS = '".$id."'";
	
	//echo "<br>".$sql."<br>"."<br>";
	
	$stmt = getConn()->query($sql);
	$stmt->execute();
	closeConn();
	mensagemVerde("Modificação realizada com sucesso.");
	
}

function deletaUsuario($id){
	$sql = "DELETE FROM USUARIOS WHERE USUARIOS.idUSUARIOS='$id'";
	$stmt = getConn()->query($sql);
	closeConn();
	$_SESSION['usuarioDeletado']="deletado";
}

//valida se tem caracter problematico no cadastro
function ValidarEmail($email){
	if (!preg_match ("/^[A-Za-z0-9]+([_.-][A-Za-z0-9]+)*@[A-Za-z0-9]+([_.-][A-Za-z0-9]+)*\\.[A-Za-z0-9]{2,4}$/", $email) &&
		!$email == "")
	  return false;
	else
	  return true;
}


/*
-------------------------------------------------------------------------------------------------------------------
GRUPOS
-------------------------------------------------------------------------------------------------------------------

*/
function consultaGrupos(){
	$stmt = getConn()->query("SELECT * FROM GRUPOS");
	$dados = $stmt->fetchAll();
	//$dados = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
	closeConn();
	return $dados;

}

function consultaGrupoCampos($nome, $nivel, $id){
	$colunas = array();
	$valores = array();
	
	if ($nome !=""){
		array_push($colunas, "nome");
		array_push($valores,$nome);
	}
	if ($nivel !=""){
		array_push($colunas, "nivel");
		array_push($valores,$nivel);
	}
	if ($id !=""){ 
		array_push($colunas,"idGRUPOS");
		array_push($valores,$id);
	}
	
	$query = "SELECT * FROM GRUPOS WHERE (";
	$temp = "";
	for ($i = 0; $i < sizeof($colunas); $i++) {
		if(sizeof($colunas)-1 ==$i){
			$temp = $temp.$colunas[$i]."='".$valores[$i]."'";
		}else{
			$temp = $temp.$colunas[$i]."='".$valores[$i]."') AND (";
		}
	}
	$query = $query.$temp.") ";
	//echo $query;
	try {
	// retorna e executa a query
		$stmt = getConn()->query($query);
		$dados = $stmt->fetchAll();
		return $dados;
		closeConn();
	}catch(PDOException $e){
		echo "Erro: " . $e->getMessage();
		return "sem grupos";
	}	
}


function cadastraGrupos($nome, $nivel){
	
	$_SESSION['erroCadastro']="" ;
	$dados = consultaGrupoCampos($nome, "", "");
	
	if (sizeof($dados) == 1) {
		$_SESSION['erroCadastro']="Grupo já existente"; 
		header("Location: ../A3RA/grupoCadastro.php"); exit;		
	} else{		
		$conn = getConn();
		$stmt = $conn->prepare("INSERT INTO GRUPOS (nome, nivel)  
							VALUES (:nome, :nivel)");
		$stmt->bindParam(':nome', $nome);
		$stmt->bindParam(':nivel', $nivel);
		$stmt->execute();
		mensagemVerde("Cadastro de grupo realizado com sucesso.");
		closeConn();
	}	
}

function modificaGrupo($nome, $nivel, $id){

	$sql = "update GRUPOS SET 
	GRUPOS.nome = '". $nome ."',
	GRUPOS.nivel = '". $nivel ."'
	WHERE GRUPOS.idGRUPOS = '".$id."'";
	
	$stmt = getConn()->query($sql);
	$stmt->execute();
	closeConn();
	mensagemVerde("Modificação realizada com sucesso.");
}

function deletaGrupo($id){
	$sql = "DELETE FROM ".$database.".GRUPOS WHERE GRUPOS.idGRUPOS = '$id'";
	$stmt = getConn()->query($sql);
	closeConn();
	$_SESSION['grupoDeletado']="deletado";
}



/*
-------------------------------------------------------------------------------------------------------------------
ARQUIVOS
-------------------------------------------------------------------------------------------------------------------

*/
function cadastraArquivo($nome, $endereco, $extensao, $tamanho, $id ){
	$conn = getConn();	
	$dataHj = date(DATE_RFC822);

	$stmt = $conn->prepare("INSERT INTO ARQUIVOS  (nome, endereco, extensao, tamanho, data, USUARIOS_idUSUARIOS)  
						VALUES (:nome, :endereco, :extensao, :tamanho, :dataHj, :USUARIOS_idUSUARIOS)");
	$stmt->bindParam(':nome', $nome);
	$stmt->bindParam(':endereco', $endereco);
	$stmt->bindParam(':extensao', $extensao);
	$stmt->bindParam(':tamanho', $tamanho);
	$stmt->bindParam(':dataHj', $dataHj);
	$stmt->bindParam(':USUARIOS_idUSUARIOS', $id);
	$stmt->execute();
	mensagemVerde("Cadastro de arquivo foi realizado com sucesso.");
	$_SESSION['arquivoCadastro']="cadastrado";	
	closeConn();
}

function consultaArquivosCampos($id, $nome, $extensao, $idUser){
	$colunas = array();
	$valores = array();
	if ($id !=""){
		array_push($colunas,"idARQUIVOS");
		array_push($valores,$id);
	}
	if ($nome !=""){
		array_push($colunas, "nome");
		array_push($valores,$nome);
	}
	if ($extensao !=""){
		array_push($colunas,"extensao");
		array_push($valores,$extensao);
	}
	if ($idUser !=""){
		array_push($colunas,"USUARIOS_idUSUARIOS");
		array_push($valores,$idUser);
	}
	
	$query = "SELECT * FROM ARQUIVOS WHERE (";
	$temp = "";
	for ($i = 0; $i < sizeof($colunas); $i++) {
		if(sizeof($colunas)-1 ==$i){
			$temp = $temp.$colunas[$i]."='".$valores[$i]."'";
		}else{
			$temp = $temp.$colunas[$i]."='".$valores[$i]."') AND (";
		}
	}
	$query = $query.$temp.") ";
	//echo $query;
	$stmt = getConn()->query($query );
	$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
	closeConn();
	return $dados;
}
	
function consultaArquivos(){
	$query = "SELECT * FROM ARQUIVOS";
	$stmt = getConn()->query($query );
	$dados = $stmt->fetchAll();
	closeConn();
	return $dados;
}

function modificaMidia($nome, $endereco, $extensao, $data,  $id){

	$sql = "update ARQUIVOS SET 
	ARQUIVOS.nome = '". $nome ."',
	ARQUIVOS.endereco = '". $endereco ."',
	ARQUIVOS.extensao = '". $extensao ."',
	ARQUIVOS.data = '". $data ."' 
	WHERE arquivos.idARQUIVOS = '".$id."'";
	
	$stmt = getConn()->query($sql);
	$stmt->execute();
	closeConn();
	
	mensagemVerde("Modificação realizada com sucesso.");
}

function deletaMidia($id, $idUser){
	$sql = "DELETE FROM ARQUIVOS WHERE idARQUIVOS='$id'";
	$stmt = getConn()->query($sql);
	closeConn();
	$_SESSION['arquivoDeletado']="deletado";
}


/*
-------------------------------------------------------------------------------------------------------------------
GPS
-------------------------------------------------------------------------------------------------------------------

*/

function cadastraGPS($nome, $texto, $latitude,$longitude, $tipo, $id ){

	$dados = consultaGPSCampos("", $nome, "", "","", "");

	if (sizeof($dados) >= 1) {
		mensagemVermelha("GPS com o nome $nome já cadastrado.");
	} else{	
		try {	
			$conn = getConn();
			
			$lat = $latitude;
			$lon = $longitude;
			$alt = 0;
			$query = "INSERT INTO GEOPOS  (latitude, longitude, altura, nome, texto, tipo, USUARIOS_idUSUARIOS)  
								  VALUES (:latitude,:longitude,:altura,:nome,:texto,:tipo,:USUARIOS_idUSUARIOS)";
			$stmt = $conn->prepare($query);
			$stmt->bindParam(':latitude', $lat);
			$stmt->bindParam(':longitude', $lon);
			$stmt->bindParam(':altura', $alt);
			$stmt->bindParam(':nome', $nome);
			$stmt->bindParam(':texto', $texto);
			$stmt->bindParam(':tipo', $tipo);
			$stmt->bindParam(':USUARIOS_idUSUARIOS', $id);
			$stmt->execute();
			mensagemVerde("Cadastro de GPS foi realizado com sucesso.");
			closeConn();
		}catch(PDOException $e){
			echo "Error: " . $e->getMessage();
		}
	}	
}

function consultaGPSCampos($id, $nome, $lat, $lon, $tipo, $idUser){
	$colunas = array();
	$valores = array();
	
	if ($id !=""){
		array_push($colunas,"idGEOPOS");
		array_push($valores,$id);
	}
	if ($nome !=""){
		array_push($colunas, "nome");
		array_push($valores,$nome);
	}
	if ($lat !=""){
		array_push($colunas,"latitude");
		array_push($valores,$lat);
	}
	if ($lon !=""){
		array_push($colunas,"longitude");
		array_push($valores,$lon);
	}
	if ($tipo !=""){
		array_push($colunas,"tipo");
		array_push($valores,$tipo);
	}
	if ($idUser !=""){
		array_push($colunas,"USUARIOS_idUSUARIOS");
		array_push($valores,$idUser);
	}
	
	$query = "SELECT * FROM GEOPOS WHERE (";
	$temp = "";
	for ($i = 0; $i < sizeof($colunas); $i++) {
		if(sizeof($colunas)-1 ==$i){
			$temp = "GEOPOS.".$temp.$colunas[$i]."='".$valores[$i]."'";
		}else{
			$temp = "GEOPOS.".$temp.$colunas[$i]."='".$valores[$i]."') AND (";
		}
	}
	$query = $query.$temp.") ";
	//echo $query;
	$stmt = getConn()->query($query );
	$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
	closeConn();
	return $dados;
}
	
function consultaGPS(){
	$query = "SELECT * FROM GEOPOS";
	$stmt = getConn()->query($query );
	$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
	closeConn();
	return $dados;
}

function modificaGPS($nome, $texto, $lat, $lon, $tipo, $id){

	$sql = "update a3ra1.geopos SET 
	nome = '$nome',
	texto = '$texto',
	latitude = '$lat',
	longitude = '$lon', 
	altura = '0', 
	tipo = '$tipo'
	WHERE idGEOPOS = '$id'";
	
	$stmt = getConn()->query($sql);
	$stmt->execute();
	closeConn();
	
	mensagemVerde("Modificação realizada com sucesso.");
}

function deletaGPS($id){
	$sql = "DELETE FROM GEOPOS WHERE GEOPOS.idGEOPOS='$id'";
	$stmt = getConn()->query($sql);
	closeConn();
	$_SESSION['gpsDeletado']="deletado";
}


/*
-------------------------------------------------------------------------------------------------------------------
MARCADORES
-------------------------------------------------------------------------------------------------------------------

*/

function cadastraMarcadores($nome, $targetID, $tamanho, $dimensao, $idUser){
	$dados =  consultaMarcadoresCampos("", $nome, "", "");
	
	if (sizeof($dados) >= 1) {
		mensagemVermelha("Imagem com o nome $nome já cadastrado.");
	} else{	
		try {	
			$conn = getConn();
			
			$query = "INSERT INTO MARCADORES  (nome, targetID, tamanho, dimensao, USUARIOS_idUSUARIOS)  
								  VALUES (:nome,:targetID,:tamanho,:dimensao,:USUARIOS_idUSUARIOS)";
			$stmt = $conn->prepare($query);
			$stmt->bindParam(':nome', $nome);
			$stmt->bindParam(':targetID', $targetID);
			$stmt->bindParam(':tamanho', $tamanho);
			$stmt->bindParam(':dimensao', $dimensao);
			$stmt->bindParam(':USUARIOS_idUSUARIOS', $idUser);
			$stmt->execute();
			mensagemVerde("Cadastro de marcador foi realizado com sucesso.");
			closeConn();
		}catch(PDOException $e){
			echo "Error: " . $e->getMessage();
		}
	}	
}

function consultaMarcadoresCampos($id, $nome, $targetID, $idUser){
	$colunas = array();
	$valores = array();
	
	if ($id !=""){
		array_push($colunas, "idMARCADORES");
		array_push($valores,$id);
	}
	if ($nome !=""){
		array_push($colunas, "nome");
		array_push($valores,$nome);
	}
	if ($targetID !=""){
		array_push($colunas,"targetID");
		array_push($valores,$targetID);
	}
	if ($idUser !=""){
		array_push($colunas,"USUARIOS_idUSUARIOS");
		array_push($valores,$idUser);
	}
	
	$query = "SELECT * FROM MARCADORES WHERE (";
	$temp = "";
	for ($i = 0; $i < sizeof($colunas); $i++) {
		if(sizeof($colunas)-1 ==$i){
			$temp = $temp.$colunas[$i]."='".$valores[$i]."'";
		}else{
			$temp = $temp.$colunas[$i]."='".$valores[$i]."') AND (";
		}
	}
	$query = $query.$temp.") ";
	//echo $query;
	$stmt = getConn()->query($query );
	$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
	closeConn();
	return $dados;
}
	
function consultaMarcadores(){
	$query = "SELECT * FROM MARCADORES";
	$stmt = getConn()->query($query );
	$dados = $stmt->fetchAll();
	closeConn();
	return $dados;
}

function deletaMarcadores($id){
	$sql = "DELETE FROM MARCADORES WHERE MARCADORES.idMARCADORES='$id'";
	$stmt = getConn()->query($sql);
	closeConn();
	$_SESSION['marcadorDeletado']="deletado";
}


/*
-------------------------------------------------------------------------------------------------------------------
OBJETOS
-------------------------------------------------------------------------------------------------------------------

*/

function cadastraObjetos($nome, $texto, $marcador, $geo, $arquivo, $id, $targetId){
	
	$dados = consultaObjetosCampos("", $nome, "","");
	
	if (sizeof($dados) >= 1) {
		$_SESSION['erroCadastroObjeto']="Objeto multimídia já existente"; 
	} else{	
		try {
			$colunas = array();
			$valores = array();
			
			if ($nome !=""){
				array_push($colunas, "nome");
				array_push($valores,$nome);
			}
			if ($texto !=""){
				array_push($colunas,"texto");
				array_push($valores,$texto);
			}
			if ($marcador !=""){
				array_push($colunas,"MARCADORES_idMARCADORES");
				array_push($valores,$marcador);
			}
			if ($geo !=""){
				array_push($colunas,"GEOPOS_idGEOPOS");
				array_push($valores,$geo);
			}
			if ($arquivo !=""){
				array_push($colunas,"ARQUIVOS_idARQUIVOS");
				array_push($valores,$arquivo);
			}
			if ($id !=""){
				array_push($colunas,"usuario");
				array_push($valores,$id);
			}
			if ($targetId !=""){
				array_push($colunas,"TARGETID");
				array_push($valores,$targetId);
			}
			
			$query = "INSERT INTO OBJETO  (";
			$temp = "";
			for ($i = 0; $i < sizeof($colunas); $i++) {
				if(sizeof($colunas)-1 ==$i){
					$temp = $temp."OBJETO.".$colunas[$i].")";
				}else{
					$temp = $temp."OBJETO.".$colunas[$i].", ";
				}
			}
			$query = $query.$temp." values (";
			$temp = "";
			for ($i = 0; $i < sizeof($valores); $i++) {
				if(sizeof($valores)-1 ==$i){
					$temp = $temp.":".$colunas[$i].")";
				}else{
					$temp = $temp.":".$colunas[$i].", ";
				}
			}
			$query = $query.$temp;
			
			//echo $query;
			
			$conn = getConn();
			$stmt = $conn->prepare($query);
			
			if ($nome !="")	$stmt->bindParam(':nome', $nome);
			if ($texto !="")$stmt->bindParam(':texto', $texto);
			if ($marcador !="")$stmt->bindParam(':MARCADORES_idMARCADORES', $marcador);
			if ($geo !="")$stmt->bindParam(':GEOPOS_idGEOPOS', $geo);
			if ($arquivo !="")$stmt->bindParam(':ARQUIVOS_idARQUIVOS', $arquivo);
			if ($id !="")$stmt->bindParam(':usuario', $id);
			if ($targetId !="")$stmt->bindParam(':TARGETID', $targetId);
			
			//print_r($stmt);
			$stmt->execute();
			mensagemVerde("Seu cadastro foi realizado com sucesso.");
			closeConn();
			$_SESSION['objetoCadastro']="cadastrado";
			
		}catch(PDOException $e){
			echo "Error: " . $e->getMessage();
		}
	}	
}

function consultaObjetosCampos($id, $nome, $idUser, $targetId){
	try {
		$colunas = array();
		$valores = array();
		
		if ($id !=""){
			array_push($colunas,"idOBJETO");
			array_push($valores,$id);
		}
		if ($nome !=""){
			array_push($colunas, "nome");
			array_push($valores,$nome);
		}
		if ($idUser !=""){
			array_push($colunas,"usuario");
			array_push($valores,$idUser);
		}
		if ($targetId !=""){
			array_push($colunas,"TARGETID");
			array_push($valores,$targetId);
		}
		
		$query = "SELECT * FROM OBJETO WHERE (";
		$temp = "";
		for ($i = 0; $i < sizeof($colunas); $i++) {
			if(sizeof($colunas)-1 ==$i){
				$temp = $temp."OBJETO.".$colunas[$i]."='".$valores[$i]."'";
			}else{
				$temp = $temp."OBJETO.".$colunas[$i]."='".$valores[$i]."') AND (";
			}
		}
		$query = $query.$temp.") ";
		//echo $query;
		$stmt = getConn()->query($query );
		$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
		closeConn();
		return $dados;
	}catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}
}
	
function consultaObjetos(){
	$query = "SELECT * FROM OBJETO";
	$stmt = getConn()->query($query );
	$dados = $stmt->fetchAll();
	closeConn();
	return $dados;
}

function modificaObjetos($nome, $marcador, $geo, $arquivo, $texto,  $usuario, $id, $targetId){
	
	try {
		$sql = "update OBJETO SET 
		OBJETO.nome = '". $nome ."',
		OBJETO.MARCADORES_idMARCADORES = '". $marcador ."',
		OBJETO.GEOPOS_idGEOPOS = '". $geo ."',
		OBJETO.ARQUIVOS_idARQUIVOS = '". $arquivo ."',
		OBJETO.usuario = '". $usuario ."', 
		OBJETO.texto = '". $texto ."' 
		OBJETO.TARGETID = '". $targetId ."' 
		WHERE OBJETO.idOBJETO = '".$id."'";
		
		
		$stmt = getConn()->query($sql);
		$stmt->execute();
		closeConn();
		mensagemVerde("Modificação realizada com sucesso.");
		
	}catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}
}

function deletaObjetos($id){
	$sql = "DELETE FROM OBJETO WHERE OBJETO.idOBJETO='$id'";
	$stmt = getConn()->query($sql);
	closeConn();
	$_SESSION['objetoDeletado']="deletado";
}



/*
-------------------------------------------------------------------------------------------------------------------
PROJETOS
-------------------------------------------------------------------------------------------------------------------

*/

function cadastraProjetos($nome, $tipo, $acesso, $userGrupos, $userNomes, $objetos, $nivel, $texto,$id, $acesso){

	
	$dados =   consultaProjetoCampos("", $nome,"","", "","");
	
	if (sizeof($dados)>= 1) {
		$_SESSION['erroCadastro']="Projeto já existente"; 
	} else{	
		//tratamento da tabela projetos
		$conn = getConn();
		$stmt = $conn->prepare("INSERT INTO PROJETOS  (nome, texto, tipo, USUARIOS_idUSUARIOS, acesso)  
						VALUES (:nome, :texto, :tipo, :USUARIOS_idUSUARIOS, :acesso)");
		$stmt->bindParam(':nome', $nome);
		$stmt->bindParam(':texto', $texto);
		$stmt->bindParam(':tipo', $tipo);
		$stmt->bindParam(':USUARIOS_idUSUARIOS', $id);
		$stmt->bindParam(':acesso', $acesso);
		$stmt->execute();
		
		$dados3 =  consultaProjetoCampos("", $nome,"","", "","");
		foreach($dados3 as $linhaP) {
			$linha = $linhaP;
		}
		$idProjeto = $linha['idPROJETOS'];
		
		if($acesso =="privado"){ 
 			$sql ="";
			//tratamento da tabela objetos	
		   for ($i = 0; $i < count($objetos); $i++) {
				$objetoAux = $objetos[$i];
				$sql = "INSERT INTO PROJETOS_has_OBJETO (PROJETOS_idPROJETOS, OBJETO_idOBJETO) 
			   		                            VALUES (:PROJETOS_idPROJETOS,:OBJETO_idOBJETO)";
				$stmt = $conn->prepare($sql);								
				$stmt->bindParam(':PROJETOS_idPROJETOS', $idProjeto);
				$stmt->bindParam(':OBJETO_idOBJETO', $objetoAux);
				$stmt->execute();
		   } 
			 //tratamento da tabela GRUPOS_has_PROJETOS
			if($userNomes ==""){ //se não tem nomes então foi escolhido grupos, sempre é chaveado.
			   for ($i = 0; $i < count($userGrupos); $i++) {
					$userGruposAux = $userGrupos[$i];
					$sql = "INSERT INTO GRUPOS_has_PROJETOS (GRUPOS_idGRUPOS, PROJETOS_idPROJETOS, nivel) 
						                            VALUES (:GRUPOS_idGRUPOS,:PROJETOS_idPROJETOS,:nivel)";
					$stmt = $conn->prepare($sql);	
					$stmt->bindParam(':GRUPOS_idGRUPOS', $userGruposAux);
					$stmt->bindParam(':PROJETOS_idPROJETOS', $idProjeto);
					$stmt->bindParam(':nivel', $nivel);
					$stmt->execute();
			   }
			}
			
			//tratamento da tabela GRUPOS_has_PROJETOS
			if($userGrupos ==""){//se não tem grupos então foi escolhido nomes, sempre é chaveado.
			   for ($i = 0; $i < count($userNomes); $i++) {
					$userNomesAux = $userNomes[$i];
					$sql = "INSERT INTO USUARIOS_has_PROJETOS (USUARIOS_idUSUARIOS, PROJETOS_idPROJETOS, nivel) 
						                              VALUES (:USUARIOS_idUSUARIOS,:PROJETOS_idPROJETOS,:nivel)";
					$stmt = $conn->prepare($sql);	
					$stmt->bindParam(':USUARIOS_idUSUARIOS', $userNomesAux);
					$stmt->bindParam(':PROJETOS_idPROJETOS', $idProjeto);
					$stmt->bindParam(':nivel', $nivel);
					$stmt->execute();
			   }
			}
			mensagemVerde("Seu cadastro foi realizado com sucesso.");
		}
		if($acesso =="publico"){
			$sql ="";				
			//tratamento da tabela objetos	
		   for ($i = 0; $i < count($objetos); $i++) {
				$objetoAux = $objetos[$i];
				//echo"Dentro do insert o idOBJETO: ".$objetoAux."<br>";
				$sql = "INSERT INTO PROJETOS_has_OBJETO (PROJETOS_idPROJETOS, OBJETO_idOBJETO) 
			   		VALUES (:PROJETOS_idPROJETOS, :OBJETO_idOBJETO)";
				$stmt = $conn->prepare($sql);	
				$stmt->bindParam(':PROJETOS_idPROJETOS', $idProjeto);
				$stmt->bindParam(':OBJETO_idOBJETO', $objetoAux);
				$stmt->execute();
		   } 
			mensagemVerde("Seu cadastro foi realizado com sucesso."); 
		}
	}
	closeConn();	
}

function consultaProjetoCampos($id, $nome,$texto,$tipo, $idUser,$acesso){
	$colunas = array();
	$valores = array();
	
	if ($id !=""){
		array_push($colunas,"idPROJETOS");
		array_push($valores,$id);
	}
	if ($nome !=""){
		array_push($colunas, "nome");
		array_push($valores,$nome);
	}
	if ($idUser !=""){
		array_push($colunas,"USUARIOS_idUSUARIOS");
		array_push($valores,$idUser);
	}
	if ($texto !=""){
		array_push($colunas,"texto");
		array_push($valores,$texto);
	}
	if ($tipo !=""){
		array_push($colunas,"tipo");
		array_push($valores,$tipo);
	}
	if ($acesso !=""){
		array_push($colunas,"acesso");
		array_push($valores,$acesso);
	}
	$query = "SELECT * FROM PROJETOS WHERE (";
	$temp = "";
	for ($i = 0; $i < sizeof($colunas); $i++) {
		if(sizeof($colunas)-1 ==$i){
			$temp = $temp.$colunas[$i]."='".$valores[$i]."'";
		}else{
			$temp = $temp.$colunas[$i]."='".$valores[$i]."') AND (";
		}
	}
	$query = $query.$temp.") ";
	//echo $query;
	$stmt = getConn()->query($query);
	$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
	closeConn();
	return $dados;
}

function consultaProjeto(){
	$query = "SELECT * FROM PROJETOS";
	$stmt = getConn()->query($query );
	$dados = $stmt->fetchAll();
	closeConn();
	return $dados;
}

function modificaProjeto($id, $nome,$texto,$tipo, $idUser,$acesso){

	$sql = "update PROJETOS SET 
	PROJETOS.nome = '". $nome ."',
	PROJETOS.tipo = '". $tipo ."',
	PROJETOS.texto = '". $texto ."',
	PROJETOS.acesso = '". $acesso ."' 
	PROJETOS.USUARIOS_idUSUARIOS = '". $idUser ."'
	WHERE PROJETOS.idPROJETOS = '".$id."'";
	
	$stmt = getConn()->query($sql);
	$stmt->execute();
	closeConn();
	
	mensagemVerde("Modificação realizada com sucesso.");
}

function deletaProjeto($id){
	$sql = "DELETE FROM PROJETOS WHERE PROJETOS.idPROJETOS='$id'";
	$stmt = getConn()->query($sql);
	closeConn();
	$_SESSION['projetoDeletado']="deletado";
}

function consultaProjeto_ObjetosCampos($idProjeto, $idObjeto){
	try{
		$colunas = array();
		$valores = array();
		
		if ($idProjeto !=""){
			array_push($colunas,"PROJETOS_idPROJETOS");
			array_push($valores,$idProjeto);
		}
		if ($idObjeto !=""){
			array_push($colunas, "OBJETO_idOBJETO");
			array_push($valores,$idObjeto);
		}
	
		$query = "SELECT * FROM PROJETOS_has_OBJETO WHERE (";
		$temp = "";
		for ($i = 0; $i < sizeof($colunas); $i++) {
			if(sizeof($colunas)-1 ==$i){
				$temp = $temp.$colunas[$i]."='".$valores[$i]."'";
			}else{
				$temp = $temp.$colunas[$i]."='".$valores[$i]."') AND (";
			}
		}
		$query = $query.$temp.") ";
		//echo $query;
		$stmt = getConn()->query($query);
		$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
		closeConn();
		return $dados;
	}catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}
}

function deletaProjeto_Objetos($idProj){
	$sql = "DELETE FROM projetos_has_objeto WHERE projetos_has_objeto.PROJETOS_idPROJETOS='$idProj'";
	$stmt = getConn()->query($sql);
	closeConn();
	$_SESSION['projeto_objetoDeletado']="deletado";
}


function consultaProjeto_UsuarioCampos($idProjeto, $idUser, $nivel){
	try{
		$colunas = array();
		$valores = array();
		
		if ($idProjeto !=""){
			array_push($colunas,"PROJETOS_idPROJETOS");
			array_push($valores,$idProjeto);
		}
		if ($idUser !=""){
			array_push($colunas, "USUARIOS_idUSUARIOS");
			array_push($valores,$idUser);
		}
		if ($nivel !=""){
			array_push($colunas, "nivel");
			array_push($valores,$nivel);
		}
	
		$query = "SELECT * FROM USUARIOS_has_PROJETOS WHERE (";
		$temp = "";
		for ($i = 0; $i < sizeof($colunas); $i++) {
			if(sizeof($colunas)-1 ==$i){
				$temp = $temp.$colunas[$i]."='".$valores[$i]."'";
			}else{
				$temp = $temp.$colunas[$i]."='".$valores[$i]."') AND (";
			}
		}
		$query = $query.$temp.") ";
		//echo $query;
		$stmt = getConn()->query($query);
		$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
		closeConn();
		return $dados;
	}catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}
}

function deletaProjeto_Usuario($idProj){
	$sql = "DELETE FROM USUARIOS_has_PROJETOS WHERE USUARIOS_has_PROJETOS.PROJETOS_idPROJETOS='$idProj'";
	$stmt = getConn()->query($sql);
	closeConn();
	$_SESSION['projeto_usuarioDeletado']="deletado";
}

function modificaProjeto_UsuarioCampos($idProjeto, $idUser, $nivel){

	$sql = "update USUARIOS_has_PROJETOS SET 
	USUARIOS_has_PROJETOS.nivel = '". $nivel ."'
	WHERE USUARIOS_has_PROJETOS.PROJETOS_idPROJETOS = '". $idProjeto ."' and USUARIOS_has_PROJETOS.USUARIOS_idUSUARIOS = '". $idUser ."'";
	
	$stmt = getConn()->query($sql);
	$stmt->execute();
	closeConn();
}

function consultaProjeto_GruposCampos($idProjeto, $idGrupo, $nivel){
	try{
		$colunas = array();
		$valores = array();
		
		if ($idProjeto !=""){
			array_push($colunas,"PROJETOS_idPROJETOS");
			array_push($valores,$idProjeto);
		}
		if ($idGrupo !=""){
			array_push($colunas, "GRUPOS_idGRUPOS");
			array_push($valores,$idGrupo);
		}
		if ($nivel !=""){
			array_push($colunas, "nivel");
			array_push($valores,$nivel);
		}
	
		$query = "SELECT * FROM GRUPOS_has_PROJETOS WHERE (";
		$temp = "";
		for ($i = 0; $i < sizeof($colunas); $i++) {
			if(sizeof($colunas)-1 ==$i){
				$temp = $temp.$colunas[$i]."='".$valores[$i]."'";
			}else{
				$temp = $temp.$colunas[$i]."='".$valores[$i]."') AND (";
			}
		}
		$query = $query.$temp.") ";
		//echo $query;
		$stmt = getConn()->query($query);
		$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
		closeConn();
		return $dados;
	}catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}
}

function deletaProjeto_Grupos($idProj){
	$sql = "DELETE FROM GRUPOS_has_PROJETOS WHERE GRUPOS_has_PROJETOS.PROJETOS_idPROJETOS='$idProj'";
	$stmt = getConn()->query($sql);
	closeConn();
	$_SESSION['projeto_grupoDeletado']="deletado";
}






/*
-------------------------------------------------------------------------------------------------------------------
feedback
-------------------------------------------------------------------------------------------------------------------

*/

function cadastraFeed($tipo, $texto, $idUser, $idProj, $idGeo){
	try{
		// prepare sql and bind parameters
		$conn = getConn();
		$stmt = $conn->prepare("INSERT INTO FEEDBACK  (tipo, texto, USUARIOS_idUSUARIOS, PROJETOS_idPROJETOS, GEOPOS_idGEOPOS)  
						  VALUES (:tipo,:texto,:USUARIOS_idUSUARIOS,:PROJETOS_idPROJETOS,:GEOPOS_idGEOPOS)");
		$stmt->bindParam(':tipo', $tipo);
		$stmt->bindParam(':texto', $texto);
		$stmt->bindParam(':USUARIOS_idUSUARIOS', $idUser);
		$stmt->bindParam(':PROJETOS_idPROJETOS', $idProj);
		$stmt->bindParam(':GEOPOS_idGEOPOS', $idGeo);
		$stmt->execute();
		closeConn();
	}catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}	
}

function consultaFeedCampos($id, $tipo, $texto, $idUser, $idProj, $idGeo){
	$colunas = array();
	$valores = array();
	
	if ($id !=""){
		array_push($colunas,"idFEEDBACK");
		array_push($valores,$id);
	}
	if ($idUser !=""){
		array_push($colunas,"USUARIOS_idUSUARIOS");
		array_push($valores,$idUser);
	}
	if ($texto !=""){
		array_push($colunas,"texto");
		array_push($valores,$texto);
	}
	if ($tipo !=""){
		array_push($colunas,"tipo");
		array_push($valores,$tipo);
	}
	if ($idProj !=""){
		array_push($colunas,"PROJETOS_idPROJETOS");
		array_push($valores,$idProj);
	}
	if ($idGeo !=""){
		array_push($colunas,"GEOPOS_idGEOPOS");
		array_push($valores,$idGeo);
	}
	$query = "SELECT * FROM FEEDBACK WHERE (";
	$temp = "";
	for ($i = 0; $i < sizeof($colunas); $i++) {
		if(sizeof($colunas)-1 ==$i){
			$temp = $temp.$colunas[$i]."='".$valores[$i]."'";
		}else{
			$temp = $temp.$colunas[$i]."='".$valores[$i]."') AND (";
		}
	}
	$query = $query.$temp.") ";
	//echo $query;
	$stmt = getConn()->query($query );
	$dados = $stmt->fetchAll();
	closeConn();
	return $dados;
}
	
function consultaFeed(){
	$query = "SELECT * FROM PROJETOS";
	$stmt = getConn()->query($query );
	$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
	closeConn();
	return $dados;
}

function deletaFeed($id){
	$sql = "DELETE FROM feedback WHERE feedback.idFEEDBACK='$id'";
	$stmt = getConn()->query($sql);
	closeConn();
	$_SESSION['feedDeletado']="deletado";
}


/*
-------------------------------------------------------------------------------------------------------------------
EVENTOS
-------------------------------------------------------------------------------------------------------------------

*/
/*o cadastramento de eventos passa por uma análise difícil. O modelo de dados seria bastante complicado para expressar
um objeto que sofre ação de um objeto, que normalmente são 2 id's de objeto diferentes, e isso na mesma tabela não estava
correto. Um artifício técnico para o protótipo foi usar o campo objetivo, onde fica o nome do objeto que sofre a ação 
*/

function cadastraEventos($idObj, $idAct, $gatilho, $projeto){

	$dados = consultaEventosCampos($idObj, $idAct, $gatilho, $projeto);
	
	if (sizeof($dados)>= 1) {
		$_SESSION['erroCadastro']="Evento já existente"; 
	} else{	
		try{
			// prepare sql and bind parameters
			$conn = getConn();
			$stmt = $conn->prepare("INSERT INTO EVENTOS  (OBJETO_idOBJETO, ACOES_idACOES, gatilho, PROJETOS_idPROJETOS)  
												 VALUES (:OBJETO_idOBJETO,:ACOES_idACOES,:gatilho,:PROJETOS_idPROJETOS)");
			$stmt->bindParam(':OBJETO_idOBJETO', $idObj);
			$stmt->bindParam(':ACOES_idACOES', $idAct);
			$stmt->bindParam(':gatilho', $gatilho);
			$stmt->bindParam(':PROJETOS_idPROJETOS', $projeto);
			$stmt->execute();
			closeConn();
		}catch(PDOException $e){
			echo "Error: " . $e->getMessage();
		}
	}	
}

function consultaEventosCampos($idObj, $idAct, $gatilho, $projeto){
	$colunas = array();
	$valores = array();

	if ($idObj !=""){
		array_push($colunas, "OBJETO_idOBJETO");
		array_push($valores,$idObj);
	}
	if ($idAct !=""){
		array_push($colunas,"ACOES_idACOES");
		array_push($valores,$idAct);
	}
	if ($gatilho !=""){
		array_push($colunas,"gatilho");
		array_push($valores,$gatilho);
	}
	if ($projeto !=""){
		array_push($colunas,"PROJETOS_idPROJETOS");
		array_push($valores,$projeto);
	}

	$query = "SELECT * FROM EVENTOS WHERE (";
	$temp = "";
	for ($i = 0; $i < sizeof($colunas); $i++) {
		if(sizeof($colunas)-1 ==$i){
			$temp = $temp.$colunas[$i]."='".$valores[$i]."'";
		}else{
			$temp = $temp.$colunas[$i]."='".$valores[$i]."') AND (";
		}
	}
	$query = $query.$temp.") ";
	//echo $query;
	$stmt = getConn()->query($query );
	$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
	closeConn();
	return $dados;
}
	
function consultaEventos(){
	$query = "SELECT * FROM EVENTOS";
	$stmt = getConn()->query($query );
	$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
	closeConn();
	return $dados;
}

function consultaEventosPorObjetos($idObj){
	$query = "SELECT * FROM EVENTOS WHERE EVENTOS.OBJETO_idOBJETO = $idObj";
	$stmt = getConn()->query($query);
	$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
	closeConn();
	return $dados;
}

function consultaEventosPorProjetos($idProj){
	//INNER JOIN a3ra1.ACOES ON ACOES.idACOES = EVENTOS.ACOES_idACOES
	/*
	$query = "SELECT * FROM a3ra1.EVENTOS
				INNER JOIN a3ra1.OBJETO ON OBJETO.idOBJETO = EVENTOS.OBJETO_idOBJETO
				INNER JOIN a3ra1.PROJETOS_has_OBJETO ON PROJETOS_has_OBJETO.OBJETO_idOBJETO = OBJETO.idOBJETO AND 
				PROJETOS_has_OBJETO.PROJETOS_idPROJETOS = $idProj";
				*/
	$query = "SELECT EV.*
				FROM a3ra1.EVENTOS EV
				WHERE
				EV.OBJETO_idOBJETO in 
					(SELECT DISTINCT OBJETO_idOBJETO 
					 FROM a3ra1.PROJETOS_has_OBJETO 
					 WHERE PROJETOS_idPROJETOS = $idProj)";
	$stmt = getConn()->query($query);
	$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
	//$dados1=[$dados];
	closeConn();
	return $dados;
}

function modificaEventos($nome, $tipo, $aciona, $obs,  $id){

	$sql = "update EVENTOS SET 
	EVENTOS.nome = '". $nome ."',
	EVENTOS.tipo = '". $tipo ."',
	EVENTOS.acionamento = '". $aciona ."',
	EVENTOS.obs = '". $obs ."' 
	WHERE EVENTOS.idEVENTOS = '".$id."'";
	
	$stmt = getConn()->query($sql);
	$stmt->execute();
	closeConn();
	
	mensagemVerde("Modificação realizada com sucesso.");
}

function deletaEventos($id){
	$sql = "DELETE FROM EVENTOS WHERE EVENTOS.idEVENTOS='$id'";
	$stmt = getConn()->query($sql);
	closeConn();
	$_SESSION['EventoDeletado']="deletado";
}

/*
-------------------------------------------------------------------------------------------------------------------
AÇÕES
-------------------------------------------------------------------------------------------------------------------

*/

function cadastraAcao($nome, $acionamento, $obs){
	try {	
		$conn = getConn();

		$query = "INSERT INTO ACOES  (nome, acionamento, obs)  
							  VALUES (:nome,:acionamento,:obs)";
		$stmt = $conn->prepare($query);
		$stmt->bindParam(':nome', $nome);
		$stmt->bindParam(':acionamento', $acionamento);
		$stmt->bindParam(':obs', $obs);
		$stmt->execute();
		closeConn();
		mensagemVerde("cadastrado: $nome, $acionamento, $obs");
	}catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}
}

function consultaAcaoCampos($nome, $acionamento, $obs, $id){
	$colunas = array();
	$valores = array();
	if ($id !=""){
		array_push($colunas,"idACOES");
		array_push($valores,$id);
	}
	if ($nome !=""){
		array_push($colunas, "nome");
		array_push($valores,$nome);
	}
	if ($acionamento !=""){
		array_push($colunas,"acionamento");
		array_push($valores,$acionamento);
	}
	if ($obs !=""){
		array_push($colunas,"obs");
		array_push($valores,$obs);
	}
	
	$query = "SELECT * FROM ACOES WHERE (";
	$temp = "";
	for ($i = 0; $i < sizeof($colunas); $i++) {
		if(sizeof($colunas)-1 ==$i){
			$temp = "ACOES.".$temp.$colunas[$i]."='".$valores[$i]."'";
		}else{
			$temp = "ACOES.".$temp.$colunas[$i]."='".$valores[$i]."') AND (";
		}
	}
	$query = $query.$temp.") ";
	//echo $query;
	$stmt = getConn()->query($query );
	$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
	closeConn();
	return $dados;
}
	
function consultaAcao(){
	$query = "SELECT * FROM ACOES";
	$stmt = getConn()->query($query );
	$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
	closeConn();
	return $dados;
}

function modificaAcao($nome, $acionamento, $obs, $id){

	$sql = "update a3ra1.ACOES SET 
	nome = '$nome',
	acionamento = '$acionamento',
	obs = '$obs'
	WHERE idACOES = '$id'";
	
	$stmt = getConn()->query($sql);
	$stmt->execute();
	closeConn();
}

function deletaAcao($id){
	$sql = "DELETE FROM ACOES WHERE ACOES.idACOES='$id'";
	$stmt = getConn()->query($sql);
	closeConn();
}

/*
-------------------------------------------------------------------------------------------------------------------
INDICES
-------------------------------------------------------------------------------------------------------------------

*/

function cadastraIndices($nome, $valor, $obs){
	try {	
		$conn = getConn();

		$query = "INSERT INTO INDICES  (nome, valor, obs)  
							  VALUES (:nome,:valor,:obs)";
		$stmt = $conn->prepare($query);
		$stmt->bindParam(':nome', $nome);
		$stmt->bindParam(':valor', $valor);
		$stmt->bindParam(':obs', $obs);
		$stmt->execute();
		closeConn();
		mensagemVerde("cadastrado: $nome, $valor, $obs");
	}catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}
}

function consultaIndicesCampos($nome, $valor, $obs, $id){
	$colunas = array();
	$valores = array();
	if ($id !=""){
		array_push($colunas,"idINDICES");
		array_push($valores,$id);
	}
	if ($nome !=""){
		array_push($colunas, "nome");
		array_push($valores,$nome);
	}
	if ($valor !=""){
		array_push($colunas,"valor");
		array_push($valores,$valor);
	}
	if ($obs !=""){
		array_push($colunas,"obs");
		array_push($valores,$obs);
	}
	
	$query = "SELECT * FROM INDICES WHERE (";
	$temp = "";
	for ($i = 0; $i < sizeof($colunas); $i++) {
		if(sizeof($colunas)-1 ==$i){
			$temp = "INDICES.".$temp.$colunas[$i]."='".$valores[$i]."'";
		}else{
			$temp = "INDICES.".$temp.$colunas[$i]."='".$valores[$i]."') AND (";
		}
	}
	$query = $query.$temp.") ";
	//echo $query;
	$stmt = getConn()->query($query );
	$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
	closeConn();
	return $dados;
}
	
function consultaIndices(){
	$query = "SELECT * FROM INDICES";
	$stmt = getConn()->query($query );
	$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
	closeConn();
	return $dados;
}

function modificaIndices($nome, $valor, $obs, $id){

	$sql = "update a3ra1.INDICES SET 
	nome = '$nome',
	valor = '$valor',
	obs = '$obs'
	WHERE idINDICES = '$id'";
	
	$stmt = getConn()->query($sql);
	$stmt->execute();
	closeConn();
}

function deletaIndices($id){
	$sql = "DELETE FROM INDICES WHERE INDICES.idINDICES='$id'";
	$stmt = getConn()->query($sql);
	closeConn();
}
?>