<?php 
@session_start();
require_once("../conexao.php");
require_once("verificar.php");

$data_atual = date('Y-m-d');
$mes_atual = Date('m');
$ano_atual = Date('Y');
$data_mes = date('Y-m-01');
$data_mes_final = date('Y-m-t');
$data_ano = $ano_atual."-01-01";

//$data_mes_atual = date('Y-m-01');

// Converte a data atual para um objeto DateTime
$dataAtualObj = new DateTime($data_atual);
$dataMesAnteriorObj = $dataAtualObj->modify('-1 month');

// Obtém a string formatada do mês anterior
$mes_anterior = $dataMesAnteriorObj->format('Y-m-01');
$mes_anterior_final = $dataMesAnteriorObj->format('Y-m-t');



$query = $pdo->query('SELECT funcionario FROM funcionarios');
$nomes = $query->fetchAll(PDO::FETCH_COLUMN);

$query2 = $pdo->query('SELECT nome_assunto FROM assunto_pontua');
$assuntos = $query2->fetchAll(PDO::FETCH_COLUMN);

$pag_inicial = 'home';
if(@$_SESSION['nivel'] != 'Administrador'){
	require_once("verificar_permissoes.php");
}

if(@$_GET['pagina'] != ""){
	$pagina = @$_GET['pagina'];
}else{
	$pagina = $pag_inicial;
}

$id_usuario = @$_SESSION['id'];
$query = $pdo->query("SELECT * from usuarios where id = '$id_usuario'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
	$nome_usuario = $res[0]['nome'];
	$email_usuario = $res[0]['email'];
	$telefone_usuario = $res[0]['telefone'];
	$senha_usuario = $res[0]['senha'];
	$nivel_usuario = $res[0]['nivel'];
	$foto_usuario = $res[0]['foto'];
	$endereco_usuario = $res[0]['endereco'];
}


?>
<!DOCTYPE HTML>
<html>
<head>
	<title><?php echo $nome_sistema ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" href="../img/icone.png" type="image/x-icon">

	<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

	<!-- Bootstrap Core CSS -->
	<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />

	<!-- Custom CSS -->
	<link href="css/style.css" rel='stylesheet' type='text/css' />

	<!-- font-awesome icons CSS -->
	<link href="css/font-awesome.css" rel="stylesheet"> 
	<!-- //font-awesome icons CSS-->

	<!-- side nav css file -->
	<link href='css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css'/>
	<!-- //side nav css file -->

	<!-- js-->
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/modernizr.custom.js"></script>

	<!--webfonts-->
	<link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
	<!--//webfonts--> 

	<!-- chart -->
	<script src="js/Chart.js"></script>
	<!-- //chart -->

	<!-- Metis Menu -->
	<script src="js/metisMenu.min.js"></script>
	<script src="js/custom.js"></script>
	<link href="css/custom.css" rel="stylesheet">
	<!--//Metis Menu -->
	<style>
		#chartdiv {
			width: 100%;
			height: 295px;
		}
	</style>
	<!--pie-chart --><!-- index page sales reviews visitors pie chart -->
	<script src="js/pie-chart.js" type="text/javascript"></script>
	<script type="text/javascript">

		$(document).ready(function () {
			$('#demo-pie-1').pieChart({
				barColor: '#2dde98',
				trackColor: '#eee',
				lineCap: 'round',
				lineWidth: 8,
				onStep: function (from, to, percent) {
					$(this.element).find('.pie-value').text(Math.round(percent) + '%');
				}
			});

			$('#demo-pie-2').pieChart({
				barColor: '#8e43e7',
				trackColor: '#eee',
				lineCap: 'butt',
				lineWidth: 8,
				onStep: function (from, to, percent) {
					$(this.element).find('.pie-value').text(Math.round(percent) + '%');
				}
			});

			$('#demo-pie-3').pieChart({
				barColor: '#ffc168',
				trackColor: '#eee',
				lineCap: 'square',
				lineWidth: 8,
				onStep: function (from, to, percent) {
					$(this.element).find('.pie-value').text(Math.round(percent) + '%');
				}
			});


		});

	</script>
	<!-- //pie-chart --><!-- index page sales reviews visitors pie chart -->


