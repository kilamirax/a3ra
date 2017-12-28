<?php
error_reporting(0); // sem isso a pagina fica bem suja...
include('prazoValor.php');

session_start();

$imagem = "";
$valor;
$peso;
$nomeLivro = "";
$prod = $_POST["prod"];
$user = $_POST["user"];
$nome = $_POST["nome"];
$im = $_POST["im"];

	//pelo cep pegar o endereço
	if(isset($_POST["cep"])){
		//verifica o endereço do destinatário eplo CEP
		$cep  = $_POST["cep"];
		/*
		$vr_Link = "http://correiosapi.apphb.com/cep/";
		$vr_Curl = curl_init();
		curl_setopt($vr_Curl, CURLOPT_URL, $vr_Link.$cep);
		curl_setopt($log, CURLOPT_RETURNTRANSFER, true);
		$end = curl_exec($vr_Curl);
		curl_close($vr_Curl);
		*/
		$cep = str_replace('-', '', $cep);
		
		$url = "http://correiosapi.apphb.com/cep/";
		$log = curl_init();
		curl_setopt_array($log, array(
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_HTTPGET => 1,
					CURLOPT_URL => $url.$cep,
					));
		$end = json_decode(curl_exec($log), true);
		curl_close($log);
	}
	
	//pra testar, depois tem que apagar
	if(isset($_POST["prod"])){
		$imagem = $im;
		$valor = 166.10;
		$peso = '1.300';
		$nomeLivro = "3ds Max Modeling For Games";
	}

	if($prod == "1"){
		$imagem = $im;
		$valor = 166.00;
		$peso = '1.300';
		$nomeLivro = "3ds Max Modeling For Games";
	}
	
	if($prod == "2"){
		$imagem = $im;
		$valor = 66.00;
		$peso = '0.600';
		$nomeLivro = "Sandman - Estação das Brumas - Vol. 4";
	}
	
	if($prod == "3"){
		$imagem = $im;
		$valor = 55.80;
		$peso = '0.600';
		$nomeLivro = "Calvin & Haroldo - E Foi Assim que Tudo Começou";
	}
	
	if($prod == "4"){
		$imagem = $im;
		$valor = 60.00;
		$peso = '0.300';
		$nomeLivro = "O Senhor dos Anéis I - A Sociedade do Anel";
	}
?>


<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Livraria RESTFul</title>
<style type="text/css">
body {
	background-image: url(Img/papel-de-parede-livro.jpg);
}
.fonte {
	font-family: Arial, Helvetica, sans-serif;
}
.Logo {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 36px;
	color: #090;
}
.subTitulo {
	font-size: 24px;
}
.tabela {
	font-size: 36px;
}
.tabela {
	font-size: 24px;
}
</style>
</head>

<body>

<table width="1354" border="0">
	  <tr>
		<td align="center" bgcolor="#FFFFFF" class="Logo"><span class="Logo">Livraria RESTFul - <span class="subTitulo"><span class="subTitulo">2º Trabalho prático da matéria de Hipermídia e Web - UFES Mestrado 2013/2</span></span></span><span class="subTitulo"><span class="subTitulo"></span></span></td>
  </tr>
	</table>



<table width="1013" border="0">

  <tr>
    <td width="363" align="right" class="subTitulo">O produto ser enviado para </td>
    <td width="317">
    	<img src="https://graph.facebook.com/<?php echo $user; ?>/picture" alt="" />
   	<span class="subTitulo"><?php echo $nome;?> </span></td>
    <td width="319" class="subTitulo">&nbsp;</td>
  </tr>
  
  <tr>
    <td align="right" class="subTitulo">
    	O CEP do destinatário:
    </td>
	<?php 
		if(isset($cep)){
			echo "";
		} else{
			echo "<td><form id=\"form1\" name=\"form1\" method=\"post\" action=\"carrinho.php\">";
			echo "<input type=\"hidden\" name=\"imagem\" id=\"imagem\" value=\"$i\"></a>";
			echo "<input type=\"hidden\" name=\"nomeDest\" id=\"nomeDest\" value=\"$i\"></a>";
			echo "<input type=\"hidden\" name=\"prod\" id=\"prod\" value=\"$prod\"></a>";
			echo "<input type=\"hidden\" name=\"user\" id=\"user\" value=\"$user\">";
			echo "<input type=\"hidden\" name=\"nome\" id=\"nome\" value=\"$nome\">";
			echo "<input type=\"hidden\" name=\"im\" id=\"im\" value=\"$im\">";
			echo "<input type=\"text\" name=\"cep\" id=\"cep\">      ";  
			echo "<input type=\"submit\" name=\"button\" id=\"button\" value=\"Enviar\">";
			echo "</form>";
			echo "</td>";
		}
		
	?>
  </tr>
  <tr>
    <td align="right" class="subTitulo">Endereço:</td>
    <td colspan="2">
    <?php 
		if(isset($cep)){
			
			$cep = str_replace('-', '', $cep);
			
			//{"cep":29167124,"tipoDeLogradouro":"Avenida","logradouro":"Braúna","bairro":"Colina de Laranjeiras","cidade":"Serra","estado":"ES"}
			//var_dump($end);
			echo "CEP: ".$end['cep']."<br>"; 
			echo "Logradouro: ".$end['tipoDeLogradouro']." ".$end['logradouro']."<br>"; 
			echo "Bairro: ".$end['bairro']."<br>"; 
			echo "Cidade: ".$end['cidade']."<br>"; 
			echo "Estado: ".$end['estado']."<br>"; 
		}	
	?>
    </td>
  </tr>

  
</table>








<p>&nbsp;</p>
<table width="1437" height="156" border="1">
  <tr border="1">
    <td width="266" border="1">PRODUTO</td>
    <td width="613" border="1">DESCRIÇÃO</td>
    <td width="149" border="1">QUANTIDADE</td>
    <td width="381" border="1">TOTAL</td>
  </tr>
  <tr border="1">
    <td border="1"><span class="style3">
      <?php 
			echo "<img src=\"$imagem\" border=\"0\" />";
		?>
    </span>
    </td border="1">
    <td border="1"><span class="descri">
      <?php 
			echo $nomeLivro;
		?>
    </span></td>
    <td border="1"><span class="descri">
      <?php 
			echo "1"; 
		?>
    </span>
    </td>
    <td><span class="valores"> 
        <?php 
				echo "R$ ".$valor;
		?>
    </span>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><span class="LetraForte">FRETE:</span></td>
    <td><span class="descri">
      <?php
	  	if(isset($cep)){
			$frete =  str_replace(',','.',frete($cep));
			
			echo "R$ ". $frete;
			
		}
	  ?>
    </span>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>TOTAL:</strong></td>
    <td><span class="descri">
        <?php
	
		
			$valorfinal = $frete + floatval($valor);
	  		echo "R$ ".$valorfinal;
	  	?>
    </span></td>
  </tr>
  <tr>
    <td colspan="2"><a href="index.php"><img src="Img/voltar.png" width="500" height="107" border="0"></a></td>
    <td colspan="2">
    <form id="form1" name="form1" method="post" action="final.php">
    	<input type="hidden" name="im" id="im" value="<?php echo $imagem; ?>">
        <input type="hidden" name="nome" id="nome" value="<?php echo $nome; ?>">
        <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">
        <input type="hidden" name="nomeLivro" id="nomeLivro" value="<?php echo $nomeLivro; ?>">
    	<input type="image" src="Img/finalizar.png" width="500" height="107"> 
    </form>
    </td>
  </tr>
</table>






<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>