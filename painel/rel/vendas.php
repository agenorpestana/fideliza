<?php 
include('../../conexao.php');

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$data_hoje = utf8_encode(strftime('%A, %d de %B de %Y', strtotime('today')));


$dataInicial = $_GET['dataInicial'];
$dataFinal = $_GET['dataFinal'];
$selecao = $_GET['selecao'];


$dataInicialF = implode('/', array_reverse(explode('-', $dataInicial)));
$dataFinalF = implode('/', array_reverse(explode('-', $dataFinal)));


if($dataInicial == $dataFinal){
	$texto_apuracao = 'APURADO EM '.$dataInicialF;
}else if($dataInicial == '1980-01-01'){
	$texto_apuracao = 'APURADO EM TODO O PERÍODO';
}else{
	$texto_apuracao = 'APURAÇÃO DE '.$dataInicialF. ' ATÉ '.$dataFinalF;
}


if($selecao == ''){
	$acao_rel = '';
}else{
	$acao_rel = ' - Técnico '.$selecao;
}

$selecao = '%'.$selecao.'%';



?>

<!DOCTYPE html>
<html>
<head>
	<title>Relatório Pontos</title>	

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">

	<style>

		@page {
			margin: 0px;

		}

		body{
			margin-top:0px;
			font-family:Times, "Times New Roman", Georgia, serif;
		}		

			.footer {
				margin-top:20px;
				width:100%;
				background-color: #ebebeb;
				padding:5px;
				position:absolute;
				bottom:0;
			}

		

		.cabecalho {    
			padding:10px;
			margin-bottom:30px;
			width:100%;
			font-family:Times, "Times New Roman", Georgia, serif;
		}

		.titulo_cab{
			color:#0340a3;
			font-size:17px;
		}

		
		
		.titulo{
			margin:0;
			font-size:28px;
			font-family:Arial, Helvetica, sans-serif;
			color:#6e6d6d;

		}

		.subtitulo{
			margin:0;
			font-size:12px;
			font-family:Arial, Helvetica, sans-serif;
			color:#6e6d6d;
		}



		hr{
			margin:8px;
			padding:0px;
		}


		
		.area-cab{
			
			display:block;
			width:100%;
			height:10px;

		}

		
		.coluna{
			margin: 0px;
			float:left;
			height:30px;
		}

		.area-tab{
			
			display:block;
			width:100%;
			height:30px;

		}


		.imagem {
			width: 200px;
			position:absolute;
			right:20px;
			top:10px;
		}

		.titulo_img {
			position: absolute;
			margin-top: 10px;
			margin-left: 10px;

		}

		.data_img {
			position: absolute;
			margin-top: 40px;
			margin-left: 10px;
			border-bottom:1px solid #000;
			font-size: 10px;
		}

		.endereco {
			position: absolute;
			margin-top: 50px;
			margin-left: 10px;
			border-bottom:1px solid #000;
			font-size: 10px;
		}

		.verde{
			color:green;
		}
		

	</style>


</head>
<body>	



<div class="titulo_cab titulo_img"><u>Relatório de Pontos  <?php echo $acao_rel ?> </u></div>	
	<div class="data_img"><?php echo mb_strtoupper($data_hoje) ?></div>


		<img class="imagem" src="<?php echo $url_sistema ?>img/logo_rel.jpg" width="50px" height="43">



	
	<br><br><br>
	<div class="cabecalho" style="border-bottom: solid 1px #0340a3">
	</div>

	<div class="mx-2" style="padding-top:10px ">

		<section class="area-cab">
			
			<div class="coluna" style="width:50%">
				<small><small><small><u><?php echo $texto_apuracao ?></u></small></small></small>
			</div>

	
			</section>

		<br>

		<?php 
		$total_vendas = 0;
		$total_vendasF = 0;
		$query = $pdo->query("SELECT * from os where (data_fechamento >= '$dataInicial' and data_fechamento <= '$dataFinal') and funcionario LIKE '$selecao' order by id desc ");
		$res = $query->fetchAll(PDO::FETCH_ASSOC);
		$total_reg = count($res);
		if($total_reg > 0){
			?>

			<small><small>
				<section class="area-tab" style="background-color: #f5f5f5;">
					
					<div class="linha-cab" style="padding-top: 5px;">
						<div class="coluna" style="width:20%">FUNCIONÁRIO</div>
						<div class="coluna" style="width:17%">DATA ABERTURA</div>
						<div class="coluna" style="width:17%">DATA FECH</div>
						<div class="coluna" style="width:17%">ASSUNTO</div>
						<div class="coluna" style="width:10%">PONTOS</div>
						<div class="coluna" style="width:10%">ID OS</div>
						<div class="coluna" style="width:10%">PONTOS N</div>
							

					</div>
					
				</section><small></small>

				<div class="cabecalho mb-1" style="border-bottom: solid 1px #e3e3e3;">
				</div>

				<?php 
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

	$query = $pdo->query("
        SELECT SUM(pontos) as total_pontos
        FROM os AS os
        WHERE os.data_fechamento >= '$dataInicial' 
        AND os.data_fechamento <= '$dataFinal 23:59:59'
        and funcionario LIKE '$selecao'
    ");

    $resultado = $query->fetch(PDO::FETCH_ASSOC);

    $totalPontos = $resultado['total_pontos'];


	

				 ?>

<tr>
		
		<section class="area-tab" style="padding-top:5px">					
						<div class="linha-cab">				
							<div class="coluna" style="width:20%"><?php echo $funcionario ?></div>
							<div class="coluna" style="width:18%"><?php echo $data_abertura ?></div>
							<div class="coluna" style="width:16%"><?php echo $data_fechamento ?></div>

							<div class="coluna" style="width:17%"><?php echo $assunto ?></div>							

							<div class="coluna" style="width:10%"><?php echo $pontos ?> </div>	
							<div class="coluna" style="width:10%"><?php echo $id_os ?></div>	
							<div class="coluna" style="width:10%"><?php echo $pontos_negativo ?></div>
							
													

						</div>
					</section>
					<div class="cabecalho" style="border-bottom: solid 1px #e3e3e3;">
					</div>
</tr>
				<?php } ?>

			</small>



		</div>


		<div class="cabecalho mt-3" style="border-bottom: solid 1px #0340a3">
		</div>


	<?php }else{
		echo '<div style="margin:8px"><small><small>Sem Registros no banco de dados!</small></small></div>';
	} ?>





	<div class="col-md-12 p-2">
		<div class="" align="right">

		<span class="text-success"> <small><small><small><small>TOTAL PONTOS</small> : <?php echo $totalPontos ?></small></small></small>  </span>			

		
		</div>
	</div>
	<div class="cabecalho" style="border-bottom: solid 1px #0340a3">
	</div>




	<div class="footer"  align="center">
		<span style="font-size:10px"><?php echo $nome_sistema ?> Whatsapp: <?php echo '(73)99856-2715' ?></span> 
	</div>




	</body>

	</html>