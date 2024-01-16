<?php 

include('../conexao.php');

//CARREGAR DOMPDF
require_once '../dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;

header("Content-Transfer-Encoding: binary");
header("Content-Type: image/png");

//INICIALIZAR A CLASSE DO DOMPDF
$options = new Options();
$options->set('isRemoteEnabled', true);
$pdf = new DOMPDF($options);


if(@$_GET['url']){
	$id_mat = $_GET['url'];
}else{
	$id_mat = $_POST['id_mat'];
}


//ALIMENTAR OS DADOS NO RELATÓRIO
$html = utf8_encode(file_get_contents($url_sistema."sistema/rel/certificado.php?id_mat=".$id_mat));


//Definir o tamanho do papel e orientação da página
$pdf->set_paper('A4', 'landscape');

//CARREGAR O CONTEÚDO HTML
$pdf->load_html(utf8_decode($html));

//RENDERIZAR O PDF
$pdf->render();

//NOMEAR O PDF GERADO
$pdf->stream(
'certificado.pdf',
array("Attachment" => false)
);




?>