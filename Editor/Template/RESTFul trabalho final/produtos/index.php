<?php

require '../Slim/Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->response()->header('Content-Type', 'application/json;charset=utf-8');


$app->get('/', function () {
   $sql = "SELECT * FROM Produtos";
  $stmt = getConn()->query($sql);
  $produtos = $stmt->fetchAll(PDO::FETCH_OBJ);
  echo "{\"produtos\":".json_encode($produtos)."}";
  return $produtos;
});


/*
$app->post('/produtos',function ()
{
  $request = \Slim\Slim::getInstance()->request();
  $produto = json_decode($request->getBody());
  $sql = "INSERT INTO victoryi_restful.Produtos (nome,preco,peso, imagem) values (:nome,:preco,:peso,:imagem) ";
  $conn = getConn();
  $stmt = $conn->prepare($sql);
  $stmt->bindParam("nome",$produto->nome);
  $stmt->bindParam("preco",$produto->preco);
  $stmt->bindParam("peso",$produto->peso);
  $stmt->bindParam("imagem",$produto->imagem);
  $stmt->execute();
  $produto->id = $conn->lastInsertId();
  echo json_encode($produto);
});
*/


$app->get('/:id', function ($id) {

	$conn = getConn();
	//$sql = "SELECT * FROM restful.produtos where id =:id";
	$sql = "SELECT * FROM victoryi_restful.Produtos where id =:id";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam("id",$id);
	$stmt->execute();
	$produto = $stmt->fetchObject();

	echo json_encode($produto);
 
});


$app->run();
function getConn()
{
	//server vis	
 return new PDO('mysql:host=victoryisland.com.br;
 					   dbname=victoryi_restful',
					   'victoryi_restful',
					   '1restful23',
  array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
  );

  /*
  //server local host
  return new PDO('mysql:host=127.0.0.1;dbname=restful',
  'root',
  '',
  array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
  );
  */
}



?>
