<?php 

$id_mat = $_GET['id_mat'];
include('../conexao.php');




$query = $pdo->query("SELECT * FROM matriculas where id = '$id_mat' and status = 'Finalizado' ORDER BY id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if(@count($res) == 0){
    echo 'Você não possui essa matricula finalizada!';
    exit();
}

$data = $res[0]['data_conclusao'];
$curso = $res[0]['id_curso'];
$aluno = $res[0]['aluno'];

$query = $pdo->query("SELECT * FROM usuarios where id = '$aluno' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nome_aluno = $res[0]['nome'];
$cpf = $res[0]['cpf'];

$query = $pdo->query("SELECT * FROM cursos where id = '$curso' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nome_curso = $res[0]['nome'];
$carga = $res[0]['carga'];
$tecnologias = $res[0]['tecnologias'];


$data2 = implode('/', array_reverse(explode('-', $data)));

if($tecnologias == ""){
    $classe_tec = 'ocultar';
}else{
    $classe_tec = '';
}

if($cpf == ""){
    $classe_cpf = 'ocultar';
}else{
    $classe_cpf = '';
}

?>



<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<style>

 @page {
            margin: 0px;
            
        }


.imagem {
width: 100%;
}	

.nome-curso {
position: absolute;
margin-top: 270px;
text-align:center;
color:#913610;
font-size:29px;
width:100%;
margin-left: 20px;
}

.nome-aluno {
position: absolute;
margin-top: 330px;
text-align:center;
color:#000;
font-size:31px;
width:100%;

}


.descricao {
position: absolute;
margin-top: 415px;
text-align:center;
color:#473e3a;
font-size:19px;
width:100%;

}


.carga {
position: absolute;
margin-top: 500px;
text-align:center;
color:#473e3a;
font-size:25px;
width:100%;

}


.cpf {
position: absolute;
margin-top: 534px;
text-align:center;
color:#473e3a;
font-size:15px;
width:100%;

}



.tecnologias {
position: absolute;
margin-top: 470px;
text-align:center;
color:#737373;
font-size:14px;
width:100%;

}

.ocultar{
    display:none;
}

.id{
   position: absolute;
margin-top: 50px;
margin-left: 965px;
text-align:center;
color:#fff;
font-size:16px;
width:100%; 
opacity:0.1;
}


.conteudo {
position: absolute;
margin-top: 210px;
text-align:left;
color:#454545;
font-size:13px;
width:100%;
margin-left: 230px;
}

.aluno_verso {
position: absolute;
margin-top: 600px;
text-align:center;
color:#454545;
font-size:14px;
width:100%;
margin-left: 20px;
}

.imagem2{
    width:100%;
    position: absolute;
}


</style>

<!DOCTYPE html>
<html>
<head>
	 <title>Certificado - <?php echo $nome_sistema ?></title>
	
</head>



<body>
<div class="id"> <?php echo $id_mat; ?></div>
<div class="nome-curso"> CURSO DE <?php echo mb_strtoupper($nome_curso); ?></div>
<div class="nome-aluno"> <b><?php echo mb_strtoupper($nome_aluno); ?></b></div>
<div class="descricao"> PARABÉNS PELA CONCLUSÃO COM EXCELÊNCIA DO TREINAMENTO <br><span class="text-warning"><?php echo mb_strtoupper($nome_curso); ?></span> MINISTRADO PELO PORTAL HUGO CURSOS!</div>
<div class="tecnologias <?php echo $classe_tec ?>"> <b>Técnologias Utilizadas (<?php echo $tecnologias; ?>)</b></div>
<div class="carga"> <?php echo $carga; ?> Horas - Emitido em <?php echo $data2; ?></div>
<div class="cpf <?php echo $classe_cpf ?>"> Documento do Aluno : <?php echo $cpf; ?> </div>

<img class="imagem" src="<?php echo $url_sistema ?>sistema/img/certificado-fundo.jpg">

<?php if($verso == "Sim"){ ?>

<div class="verso">
<img class="imagem2" src="<?php echo $url_sistema ?>sistema/img/certificado-verso.jpg">
<div class="conteudo">

 - <?php echo mb_strtoupper($tecnologias); ?>
     
 </div>
<div class="aluno_verso"> ______________________________________________________________<br><?php echo mb_strtoupper($nome_aluno); ?></div>
</div>

<?php } ?>

</body>

</html>
