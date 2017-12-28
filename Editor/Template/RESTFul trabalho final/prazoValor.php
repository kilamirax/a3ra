<?php

function frete($cep)
{
	/*
	40010 SEDEX sem contrato.
	40045 SEDEX a Cobrar, sem contrato.
	40126 SEDEX a Cobrar, com contrato.
	40215 SEDEX 10, sem contrato.
	40290 SEDEX Hoje, sem contrato.
	40096 SEDEX com contrato.
	40436 SEDEX com contrato.
	40444 SEDEX com contrato.
	40568 SEDEX com contrato.
	40606 SEDEX com contrato.
	41106 PAC sem contrato.
	41068 PAC com contrato.
	81019 e-SEDEX, com contrato.
	81027 e-SEDEX Prioritário, com conrato.
	81035 e-SEDEX Express, com contrato.
	81868 (Grupo 1) e-SEDEX, com contrato.
	81833 (Grupo 2) e-SEDEX, com contrato.
	81850 (Grupo 3) e-SEDEX, com contrato.
	*/
	
	$data['nCdEmpresa'] = '';
	$data['sDsSenha'] = '';
	$data['sCepOrigem'] = '29167124';
	$data['sCepDestino'] = $cep;
	$data['nVlPeso'] = '1';
	$data['nCdFormato'] = '1';
	$data['nVlComprimento'] = '16';
	$data['nVlAltura'] = '5';
	$data['nVlLargura'] = '15';
	$data['nVlDiametro'] = '0';
	$data['sCdMaoPropria'] = 's';
	$data['nVlValorDeclarado'] = '200';
	$data['sCdAvisoRecebimento'] = 'n';
	$data['StrRetorno'] = 'xml';
	//$data['nCdServico'] = '40010';
	$data['nCdServico'] = '40010';
	$data = http_build_query($data);
	 
	$url = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx';
	$curl = curl_init($url . '?' . $data);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($curl);
	$result = simplexml_load_string($result);
	 
	//print_r($result);
	 
	foreach($result -> cServico as $row) {
		if($row -> Erro == 0) {
			$valor = $row -> Valor;
			/*
			echo "Codigo ".$row -> Codigo . '<br>';
			echo "Valor ".$row -> Valor . '<br>';
			echo "PrazoEntrega ".$row -> PrazoEntrega . '<br>';
			echo "ValorMaoPropria ".$row -> ValorMaoPropria . '<br>';
			echo "ValorAvisoRecebimento ".$row -> ValorAvisoRecebimento . '<br>';
			echo "ValorValorDeclarado ".$row -> ValorValorDeclarado . '<br>';
			echo "EntregaDomiciliar ".$row -> EntregaDomiciliar . '<br>';
			echo "EntregaSabado ".$row -> EntregaSabado;
			*/
		} else {
			echo $row -> MsgErro;
		}
		echo '<hr>';
	}
	return $valor;
}
?>