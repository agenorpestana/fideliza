<?php
include_once("conexao.php");

echo "<meta HTTP-EQUIV='refresh' CONTENT='60;URL=dashboard.php'>";


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

?>
<!DOCTYPE HTML>
<html lang="pt-BR">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
  <title>Gráficos</title>
  
</head>
<body>
    <!-- <div id="piechart" style="width: 700px; height: 200px;"></div>
    <div id="piechart2" style="width: 700px; height: 200px;"></div>
    <div id="barchart_material" style="width: 600px; height: 250px;"></div> -->

     <div style="display: inline-block; margin-right: -70px; margin-left: -30px;">
        <div id="piechart" style="width: 480px; height: 200px;"></div>
    </div>

    <div style="display: inline-block; margin-right: 15px;">
        <div id="piechart2" style="width: 480px; height: 200px;"></div>
    </div>

    <div style="display: block; clear: both;">
        <div id="barchart_material" style="width: 800px; height: 200px;"></div>
    </div>
    <div id="chart_div"></div>
    <br/>
    <div id="btn-group">
      <button class="button button-blue" id="none">Quantidade</button>
      <button class="button button-blue" id="scientific">Notação Científica</button>
      <button class="button button-blue" id="decimal">Decimal</button>
      <button class="button button-blue" id="short">Abreviado ex:(1K, 2K e etc)</button>
    </div>
</body>
</html>

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