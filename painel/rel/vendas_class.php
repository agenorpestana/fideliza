<?php 

require_once("../../conexao.php");


$dataInicial = $_POST['dataInicial'];
$dataFinal = $_POST['dataFinal'];
$selecao = urlencode($_POST['selecao']);


//ALIMENTAR OS DADOS NO RELATÓRIO
$html = utf8_encode(file_get_contents($url_sistema."painel/rel/vendas.php?selecao=$selecao&dataInicial=$dataInicial&dataFinal=$dataFinal"));

//CARREGAR DOMPDF
require_once('../dompdf/autoload.inc.php');
use Dompdf\Dompdf;
use Dompdf\Options;

header("Content-Transfer-Encoding: binary");
header("Content-Type: image/png");


//INICIALIZAR A CLASSE DO DOMPDF
$options = new Options();
$options->set('isRemoteEnabled', true);
$pdf = new DOMPDF($options);

//Definir o tamanho do papel e orientação da página
$pdf->set_paper('A4', 'portrait');

//CARREGAR O CONTEÚDO HTML
$pdf->load_html(utf8_decode($html));

//RENDERIZAR O PDF
$pdf->render();

//NOMEAR O PDF GERADO
$pdf->stream(
'pontuacao.pdf',
array("Attachment" => false)
);




?>