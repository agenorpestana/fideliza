<?php 
$pag = 'contatos';

if(@$contatos == 'ocultar'){
    echo "<script>window.location='../index.php'</script>";
    exit();
}

$data_hoje = date('Y-m-d');
$data_ontem = date('Y-m-d', strtotime("-1 days",strtotime($data_hoje)));

$mes_atual = Date('m');
$ano_atual = Date('Y');
$data_mes = $ano_atual."-".$mes_atual."-01";
 ?>



 <div class="bs-example widget-shadow" style="padding:15px; margin-top:-10px" >

    <div class="row">

    <div class="col-md-12" style="margin-bottom:15px;">           

        <div style="float:left; margin-right:10px"><span><small><i title="Data da Venda Inicial" class="fa fa-calendar-o"></i></small></span></div>
        <div  style="float:left; margin-right:20px">
            <input type="date" class="form-control " name="data-inicial"  id="data-inicial-caixa" value="<?php echo date('Y-m-d') ?>" required>
        </div>

        <div style="float:left; margin-right:10px"><span><small><i title="Data da Venda Final" class="fa fa-calendar-o"></i></small></span></div>
        <div  style="float:left; margin-right:30px">
            <input type="date" class="form-control " name="data-final"  id="data-final-caixa" value="<?php echo date('Y-m-d') ?>" required>
        </div>

        
        <div style="float:left; margin-right:10px">
            <input type="text" class="form-control" name="nome-pesquisa" id="nome-pesquisa" placeholder="Pesquisar por Nome">
        </div>
             <!-- <div style="float:left; margin-right:10px; margin-top:10px"><span><small><i title="Pesquisar por Nome" class="fa fa-search"></i></small></div>

             </div> -->
        
<!--<div class="col-md-2" style="margin-top:5px;" align="center">   
         <div > 
        <small >
            <a title="Vendas de Ontem" class="text-muted" href="#" onclick="valorData('<?php echo $data_ontem ?>', '<?php echo $data_ontem ?>')"><span>Ontem</span></a> / 
            <a title="Vendas de Hoje" class="text-muted" href="#" onclick="valorData('<?php echo $data_hoje ?>', '<?php echo $data_hoje ?>')"><span>Hoje</span></a> / 
            <a title="Vendas do Mês" class="text-muted" href="#" onclick="valorData('<?php echo $data_mes ?>', '<?php echo $data_hoje ?>')"><span>Mês</span></a>
        </small>
        </div> 
    </div>-->

</div>

<hr>

    <div id="listar">

    </div>
</div>

<hr>

<form style="float:left; margin-right:10px" action="import.php" method="post" enctype="multipart/form-data">
    <div style="float:left; margin-right:10px">
        <input type="file" class="form-control" name="csvFile" id="csvFile" accept=".csv">  
        </div>                 
        <div style="float:left; margin-right:30px">
            <button type="submit" class="btn btn-primary" name="import">Importar CSV</button>

    </div>
</form>


<div class="main-page margin-mobile">

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
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome do Grupo">                         
                        </div>

                        <div class="col-md-6" style="margin-top: 22px">                         
                                <button type="submit" class="btn btn-primary">Sincronizar</button>                   
                        </div>

                        
                    </div>

            
                    <input type="hidden" class="form-control" type="submit">                    

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
                <h4 class="modal-title" id="exampleModalLabel"><span><b>Nome do Cliente: </b></span><span id="titulo_dados"></span></h4>
                <button id="btn-fechar-dados" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body">
                <div class="row" style="margin-top: 0px">
                    <div class="col-md-12" style="margin-bottom: 5px">
                        <span><b>Telefone Cliente: </b></span><span id="telefone"></span>
                    </div>
                        
                    <div class="col-md-6" style="margin-bottom: 5px">
                        <span><b>CPF / CNPJ: </b></span><span id="cpfcnpj"></span>
                    </div>

                    <div class="col-md-6" style="margin-bottom: 5px">
                        <span><b>Id Cliente: </b></span><span id="id"></span>
                    </div>


                                      
                    <div class="col-md-12" style="margin-bottom: 5px">
                        <span><b>Data Cadastro: </b></span><span id="data_cadastro"></span>
                    </div>

                    <div class="col-md-6" style="margin-bottom: 5px">
                        <span><b>Ativo: </b></span><span id="ativo"></span>
                    </div>

                    <div class="col-md-6" style="margin-bottom: 5px">
                        <span><b>Data Nascimento: </b></span><span id="data_nascimento"></span>
                    </div>

                    <div class="col-md-12" style="margin-bottom: 5px">
                        <span><b>Endereço: </b></span><span id="endereco"></span>
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
     $('#nome-pesquisa').val(nomePesquisa);
    listar();
}
</script>

<script type="text/javascript">
    function listar(){      
    
    var dataInicial = $('#data-inicial-caixa').val();
    var dataFinal = $('#data-final-caixa').val();   
    var nomePesquisa = $('#nome-pesquisa').val();
    $.ajax({

       url: 'paginas/' + pag + "/listar.php",
        method: 'POST',
        data: {dataInicial, dataFinal, nomePesquisa},
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

        $('#nome-pesquisa').change(function(){                       
            $('#tipo-busca').val('');
            listar();
        }); 

</script>