<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/> <script src="DataTables/datatables.min.js"></script>

	
</head> 
<body class="cbp-spmenu-push">
	<div class="main-content">
		<div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
			<!--left-fixed -navigation-->
			<aside class="sidebar-left" style="overflow: scroll; height:100%; scrollbar-width: thin;">
				<nav class="navbar navbar-inverse">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".collapse" aria-expanded="false">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<h1><a class="navbar-brand" href="index.php"><span class="fa fa-globe"></span> ITLFibra<span class="dashboard_text"><?php echo $nome_sistema ?></span></a></h1>
					</div>
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="sidebar-menu">
							<li class="header">MENU NAVEGAÇÃO</li>
							<li class="treeview <?php echo $home ?>">
								<a href="index.php">
									<i class="fa fa-dashboard"></i> <span>Home</span>
								</a>
							</li>
							<li class="treeview <?php echo $menu_pessoas ?>">
								<a href="#">
									<i class="fa fa-users"></i>
									<span>Pessoas</span>
									<i class="fa fa-angle-left pull-right"></i>
								</a>
								<ul class="treeview-menu">
									<li class="<?php echo $usuarios ?>"><a href="index.php?pagina=usuarios"><i class="fa fa-angle-right"></i> Usuários</a></li>
									
								</ul>
							</li>

							<li class="treeview <?php echo $menu_supote ?>">
								<a href="#">
									<i class="fa fa-gears"></i>
									<span>Suporte</span>
									<i class="fa fa-angle-left pull-right"></i>
								</a>
								<ul class="treeview-menu">
									<li class="<?php echo $os ?>"><a href="index.php?pagina=os"><i class="fa fa-angle-right"></i> Ordem de Serviço</a></li>
									<li class="<?php echo $contatos ?>"><a href="index.php?pagina=contatos"><i class="fa fa-angle-right"></i> Contatos</a></li>
									<li class="<?php echo $funcionarios ?>"><a href="index.php?pagina=funcionarios"><i class="fa fa-angle-right"></i> Funcionarios</a></li>
									<!-- <li ><a href="api/script-salvaros.php" target="_blank"><i class="fa fa-angle-right"></i> Script Salvar OS</a></li> -->
									
								</ul>
							</li>

							<li class="treeview <?php echo $menu_fidelize ?>">
								<a href="#">
									<i class="fa fa-user-plus"></i>
									<span>Fideliza</span>
									<i class="fa fa-angle-left pull-right"></i>
								</a>
								<ul class="treeview-menu">
									<li class="<?php echo $indicacoes ?>"><a href="index.php?pagina=indicacoes"><i class="fa fa-comments-o"></i> Indicações</a></li>

									<li class="<?php echo $indicacoes_finalizadas ?>"><a href="index.php?pagina=indicacoes_finalizadas"><i class="fa fa-comments"></i> Indicações Finalizadas</a></li>

									<li class="<?php echo $avaliacoes ?>"><a href="index.php?pagina=avaliacoes"><i class="fa fa-thumbs-o-up"></i> Avaliações</a></li>

									<li class="<?php echo $avaliacoes_finalizadas ?>"><a href="index.php?pagina=avaliacoes_finalizadas"><i class="fa fa-thumbs-up"></i> Avaliação Finalizadas</a></li>

									<li ><a href="paginas/contatos/script-salvar.php" target="_blank"><i class="fa fa-angle-right"></i> Script Salvar Contatos</a></li>
									
									
								</ul>
							</li>

							<li class="treeview <?php echo $menu_pontuacao ?>">
								<a href="#">
									<i class="fa fa-product-hunt"></i>
									<span>Pontua</span>
									<i class="fa fa-angle-left pull-right"></i>
								</a>

								<ul class="treeview-menu">														
									<li class="<?php echo $pontua_tecnicos ?>"><a href="index.php?pagina=pontua_tecnicos"><i class="fa fa-user-plus"></i> Pontuação Técnicos</a></li>
								</ul>

								<ul class="treeview-menu">														
									<li class="<?php echo $tabela_pontos ?>"><a href="index.php?pagina=tabela_pontos"><i class="fa fa-user-plus"></i> Tabela de Pontos</a></li>
								</ul>

							</li>

							<li class="treeview <?php echo $menu_marketing ?>">
								<a href="#">
									<i class="fa fa-envelope-o"></i>
									<span>Campanhas / Recursos</span>
									<i class="fa fa-angle-left pull-right"></i>
								</a>
								<ul class="treeview-menu">

																
									<li class="<?php echo $marketing ?>"><a href="index.php?pagina=marketing"><i class="fa fa-whatsapp"></i> Marketing Whatsapp</a></li>
								</ul>
							</li>

							<li class="treeview <?php echo $menu_cadastros ?>">
								<a href="#">
									<i class="fa fa-plus"></i>
									<span>Cadastros</span>
									<i class="fa fa-angle-left pull-right"></i>
								</a>
								<ul class="treeview-menu">
									<li class="<?php echo $grupo_acessos ?>"><a href="index.php?pagina=grupo_acessos"><i class="fa fa-angle-right"></i> Grupos</a></li>

									<li class="<?php echo $acessos ?>"><a href="index.php?pagina=acessos"><i class="fa fa-angle-right"></i> Acessos</a></li>

									<!-- <li ><a href="paginas/funcionarios/salvar-funcionarios.php" target="_blank"><i class="fa fa-angle-right"></i> Salvar Funcionarios</a></li> -->
									
								</ul>
							</li>

							<li class="treeview <?php echo $menu_relatorios ?>">
								<a href="#">
									<i class="fa fa-file-pdf-o"></i>
									<span>Relatórios </span>
									<i class="fa fa-angle-left pull-right"></i>
								</a>
								<ul class="treeview-menu">
									<li><a href="#" data-toggle="modal" data-target="#RelVen"><i class="fa fa-angle-right"></i> Pontos por Funcionários</a></li>

									<!--<li><a href="#" data-toggle="modal" data-target="#RelCon"><i class="fa fa-angle-right"></i> Contas</a></li>                

									<li><a href="#" data-toggle="modal" data-target="#RelLucro"><i class="fa fa-angle-right"></i> Detalhamento de Lucro</a></li>

									<li><a href="#" data-toggle="modal" data-target="#RelComissoes"><i class="fa fa-angle-right"></i> Comissões</a></li>-->


								</ul>
							</li>

							<li class="treeview <?php echo $menu_link ?>">
								<a href="#" id="linkParaCopiar">
									<i class="fa fa-link"></i>
									<span>Link para indicar</span>
									<i class="fa fa-angle-left pull-right"></i>
								</a>
								
							</li>

							

						</ul>
					</div>
					<!-- /.navbar-collapse -->
				</nav>
			</aside>
		</div>
		<!--left-fixed -navigation-->
		
		<!-- header-starts -->
		<div class="sticky-header header-section ">
			<div class="header-left">
				<!--toggle button start-->
				<button id="showLeftPush" data-toggle="collapse" data-target=".collapse"><i class="fa fa-bars"></i></button>
				<!--toggle button end-->
				<div class="profile_details_left"><!--Menu de notificações -->
					<ul class="nofitications-dropdown">
						<li class="dropdown head-dpdn">
							<?php 
							$query = $pdo->query("SELECT * FROM formulario where status = 'Pendente'");
							$res = $query->fetchAll(PDO::FETCH_ASSOC);
							$total_avaliacoes_pendente = @count($res);

							if ($total_avaliacoes_pendente > 1) {
								$texto_avaliacao = 'Avaliações pendentes';
							}else{
								$texto_avaliacao = 'Avaliação pendente';
							}
							?>
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-comments" style="color:#FFF"></i><span class="badge"><?php echo $total_avaliacoes_pendente ?></span></a>
							<ul class="dropdown-menu">
								<li>
									<div class="notification_header">
										<h3>Você possiu <?php echo $total_avaliacoes_pendente ?> <?php echo $texto_avaliacao ?> </h3>
									</div>
								</li>

								<?php 
									$query = $pdo->query("SELECT * FROM formulario where status = 'Pendente' order by id asc limit 5");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									$total_avaliacoes_pendente = @count($res);
									if ($total_avaliacoes_pendente > 0) {
										for ($i=0; $i < $total_avaliacoes_pendente; $i++) { 
																		
								 ?>

								<li><a href="#">
									
									<div class="notification_desc">
										<span style="color:red"><?php echo $res[$i]['nome_cliente'] ?></span>
									</div>
									<div class="clearfix"></div>	
								</a></li>
								<?php } }?>
								<li>
									<div class="notification_bottom">
										<a href="index.php?pagina=avaliacoes">Ver todas as Avaliações Pendentes</a>
									</div> 
								</li>
							</ul>
						</li>
						



						<li class="dropdown head-dpdn">
							<?php 
							$query = $pdo->query("SELECT * from indicacoes where status = 'Aguardando'");
							$res = $query->fetchAll(PDO::FETCH_ASSOC);
							$total_indicacoes_pendente = @count($res);

							if ($total_indicacoes_pendente > 1) {
								$texto_indicacao = 'Indicações pendentes';
							}else{
								$texto_indicacao = 'Indicação pendente';
							}
							?>
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-thumbs-o-up" style="color:#FFF"></i><span class="badge"><?php echo $total_indicacoes_pendente ?></span></a>
							<ul class="dropdown-menu">
								<li>
									<div class="notification_header">
										<h3>Você possiu <?php echo $total_indicacoes_pendente ?> <?php echo $texto_indicacao ?> </h3>
									</div>
								</li>

								<?php 
									$query = $pdo->query("SELECT * FROM indicacoes where status = 'Aguardando' order by id asc limit 5");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									$total_indicacoes_pendente = @count($res);
									if ($total_indicacoes_pendente > 0) {
										for ($i=0; $i < $total_indicacoes_pendente; $i++) { 
																		
								 ?>

								<li><a href="#">
									
									<div class="notification_desc">
										<span style="color:red"><?php echo $res[$i]['nome_ind'] ?></span>
									</div>
									<div class="clearfix"></div>	
								</a></li>
								<?php } }?>
								<li>
									<div class="notification_bottom">
										<a href="index.php?pagina=indicacoes">Ver todas as Indicações Pendentes</a>
									</div> 
								</li>
							</ul>
						</li>



					</ul>
					<div class="clearfix"> </div>
				</div>
				
			</div>
			<div class="header-right">

				<div class="profile_details">		
					<ul>
						<li class="dropdown profile_details_drop">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								<div class="profile_img">	
									<span class="prfil-img"><img src="images/perfil/<?php echo $foto_usuario ?>" alt="" width="50px" height="50px"> </span> 
									<div class="user-name esc">
										<p><?php echo $nome_usuario ?></p>
										<span><?php echo $nivel_usuario ?></span>
									</div>
									<i class="fa fa-angle-down lnr"></i>
									<i class="fa fa-angle-up lnr"></i>
									<div class="clearfix"></div>	
								</div>	
							</a>
							<ul class="dropdown-menu drp-mnu">
								<li class="<?php echo $configuracoes ?>"> <a href="" data-toggle="modal" data-target="#modalConfig"><i class="fa fa-cog"></i> Configurações</a> </li> 
								<li> <a href="" data-toggle="modal" data-target="#modalPerfil"><i class="fa fa-user"></i> Perfil</a> </li> 								
								<li> <a href="logout.php"><i class="fa fa-sign-out"></i> Sair</a> </li>
							</ul>
						</li>
					</ul>
				</div>
				<div class="clearfix"> </div>				
			</div>
			<div class="clearfix"> </div>	
		</div>
		<!-- //header-ends -->




		<!-- main content start-->
		<div id="page-wrapper">
			<?php 
			require_once('paginas/'.$pagina.'.php');
			?>
		</div>





	</div>

	<!-- Modal Rel Vendas -->
	<div class="modal fade" id="RelVen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="exampleModalLabel">Relatório de Pontuação por Funcionário
						<small>(
							<a href="#" onclick="datas('1980-01-01', 'tudo-Os', 'Os')">
								<span style="color:#000" id="tudo-Os">Tudo</span>
							</a> / 
							<a href="#" onclick="datas('<?php echo $data_atual ?>', 'hoje-os', 'Os')">
								<span id="hoje-Os">Hoje</span>
							</a> /
							<a href="#" onclick="datas('<?php echo $data_mes ?>', 'mes-os', 'Os')">
								<span style="color:#000" id="mes-Os">Mês</span>
							</a> /
							<a href="#" onclick="datas('<?php echo $mes_anterior ?>', 'mesant-os', 'Os')">
								<span style="color:#000" id="mesant-Os">Mês - Ant.</span>
							</a> /
							<a href="#" onclick="datas('<?php echo $data_ano ?>', 'ano-os', 'Os')">
								<span style="color:#000" id="ano-Os">Ano</span>
							</a> 
						)</small>



					</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form method="post" action="rel/pontua_class.php" target="_blank">
					<div class="modal-body">

						<div class="row">
							<div class="col-md-4">						
								<div class="form-group"> 
									<label>Data Inicial</label> 
									<input type="date" class="form-control" name="dataInicial" id="dataInicialRel-Os" value="<?php echo date('Y-m-d') ?>" required> 
								</div>						
							</div>
							<div class="col-md-4">
								<div class="form-group"> 
									<label>Data Final</label> 
									<input type="date" class="form-control" name="dataFinal" id="dataFinalRel-Os" value="<?php echo date('Y-m-d') ?>" required> 
								</div>
							</div>
						<div class="row">
							<div class="col-md-8">						
								<div class="form-group"> 
									<label>Selecione um Técnico</label> 
									<select class="form-control sel13" name="selecao" style="width:100%;">
										<option value="">SELECIONE UM TÉCNICO</option>
										<?php foreach ($nomes as $nome) : ?>
											<option value="<?php echo $nome; ?>"><?php echo $nome; ?></option>
										<?php endforeach; ?>
									</select>
								</select> 
								</div>						
							</div>
						</div>
						</div>


						

					</div>

					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">Gerar Relatório</button>
					</div>
				</form>

			</div>
		</div>
	</div>

