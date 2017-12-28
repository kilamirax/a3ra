<?php
error_reporting(0); // sem isso a pagina fica bem suja...
include('prazoValor.php');

session_start();

$imagem = "";
$valor = "";
$peso = "";
$nomeLivro = "";
$imagem = $_POST["im"];
$nomeLivro = $_POST["nomeLivro"];
$nome = $_POST["nome"];
$user = $_POST["user"];		


		/*
	$mural = array(
	  'message'     => $nome.' comprou um '.$nomeLivro,
	  'name'        => $nomeLivro,
	  'caption'     => 'Comprado na LivrariaRestful',
	  'link'        => 'url',
	  'description' => 'Livro muito legal!',
	  'picture'     => $imagem,
	  'actions'     => array(
		array(
		  'name' => 'LivrariaRestful',
		  'link' => 'url do seu site'
		)
	  )
	);
	
	$endpoint = '/$user/feed';
		
	$facebook->api( $endpoint, 'POST', $mural );
		*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
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
	<div id="fb-root"></div>
	<script>
      window.fbAsyncInit = function() {
        // init the FB JS SDK
        FB.init({
          appId      : '174175052769874',                        // App ID from the app dashboard
          channelUrl : 'http://www.victoryisland.com.br/TZ/restful/final.php', // Channel file for x-domain comms
          status     : true,                                 // Check Facebook Login status
          xfbml      : true                                  // Look for social plugins on the page
        });
    
        // Additional initialization code such as adding Event Listeners goes here
      };
    
      // Load the SDK asynchronously
      (function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement(s); js.id = id;
         js.src = "//connect.facebook.net/en_US/all.js";
         fjs.parentNode.insertBefore(js, fjs);
       }(document, 'script', 'facebook-jssdk'));
    </script>
    
    <table width="1354" border="0">
	  <tr>
		<td align="center" bgcolor="#FFFFFF" class="Logo">Livraria RESTFul - <span class="subTitulo">2º Trabalho prático da matéria de Hipermídia e Web - UFES Mestrado 2013/2</span></td>
	  </tr>
	</table>
    
    <p>
        <script type="text/javascript">
	function bagulho(){
		FB.ui(
		  {
			method: 'feed',
			name: '<?php echo $nome; ?>',
			to: '<?php echo $user; ?>',
			link: 'http://www.victoryisland.com.br/TZ/restful/',
			picture: '<?php echo "http://www.victoryisland.com.br/TZ/restful/".$imagem;?>',
			caption: 'Comprado na LivrariaRestful',
			description: 'Livro muito legal!'
		  },
		  function(response) {
			if (response && response.post_id) {
			 // alert('Post was published.');
			} else {
			  //alert('Post was not published.');
			  console.dir(response);
			}
		  }
		);
	}
        </script>
      
      Você concluiu sua compra, quer postar no facebook?    </p>
    <p>
      <input name="teste" type="button" value="Postar"onclick="javascript:bagulho()"/>
    </p>
    <p>&nbsp;</p>
    <a href="index.php"><img src="Img/voltar.png" width="500" height="107" border="0"></a>
</body>
</html>
