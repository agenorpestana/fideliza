<?php 
require_once('../conexao.php');
require_once('verificar.php');

$pag = 'avaliacoes_finalizadas';

if(@$avaliacoes == 'ocultar'){
	echo "<script>window.location='../index.php'</script>";
    exit();
}

 ?>

<div class="main-page margin-mobile">

<!-- <a onclick="inserir()" type="button" class="btn btn-primary"><span class="fa fa-plus"></span> Nova  indicação</a>-->



<!--<li class="dropdown head-dpdn2" style="display: inline-block;">		
		<a href="#" data-toggle="dropdown"  class="btn btn-danger dropdown-toggle" id="btn-deletar" style="display:none"><span class="fa fa-trash-o"></span> Deletar</a>

		<ul class="dropdown-menu">
		<li>
		<div class="notification_desc2">
		<p>Excluir Selecionados? <a href="#" onclick="deletarSel()"><span class="text-danger">Sim</span></a></p>
		</div>
		</li>										
		</ul>
</li>-->

<div class="bs-example widget-shadow" style="padding:15px" id="listar">

</div>

</div>

<input type="hidden" id="ids">

<!-- Modal Perfil -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_inserir"></span></h4>
				<button id="btn-fechar" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form">
			<div class="modal-body">
				

					<div class="row">
						<div class="col-md-12">							
								<label>Observações</label>
								<input type="text" class="form-control" id="obs_ind" name="obs_ind" placeholder="Observações">							
						</div>

						<div class="col-md-6" style="margin-top: 22px">							
								<button type="submit" class="btn btn-primary">Salvar</button>					
						</div>

						
					</div>

			
					<input type="hidden" class="form-control" id="id" name="id">					

				<br>
				<small><div id="mensagem" align="center"></div></small>
			</div>
			
			</form>
		</div>
	</div>
</div>



<!-- Modal Dados -->
<div class="modal fade" id="modalDados" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel"><span><b>Id Os: </b></span><span id="titulo_dados"></span></h4>
                <button id="btn-fechar-dados" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body">
                <div class="row" style="margin-top: 0px">

                	<div class="col-md-6" style="margin-bottom: 5px">
                        <span><b>Cliente: </b></span><span id="nome_cliente"></span>
                    </div>
                        
                    <div class="col-md-6" style="margin-bottom: 5px">
                        <span><b>Telefone: </b></span><span id="telefone_cliente"></span>
                    </div>

                    <div class="col-md-6" style="margin-bottom: 5px">
                        <span><b>Atendimento Nota: </b></span><span id="perg1"></span>
                    </div>
                        
                    <div class="col-md-6" style="margin-bottom: 5px">
                        <span><b>Instalação Nota: </b></span><span id="perg2"></span>
                    </div>

                    <div class="col-md-6" style="margin-bottom: 5px">
                        <span><b>Recomendar Serviço Nota: </b></span><span id="perg3"></span>
                    </div>
                   	                  
                    <div class="col-md-12" style="margin-bottom: 5px">
                        <span><b>Satisfação do Cliente: </b></span><span id="perg4"></span>
                    </div>

                    <div class="col-md-6" style="margin-bottom: 5px">
                        <span><b>Id Cliente: </b></span><span id="id_cliente"></span>
                    </div>

                    <div class="col-md-6" style="margin-bottom: 5px">
                        <span><b>Data da Resposta: </b></span><span id="data_resposta"></span>
                    </div>
   

                </div>
            </div>
                    
        </div>
    </div>
</div>
<div class="col-md-6" style="margin-bottom: 5px">
                        
                    </div>