<!-- Modal Rel Contas -->
	<div class="modal fade" id="RelCon" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="exampleModalLabel">Relatório de Contas
						<small>(
							<a href="#" onclick="datas('1980-01-01', 'tudo-Con', 'Con')">
								<span style="color:#000" id="tudo-Con">Tudo</span>
							</a> / 
							<a href="#" onclick="datas('<?php echo $data_atual ?>', 'hoje-Con', 'Con')">
								<span id="hoje-Con">Hoje</span>
							</a> /
							<a href="#" onclick="datas('<?php echo $data_mes ?>', 'mes-Con', 'Con')">
								<span style="color:#000" id="mes-Con">Mês</span>
							</a> /
							<a href="#" onclick="datas('<?php echo $data_ano ?>', 'ano-Con', 'Con')">
								<span style="color:#000" id="ano-Con">Ano</span>
							</a> 
						)</small>



					</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form method="post" action="rel/contas_class.php" target="_blank">
					<div class="modal-body">

						<div class="row">
							<div class="col-md-4">						
								<div class="form-group"> 
									<label>Data Inicial</label> 
									<input type="date" class="form-control" name="dataInicial" id="dataInicialRel-Con" value="<?php echo date('Y-m-d') ?>" required> 
								</div>						
							</div>
							<div class="col-md-4">
								<div class="form-group"> 
									<label>Data Final</label> 
									<input type="date" class="form-control" name="dataFinal" id="dataFinalRel-Con" value="<?php echo date('Y-m-d') ?>" required> 
								</div>
							</div>

							<div class="col-md-4">						
								<div class="form-group"> 
									<label>Pago</label> 
									<select class="form-control sel13" name="pago" style="width:100%;">
										<option value="">Todas</option>
										<option value="Sim">Somente Pagas</option>
										<option value="Não">Pendentes</option>
										
									</select> 
								</div>						
							</div>

						</div>



							<div class="row">
							<div class="col-md-6">						
								<div class="form-group"> 
									<label>Pagar / Receber</label> 
									<select class="form-control sel13" name="tabela" style="width:100%;">
										<option value="pagar">Contas à Pagar</option>
										<option value="receber">Contas à Receber</option>
																				
									</select> 
								</div>						
							</div>
							<div class="col-md-6">
								<div class="form-group"> 
									<label>Consultar Por</label> 
									<select class="form-control sel13" name="busca" style="width:100%;">
										<option value="vencimento">Data de Vencimento</option>
										<option value="data_pgto">Data de Pagamento</option>
																				
									</select>
								</div>
							</div>

							

						</div>


						

					</div>

					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">Gerar Relatório</button>
					</div>
				</form>

			</div>
		</div>
	</div>








	<!-- Modal Rel Lucro -->
	<div class="modal fade" id="RelLucro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="exampleModalLabel">Relatório de Lucro
						<small>(
							<a href="#" onclick="datas('1980-01-01', 'tudo-Luc', 'Luc')">
								<span style="color:#000" id="tudo-Luc">Tudo</span>
							</a> / 
							<a href="#" onclick="datas('<?php echo $data_atual ?>', 'hoje-Luc', 'Luc')">
								<span id="hoje-Luc">Hoje</span>
							</a> /
							<a href="#" onclick="datas('<?php echo $data_mes ?>', 'mes-Luc', 'Luc')">
								<span style="color:#000" id="mes-Luc">Mês</span>
							</a> /
							<a href="#" onclick="datas('<?php echo $data_ano ?>', 'ano-Luc', 'Luc')">
								<span style="color:#000" id="ano-Luc">Ano</span>
							</a> 
						)</small>



					</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form method="post" action="rel/lucro_class.php" target="_blank">
					<div class="modal-body">

						<div class="row">
							<div class="col-md-4">						
								<div class="form-group"> 
									<label>Data Inicial</label> 
									<input type="date" class="form-control" name="dataInicial" id="dataInicialRel-Luc" value="<?php echo date('Y-m-d') ?>" required> 
								</div>						
							</div>
							<div class="col-md-4">
								<div class="form-group"> 
									<label>Data Final</label> 
									<input type="date" class="form-control" name="dataFinal" id="dataFinalRel-Luc" value="<?php echo date('Y-m-d') ?>" required> 
								</div>
							</div>

							
						</div>


						

					</div>

					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">Gerar Relatório</button>
					</div>
				</form>

			</div>
		</div>
	</div>







	<!-- Modal Rel Comissoes -->
	<div class="modal fade" id="RelComissoes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="exampleModalLabel">Relatório de Comissões
						<small>(
							<a href="#" onclick="datas('1980-01-01', 'tudo-Com', 'Com')">
								<span style="color:#000" id="tudo-Com">Tudo</span>
							</a> / 
							<a href="#" onclick="datas('<?php echo $data_atual ?>', 'hoje-Com', 'Com')">
								<span id="hoje-Com">Hoje</span>
							</a> /
							<a href="#" onclick="datas('<?php echo $data_mes ?>', 'mes-Com', 'Com')">
								<span style="color:#000" id="mes-Com">Mês</span>
							</a> /
							<a href="#" onclick="datas('<?php echo $data_ano ?>', 'ano-Com', 'Com')">
								<span style="color:#000" id="ano-Com">Ano</span>
							</a> 
						)</small>



					</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form method="post" action="rel/comissoes_class.php" target="_blank">
					<div class="modal-body">

						<div class="row">
							<div class="col-md-4">						
								<div class="form-group"> 
									<label>Data Inicial</label> 
									<input type="date" class="form-control" name="dataInicial" id="dataInicialRel-Com" value="<?php echo date('Y-m-d') ?>" required> 
								</div>						
							</div>
							<div class="col-md-4">
								<div class="form-group"> 
									<label>Data Final</label> 
									<input type="date" class="form-control" name="dataFinal" id="dataFinalRel-Com" value="<?php echo date('Y-m-d') ?>" required> 
								</div>
							</div>

							<div class="col-md-4">						
								<div class="form-group"> 
									<label>Pago</label> 
									<select class="form-control sel13" name="pago" style="width:100%;">
										<option value="">Todas</option>
										<option value="Sim">Somente Pagas</option>
										<option value="Não">Pendentes</option>
										
									</select> 
								</div>						
							</div>

						</div>



							<div class="row">
							<div class="col-md-6">						
								<div class="form-group"> 
									<label>Professor</label> 
									<select class="form-control sel82" name="sel_professor" id="sel_professor" style="width:100%;">
								<option value="">Selecione um Professor</option> 
									<?php 
									$query = $pdo->query("SELECT * FROM usuarios where nivel = 'Professor' or nivel = 'Administrador' order by nome asc");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									for($i=0; $i < @count($res); $i++){
										foreach ($res[$i] as $key => $value){}

											?>	
										<option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>

									<?php } ?>

								</select>
								</div>						
							</div>
							

							

						</div>


						

					</div>

					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">Gerar Relatório</button>
					</div>
				</form>

			</div>
		</div>
	</div>


	<!-- new added graphs chart js-->
	
	<script src="js/Chart.bundle.js"></script>
	<script src="js/utils.js"></script>
	
	
	
	<!-- Classie --><!-- for toggle left push menu script -->
	<script src="js/classie.js"></script>
	<script>
		var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
		showLeftPush = document.getElementById( 'showLeftPush' ),
		body = document.body;

		showLeftPush.onclick = function() {
			classie.toggle( this, 'active' );
			classie.toggle( body, 'cbp-spmenu-push-toright' );
			classie.toggle( menuLeft, 'cbp-spmenu-open' );
			disableOther( 'showLeftPush' );
		};


		function disableOther( button ) {
			if( button !== 'showLeftPush' ) {
				classie.toggle( showLeftPush, 'disabled' );
			}
		}
	</script>
	<!-- //Classie --><!-- //for toggle left push menu script -->

	<!--scrolling js-->
	<script src="js/jquery.nicescroll.js"></script>
	<script src="js/scripts.js"></script>
	<!--//scrolling js-->
	
	<!-- side nav js -->
	<script src='js/SidebarNav.min.js' type='text/javascript'></script>
	<script>
		$('.sidebar-menu').SidebarNav()
	</script>
	<!-- //side nav js -->
	
	
	
	<!-- Bootstrap Core JavaScript -->
	<script src="js/bootstrap.js"> </script>
	<!-- //Bootstrap Core JavaScript -->



	<!-- Mascaras JS -->
