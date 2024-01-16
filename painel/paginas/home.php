<?php 
if(@$home == 'ocultar'){
	echo "<script>window.location='../index.php'</script>";
	exit();
}

$data_atual = date('Y-m-d');
// Obter o primeiro dia do mês atual
$primeiroDiaDoMes = date('Y-m-01');

// Obter o último dia do mês atual
$ultimoDiaDoMes = date('Y-m-t');


// Consulta para obter os 5 assuntos que mais abriram OS no mês
$query = $pdo->query("
    SELECT assunto, COUNT(*) as total_os
    FROM os
    WHERE DATE(data_abertura) BETWEEN '{$primeiroDiaDoMes}' AND '{$ultimoDiaDoMes}'
    GROUP BY assunto
    ORDER BY total_os DESC
    LIMIT 5
");
$assuntosMaisAbertos = $query->fetchAll(PDO::FETCH_ASSOC);


$query = $pdo->query("SELECT * from os where DATE(data_abertura) = '$data_atual'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_os = @count($res);

$query = $pdo->query("SELECT * FROM os WHERE formulario_respondido_os > 0 AND DATE(data_fechamento) BETWEEN '{$primeiroDiaDoMes}' AND '{$ultimoDiaDoMes}'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_form_resp = @count($res);

$query = $pdo->query("SELECT * from os where DATE(data_fechamento) BETWEEN '{$primeiroDiaDoMes}' AND '{$ultimoDiaDoMes}'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$totalOS = @count($res);


if($total_form_resp > 0 and $totalOS > 0){
    $percentagem_form_os = ($total_form_resp / $totalOS) * 100;
}else{
    $percentagem_form_os = 0;
}

$query = $pdo->query("SELECT * from os where DATE(data_fechamento) = '$data_atual'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_os_fechada = @count($res);

$query = $pdo->query("SELECT * from os where status = 'EN'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$Total_os_encaminhada = @count($res);

$query = $pdo->query("SELECT * from os where status = 'A'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$Total_os_aberto = @count($res);


$query = $pdo->query("SELECT * from indicacoes where DATE(data_cadastro) = '$data_atual'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$Total_indicacoes = @count($res);

// Consulta para obter os 8 técnicos que mais finalizam 'os' com status 'F' no mês atual
$queryTecnicos = $pdo->query("
    SELECT funcionario, COUNT(*) as total_os
    FROM os
    WHERE status = 'F' AND DATE(data_fechamento) BETWEEN '{$primeiroDiaDoMes}' AND '{$ultimoDiaDoMes}'
    GROUP BY funcionario
    ORDER BY total_os DESC
    LIMIT 8
");
$tecnicos = $queryTecnicos->fetchAll(PDO::FETCH_ASSOC);

// Para cada técnico, consulte os 5 assuntos mais executados no mês atual
$data = [['funcionario']];
foreach ($tecnicos as $tecnico) {
    $queryAssuntos = $pdo->query("
        SELECT assunto, COUNT(*) as total_os
        FROM os
        WHERE status = 'F' AND funcionario = '{$tecnico['funcionario']}' AND DATE(data_fechamento) BETWEEN '{$primeiroDiaDoMes}' AND '{$ultimoDiaDoMes}'
        GROUP BY assunto
        ORDER BY total_os DESC
        LIMIT 5
    ");
    $assuntos = $queryAssuntos->fetchAll(PDO::FETCH_ASSOC);

    // Adicione os dados do técnico e seus 5 assuntos ao array $data
    $row = [$tecnico['funcionario']];
    foreach ($assuntos as $assunto) {
        $row[] = (int)$assunto['total_os'];
    }
    $data[] = $row;
}

// Converta o array PHP em um array JavaScript para ser usado no gráfico
$jsData = json_encode($data);









//echo "<meta HTTP-EQUIV='refresh' CONTENT='30;URL=index.php'>";



$query = $pdo->query("SELECT * from os where DATE(data_abertura) = '$data_atual'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_os = @count($res);

$query = $pdo->query("SELECT * FROM os WHERE formulario_respondido_os > 0 AND DATE(data_fechamento) BETWEEN '{$primeiroDiaDoMes}' AND '{$ultimoDiaDoMes}'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_form_resp = @count($res);

$query = $pdo->query("SELECT * from os where DATE(data_fechamento) BETWEEN '{$primeiroDiaDoMes}' AND '{$ultimoDiaDoMes}'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$totalOS = @count($res);


if($total_form_resp > 0 and $totalOS > 0){
    $percentagem_form_os = ($total_form_resp / $totalOS) * 100;
}else{
    $percentagem_form_os = 0;
}

$query = $pdo->query("SELECT * from os where DATE(data_fechamento) = '$data_atual'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_os_fechada = @count($res);

$query = $pdo->query("SELECT * from os where status = 'EN'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$Total_os_encaminhada = @count($res);

$query = $pdo->query("SELECT * from os where status = 'A'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$Total_os_aberto = @count($res);


$query = $pdo->query("SELECT * from indicacoes where DATE(data_cadastro) = '$data_atual'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$Total_indicacoes = @count($res);

if($total_os_fechada > 0 and $Total_os_encaminhada > 0){
    $percentagem_os = ($total_os_fechada / $Total_os_encaminhada) * 100;
}else{
    $percentagem_os = 0;
}

//Gráfico de linhas

$meses = 6;
$mesAtual = date('m');
$mes_atual = date('m');
$ano_atual = date('Y');
$data_inicio_mes_atual = $ano_atual.'-'.$mes_atual.'-01';
$data_inicio_apuracao = date('Y-m-d', strtotime("-$meses months",strtotime($data_inicio_mes_atual)));
$data_final_apuracao = date('Y-m-d', strtotime("-$mesAtual months",strtotime($data_inicio_mes_atual)));
//var_dump($mes_atual);
$datas_apuracao = '';
$nome_mes = '';
$datas_apuracao_final = '';

/*$total_receber_final = '';
$total_pagar_final = '';*/

$detratores_final = '';
$promotores_final = '';
$neutros_final = '';
for($cont=1; $cont<$meses+1; $cont++){

	$datas_apuracao = date('Y-m-d', strtotime("+$cont months",strtotime($data_inicio_apuracao)));
	$datas_apuracao_atual = date('Y-m-d', strtotime("+$cont months",strtotime($data_final_apuracao)));

	$mes = date('m', strtotime($datas_apuracao));
	$ano = date('Y', strtotime($datas_apuracao));
//echo $datas_apuracao;

	if($mes == '01'){
		$nome_mes = 'Janeiro';
	}

	if($mes == '02'){
		$nome_mes = 'Fevereiro';
	}

	if($mes == '03'){
		$nome_mes = 'Março';
	}

	if($mes == '04'){
		$nome_mes = 'Abril';
	}

	if($mes == '05'){
		$nome_mes = 'Maio';
	}

	if($mes == '06'){
		$nome_mes = 'Junho';
	}

	if($mes == '07'){
		$nome_mes = 'Julho';
	}

	if($mes == '08'){
		$nome_mes = 'Agosto';
	}

	if($mes == '09'){
		$nome_mes = 'Setembro';
	}

	if($mes == '10'){
		$nome_mes = 'Outubro';
	}

	if($mes == '11'){
		$nome_mes = 'Novembro';
	}

	if($mes == '12'){
		$nome_mes = 'Dezembro';
	}

	if($mes == '04' || $mes == '06' || $mes == '09' || $mes == '11'){
		$data_final_mes = '30';
	}else if($mes == '2'){
		$data_final_mes = '28';
	}else{
		$data_final_mes = '31';
	}
	
	$data_final_mes_completa = $ano.'-'.$mes.'-'.$data_final_mes;	
	$data_final_mes_atual = $ano_atual.'-'.$mes_atual.'-'.$data_final_mes;



	$query = $pdo->query("SELECT * from formulario where data_resposta >= '$datas_apuracao' and data_resposta <= '$data_final_mes_completa'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$linhas = @count($res);

	$detratores = 0;
	$neutros = 0;
	$promotores = 0;


	if ($linhas > 0) {

		for ($i = 0; $i < $linhas; $i++) {
			$perg3 = $res[$i]['perg3'];

    // Aqui você pode classificar as respostas da perg3 em Detratores, Neutros e Promotores
			if ($perg3 >= 0 && $perg3 <= 6) {
				$detratores++;
			} elseif ($perg3 >= 7 && $perg3 <= 8) {
				$neutros++;
			} elseif ($perg3 >= 9 && $perg3 <= 10) {
				$promotores++;
			}
		}
	}

	if ($linhas > 0) {
		$detratores_final .= number_format(((($detratores)/$linhas)*100),2).'*';		
		$promotores_final .= number_format(((($promotores)/$linhas)*100),2).'*';

		$neutros_final .= number_format(((($neutros)/$linhas)*100),2).'*';

	}else{
		$detratores_final .= $detratores.'*';
		$promotores_final .= $promotores.'*';
		$neutros_final .= $neutros.'*';

	}

	$datas_apuracaoF = implode('/', array_reverse(explode('-', $datas_apuracao)));

	$datas_apuracao_final .= $nome_mes.'*';
}
//var_dump($datas_apuracao_final);
$query2 = $pdo->query("SELECT * from formulario where data_resposta >= '$data_inicio_mes_atual' and data_resposta <= '$data_final_mes_atual'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$cont = @count($res2);

$detratoresNPS = 0;
$neutrosNPS = 0;
$promotoresNPS = 0;

if ($cont > 0) {
	
	for ($i = 0; $i < $cont; $i++) {
		$perg3 = $res2[$i]['perg3'];

    // Aqui você pode classificar as respostas da perg3 em Detratores, Neutros e Promotores
		if ($perg3 >= 0 && $perg3 <= 6) {
			$detratoresNPS++;
		} elseif ($perg3 >= 7 && $perg3 <= 8) {
			$neutrosNPS++;
		} elseif ($perg3 >= 9 && $perg3 <= 10) {
			$promotoresNPS++;
		}
	}

	$nps = (($promotoresNPS - $detratoresNPS) / $cont) * 100;

	// Agora você tem o total de Detratores, Neutros e Promot
	// Formate o valor do NPS com duas casas decimais
	$nps_formatado = number_format($nps, 2);

}else{
	$nps = 0;
	$nps_formatado = 0;
}

$total_meses = '';
//valores para grafico de barras
for($cont=1; $cont<=12; $cont++){
	if($cont < 10){
		$mes = '0'.$cont;
	}else{
		$mes = $cont;
	}
$data_inicio_mes = $ano_atual.'-'.$mes.'-01';

if($mes == '04' || $mes == '06' || $mes == '09' || $mes == '11'){
		$data_final_mes = '30';
	}else if($mes == '2'){
		$data_final_mes = '28';
	}else{
		$data_final_mes = '31';
	}

$data_inicio_mes = $ano_atual.'-'.$mes.'-01';
$data_fim_mes = $ano_atual.'-'.$mes.'-'.$data_final_mes;

$query = $pdo->query("SELECT * from os where data_fechamento >= '$data_inicio_mes' and data_fechamento <= '$data_fim_mes 23:59:59' and status = 'F'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_mes = @count($res);
$total_meses .= $total_mes.'*';
}


?>

<input type="hidden" name="meses_ano" value="<?php echo $datas_apuracao_final ?>">
<input type="hidden" name="detrator_meses" value="<?php echo $detratores_final ?>">
<input type="hidden" name="promotor_meses" value="<?php echo $promotores_final ?>">
<input type="hidden" name="neutro_meses" value="<?php echo $neutros_final ?>">

<div class="main-page margin-mobile">

	<?php if($ativo_sistema == ''){ ?>
		<div style="background: #ffc341; color:#3e3e3e; padding:10px; font-size:14px; margin-bottom:10px">
			<div><i class="fa fa-info-circle"></i> <b>Aviso: </b> Prezado Cliente, não identificamos o pagamento de sua última mensalidade, entre em contato conosco o mais rápido possivel para regularizar o pagamento, caso contário seu acesso ao sistema será desativado.</div>
		</div>
	<?php } ?>

	<div class="col_3">
		<a href="index.php?pagina=os">
		<div class="col-md-3 widget widget1">
			<div class="r3_counter_box">
				<i class="pull-left fa fa-file icon-rounded"></i>
				<div class="stats">
					<h5><strong><?php echo $total_os ?></strong></h5>
					<span>Total OS Aberta hoje</span>
				</div>
			</div>
		</div>
		</a>
		<div class="col-md-3 widget widget1">
			<a href="index.php?pagina=pontua">
			<div class="r3_counter_box">
				<i class="pull-left fa fa-folder user1 icon-rounded"></i>
				<div class="stats">
					<h5><strong><?php echo $total_os_fechada ?></strong></h5>
					<span>Total Os fechada hoje</span>
				</div>
			</div>
		</div>
		</a>
		<div class="col-md-3 widget widget1">
			<div class="r3_counter_box">
				<i class="pull-left fa fa-money user2 icon-rounded"></i>
				<div class="stats">
					<h5><strong><?php echo $Total_os_encaminhada ?></strong></h5>
					<span>Total OS com Técnicos</span>
				</div>
			</div>
		</div>
		<div class="col-md-3 widget widget1">
			<div class="r3_counter_box">
				<i class="pull-left fa fa-pie-chart dollar1 icon-rounded"></i>
				<div class="stats">
					<h5><strong><?php echo $nps_formatado ?></strong></h5>
					<span>NPS Mês Atual</span>
				</div>
			</div>
		</div>
		<div class="col-md-3 widget">
			<div class="r3_counter_box">
				<i class="pull-left fa fa-users dollar2 icon-rounded"></i>
				<div class="stats">
					<h5><strong><?php echo $Total_indicacoes ?></strong></h5>
					<span>Total indicações Hoje</span>
				</div>
			</div>
		</div>
		<div class="clearfix"> </div>
	</div>
	
	<div class="row-one widgettable">
		<div class="col-md-8 content-top-2 card">
			<div class="agileinfo-cdr">
				<div class="card-header">
					<h3>Últimos 6 Meses</h3>
				</div>
				
				<div id="Linegraph" style="width: 98%; height: 350px">
				</div>
				
			</div>
		</div>
		<div class="col-md-4 stat">
			<div class="content-top-1">
				<div class="col-md-6 top-content">
					<h5>Ordem de serviço Finalizadas</h5>
					<label><?php echo $total_os_fechada ?> / <?php echo $Total_os_encaminhada ?></label>
				</div>
				<div class="col-md-6 top-content1">	   
					<div id="demo-pie-1" class="pie-title-center" data-percent="<?php echo $percentagem_os ?>"> <span class="pie-value"></span> </div>
				</div>
				<div class="clearfix"> </div>
			</div>
			<div class="content-top-1">
				<div class="col-md-6 top-content">
					<h5>Formulários Respondidos</h5>
					<label><?php echo $total_form_resp ?> / <?php echo $totalOS ?></label>
				</div>
				<div class="col-md-6 top-content1">	   
					<div id="demo-pie-2" class="pie-title-center" data-percent="<?php echo $percentagem_form_os ?>"> <span class="pie-value"></span> </div>
				</div>
				<div class="clearfix"> </div>
			</div>
			<div class="content-top-1">
				<div class="col-md-6 top-content">
					<h5>Total de OS em aberto</h5>
					<label><?php echo $Total_os_aberto ?></label>
				</div>
				<div class="col-md-6 top-content1">	   
					<div id="demo-pie-3" class="pie-title-center" data-percent="90"> <span class="pie-value"></span> </div>
				</div>
				<div class="clearfix"> </div>
			</div>

		</div>


		<div class="content-top-1">
			<div class="content-top-1">
				<div class="col-md-6 top-content">

				<div class="stats" id="piechart"></div>

			</div>

			
		</div>



	</div>


			<div class="content-top-1">
				<div class="col-md-6 top-content">

				<div  class="stats" id="piechart2"></div>

			</div>

		
		</div>


		<div class="clearfix"> </div>

	</div>
	
	<div class="row-one widgettable">
		<div class="col-md-12 content-top-2 card" style="padding:20px">
			<div class="card-header">
				<h3>OS Finalizadas <?php echo $ano_atual ?></h3>
			</div>			
				<canvas id="canvas" style="width: 100%; height:450px;"></canvas>
				
		</div>	
	</div>	
	

	
</div>




<!-- for index page weekly sales java script -->
<script src="js/SimpleChart.js"></script>
<script>
	var meses = "<?=$datas_apuracao_final?>";
	var dados = meses.split("*"); 

	var detratores = "<?=$detratores_final?>";
	var dados_detratores = detratores.split("*"); 

	

	var promotores = "<?=$promotores_final?>";
	var dados_promotores = promotores.split("*"); 

	var neutros = "<?=$neutros_final?>";
	var dados_neutros = neutros.split("*");

	var maior_valor_linha_detratores = Math.max(...dados_detratores);
	var maior_valor_linha_promotores = Math.max(...dados_promotores);
	var maior_valor = Math.max(maior_valor_linha_detratores, maior_valor_linha_promotores);
	maior_valor = parseFloat(maior_valor) + 10;

	var menor_valor_linha_detratores = Math.min(...dados_detratores);
	var menor_valor_linha_promotores = Math.min(...dados_promotores);
	var menor_valor = Math.min(menor_valor_linha_detratores, menor_valor_linha_promotores);

	var graphdata1 = {
		linecolor: "#008000",
		title: "Promotores",
		values: [
			{ X: dados[0], Y: dados_promotores[0] },
			{ X: dados[1], Y: dados_promotores[1] },
			{ X: dados[2], Y: dados_promotores[2] },
			{ X: dados[3], Y: dados_promotores[3] },
			{ X: dados[4], Y: dados_promotores[4] },
			{ X: dados[5], Y: dados_promotores[5] },
			/*{ X: dados[6], Y: dados_promotores[6] },
			{ X: dados[7], Y: dados_promotores[7] },
			{ X: dados[8], Y: dados_promotores[8] },
			{ X: dados[9], Y: dados_promotores[9] },
			{ X: dados[10], Y: dados_promotores[10] },
			{ X: dados[11], Y: dados_promotores[11] },*/
			]
	};
	var graphdata2 = {
		linecolor: "#FF0000",
		title: "Detratores",
		values: [
			{ X: dados[0], Y: dados_detratores[0] },
			{ X: dados[1], Y: dados_detratores[1] },
			{ X: dados[2], Y: dados_detratores[2] },
			{ X: dados[3], Y: dados_detratores[3] },
			{ X: dados[4], Y: dados_detratores[4] },
			{ X: dados[5], Y: dados_detratores[5] },
			/*{ X: dados[6], Y: dados_detratores[6] },
			{ X: dados[7], Y: dados_detratores[7] },
			{ X: dados[8], Y: dados_detratores[8] },
			{ X: dados[9], Y: dados_detratores[9] },
			{ X: dados[10], Y: dados_detratores[10] },
			{ X: dados[11], Y: dados_detratores[11] },*/
			]
	};
	/*var graphdata3 = {
		linecolor: "#FF99CC",
		title: "Wednesday",
		values: [
			{ X: dados[0], Y: dados_neutros[0] },
			{ X: dados[1], Y: dados_neutros[1] },
			{ X: dados[2], Y: dados_neutros[2] },
			{ X: dados[3], Y: dados_neutros[3] },
			{ X: dados[4], Y: dados_neutros[4] },
			{ X: dados[5], Y: dados_neutros[5] }
			]
	};
	var graphdata4 = {
		linecolor: "Random",
		title: "Thursday",
		values: [
			{ X: "6:00", Y: 300.00 },
			{ X: "7:00", Y: 410.98 },
			{ X: "8:00", Y: 310.00 },
			{ X: "9:00", Y: 314.00 },
			{ X: "10:00", Y: 310.25 },
			{ X: "4:00", Y: 310.00 },
			]
	};*/

	var dataRangeLinha = {
		linecolor: "transparent",
		title: "",
		values: [
			{ X: dados[0], Y: menor_valor },
			{ X: dados[1], Y: menor_valor },
			{ X: dados[2], Y: menor_valor },
			{ X: dados[3], Y: menor_valor },
			{ X: dados[4], Y: menor_valor },
			{ X: dados[5], Y: maior_valor },

			]
	};
	
	/*$(function () {
		$("#Bargraph").SimpleChart({
			ChartType: "Bar",
			toolwidth: "50",
			toolheight: "25",
			axiscolor: "#E6E6E6",
			textcolor: "#6E6E6E",
			showlegends: true,
			data: [graphdata3, graphdata2, graphdata1],
			legendsize: "140",
			legendposition: 'bottom',
			xaxislabel: 'Meses',
			title: 'Últimos 6 Meses',
			yaxislabel: 'Escala'
		});
		$("#sltchartype").on('change', function () {
			$("#Bargraph").SimpleChart('ChartType', $(this).val());
			$("#Bargraph").SimpleChart('reload', 'true');
		});*/

	$("#Linegraph").SimpleChart({
		ChartType: "Line",
		toolwidth: "50",
		toolheight: "25",
		axiscolor: "#E6E6E6",
		textcolor: "#6E6E6E",
		showlegends: true,
		data: [graphdata2, graphdata1, dataRangeLinha],
		legendsize: "35",
		legendposition: 'bottom',
		xaxislabel: 'Meses',
		title: 'Detrator e Promotor',
		yaxislabel: 'Escala em percentual'
	});

	

</script>
<!-- //for index page weekly sales java script -->

<!-- GRAFICO DE BARRAS -->
	<script type="text/javascript">
		$(document).ready(function() {

			var consultas = "<?=$total_meses?>";
			var dados = consultas.split("*");  

		   
				var color = Chart.helpers.color;
				var barChartData = {
					labels: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
					datasets: [{
						label: '',
						backgroundColor: color('blue').alpha(0.5).rgbString(),
						borderColor: 'blue',
						borderWidth: 1,
						data: [
						dados[0],
						dados[1],
						dados[2],
						dados[3],
						dados[4],
						dados[5],
						dados[6],
						dados[7],
						dados[8],
						dados[9],
						dados[10],
						dados[11]
						
						]
					}, 
					]

				};

			var ctx = document.getElementById("canvas").getContext("2d");
					window.myBar = new Chart(ctx, {
						type: 'bar',
						data: barChartData,
						options: {
							responsive: true,
							legend: {
								position: '',
							},
							title: {
								display: true,
								text: 'Consultas Efetuadas nos Mêses'
							}
						}
					});

	})
	
	</script>

	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            <?php
            foreach ($assuntosMaisAbertos as $assunto) {
                echo "['{$assunto['assunto']} - {$assunto['total_os']}', {$assunto['total_os']}],";
            }
            ?>
        ]);

        var options = {
            title: 'Gráfico 01'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
    }
</script>

    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Encaminhadas - <?php echo $Total_os_encaminhada ?>',  <?php echo $Total_os_encaminhada ?>],
          ['OS esse Mês - <?php echo $totalOS ?>',    <?php echo $totalOS ?>],
          ['OS Abertas - <?php echo $Total_os_aberto ?>',    <?php echo $Total_os_aberto ?>]
        ]);

        var options = {
          title: 'Gráfico 01'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart2'));

        chart.draw(data, options);
      }
    </script>


   <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable(<?php echo $jsData; ?>);

        var options = {
          chart: {
            title: 'OS Por Assunto - Mês Atual',
            subtitle: 'OS, funcionarios, mensal',
          },
          bars: 'horizontal' // Required for Material Bar Charts.
        };


        var chart = new google.charts.Bar(document.getElementById('barchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>

    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Year', 'Sales', 'Expenses', 'Profit'],
          ['2014', 1000, 400, 200],
          ['2015', 1170, 460, 250],
          ['2016', 660, 1120, 300],
          ['2017', 1030, 540, 350]
        ]);

        var options = {
          chart: {
            title: 'Company Performance',
            subtitle: 'Sales, Expenses, and Profit: 2014-2017',
          },
          bars: 'horizontal', // Required for Material Bar Charts.
          hAxis: {format: 'short'},
          height: 400,
          colors: ['#1b9e77', '#d95f02', '#7570b3']
        };

        var chart = new google.charts.Bar(document.getElementById('chart_div'));

        chart.draw(data, google.charts.Bar.convertOptions(options));

        var btns = document.getElementById('btn-group');

        btns.onclick = function (e) {

          if (e.target.tagName === 'BUTTON') {
            options.hAxis.format = e.target.id === 'none' ? '' : e.target.id;
            chart.draw(data, google.charts.Bar.convertOptions(options));
          }
        }
      }
    </script>

	