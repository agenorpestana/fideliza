<?php 
$pag = 'formulario';

if(@$formulario == 'ocultar'){
    echo "<script>window.location='../index.php'</script>";
    exit();
}

?>

<!-- Formulário de Avaliação -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Avaliação</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formAvaliacao">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="avaliacaoCurso">1 - Como você avalia nosso curso?</label>
                        <div class="estrelas">
                            <input type="radio" name="avaliacaoCurso" id="avaliacaoCurso5" value="5" required>
                            <label for="avaliacaoCurso5"></label>
                            <input type="radio" name="avaliacaoCurso" id="avaliacaoCurso4" value="4">
                            <label for="avaliacaoCurso4"></label>
                            <input type="radio" name="avaliacaoCurso" id="avaliacaoCurso3" value="3">
                            <label for="avaliacaoCurso3"></label>
                            <input type="radio" name="avaliacaoCurso" id="avaliacaoCurso2" value="2">
                            <label for="avaliacaoCurso2"></label>
                            <input type="radio" name="avaliacaoCurso" id="avaliacaoCurso1" value="1">
                            <label for="avaliacaoCurso1"></label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="avaliacaoInstalacao">2 - Como você avalia nossa instalação?</label>
                        <div class="estrelas">
                            <input type="radio" name="avaliacaoInstalacao" id="avaliacaoInstalacao5" value="5" required>
                            <label for="avaliacaoInstalacao5"></label>
                            <input type="radio" name="avaliacaoInstalacao" id="avaliacaoInstalacao4" value="4">
                            <label for="avaliacaoInstalacao4"></label>
                            <input type="radio" name="avaliacaoInstalacao" id="avaliacaoInstalacao3" value="3">
                            <label for="avaliacaoInstalacao3"></label>
                            <input type="radio" name="avaliacaoInstalacao" id="avaliacaoInstalacao2" value="2">
                            <label for="avaliacaoInstalacao2"></label>
                            <input type="radio" name="avaliacaoInstalacao" id="avaliacaoInstalacao1" value="1">
                            <label for="avaliacaoInstalacao1"></label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="probabilidade">3 - Qual a probabilidade de você recomendar o <?php echo $nome_sistema; ?> para um amigo ou colega?</label>
                        <input type="range" class="custom-range" id="probabilidade" name="probabilidade" min="1" max="10" step="1" value="10">
                        <span id="probabilidadeValue">10</span>
                    </div>

                    <div class="form-group">
                        <label for="melhorarSatisfacao">4 - O que podemos fazer para melhorar sua satisfação com o nosso Provedor?</label>
                        <textarea class="form-control" id="melhorarSatisfacao" name="melhorarSatisfacao" rows="4" maxlength="255"></textarea>
                    </div>

                    <input type="hidden" class="form-control" id="id" name="id">

                    <div id="mensagem" align="center"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Enviar Avaliação</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script type="text/javascript">var pag = "<?=$pag?>"</script>
<script src="js/ajax.js"></script>

<script type="text/javascript">

    function listarPermissoes(id){
         $.ajax({
        url: 'paginas/' + pag + "/listar_permissoes.php",
        method: 'POST',
        data: {id},
        dataType: "html",

        success:function(result){           
            $("#listar_permissoes").html(result);
            $('#mensagem_permissao').text('');
        }
    });
    }

    function adicionarPermissao(id, usuario){
         $.ajax({
        url: 'paginas/' + pag + "/add_permissao.php",
        method: 'POST',
        data: {id, usuario},
        dataType: "html",

        success:function(result){           
           listarPermissoes(usuario);
        }
    });
    }


    function marcarTodos(){
        let checkbox = document.getElementById('input-todos');
        var usuario = $('#id_permissoes').val();
        
        if(checkbox.checked) {
            adicionarPermissoes(usuario);           
        } else {
            limparPermissoes(usuario);
        }
    }


    function adicionarPermissoes(id_usuario){
        
        $.ajax({
        url: 'paginas/' + pag + "/add_permissoes.php",
        method: 'POST',
        data: {id_usuario},
        dataType: "html",

        success:function(result){           
           listarPermissoes(id_usuario);
        }
    });
    }


    function limparPermissoes(id_usuario){
        
        $.ajax({
        url: 'paginas/' + pag + "/limpar_permissoes.php",
        method: 'POST',
        data: {id_usuario},
        dataType: "html",

        success:function(result){           
           listarPermissoes(id_usuario);
        }
    });
    }
</script>