<script type="text/javascript" src="js/mascaras.js"></script>

<!-- Ajax para funcionar Mascaras JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script> 

	
</body>
</html>






<!-- Modal Perfil -->
<div class="modal fade" id="modalPerfil" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel">Alterar Dados</h4>
				<button id="btn-fechar-perfil" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form-perfil">
			<div class="modal-body">
				

					<div class="row">
						<div class="col-md-6">							
								<label>Nome</label>
								<input type="text" class="form-control" id="nome_perfil" name="nome" placeholder="Seu Nome" value="<?php echo $nome_usuario ?>" required>							
						</div>

						<div class="col-md-6">							
								<label>Email</label>
								<input type="email" class="form-control" id="email_perfil" name="email" placeholder="Seu Nome" value="<?php echo $email_usuario ?>" required>							
						</div>
					</div>


					<div class="row">
						<div class="col-md-4">							
								<label>Telefone</label>
								<input type="text" class="form-control" id="telefone_perfil" name="telefone" placeholder="Seu Telefone" value="<?php echo $telefone_usuario ?>" required>							
						</div>

						<div class="col-md-4">							
								<label>Senha</label>
								<input type="password" class="form-control" id="senha_perfil" name="senha" placeholder="Senha" value="<?php echo $senha_usuario ?>" required>							
						</div>

						<div class="col-md-4">							
								<label>Confirmar Senha</label>
								<input type="password" class="form-control" id="conf_senha_perfil" name="conf_senha" placeholder="Confirmar Senha" value="" required>							
						</div>

						
					</div>

					

					<div class="row">
						<div class="col-md-12">	
							<label>Endereço</label>
							<input type="text" class="form-control" id="endereco_perfil" name="endereco" placeholder="Seu Endereço" value="<?php echo $endereco_usuario ?>" >	
						</div>

						
					</div>
					


					<div class="row">
						<div class="col-md-8">							
								<label>Foto</label>
								<input type="file" class="form-control" id="foto_perfil" name="foto" value="<?php echo $foto_usuario ?>" onchange="carregarImgPerfil()">							
						</div>

						<div class="col-md-4">								
							<img src="images/perfil/<?php echo $foto_usuario ?>"  width="80px" id="target-usu">								
							
						</div>

						
					</div>


					<input type="hidden" name="id_usuario" value="<?php echo $id_usuario ?>">
				

				<br>
				<small><div id="msg-perfil" align="center"></div></small>
			</div>
			<div class="modal-footer">       
				<button type="submit" class="btn btn-primary">Salvar</button>
			</div>
			</form>
		</div>
	</div>
