<?php	
ob_start();
	//error_reporting(0); //desabilitar as irritantes mesnagens de warnning
	include('banco.php');
	
	require '../A3RA/vendor/slim/slim/Slim/Slim.php';
	\Slim\Slim::registerAutoloader();
	$app = new \Slim\Slim();
	$app->response()->header('Content-Type', 'application/json;charset=utf-8');
	
	$app->get('/', function () {
		echo "para véi";
		$servidor = servidor();
		//echo $servidor['endereco'];
		header("Location: ../A3RA/login.php"); exit();
	});
	
	$app->get('/primeiravez','primeiraVez');
	$app->get('/grupos','getGrupos');
	$app->get('/grupos/:id','getGruposId');
	$app->get('/gps/:id','getGPSId');
	$app->get('/gps/','getGPS');
	$app->get('/marcador/:id','getMarcadorId');
	$app->get('/arquivo/:id','getArquivoId');
	$app->get('/objetos/','getObjetos');
	$app->get('/objeto/:id','getObjetoId');
	$app->get('/projetosPublicos','getProjetosPublicos');
	$app->get('/projetosPublicos/:idU','getProjetosPublicosId');
	$app->get('/projetosPrivados/:idU','getProjetosPrivados');
	$app->get('/projetosPorUsuario/:idU','getProjetosPorUsuario');
	$app->get('/objetosPorProjeto/:idU','getObjetosPorProjeto');
	$app->get('/log/:usuario/:senha','loginUsuario');
	$app->get('/eventosPorProjeto/:idU','getEventosPorProjeto');
	
	$app->post('/gps/:projeto','gpsFeedback');
	$app->post('/feedback/:projeto','feedback');
	//$app->post('/gps/:long/:lati/:projeto','gpsFeedback');
	//$app->post('/addgrupos','addGrupos');
	
	$app->run();
	
	function primeiraVez(){
		//grupo adm
		cadastraGrupos("Adm", "0");
		cadastraGrupos('Sem grupo','5');
		
		//usuário sistema cadastraUsuarios($nome, $usuario, $senha, $email , $grupo, $obs)
		cadastraUsuarios("Sistema", "sistema", "s", "" , "1", "usuário responsável por ter objetos controlados pelos programas");
		cadastraUsuarios("t",       "t",       "t", "@" , "1", "usuário teste");
		
		//cadasta os objetos do sistema
		cadastraObjetos("Inicio Programa", "Usando quando o programa cliente se inicia", "", "", "", "1");
		cadastraObjetos("Fim de Programa", "Usando para finalizar o programa, como um final de jogo", "", "", "", "1");
		cadastraObjetos("Sempre", "uma forma de que, a ação escolhida, sempre seja executada", "", "", "", "1");
		
		//tabela ação
		cadastraAcao("Habilitação de objeto", "objeto", "Faz o objeto ser apresentado a cena.");
		cadastraAcao("Habilitação de objeto por colisão", "colisão", "Quando o usuário colidir na geo-posição ou por processamento de imagem um marcador for detectado, 
						um objeto será apresentado a cena.");
		cadastraAcao("Aumenta objeto", "aumenta", "Quando um objeto é aumentado na realizade. Normalmente quando se cadastra um marcador para realidade aumentada
		                se deseja que um objeto em questão apareça quando o marcador for detectado, e é esse o caso.");							
		cadastraAcao("Modificação de índices", "indices", "São planejados para modificação de pontuação, vidas ou mesmo fazer com que o usuário perca itens 
						já encontrados. A seleção deste tipo de ação habilitará informações a serem preenchidas para complemento das características da ação, 
						como por exemplo se será aumentado pontos, deverá ser preenchido a quantidade ou se for para perder itens já coletados que seja 
						escolhido qual será perdido.");	
		cadastraAcao("Habilitação por tempo", "tempo", "Nesse caso ao ser criado ou aparecer na cena o objeto começará a contar tempo. A ação deve ter o valor 
						desse tempo que o objeto irá contar. Ao termino dessa contagem o sistema cliente realizará uma determinada ação, que é outro evento.");				
		cadastraAcao("Habilitação de outros eventos", "eventos", "Ações podem estar desabilitados e somente com o acionamento desta ação em questão um ou mais 
						eventos podem se tornar visíveis. Um exemplo deste tipo de ação é o de fim de aplicação, ou ligação entre outras sequencias de ações.");				
		cadastraAcao("Habilitação de Feedback", "feedback", "Essa ação é especifica para chamar a função de feedback para o usuário poder contribuir com o projeto");
		
		//tabela indices
		cadastraIndices("mochila", "numerico", "Quantidade de itens dentro da mochila.");
		cadastraIndices("pontuação", "numerico", "Quantidade de pontos realizado pelo jogador.");
		
		
		//carga de teste
		cadastraMarcadores("vi_01.jpg", "7163210a0ec94f07aba767b926f66297", "", "", "2");
		cadastraMarcadores("BatmanLegoMovie.jpg", "6e3af09548ed4f908d6553c5adc12ec8", "", "", "2");

		cadastraGPS("Casa", "cafofo", "-20.18723","-40.25405", "mapMarker", "2" );
		cadastraGPS("Piscina", "Aqui fica a piscina", "	-20.18637","-40.25504", "informativo", "2" );
		cadastraGPS("Entrada", "Entrada do condomínio", "	-20.18606","-40.25537", "mapMarker", "2" );

		cadastraObjetos("CasaObj", "casa", "", "1", "", "2");
		cadastraObjetos("PiscinaObj", "pisciana", "", "2", "", "2");
		cadastraObjetos("EntradaObj", "Entrada cond", "", "3", "", "2");
		cadastraObjetos("batman", "marcador batman", "2", "", "", "2");
		cadastraObjetos("objetoTexto", "objeto de texto para teste", "", "", "", "2");
	}
	
	function getEventosPorProjeto($id){
		$array = array();
		$dados = consultaEventosCampos("", "", "", $id);
		foreach($dados as $linha){
			array_push($array, $linha);
		}
		//print_r($array);
		echo json_encode($array,JSON_UNESCAPED_UNICODE);
	}
	
	function getArquivoId($id){
		$dados = consultaArquivosCampos($id, "", "", "");
		foreach($dados as $linha){
			echo json_encode($linha,JSON_UNESCAPED_UNICODE);
		}
	}
	
	function getMarcadorId($id){
		$dados = consultaMarcadoresCampos($id, "", "", "");
		foreach($dados as $linha){
			echo json_encode($linha,JSON_UNESCAPED_UNICODE);
		}
	}
	
	function getGPSId($id){
		$dados = consultaGPSCampos($id, "", "", "", "", "");
		foreach($dados as $linha){
			echo json_encode($linha,JSON_UNESCAPED_UNICODE);
		}
	}
	function getGPS(){
		$dados = consultaGPS();
		foreach($dados as $linha){
			echo json_encode($linha,JSON_UNESCAPED_UNICODE);
		}
	}

	function getObjetos(){
		$dados = consultaObjetos();
		foreach($dados as $linha){
			echo json_encode($linha,JSON_UNESCAPED_UNICODE);
		}
	}
	
	function getObjetoId($id){
		$dados = consultaObjetosCampos($id, "", "","");
		foreach($dados as $linha){
			echo json_encode($linha,JSON_UNESCAPED_UNICODE);
		}
	}
	
	function gpsFeedback($proj){
		$request = \Slim\Slim::getInstance()->request();
		$geo = json_decode($request->getBody());
		$conn = getConn();
		cadastraGPS($geo->nome, $geo->texto,$geo->latitude, $geo->longitude, $geo->tipoGPS, $geo->USUARIOS_idUSUARIOS );
		//$geo->id = $conn->lastInsertId();
		echo json_encode($geo,JSON_UNESCAPED_UNICODE);
		closeConn();
	}
	
	function feedback($proj){
		$request = \Slim\Slim::getInstance()->request();
		$geo = json_decode($request->getBody());
		$conn = getConn();

		cadastraGPS($geo->nome, $geo->texto,$geo->latitude, $geo->longitude, $geo->tipoGPS, $geo->USUARIOS_idUSUARIOS );
		$geo->id = $conn->lastInsertId();

		//$dados = consultaGPSCampos("",$geo->nome, "", "", "", $geo->USUARIOS_idUSUARIOS);
		$dados = consultaGPS();
		$id = "";
		foreach($dados as $linha){
			$id = $linha['idGEOPOS'];
		}

		cadastraFeed($geo->tipoFeed, $geo->texto_feedback, $geo->USUARIOS_idUSUARIOS , $proj, $id);

		echo json_encode($geo,JSON_UNESCAPED_UNICODE);
		closeConn();
	}
	
	function getObjetosPorProjeto($id){
		$dados = consultaProjeto_ObjetosCampos($id, "");
		$b = array();
		foreach($dados as $linha){
			$dadosObjeto = consultaObjetosCampos($linha['OBJETO_idOBJETO'], "", "","");
			foreach($dadosObjeto as $linhaObjeto){
				array_push($b, $linhaObjeto);
			}
			
		}
		echo json_encode($b,JSON_UNESCAPED_UNICODE);
	}
	
	function getProjetosPorUsuario($id){
		$dados = consultaProjetoCampos("", "","","", $id,"");
		foreach($dados as $linha){
			echo json_encode($linha,JSON_UNESCAPED_UNICODE);
		}
	}
	
	function getProjetosPublicosId($id){
		$dados = consultaProjetoCampos("", "","","", $id,"publico");
		foreach($dados as $linha){
			echo json_encode($linha,JSON_UNESCAPED_UNICODE);
		}
	}
	
	function getProjetosPrivados($id){
		$array = array();
		$dados = consultaProjetoCampos("", "","","", $id,"privado");
		foreach($dados as $linha){
			array_push($array, $linha);
		}
		//print_r($array);
		//echo json_encode(array_map(utf8_encode,$array));
		echo json_encode($array,JSON_UNESCAPED_UNICODE);
	}
	
	function getProjetosPublicos(){
		$dados = consultaProjetoCampos("", "","","","",'publico');
		echo json_encode($dados,JSON_UNESCAPED_UNICODE);
	}
	
	function loginUsuario($usuario, $senha){
		$dados = consultaUsuariosCampos("", $usuario, $senha, "", "", "");
		foreach($dados as $linha){
			echo json_encode($linha,JSON_UNESCAPED_UNICODE);
		}
	}

	function getGrupos(){
		$dados = consultaGrupos();
		foreach($dados as $linha){
			echo json_encode($linha,JSON_UNESCAPED_UNICODE);
		}
	}
	
	function getGruposId($id){
		$dados = consultaGrupoCampos("", "", $id);
		foreach($dados as $linha){
			echo json_encode($linha,JSON_UNESCAPED_UNICODE);
		}
	}

	ob_end_flush();
?>
