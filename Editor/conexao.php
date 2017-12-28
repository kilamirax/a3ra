<?php

function servidor(){
	//$servidor= array ("nome" => "terraria", "host" => "", "loginBD" => "", "senhaBD" => "", "db" => "", "endereco" => ""); 
	$servidor= array ("nome" => "valfenda", "host" => "", "loginBD" => "", "senhaBD" => "", "db" => "", "endereco" => ""); 
	//$servidor= array ("nome" => "hostinger", "host" => "", "loginBD" => "", "senhaBD" => "", "db" => "", "endereco" => "");
	//$servidor = array("nome" => "localhost", "host" => "", "loginBD" => "", "senhaBD" => "", "db" => "", "endereco" => "");
	//var_dump( $servidor);
	if($servidor['nome'] == "terraria"){
		$servidor['host'] ='localhost';
		$servidor['loginBD'] = 'tz';
		$servidor['senhaBD'] = 'tz';
		$servidor['db'] = "A3RA1";
		$servidor['endereco'] = "ec2-52-67-226-97.sa-east-1.compute.amazonaws.com";
	}
	if($servidor['nome'] == "valfenda"){
		$servidor['host'] ='localhost';
		$servidor['loginBD'] = 'valfenda';
		$servidor['senhaBD'] = '1valfenda';
		$servidor['db'] = "A3RA1";
		$servidor['endereco'] = "ec2-52-67-24-163.sa-east-1.compute.amazonaws.com";
	}
	if($servidor['nome'] == "godaddy"){
		$servidor['host'] ='localhost';
		$servidor['loginBD'] = 'james_adm';
		$servidor['senhaBD'] = '1james';
		$servidor['db'] = "A3RA1";
		$servidor['endereco'] = "http://jameswarlock.com.br";
	}
	if($servidor['nome'] == "localhost"){
		//var_dump( $servidor);
		$servidor['host'] = 'localhost';
		$servidor['loginBD'] = 'root';
		$servidor['senhaBD'] = '';
		$servidor['db'] = "A3RA1";
		$servidor['endereco'] = "http://localhost/GoDaddy";
	}
	if($servidor['nome'] == "hostinger"){
		$servidor['host'] = 'mysql.hostinger.com.br';
		$servidor['loginBD'] = 'u232345207_a3ra';
		$servidor['senhaBD'] = '1a3ra2';
		$servidor['db'] = "u232345207_a3ra";
		$servidor['endereco'] = "http://a3ra.esy.es";
	}
	return $servidor;
}

function getConn(){
	$servidor = servidor();
	$conexao = "mysql:host=".$servidor['host'].";dbname=".$servidor['db'].";charset=utf8";
	//echo $conexao;
	try{
		$conn = new PDO($conexao,$servidor['loginBD'],$servidor['senhaBD'],array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		$conn->exec("set names utf8");
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}catch(PDOException $e){
		echo "Erro de conecção: " . $e->getMessage();
	}
	return $conn;
}

function closeConn(){
	$conn = null;
}

function bancoDados(){
	return $db;
}
?>