</div>








<!-- Modal Config -->
<div class="modal fade" id="modalConfig" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel">Editar Configurações</h4>
				<button id="btn-fechar-config" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form-config">
			<div class="modal-body">
				

					<div class="row">
						<div class="col-md-4">							
								<label>Nome do Projeto</label>
								<input type="text" class="form-control" id="nome_sistema" name="nome_sistema" placeholder="Delivery Interativo" value="<?php echo @$nome_sistema ?>" required>							
						</div>

						<div class="col-md-4">							
								<label>Email Sistema</label>
								<input type="email" class="form-control" id="email_sistema" name="email_sistema" placeholder="Email do Sistema" value="<?php echo @$email_sistema ?>" >							
						</div>


						<div class="col-md-4">							
								<label>Telefone Sistema</label>
								<input type="text" class="form-control" id="telefone_sistema" name="telefone_sistema" placeholder="Telefone do Sistema" value="<?php echo @$telefone_sistema ?>" required>							
						</div>

					</div>


					<div class="row">
						<div class="col-md-5">							
								<label>Endereço <small>(Rua Número Bairro e Cidade)</small></label>
								<input type="text" class="form-control" id="endereco_sistema" name="endereco_sistema" placeholder="Rua X..." value="<?php echo @$endereco_sistema ?>" >							
						</div>

						<div class="col-md-5">							
								<label>Instagram</label>
								<input type="text" class="form-control" id="instagram_sistema" name="instagram_sistema" placeholder="Link do Instagram" value="<?php echo @$instagram_sistema ?>">							
						</div>

						<div class="col-md-2">							
								<label>Marca d'água</label>
								<select class="form-control" name="marca_dagua">
									<option value="Sim" <?php if ($marca_dagua == 'Sim') { ?> selected <?php } ?> >Sim</option>
									<option value="Não" <?php if ($marca_dagua == 'Não') { ?> selected <?php } ?> >Não</option>
								</select>							
						</div>
					</div>

					<div class="row">
						<div class="col-md-4">							
								<label>Token Whatsapp</label>
								<input type="text" class="form-control" id="token_whatsapp" name="token_whatsapp" placeholder="Seu Token" value="<?php echo $token_whatsapp ?>">							
						</div>

						<div class="col-md-4">							
								<label>Instancia Whatsapp</label>
								<input type="text" class="form-control" id="instancia_whatsapp" name="instancia_whatsapp" placeholder="Instancia Whatsapp" value="<?php echo $instancia_whatsapp ?>">							
						</div>

						<div class="col-md-4">							
								<label>Token IXC</label>
								<input type="text" class="form-control" id="token_ixc" name="token_ixc" placeholder="Token IXC" value="<?php echo $token_ixc ?>">							
						</div>

						
					</div>


					

					

					<div class="row">
						<div class="col-md-4">						
								<div class="form-group"> 
									<label>Logo (*PNG)</label> 
									<input class="form-control" type="file" name="foto-logo" onChange="carregarImgLogo();" id="foto-logo">
								</div>						
							</div>
							<div class="col-md-2">
								<div id="divImg">
									<img src="../img/<?php echo $logo_sistema ?>"  width="80px" id="target-logo">									
								</div>
							</div>


							<div class="col-md-4">						
								<div class="form-group"> 
									<label>Ícone (*Png)</label> 
									<input class="form-control" type="file" name="foto-icone" onChange="carregarImgIcone();" id="foto-icone">
								</div>						
							</div>
							<div class="col-md-2">
								<div id="divImg">
									<img src="../img/<?php echo $icone_sistema ?>"  width="50px" id="target-icone">									
								</div>
							</div>

						
					</div>




					<div class="row">
							<div class="col-md-4">						
								<div class="form-group"> 
									<label>Logo Relatório (*Jpg)</label> 
									<input class="form-control" type="file" name="foto-logo-rel" onChange="carregarImgLogoRel();" id="foto-logo-rel">
								</div>						
							</div>
							<div class="col-md-2">
								<div id="divImg">
									<img src="../img/<?php echo @$logo_rel ?>"  width="80px" id="target-logo-rel">									
								</div>
							</div>

							<div class="col-md-4">
							<label>API Whatsapp</label>
								<select class="form-control" name="api_whatsapp" id="api_whatsapp">
									<option value="Sim" <?php if ($api_whatsapp == 'Sim') { ?> selected <?php } ?> >Sim</option>
									<option value="Não" <?php if ($api_whatsapp == 'Não') { ?> selected <?php } ?> >Não</option>
								</select>


						
					</div>					
				

				<br>
				<small><div id="msg-config" align="center"></div></small>
			</div>
			<div class="modal-footer">       
				<button type="submit" class="btn btn-primary">Salvar</button>
			</div>
			</form>
		</div>
	</div>
