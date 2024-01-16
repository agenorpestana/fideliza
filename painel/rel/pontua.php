<?php 
include('../../conexao.php');

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$data_hoje = utf8_encode(strftime('%A, %d de %B de %Y', strtotime('today')));


$dataInicial = $_GET['dataInicial'];
$dataFinal = $_GET['dataFinal'];
$selecao = $_GET['selecao'];

//$dataFinalH = $dataFinal.' 23:59:59';

$dataInicialF = implode('/', array_reverse(explode('-', $dataInicial)));
$dataFinalF = implode('/', array_reverse(explode('-', $dataFinal)));
$data_formatada_F = date('d/m/Y', strtotime($dataFinal));
$data_sem_formatar = date('Y-m-d', strtotime($dataFinal));


if($dataInicial == $data_sem_formatar){
	$texto_apuracao = 'APURADO EM '.$data_formatada_F;
}else if($dataInicial == '1980-01-01'){
	$texto_apuracao = 'APURADO EM TODO O PERÍODO';
}else{
	$texto_apuracao = 'APURAÇÃO DE '.$dataInicialF. ' ATÉ '.$data_formatada_F;
}


if($selecao == ''){
	$acao_rel = '';
}else{
	$acao_rel = $selecao;
}

$selecao = '%'.$selecao.'%';

/*if(empty($selecao)){
    $acao_rel = 'TODOS OS TÉCNICOS';
    $selecao = '%'; // Para obter todos os técnicos
} else {
    $acao_rel = $selecao;
    $selecao = '%'.$selecao.'%';
}*/



?>

<!DOCTYPE html>
<html>
<head>

<style>

@import url('https://fonts.cdnfonts.com/css/tw-cen-mt-condensed');
@page { margin: 145px 20px 25px 20px; }
#header { position: fixed; left: 0px; top: -110px; bottom: 100px; right: 0px; height: 35px; text-align: center; padding-bottom: 100px; }
#content {margin-top: 0px;}
#footer { position: fixed; left: 0px; bottom: -60px; right: 0px; height: 80px; }
#footer .page:after {content: counter(page, my-sec-counter);}
body {font-family: 'Tw Cen MT', sans-serif;}

.marca{
	position: fixed;
	left:50;
	top:100;
	width:80%;
	opacity:0.08;
}

</style>

</head>
<body>


<?php 
if($marca_dagua == 'Sim'){ ?>
<img class="marca" src="<?php echo $url_sistema ?>img/logo.jpg">	
<?php } ?>


<div id="header" >

	<div style="border-style: solid; font-size: 10px; height: 50px;">
		<table style="width: 100%; border: 0px solid #ccc;">
			<tr>
				<td style="border: 1px; solid #000; width: 7%; text-align: left;">
					<img style="margin-top: 7px; margin-left: 7px;" id="imag" src="<?php echo $url_sistema ?>img/logo.jpg" width="45px">
				</td>
				<td style="width: 30%; text-align: left; font-size: 13px;">
					
				</td>
				<td style="width: 1%; text-align: center; font-size: 13px;">
				
				</td>
				<td style="width: 47%; text-align: right; font-size: 9px;padding-right: 10px;">
						<b><big>RELATÓRIO DE PONTUAÇÃO - TÉCNICO: <span style="color:green;"><?php echo $acao_rel ?> </span></big></b><br> <?php echo mb_strtoupper("$texto_apuracao") ?> <br> <?php echo mb_strtoupper($data_hoje) ?>
				</td>
			</tr>		
		</table>
	</div>

<br>


		<table id="cabecalhotabela" style="border-bottom-style: solid; font-size: 8px; margin-bottom:10px; width: 100%; table-layout: fixed;">
			<thead>
				
				<tr id="cabeca" style="margin-left: 0px; background-color:#CCC">
					<td style="width:25%">FUNCIONÁRIO</td>
					<td style="width:12%">DATA ABERTURA</td>
					<td style="width:12%">DATA FECHAMENTO</td>
					<td style="width:31%">ASSUNTO</td>
					<td style="width:06%">ID OS</td>
					<td style="width:06%">PONTOS</td>	
					<td style="width:08%">PONTOS NEGATIVO</td>		
					
				</tr>
			</thead>
		</table>
</div>


<div id="footer" class="row">
<hr style="margin-bottom: 0;">
	<table style="width:100%;">
		<tr style="width:100%;">
			<td style="width:60%; font-size: 10px; text-align: left;"><?php echo $nome_sistema ?> Telefone: <?php echo $telefone_sistema ?></td>
			<td style="width:40%; font-size: 10px; text-align: right;"><p class="page">Página  </p></td>
		</tr>
	</table>
