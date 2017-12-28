<?php
require 'facebook/src/facebook.php';

error_reporting(0); // sem isso a pagina fica bem suja...
//include('dadosFace.php');
session_start();

$prod = $_POST["prod"];
$im = $_POST["im"];


	$facebook = new Facebook(array(
	  'appId'  => '174175052769874',
	  'secret' => '9d9878df09aab6306618a049b08daadf', status=>true, xfbml=>true
	));
	
	$user = $facebook->getUser();
	
	if ($user) {
	  try {
		$user_profile = $facebook->api('/me');
		$permissions = $facebook->api( '/me/permissions' );
	  } catch (FacebookApiException $e) {
		error_log($e);
		$user = null;
	  }
	  
		try {
			$j=0;
			$amigos = $facebook->api('/me/friends');
			foreach ($amigos['data'] as $am)
			{
				//print_r($am);
				$amigo[$j]['id'] = $am['id'];
				$amigo[$j]['name'] = $am['name'];
				$j++;
			}
		} catch (FacebookApiException $e) {
			error_log($e);
		}  
	  
	}


	if ($user) {
	  $logoutUrl = $facebook->getLogoutUrl();
	  $userGeral = $user;
	  
	} else {
	  $loginUrl = $facebook->getLoginUrl();
	}

?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <title>Livraria RESTFul</title>
    <style>
      body {
	font-family: 'Lucida Grande', Verdana, Arial, sans-serif;
	background-image: url(Img/papel-de-parede-livro.jpg);
      }
      h1 a {
        text-decoration: none;
        color: #3b5998;
      }
      h1 a:hover {
        text-decoration: underline;
      }
    body,td,th {
	font-family: "Lucida Grande", Verdana, Arial, sans-serif;
	font-style: italic;
}
    .Logo {	font-size: 36px;
}
.Logo {	color: #090;
}
.Logo {	font-family: Arial, Helvetica, sans-serif;
}
.subTitulo {	font-size: 24px;
}
    #apDiv1 {
	position:absolute;
	left:866px;
	top:262px;
	width:409px;
	height:138px;
	z-index:1;
}
    </style>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>
  <body>
  
    <div id="apDiv1"><a href="index.php"><img src="Img/voltar.png" width="500" height="107" border="0"></a></div>
    <table width="1354" border="0">
      <tr>
        <td align="center" bgcolor="#FFFFFF" class="Logo">Livraria RESTFul - <span class=		"subTitulo">2º Trabalho prático da matéria de Hipermídia e Web - UFES Mestrado 2013/2</span><span class="subTitulo"></span></td>
      </tr>
    </table>
    
    
    

	<?php if ($user): ?>
		<a href="<?php echo $logoutUrl; ?>">Logout?</a>
	<?php else: ?>

    <p><br></p>
    <div>  
		<a href="<?php echo $loginUrl; ?>">
            <img src="Img/LoginWithFacebook.png" width="318" height="58">
		</a>
	</div>
    <p>
    <?php endif ?>

    <?php if ($user): ?>
	<p>Você está conectado(a). Clique na sua foto para continuar</p>       
        <table width="565" border="0">
          <tr class="destinatário">
            <td colspan="2">Você:</td>
            <td width="311">Amigos:</td>
          </tr>
          <tr>
            <td width="133">
                <form id="form1" name="form1" method="post" action="carrinho.php">
                    <input type="hidden" name="prod" id="prod" value="<?php echo $prod; ?>">
                    <input type="hidden" name="im" id="im" value="<?php echo $im; ?>">
                    <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">
                    <input type="hidden" name="nome" id="nome" value="<?php  echo $user_profile['name']; ?>">
                    <input type="image" src="https://graph.facebook.com/<?php echo $user; ?>/picture" alt="" />
                    
                </form>
            <td width="99">
                <?php 
                        echo $user_profile['name'];
                ?>
            </td>
            <td rowspan="2">
            <?php 
                echo "<table>";
                for ($i = 0; $i < sizeof($amigo); $i++) {
                    echo "<tr>";
                    echo "	<td>";
                    echo "		<form id=\"form1\" name=\"form1\" method=\"post\" action=\"carrinho.php\">";
                    $id = $amigo[$i]['id'];
					$nome = $amigo[$i]['name'];

                    echo "<input type=\"hidden\" name=\"prod\" id=\"prod\" value=\"$prod\">";
					echo "<input type=\"hidden\" name=\"im\" id=\"im\" value=\"$im\">";
					echo "<input type=\"hidden\" name=\"user\" id=\"user\" value=\"$id\">";
					echo "<input type=\"hidden\" name=\"nome\" id=\"nome\" value=\"$nome\">";
                    echo "		<input type=\"image\" src=\"https://graph.facebook.com/$id/picture\" alt=\"\" />";
                    echo "		</form>";
                    echo "	</td>";
                    echo "	<td>";
                    echo $amigo[$i]['name'];
                    echo "	</td>";
                    echo "</tr>	";
                }
                echo "</table>";
             ?>
            </td>
          </tr>
          <tr>
            <td>            
            <td>&nbsp;</td>
          </tr>
        </table>
      <?php else: ?>
      </p>
  <p><strong><em>Você não está conectado(a)</em></strong></p>
    <?php endif ?>
    <br><br>
    <a href="index.php"> Voltar para a loja<a>
  </body>
</html>