</div>






<script type="text/javascript">
	function carregarImgPerfil() {
    var target = document.getElementById('target-usu');
    var file = document.querySelector("#foto_perfil").files[0];
    
        var reader = new FileReader();

        reader.onloadend = function () {
            target.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);

        } else {
            target.src = "";
        }
    }
</script>






 <script type="text/javascript">
	$("#form-perfil").submit(function () {

		event.preventDefault();
		var formData = new FormData(this);

		$.ajax({
			url: "editar-perfil.php",
			type: 'POST',
			data: formData,

			success: function (mensagem) {
				$('#msg-perfil').text('');
				$('#msg-perfil').removeClass()
				if (mensagem.trim() == "Editado com Sucesso") {

					$('#btn-fechar-perfil').click();
					location.reload();				
						

				} else {

					$('#msg-perfil').addClass('text-danger')
					$('#msg-perfil').text(mensagem)
				}


			},

			cache: false,
			contentType: false,
			processData: false,

		});

	});
</script>






 <script type="text/javascript">
	$("#form-config").submit(function () {

		event.preventDefault();
		var formData = new FormData(this);

		$.ajax({
			url: "editar-config.php",
			type: 'POST',
			data: formData,

			success: function (mensagem) {
				$('#msg-config').text('');
				$('#msg-config').removeClass()
				if (mensagem.trim() == "Editado com Sucesso") {

					$('#btn-fechar-config').click();
					location.reload();				
						

				} else {

					$('#msg-config').addClass('text-danger')
					$('#msg-config').text(mensagem)
				}


			},

			cache: false,
			contentType: false,
			processData: false,

		});

	});
