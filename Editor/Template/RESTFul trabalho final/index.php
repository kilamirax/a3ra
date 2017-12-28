<?php
	//$urlGeral = "http://127.0.0.1/RESTFul/produtos/";
	$urlGeral = 'http://tda.lprm.inf.ufes.br/thiago/produtos/';
	//$urlGeral = 'http://kilamirax.byethost31.com/produtos/';
	//$urlGeral = 'http://www.victoryisland.com.br/TZ/restful/produtos/';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
		<td align="center" bgcolor="#FFFFFF" class="Logo">Livraria RESTFul - <span class="subTitulo">2º Trabalho prático da matéria de Hipermídia e Web - UFES Mestrado 2013/2</span></td>
	  </tr>
	</table>
	
    <p>&nbsp;</p>
    
    <form id="form1" name="form1" method="post" action="http://www.victoryisland.com.br/TZ/restful/login.php">
    <table width="666" height="233" border="0">
      <tr class="tabela">
        <td height="189" colspan="3" align="center" valign="middle" class="tabela">
        
        	 <?php
				$url = $urlGeral.'1';
				$log = curl_init();
				curl_setopt_array($log, array(
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_HTTPGET => 1,
					CURLOPT_URL => $url,
					));
				$livro = json_decode(curl_exec($log), true);
				curl_close($log);
				//echo $livro;
				$imagem = $livro['imagem'];
				echo"<input type=\"image\" src=\" $imagem\" width=\"200\" height=\"256\"></a>";		
			?>

        </td>
      </tr>
      <tr class="tabela">
        <td width="368" class="tabela">
        <?php
			echo $livro['nome'];
		?>
        </td>
        <td width="168" class="tabela">
        <?php
			echo "R$ ".$livro['preco'];
		?>
        </td>
        <td width="116" class="tabela">
        <?php
			$id = $livro['id'];
			echo "<input type=\"hidden\" name=\"prod\" id=\"prod\" value=\"$id\">";
			echo "<input type=\"hidden\" name=\"im\" id=\"im\" value=\"$imagem\">";
		?>
     
		<input type="image" src="Img/carrinho.png" width="97" height="77">
        
        </td>
      </tr>
      
    </table>
    </form>
    
    
      <form id="form2" name="form2" method="post" action="http://www.victoryisland.com.br/TZ/restful/login.php">
    <table width="666" height="233" border="0">
      <tr class="tabela">
        <td height="189" colspan="3" align="center" valign="middle" class="tabela">
        
        	 <?php
				$url = $urlGeral.'2';
				$log = curl_init();
				curl_setopt_array($log, array(
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_HTTPGET => 1,
					CURLOPT_URL => $url,
					));
				$livro = json_decode(curl_exec($log), true);
				curl_close($log);
				
				$imagem = $livro['imagem'];
				echo"<input type=\"image\" src=\" $imagem\" width=\"200\" height=\"256\"></a>";		
			?>

        </td>
      </tr>
      <tr class="tabela">
        <td width="368" class="tabela">
        <?php
			echo $livro['nome'];
		?>
        </td>
        <td width="168" class="tabela">
        <?php
			echo "R$ ".$livro['preco'];
		?>
        </td>
        <td width="116" class="tabela">
        <?php
			$id = $livro['id'];
			echo "<input type=\"hidden\" name=\"prod\" id=\"prod\" value=\"$id\">";
			echo "<input type=\"hidden\" name=\"im\" id=\"im\" value=\"$imagem\">";
		?>
     
		<input type="image" src="Img/carrinho.png" width="97" height="77">
        
        </td>
      </tr>
      
    </table>
    </form>
    
    
    <form id="form3" name="form3" method="post" action="http://www.victoryisland.com.br/TZ/restful/login.php">
    <table width="666" height="233" border="0">
      <tr class="tabela">
        <td height="189" colspan="3" align="center" valign="middle" class="tabela">
        
        	 <?php
				$url = $urlGeral.'3';
				$log = curl_init();
				curl_setopt_array($log, array(
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_HTTPGET => 1,
					CURLOPT_URL => $url,
					));
				$livro = json_decode(curl_exec($log), true);
				curl_close($log);
				
				$imagem = $livro['imagem'];
				echo"<input type=\"image\" src=\" $imagem\" width=\"200\" height=\"256\"></a>";		
			?>

        </td>
      </tr>
      <tr class="tabela">
        <td width="368" class="tabela">
        <?php
			echo $livro['nome'];
		?>
        </td>
        <td width="168" class="tabela">
        <?php
			echo "R$ ".$livro['preco'];
		?>
        </td>
        <td width="116" class="tabela">
        <?php
			$id = $livro['id'];
			echo "<input type=\"hidden\" name=\"prod\" id=\"prod\" value=\"$id\">";
			echo "<input type=\"hidden\" name=\"im\" id=\"im\" value=\"$imagem\">";
		?>
        
		<input type="image" src="Img/carrinho.png" width="97" height="77">
        
        </td>
      </tr>
      
    </table>
    </form>
    
    <form id="form4" name="form4" method="post" action="http://www.victoryisland.com.br/TZ/restful/login.php">
    <table width="666" height="233" border="0">
      <tr class="tabela">
        <td height="189" colspan="3" align="center" valign="middle" class="tabela">
        
        	 <?php
				$url = $urlGeral.'4';
				$log = curl_init();
				curl_setopt_array($log, array(
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_HTTPGET => 1,
					CURLOPT_URL => $url,
					));
				$livro = json_decode(curl_exec($log), true);
				curl_close($log);
				
				$imagem = $livro['imagem'];
				echo"<input type=\"image\" src=\" $imagem\" width=\"200\" height=\"256\"></a>";		
			?>

        </td>
      </tr>
      <tr class="tabela">
        <td width="368" class="tabela">
        <?php
			echo $livro['nome'];
		?>
        </td>
        <td width="168" class="tabela">
        <?php
			echo "R$ ".$livro['preco'];
		?>
        </td>
        <td width="116" class="tabela">
        <?php
			$id = $livro['id'];
			echo "<input type=\"hidden\" name=\"prod\" id=\"prod\" value=\"$id\">";
			echo "<input type=\"hidden\" name=\"im\" id=\"im\" value=\"$imagem\">";
		?>

		<input type="image" src="Img/carrinho.png" width="97" height="77">
        
        </td>
      </tr>
      
    </table>
    </form>
  
</body>
</html>