<!-- Modal Aulas -->
<div class="modal fade" id="modalAulas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" style="overflow: scroll; height:100%; scrollbar-width: thin;">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><span id="nome_do_cliente"> </span> - <span id="aulas_aula"> </span>  </h4>
				<span id="link-drive" class="text-muted"><small><small> (Resumo de atendimento)</small></small></span>


				<button id="btn-fechar-aula" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
				
				<div class="modal-body">
					<div class="row">
						<!-- <div class="col-md-5" style="margin-bottom: 20px">
							<div id="listar-aulas">

							</div>
						</div> -->

						<div class="col-md-12" style="margin-top: -10px">
							<div id="perguntas">
								<a class="text-dark" href="" data-toggle="modal" data-target="#modalPergunta"><i class="fa fa-commenting"></i> <span class="text-muted">Adicionar Comentário</span></a>
								<hr>
                      
							</div>

							<div id="listar-comentarios">

							</div>
						</div>
					</div>
					

					</div>


				</div>	

						

		</div>
	</div>
</div>





<!-- Modal Aula -->
<div class="modal fade" id="modalAula" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span class="neutra ocultar-mobile" id="nome_da_sessao"> </span>  <span class="neutra ocultar-mobile" id="numero_da_aula"> </span>  <span class="neutra" id="nome_da_aula"></span>	 </h4>


				<button onclick="location.reload()" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span class="neutra" aria-hidden="true">&times;</span>
				</button>
			</div>
			
			<div class="modal-body">

				<iframe class="video-mobile" width="100%" height="450" src="" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen id="target-video-aula"></iframe>

				<span id="texto-finalizado"></span>

				<div align="center">

				<a href="#" onclick="anterior()" class="cinza_escuro" id="btn-anterior">	
				<span style="margin-right:10px"><i class="fa fa-arrow-left" style="font-size:20px;"></i> Anterior
				</span>
				</a>

				<a href="#" onclick="proximo()" class="cinza_escuro" id="btn-proximo">
				<span style="margin-right:10px">Próximo<i class="fa fa-arrow-right" style="font-size:20px;margin-left:3px"></i>
				</span>
				</a>

				</div>

				<input type="hidden" id="id_da_aula">
				
			</div>
			
		</div>
	</div>
</div>