</script>




<script type="text/javascript">
	function carregarImgLogo() {
    var target = document.getElementById('target-logo');
    var file = document.querySelector("#foto-logo").files[0];
    
        var reader = new FileReader();

        reader.onloadend = function () {
            target.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);

        } else {
            target.src = "";
        }
    }
</script>





<script type="text/javascript">
	function carregarImgLogoRel() {
    var target = document.getElementById('target-logo-rel');
    var file = document.querySelector("#foto-logo-rel").files[0];
    
        var reader = new FileReader();

        reader.onloadend = function () {
            target.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);

        } else {
            target.src = "";
        }
    }
</script>





<script type="text/javascript">
	function carregarImgIcone() {
    var target = document.getElementById('target-icone');
    var file = document.querySelector("#foto-icone").files[0];
    
        var reader = new FileReader();

        reader.onloadend = function () {
            target.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);

        } else {
            target.src = "";
        }
    }
</script>

<script>
        // URL que você deseja copiar
        var urlParaCopiar = "https://itlfibra.com/fideliza/indique.php";

        // Seleciona o elemento de link
        var linkElement = document.getElementById("linkParaCopiar");

        // Adiciona um evento de clique ao link
        linkElement.addEventListener("click", function (event) {
            event.preventDefault(); // Impede o link de redirecionar

            // Cria um elemento de input temporário
            var tempInput = document.createElement("input");
            tempInput.value = urlParaCopiar; // Define o valor como a URL desejada

            // Adiciona o elemento de input à página
            document.body.appendChild(tempInput);

            // Seleciona o conteúdo do input
            tempInput.select();
            tempInput.setSelectionRange(0, 99999); // Para dispositivos móveis

            // Copia o conteúdo selecionado para a área de transferência
            document.execCommand("copy");

            // Remove o elemento de input temporário
            document.body.removeChild(tempInput);

            alert("Link copiado: " + tempInput.value);
        });
    </script>

    <script type="text/javascript">
		function datas(data, id, campo){		

			var data_atual = "<?=$data_atual?>";
			var separarData = data_atual.split("-");
			var separarDataAnt = data_atual.split("-");
			var mes = separarData[1];
			var ano = separarData[0];

			var separarId = id.split("-");

			if(separarId[0] == 'tudo'){
				data_atual = '2100-12-31';
			}

			if(separarId[0] == 'ano'){
				data_atual = ano + '-12-31';
			}

			if(separarId[0] == 'mes'){
				var data_atual = "<?=$data_mes_final?>";
			}

			if(separarId[0] == 'mesant'){ 
				var data_atual = "<?=$mes_anterior_final?>";
				
			}

			$('#dataInicialRel-'+campo).val(data);
			$('#dataFinalRel-'+campo).val(data_atual);

			document.getElementById('hoje-'+campo).style.color = "#000";
			document.getElementById('mes-'+campo).style.color = "#000";
			document.getElementById('mesant-'+campo).style.color = "#000";
			document.getElementById(id).style.color = "blue";	
			document.getElementById('tudo-'+campo).style.color = "#000";
			document.getElementById('ano-'+campo).style.color = "#000";
			document.getElementById(id).style.color = "blue";		
		}
	</script>