</div>

<div id="content" style="margin-top: 0;">



		<table style="width: 100%; table-layout: fixed; font-size:8px; text-transform: uppercase;">
			<thead>
				<tbody>




		<?php 
		$totalPontosN = 0;
		$totalPontosP = 0;
		$totalPontos = 0;
		$total_vendas = 0;
		$total_vendasF = 0;
		$query = $pdo->query("SELECT * from os where (data_fechamento >= '$dataInicial' and data_fechamento <= '$dataFinal') and funcionario LIKE '$selecao' order by id asc ");
		$res = $query->fetchAll(PDO::FETCH_ASSOC);
		$total_reg = count($res);
		if($total_reg > 0){
			
	for($i=0; $i < $total_reg; $i++){
	foreach ($res[$i] as $key => $value){}
	$id = $res[$i]['id'];
	$id_os = $res[$i]['id_os'];
	$id_tecnico = $res[$i]['id_tecnico'];	
	$funcionario = $res[$i]['funcionario'];	
	$data_abertura = $res[$i]['data_abertura'];	
	$data_fechamento = $res[$i]['data_fechamento'];	
	$assunto = $res[$i]['assunto'];
	$id_assunto = $res[$i]['id_assunto'];	
	$cidade = $res[$i]['cidade'];
	$id_cidade = $res[$i]['id_cidade'];	
	$id_cliente = $res[$i]['id_cliente'];
	$nome_cliente = $res[$i]['nome_cliente'];
	$whatsapp_cli = $res[$i]['whatsapp_cli'];	
	$status = $res[$i]['status'];
	$pontos = $res[$i]['pontos'];	
	$pontos_negativo = $res[$i]['pontos_negativo'];

	$dataAberturaF = date('d/m/Y H:i', strtotime($data_abertura));
	$dataFechamentoF = date('d/m/Y H:i', strtotime($data_fechamento));

	$query = $pdo->query("
        SELECT SUM(pontos) as total_pontos
        FROM os AS oss
        WHERE oss.data_fechamento >= '$dataInicial' 
        AND oss.data_fechamento <= '$dataFinal 23:59:59'
        and funcionario LIKE '$selecao'
    ");

    $resultado = $query->fetch(PDO::FETCH_ASSOC);

    $totalPontosP = $resultado['total_pontos'];

    $query2 = $pdo->query("
        SELECT SUM(pontos_negativo) as total_pontos_negativo
        FROM os AS osn
        WHERE osn.data_fechamento >= '$dataInicial' 
        AND osn.data_fechamento <= '$dataFinal 23:59:59'
        and funcionario LIKE '$selecao'
    ");

    $resultadoN = $query2->fetch(PDO::FETCH_ASSOC);

    $totalPontosN = $resultadoN['total_pontos_negativo'];

?>


<tr>
<td style="width:25%"><?php echo $funcionario ?></td>
<td style="width:12%"><?php echo $dataAberturaF ?></td>
<td style="width:12%"><?php echo $dataFechamentoF ?></td>
<td style="width:31%"><?php echo $assunto ?></td>
<td style="width:06%"><?php echo $id_os ?></td>
<td style="width:06%"><?php echo $pontos ?></td>
<td style="width:08%"><?php echo $pontos_negativo ?></td>

</tr>

<?php } } ?>
</tbody>
	
			</thead>
		</table>
	


</div>
<hr>
		<table>
			<thead>
				<tbody>
					<tr>

						<td style="font-size: 10px; width:600px; text-align: right;"></td>

						

						<td style="font-size: 10px; width:140px; text-align: right;"><b>TOTAL DE OS: <span style="color:green"><?php echo $total_reg ?></span></td>

							<td style="font-size: 10px; width:140px; text-align: right;"><b>PONTOS POSITIVO: <span style="color:green"><?php echo $totalPontosP ?></span></td>


								<td style="font-size: 10px; width:170px; text-align: right;"><b>PONTOS NEGATIVOS: <span style="color:red"><?php echo $totalPontosN ?></span></td>

									<td style="font-size: 10px; width:150px; text-align: right;"><b>TOTAL DE PONTOS: <span style="color:blue;"><?php echo ($totalPontos = $totalPontosP - $totalPontosN) ?></span></td>
						
					</tr>
				</tbody>
			</thead>
		</table>

</body>

</html>