<!-- Modal Pergunta -->
<div class="modal fade" id="modalPergunta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel">Novo Comentário - <span class="neutra ocultar-mobile" id="nome_do_cleinte_comentario"> </span>  </h4>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px" id="btn-fechar-pergunta">
					<span class="neutra" aria-hidden="true">&times;</span>
				</button>
			</div>
			
			<div class="modal-body">
				<form method="post" id="form-perguntas">
				<div class="modal-body">

					<div class="row">

						<div class="col-md-12">						
							<div class="form-group"> 
								<label>Comentário <small>(Max 255 Caracteres)</small></label> 
								<input type="text" class="form-control" name="comentario" id="comentario" required maxlength="255"> 
							</div>						
						</div>

						<div class="col-md-6">						
							<div class="form-group"> 
								<label>Status <small>(Finalizado / Aguardando</small></label> 
								<!--<input type="number" class="form-control" name="num_aula" id="num_aula">-->
								<select name="status" class="form-control" id="status">
									<option value="Finalizado">Finalizado</option>
									<option value="Aguardando">Aguardando</option> 
								</select> 
							</div>						
						</div>

						<div class="col-md-6" align="right" style="margin-top: 20px">						
							<button type="submit" class="btn btn-primary">Salvar</button>					
						</div>

						


					</div>
									

					<br>
					<input type="hidden" name="id_curso" id="id_os_comentario"> 
					<small><div id="mensagem-pergunta" align="center" class="mt-3"></div></small>


					<hr>
				<div align="center" class="text-muted">
					<small>ITLFibra <!--<a href="http://api.whatsapp.com/send?1=pt_BR&phone=<?php echo $tel_whatsapp ?>" title="Chamar no Whatsapp" target="_blank"><i class="fa fa-whatsapp"></i><?php echo $tel_sistema ?></a>--></small>
				</div>
					

				</div>

				


			</form>
				
				
			</div>
			
		</div>
	</div>
</div>






<!-- Modal Resposta -->
<div class="modal fade" id="modalResposta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="pergunta_resposta"></span> <span class="neutra ocultar-mobile"> </span>  </h4>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px" id="btn-fechar-resposta">
					<span class="neutra" aria-hidden="true">&times;</span>
				</button>
			</div>
			
			<div class="modal-body">
				<form method="post" id="form-respostas">
				
					<div id="listar-respostas">fsdfdsfsdfsd</div>
					
					<hr>

						<div class="col-md-12">						
							<div class="form-group"> 
								<label>Resposta<small>(Max 500 Caracteres)</small></label> 
								<textarea maxlength="500" class="form-control" name="resposta" id="resposta"></textarea> 
							</div>						
						</div>

						

						<div class="col-md-12" align="right" style="margin-top: 15px">						
							<button type="submit" class="btn btn-primary">Salvar</button>					
						</div>

							

					<br>
					<input type="hidden" name="id_comentario" id="id_comentario_resposta"> 
					<input type="hidden" name="id_curso" id="id_os_resposta"> 
					<small><div id="mensagem-pergunta" align="center" class="mt-3"></div></small>


					<hr>
				<div  class="modal-footer">
					
				</div>
					

				


			</form>
				
				
			</div>
			
		</div>
	</div>
</div>






<!-- Modal Avaliar -->
<div class="modal fade" id="modalAvaliar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel">Avaliar Curso - <span id="nome_curso_avaliar"></span> <span class="neutra ocultar-mobile"> </span>  </h4>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px" id="btn-fechar-resposta">
					<span class="neutra" aria-hidden="true">&times;</span>
				</button>
			</div>
			
			<div class="modal-body">
				<form method="post" id="form-avaliar">

					<div class="row">
					<div class="col-md-3">						
							<div class="form-group"> 
								<label>Nota<small>(de 1 a 5)</small></label> 
								<select name="nota" class="form-control">
									<option value="5">5</option>
									<option value="4">4</option>
									<option value="3">3</option>
									<option value="2">2</option>
									<option value="1">1</option>
								</select> 
							</div>						
						</div>
				
				
						<div class="col-md-12">						
							<div class="form-group"> 
								<label>Mensagem da Avaliação<small>(Max 500 Caracteres)</small></label> 
								<textarea maxlength="500" class="form-control" name="avaliacao" id="avaliacao"></textarea> 
							</div>						
						</div>

					</div>

						

						<div class="col-md-12" align="right" style="margin-top: 15px">						
							<button type="submit" class="btn btn-primary">Salvar</button>					
						</div>

							

					<br>
					
					<input type="hidden" name="id_curso" id="id_curso_avaliar"> 

					<small><div id="mensagem-avaliar" align="center" class="mt-3"></div></small>


					<hr>
				<div  class="modal-footer">
					
				</div>
					

				


			</form>
				
				
			</div>
			
		</div>
	</div>
</div>






<!-- Modal Questionario -->
<div class="modal fade" id="modalQuest" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="curso_quest"></span> <span class="neutra ocultar-mobile"> </span>  </h4>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px" id="btn-fechar-quest">
					<span class="neutra" aria-hidden="true">&times;</span>
				</button>
			</div>
			
			<div class="modal-body">
				<form method="post" id="form-quest">

					<div id="quest">

					</div>
					
					
					<input type="hidden" name="id_curso" id="id_os_comentario"> 
					<input type="hidden" name="id_mat" id="id_mat_quest"> 
					<small><div id="mensagem-quest" align="center" class="mt-3"></div></small>


					<hr>
				<div  class="modal-footer">
					<button type="submit" class="btn btn-primary">Finalizar</button>
				</div>
					

				


			</form>
				
				
			</div>
			
		</div>
	</div>
</div>

<script type="text/javascript">var pag = "<?=$pag?>"</script>
<script src="js/ajax.js"></script>

<script type="text/javascript">

	function abrirAulas(id, nome, status, usuario, id_curso, link){

        if(link == ""){
            document.getElementById('link-drive').style.display = 'none';
        }else{
            document.getElementById('link-drive').style.display = 'block';
        }

        $('#nome_do_cliente').text(nome);
        $('#aulas_aula').text(status);       
        $('#modalAulas').modal('show');
        $('#id_da_matricula').val(id);
        $('#id_do_curso').val(id_curso);
        //$('#link_drive_curso').attr('href', link);
        //listarAulas(id_curso, id);
        //listarPerguntas(id);      
        

        $('#nome_do_cleinte_comentario').text(nome);
        $('#id_os_comentario').val(id);
        //$('#id_curso_resposta').val(id_curso);
        listarPerguntas(id);
        listar();
        


    }
	
$("#form-perguntas").submit(function () {
	var id_curso = $('#id_os_comentario').val();
	event.preventDefault();
	var formData = new FormData(this);

	$.ajax({
		url: 'paginas/' + pag + "/inserir-pergunta.php",
		type: 'POST',
		data: formData,

		success: function (mensagem) {
            $('#mensagem-pergunta').text('');
            $('#mensagem-pergunta').removeClass()
            if (mensagem.trim() == "Salvo com Sucesso") { 
            		 $('#comentario').val('')
            		  $('#status').val('')                   
                    $('#btn-fechar-pergunta').click();
                    listarPerguntas(id_curso);
                    listar();
                    
                } else {
                	$('#mensagem-pergunta').addClass('text-danger')
                    $('#mensagem-pergunta').text(mensagem)
                }

            },

            cache: false,
            contentType: false,
            processData: false,
            
        });

});
</script>



<script type="text/javascript">	 
	function listarPerguntas(id){
    $.ajax({
        url: 'paginas/' + pag + "/listar-comentarios.php",
        method: 'POST',
        data: {id},
        dataType: "html",

        success:function(result){
            $("#listar-comentarios").html(result);

           
        }
    });
}

</script>


<script type="text/javascript">
function excluirPergunta(id){
	var id_curso = $('#id_os_comentario').val();
    $.ajax({
        url: 'paginas/' + pag + "/excluir-comentario.php",
        method: 'POST',
        data: {id},
        dataType: "text",

        success: function (mensagem) {            
            if (mensagem.trim() == "Excluído com Sucesso") {                
                listarPerguntas(id_curso);                
            } else {
                    $('#mensagem-excluir').addClass('text-danger')
                    $('#mensagem-excluir').text(mensagem)
                }

        },      

    });
}

</script>

<script type="text/javascript">
    function modalResposta(id_pergunta, pergunta){
        $('#pergunta_resposta').text(pergunta);
        $('#id_pergunta_resposta').val(id_pergunta);        
        $('#modalResposta').modal('show');
        listarRespostas(id_pergunta);
    }
</script>


<script type="text/javascript">
    
$("#form-respostas").submit(function () {
    var id_pergunta = $('#id_pergunta_resposta').val();
    var id_curso = $('#id_os_comentario').val();
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: 'paginas/' + pag + "/inserir-resposta.php",
        type: 'POST',
        data: formData,

        success: function (mensagem) {
            $('#mensagem-resposta').text('');
            $('#mensagem-resposta').removeClass()
            if (mensagem.trim() == "Salvo com Sucesso") { 
                     $('#resposta').val('')                                  
                     //$('#btn-fechar-resposta').click();
                     listarRespostas(id_pergunta)
                     listarPerguntas(id_curso)
                    
                } else {
                    $('#mensagem-resposta').addClass('text-danger')
                    $('#mensagem-resposta').text(mensagem)
                }

            },

            cache: false,
            contentType: false,
            processData: false,
            
        });

});
</script>




<script type="text/javascript">  
    function listarRespostas(id){
    $.ajax({
        url: 'paginas/' + pag + "/listar-respostas.php",
        method: 'POST',
        data: {id},
        dataType: "html",

        success:function(result){
            $("#listar-respostas").html(result);
           
        }
    });
}

</script>




<script type="text/javascript">
    

function excluirResposta(id){
    var id_pergunta = $('#id_pergunta_resposta').val();
    $.ajax({
        url: 'paginas/' + pag + "/excluir-resposta.php",
        method: 'POST',
        data: {id},
        dataType: "text",

        success: function (mensagem) {            
            if (mensagem.trim() == "Excluído com Sucesso") {                
                listarRespostas(id_pergunta);                
            } else {
                    $('#mensagem-resposta').addClass('text-danger')
                    $('#mensagem-resposta').text(mensagem)
                }

        },      

    });
}

</script>


