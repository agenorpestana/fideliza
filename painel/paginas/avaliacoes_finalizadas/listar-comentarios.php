<?php 
require_once("../../../conexao.php");
$tabela = 'comentarios';
@session_start();
$usuario_id = $_SESSION['id'];

$id_os = $_POST['id'];

$query_m = $pdo->query("SELECT * FROM $tabela where id_os = '$id_os' order by id desc");
$res_m = $query_m->fetchAll(PDO::FETCH_ASSOC);
for($i_m=0; $i_m < @count($res_m); $i_m++){
	foreach ($res_m[$i_m] as $key => $value){}
$id = $res_m[$i_m]['id'];
$comentario = $res_m[$i_m]['comentario'];
$status = $res_m[$i_m]['status_comentario'];
$data = $res_m[$i_m]['data'];
$dataF = implode('/', array_reverse(explode('-', $data)));
$id_usuario = $res_m[$i_m]['id_usuario'];

if($id_usuario == $usuario_id){
	$mostrar_excluir = '';
}else{
	$mostrar_excluir = 'ocultar';
}

$query = $pdo->query("SELECT * FROM usuarios where id = '$id_usuario'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nome = $res[0]['nome'];
$img_usuario = $res[0]['foto'];

echo <<<HTML
<div class="mt-3">
<small>
<span> <img style="border-radius: 100%;" class="rounded-circle z-depth-0" src="images/perfil/{$img_usuario}" width="25" height="25">  
<span class="text-muted"><b>{$nome}</b> </span>

<span class="text-muted" style="margin-left:10px">{$dataF}</span> 


	<li class="dropdown head-dpdn2" style="display: inline-block;">
		<a class="{$mostrar_excluir}" href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" title="Excluir Comentátrio"><big><i class="fa fa-trash-o text-danger "></i></big></a>

		<ul class="dropdown-menu" style="margin-left:-230px;">
		<li>
		<div class="notification_desc2">
		<p>Confirmar Exclusão? <a href="#" onclick="excluirPergunta('{$id}')"><span class="text-danger">Sim</span></a></p>
		</div>
		</li>										
		</ul>
		</li>

<br>
<span class="text-dark"><b>Comentátrio</b> - {$comentario} </span></small>
</div>

<!--<span > <a class="link-aula" href="#" onclick="modalResposta('{$id}', '{$comentario}')" title="Abrir Pergunta">Comentátrio - {$comentario}</a> </span></small>
</div>-->
<hr>
HTML;


}
?>		