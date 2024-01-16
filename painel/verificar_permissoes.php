<?php 
require_once("../conexao.php");
@session_start();
$id_usuario = $_SESSION['id'];

$home = 'ocultar';
$configuracoes = 'ocultar';


//grupo pessoas
$usuarios = 'ocultar';

//grupo suporte
$os = 'ocultar';
$contatos = 'ocultar';
$funcionarios = 'ocultar';


//grupo fidelize
$indicacoes = 'ocultar';
$indicacoes_finalizadas = 'ocultar';
$avaliacoes = 'ocultar';
$avaliacoes_finalizadas = 'ocultar';


//grupo pontua
$pontua_tecnicos = 'ocultar';
$tabela_pontos = 'ocultar';

//grupo marketing
$marketing = 'ocultar';

//grupo cadastros
$grupo_acessos = 'ocultar';
$acessos = 'ocultar';

//grupo relatórios
$rel = 'ocultar';


$query = $pdo->query("SELECT * FROM usuarios_permissoes where usuario = '$id_usuario'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	for($i=0; $i < $total_reg; $i++){
		foreach ($res[$i] as $key => $value){}
		$permissao = $res[$i]['permissao'];

		$query2 = $pdo->query("SELECT * FROM acessos where id = '$permissao'");
		$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
		$nome = $res2[0]['nome'];
		$chave = $res2[0]['chave'];
		$id = $res2[0]['id'];

		if($chave == 'home'){
			$home = '';
		}

		if($chave == 'configuracoes'){
			$configuracoes = '';
		}

		if($chave == 'marketing'){
			$marketing = '';
		}

		if($chave == 'usuarios'){
			$usuarios = '';
		}

		if($chave == 'os'){
			$os = '';
		}

		if($chave == 'contatos'){
			$contatos = '';
		}

		if($chave == 'funcionarios'){
			$funcionarios = '';
		}

		if($chave == 'grupo_acessos'){
			$grupo_acessos = '';
		}

		if($chave == 'acessos'){
			$acessos = '';
		}

		if($chave == 'indicacoes'){
			$indicacoes = '';
		}

		if($chave == 'indicacoes_finalizadas'){
			$indicacoes_finalizadas = '';
		}

		if($chave == 'avaliacoes'){
			$avaliacoes = '';
		}

		if($chave == 'avaliacoes_finalizadas'){
			$avaliacoes_finalizadas = '';
		}

		if($chave == 'pontua_tecnicos'){
			$pontua_tecnicos = '';
		}

		if($chave == 'tabela_pontos'){
			$tabela_pontos = '';
		}

		if($chave == 'rel'){
			$rel = '';
		}

	}

}



$pag_inicial = '';
if($home != 'ocultar'){
	$pag_inicial = 'home';
}else{
	$query = $pdo->query("SELECT * FROM usuarios_permissoes where usuario = '$id_usuario'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);	
	if($total_reg > 0){
		for($i=0; $i<$total_reg; $i++){
			$permissao = $res[$i]['permissao'];		
			$query2 = $pdo->query("SELECT * FROM acessos where id = '$permissao'");
			$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
			if($res2[0]['pagina'] == 'Não'){
				continue;
			}else{
				$pag_inicial = $res2[0]['chave'];
				break;
			}	
				
		}
				

	}else{
		echo 'Você não tem permissão para acessar nenhuma página, acione o administrador!';
		exit();
	}
}



if($usuarios == 'ocultar'){
	$menu_pessoas = 'ocultar';
}else{
	$menu_pessoas = '';
}

if($marketing == 'ocultar'){
	$menu_marketing = 'ocultar';
}else{
	$menu_marketing = '';
}

if($rel == 'ocultar'){
	$menu_relatorios = 'ocultar';
}else{
	$menu_relatorios = '';
}

if($os == 'ocultar' and $contatos == 'ocultar' and $funcionarios == 'ocultar'){
	$menu_supote = 'ocultar';
}else{
	$menu_supote = '';
}

if($pontua_tecnicos == 'ocultar' and $tabela_pontos == 'ocultar'){
	$menu_pontuacao = 'ocultar';
}else{
	$menu_pontuacao = '';
}

if($indicacoes == 'ocultar' and $avaliacoes == 'ocultar' and $avaliacoes_finalizadas == 'ocultar' and $indicacoes_finalizadas == 'ocultar'){
	$menu_fidelize = 'ocultar';
}else{
	$menu_fidelize = '';
}

if($grupo_acessos == 'ocultar' and $acessos == 'ocultar'){
	$menu_cadastros = 'ocultar';
}else{
	$menu_cadastros = '';
}



?>