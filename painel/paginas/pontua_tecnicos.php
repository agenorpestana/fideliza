<?php 
$pag = 'pontua_tecnicos';
require_once("../conexao.php");

if(@$os == 'ocultar'){
    echo "<script>window.location='../index.php'</script>";
    exit();
}

$query = $pdo->query('SELECT funcionario FROM funcionarios');
$nomes = $query->fetchAll(PDO::FETCH_COLUMN);

$query2 = $pdo->query('SELECT nome_assunto FROM assunto_pontua');
$assuntos = $query2->fetchAll(PDO::FETCH_COLUMN);


//$pdo = null;
//var_dump($assuntos);

 ?>

<div class="main-page margin-mobile "style="margin-top: -5px; margin-top: 5">

    <div class="row">

    <div class="col-md-15" style="margin-bottom:5px; margin-top: 5">           

        <div style="float:left; margin-right:5px; margin-top: 5"><span><small><i title="Data da Venda Inicial" class="fa fa-calendar-o"></i></small></span></div>
        <div  style="float:left; margin-right:20px; margin-top: 5">
            <input type="date" class="form-control " name="data-inicial"  id="data-inicial-caixa" value="<?php echo date('Y-m-d') ?>" required>
        </div>

        <div style="float:left; margin-right:5px; margin-top: 5"><span><small><i title="Data da Venda Final" class="fa fa-calendar-o"></i></small></span></div>
        <div  style="float:left; margin-right:30px; margin-top: 5">
            <input type="date" class="form-control " name="data-final"  id="data-final-caixa" value="<?php echo date('Y-m-d') ?>" required>
        </div>

        
        <div style="float:left; margin-right: 5px; margin-bottom: 5px">    
       <select type="text" class="form-control" id="selecao" name="selecao">
            <option value="">SELECIONE UM TÉCNICO</option>
                <?php foreach ($nomes as $nome) : ?>
            <option value="<?php echo $nome; ?>"><?php echo $nome; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div style="float:left; margin-right:5px; margin-bottom: 5px">    
       <select type="text" class="form-control" id="selecao-assunto" name="selecao-assunto">
            <option value="">SELECIONE UM ASSUNTO</option>
                <?php foreach ($assuntos as $assunto) : ?>
            <option value="<?php echo $assunto; ?>"><?php echo $assunto; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>


<li class="dropdown head-dpdn2" style="display: inline-block;">     
        <a href="#" data-toggle="dropdown"  class="btn btn-danger dropdown-toggle" id="btn-deletar" style="display:none"><span class="fa fa-trash-o"></span> Deletar</a>

        <ul class="dropdown-menu">
        <li>
        <div class="notification_desc2">
        <p>Excluir Selecionados? <a href="#" onclick="deletarSel()"><span class="text-danger">Sim</span></a></p>
        </div>
        </li>                                       
        </ul>
</li>

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
                        <div class="col-md-6">                          
                                <label>Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" required>                         
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
                <h4 class="modal-title" id="exampleModalLabel"><span><b>Número OS: </b></span><span id="titulo_dados"></span></h4>
                <button id="btn-fechar-dados" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body">
                <div class="row" style="margin-top: 0px">
                    <div class="col-md-12" style="margin-bottom: 5px">
                        <span><b>Nome do Técnico: </b></span><span id="funcionario"></span>
                    </div>

      

                    <div class="col-md-6" style="margin-bottom: 5px">
                        <span><b>Data de Abertura: </b></span><span id="data_abertura"></span>
                    </div>

                    <div class="col-md-6" style="margin-bottom: 5px">
                        <span><b>Data de Fechamento: </b></span><span id="data_fechamento"></span>
                    </div>

                    <div class="col-md-6" style="margin-bottom: 5px">
                        <span><b>Assunto: </b></span><span id="assunto"></span>
                    </div>

                    <div class="col-md-6" style="margin-bottom: 5px">
                        <span><b>Cidade: </b></span><span id="cidade"></span>
                    </div>

                    <div class="col-md-12" style="margin-bottom: 5px">
                        <span><b>Nome do Cliente: </b></span><span id="nome_cliente"></span>
                    </div>

                    <div class="col-md-8" style="margin-bottom: 5px">
                        <span><b>WhatsApp Cliente: </b></span><span id="whatsapp_cli"></span>
                    </div>

                    <div class="col-md-12" style="margin-bottom: 5px">
                        <div align="center"><img src="" id="foto_dados" width="200px"></div>
                    </div>
                </div>
            </div>
                    
        </div>
    </div>
</div>



<script type="text/javascript">var pag = "<?=$pag?>"</script>
<script src="js/ajax.js"></script>

<script type="text/javascript">
    function valorData(dataInicio, dataFinal){
     $('#data-inicial-caixa').val(dataInicio);
     $('#data-final-caixa').val(dataFinal); 
     $('#selecao').val(nomePesquisa);
     $('#selecao-assunto').val(nomeAssunto);
    listar();
}
</script>

<script type="text/javascript">
    function listar(){      
    
    var dataInicial = $('#data-inicial-caixa').val();
    var dataFinal = $('#data-final-caixa').val();   
    var nomePesquisa = $('#selecao').val();
    var nomeAssunto = $('#selecao-assunto').val();
    $.ajax({

       url: 'paginas/' + pag + "/listar.php",
        method: 'POST',
        data: {dataInicial, dataFinal, nomePesquisa, nomeAssunto},
        dataType: "html",

        success:function(result){
            $("#listar").html(result);
        }
    });
}
</script>

<script type="text/javascript">
    $('#data-inicial-caixa').change(function(){
            $('#tipo-busca').val('');
            listar();
        });

        $('#data-final-caixa').change(function(){                       
            $('#tipo-busca').val('');
            listar();
        }); 

        $('#selecao').change(function(){                       
            $('#tipo-busca').val('');
            listar();
        }); 

        $('#selecao-assunto').change(function(){                       
            $('#tipo-busca').val('');
            listar();
        }); 
</script>


