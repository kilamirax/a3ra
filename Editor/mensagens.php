<?php


function mensagemVermelha($msn){
	echo"			<div id=\"message-red\">";
	echo"			<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">";
	echo"			<tr>";
	echo"				<td class=\"red-left\">".$msn."</td>";
	echo"				<td class=\"red-right\"><a class=\"close-red\"><img src=\"images/table/transparente.png\" alt=\"\" /></a></td>";
	// 
	echo"			</tr>";
	echo"			</table>";
	echo"			</div>";
}
function mensagemAmarela($msn){
	echo"			<div id=\"message-yellow\">";
	echo"			<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">";
	echo"			<tr>";
	echo"				<td class=\"yellow-left\">".$msn."</td>";
	echo"				<td class=\"yellow-right\"><a class=\"close-yellow\"><img src=\"images/table/transparente.png\" alt=\"\" /></a></td>";
	echo"			</tr>";
	echo"			</table>";
	echo"			</div>";
}
function mensagemAzul($msn){
	echo"			<div id=\"message-blue\">";
	echo"			<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">";
	echo"			<tr>";
	echo"				<td class=\"blue-left\">".$msn." </td>";
	echo"				<td class=\"blue-right\"><a class=\"close-blue\"><img src=\"images/table/transparente.png\" alt=\"\" /></a></td>";
	echo"			</tr>";
	echo"			</table>";
	echo"			</div>";
}
	
function mensagemVerde($msn){
	echo"			<div id=\"message-green\">";
	echo"			<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">";
	echo"			<tr>";
	echo"				<td class=\"green-left\">".$msn."</td>";
	echo"				<td class=\"green-right\"><a class=\"close-green\"><img src=\"images/table/transparente.png\" alt=\"\" /></a></td>";
	echo"			</tr>";
	echo"			</table>";
	echo"			</div>";
	
	/*<div id="message-green">
		<table border="0" width="100%" cellpadding="0" cellspacing="0">
			<tr>
				<td class="green-left"></td>
				<td class="green-right"><a class="close-green"><img src="images/table/transparente.png" alt="" /></a></td>
			</tr>
		</table>
	</div>*/
}

function informa ($icone,$titulo ,$msn, $msnArrayTopicos){
	
	echo"<div class=\"left\"><img src=\"";
		if($icone == "voltar"){
			echo "images/forms/icon_seta.gif";
		}
		if($icone == "mais"){
			echo "images/forms/icon_plus.gif";
		}
		if($icone == "menos"){
			echo "images/forms/icon_minus.gif";
		}
		if($icone == "editar"){
			echo "images/forms/icon_edit.gif";
		}
	echo"\" width=\"21\" height=\"21\" alt=\"\"></div>";
	
    echo"<div class=\"right\">";
    echo"	<h5>".$titulo."</h5>";
	
    echo $msn;

	if(sizeof($msnArrayTopicos) !=0){
		echo"	<ul class=\"greyarrow\">";
		for ($i =0; $i < sizeof($msnArrayTopicos); $i++){
			echo"		<li>";
				echo $msnArrayTopicos[$i];
			echo"       </li>"; 
		}
	}
    echo"	</ul>";
    echo"</div>";
		                        
    echo"<div class=\"clear\"></div>";
    echo"<div class=\"lines-dotted-short\"></div>";
}

?>
