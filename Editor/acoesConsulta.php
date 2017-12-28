<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>A3RA</title>
<link rel="stylesheet" href="css/screen.css" type="text/css" media="screen" title="default" />
<link rel="icon" href="images/shared/icone.jpg" type="image/x-icon" />
<link rel="shortcut icon" href="images/shared/icone.jpg" type="image/x-icon" />
</head>
<body>

<!-- start content-outer ........................................................................................................................START -->
<div id="content-outer"> 
  <!-- start content -->
  <div id="content"> 
    
    <!--  Nome da pagina -->
    <div id="page-heading">
      <h1> Consulta de Ações </h1>
    </div>
    <!-- end page-heading -->
    
    <table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
      <tr>
        <th rowspan="3" class="sized"><img src="images/shared/side_shadowleft.jpg" width="20" height="400" alt="" /></th>
        <th class="topleft"></th>
        <td id="tbl-border-top">&nbsp;</td>
        <th class="topright"></th>
        <th rowspan="3" class="sized"><img src="images/shared/side_shadowright.jpg" width="20" height="400" alt="" /></th>
      </tr>
      <tr>
        <td id="tbl-border-left"></td>
        <td><!--  start content-table-inner ...................................................................... START -->
          
          <div id="content-table-inner"> 
            
            <!--  start table-content  -->
            
          <div id="table-content">

            <form action="../A3RA/marcadorConsulta.php" method="post">

              <table width="340" border="0" cellpadding="0" cellspacing="0">
                
              </table>
            </form>
            <!-- end id-form  --> 
            
          
          <?php
			//error_reporting(0); //desabilitar as irritantes mensagens de warnning

			if (!isset($_SESSION)) session_start();
						
			include('banco.php'); 			
			
			$dados = consultaAcao();
			if (sizeof($dados)>= 1){
				$cinza = false; //para chaverar o fundo cinza*/
				
				//cabeçalho da tabela
				echo "<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" id=\"product-table\">";
				echo "<tr>";
				echo "<th class=\"table-header-repeat line-left minwidth-1\"><a href=\"\">Id</a> </th>";
				echo "<th class=\"table-header-repeat line-left minwidth-1\"><a href=\"\">Nome</a> </th>";
				echo "<th class=\"table-header-repeat line-left minwidth-1\"><a href=\"\">Acionamento</a></th>";
				echo "<th class=\"table-header-repeat line-left\"><a href=\"\">Descrição</a></th>";
				echo "</tr>";
				
				//corpo da tabela
				foreach($dados as $linha){
					if($cinza){
						echo " <tr class=\"alternate-row\">";
						$cinza = false;
					}else{//sem fundo cinza
						echo "<tr>";
						$cinza = true;
					}
					echo "<td><input type=\"hidden\" name=\"id\" id=\"id\" value=\"".$linha['idACOES']."\"/>".$linha['idACOES']."</td>
						  <td><input type=\"hidden\" name=\"nome\" id=\"nome\" value=\"".$linha['nome']."\"/>".$linha['nome']."</td>
						  <td><input type=\"hidden\" name=\"acionamento\" id=\"acionamento\" value=\"" .$linha['acionamento']."\"/>".$linha['acionamento']."</td>
						  <td><input type=\"hidden\" name=\"obs\" id=\"obs\" value=\"" .$linha['obs']."\"/>".$linha['obs']."</td>
						</tr>";
				}
				echo "</table>";
			}else{
				echo "Primeira carga da tabela ação:<br><br><br>";
				cadastraAcao("Habilitação de objeto", "objeto", "Quando o usuário colidir na geo-posição ou por processamento de imagem um marcador for detectado, 
								um objeto será apresentado a cena.");
								
				cadastraAcao("Modificação de índices", "indices", "São planejados para modificação de pontuação, vidas ou mesmo fazer com que o usuário perca itens 
								já encontrados. A seleção deste tipo de ação habilitará informações a serem preenchidas para complemento das características da ação, 
								como por exemplo se será aumentado pontos, deverá ser preenchido a quantidade ou se for para perder itens já coletados que seja 
								escolhido qual seera perdido.");	

				cadastraAcao("Habilitação por tempo", "tempo", "Nesse caso ao ser criado ou aparecer na cena o objeto começará a contar tempo. A ação deve ter o valor 
								desse tempo que o objeto irá contar. Ao termino dessa contagem o sistema cliente realizará uma determinada ação, que é outro evento.");				
				cadastraAcao("Habilitação de outros eventos", "eventos", "Ações podem estar desabilitados e somente com o acionamento desta ação em questão um ou mais 
								eventos podem se tornar visíveis. Um exemplo deste tipo de ação é o de fim de aplicação, ou ligação entre outras sequencias de ações.");				
				cadastraAcao("Habilitação de Feedback", "feedback", "Essa ação é especifica para chamar a função de feedback para o usuário poder contribuir com o projeto");				

			}				
			
		?>
            </div>
            <!--  end content-table  -->
             
		   
          </div>
          
          <!--  end content-table-inner ............................................END  --></td>
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