<?php
include_once("conexao.php");

if (isset($_GET['token_os'])) {
    $token_os = $_GET['token_os'];

    //// Verifique se o token existe na tabela 'os'
    $query = $pdo->prepare("SELECT * FROM os WHERE token_os = ?");
    $query->execute([$token_os]);
    $os = $query->fetch(PDO::FETCH_ASSOC);


    if ($os) {
        // Verifique se a data de expiração ainda não foi alcançada (se aplicável)
        //$popupMessage = "Token válido porem já tem formulario respondido para esse cliente";
         
        if (!$os['formulario_respondido_os']) {
           //echo alert('popupMessage');
           $popupMessage = "Token válido porem já tem formulario respondido para esse cliente";
           $redirectUrl = "itlfibra.com/indique.php";
            ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Avaliação</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="estilo.css">
</head>
<body>


<div class="container mt-5 max-width-800">
    <h2>Formulário de Avaliação</h2>
    <form method="POST" action="processa_formulario.php">
        <div class="form-group">
            <label><b>1</b> - Como você avalia nosso <b>ATENDIMENTO? </b></label>
            <div class="star-rating">
                <input type="hidden" name="token_os" value="<?php echo $token_os; ?>">
                <input type="hidden" name="id_os" value="<?php echo $os['id']; ?>">
                <input type="radio" name="avaliacaoCurso" value="" id="vazio" checked>

                <label for="star1"></label>
                <input type="radio" name="avaliacaoCurso" value="1" id="star1" >
                <label for="star2"></label>
                <input type="radio" name="avaliacaoCurso" value="2" id="star2" >
                <label for="star3"></label>
                <input type="radio" name="avaliacaoCurso" value="3" id="star3" >
                <label for="star4"></label>
                <input type="radio" name="avaliacaoCurso" value="4" id="star4" >
                <label for="star5"></label>
                <input type="radio" name="avaliacaoCurso" value="5" id="star5" >
            </div>
        </div>

        <div class="form-group">
            <label><b>2</b> - Como você avalia nosso <b>SUPORTE?</b></label>
            <div class="star-rating">
                <input type="radio" name="avaliacaoInstalacao" value="" id="vazioI" checked>

                <label for="star6"></label>
                <input type="radio" name="avaliacaoInstalacao" value="1" id="star6" >
                <label for="star7"></label>
                <input type="radio" name="avaliacaoInstalacao" value="2" id="star7" >
                <label for="star8"></label>
                <input type="radio" name="avaliacaoInstalacao" value="3" id="star8" >
                <label for="star9"></label>
                <input type="radio" name="avaliacaoInstalacao" value="4" id="star9" >
                <label for="star10"></label>
                <input type="radio" name="avaliacaoInstalacao" value="5" id="star10" >
            </div>
        </div>

        <div class="form-group">
            <label for="probabilidade"><b>3</b> - Qual a probabilidade de você recomendar nosso <b>SERVIÇO? </b>(1 a 10)</label>
            <input type="range" class="form-control-range" name="probabilidade" id="probabilidade" min="1" max="10" step="1" value="1" required>
            <output id="probabilidadeValue">1</output>
        </div>

        <div class="form-group">
            <label for="melhorarSatisfacao"><b>4</b> - O que podemos fazer para melhorar sua satisfação?</label>
            <textarea class="form-control" name="melhorarSatisfacao" id="melhorarSatisfacao" rows="4" maxlength="255"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Enviar Avaliação</button>
    </form>
</div>


<script>
    // Atualiza o valor exibido no controle deslizante
    var probabilidadeRange = document.getElementById("probabilidade");
    var probabilidadeValue = document.getElementById("probabilidadeValue");

    probabilidadeRange.oninput = function() {
        probabilidadeValue.textContent = this.value;
    };
</script>

</body>
</html>

<?php
    } else {
        $popupMessage = "Vc já respondeu esse questionário.";
        $redirectUrl = "indique.php";
           echo "<script>
        var popupMessage = '" . addslashes($popupMessage) . "';
        var redirectUrl = '" . addslashes($redirectUrl) . "';

        // Exibe o popup
        alert(popupMessage);

        // Redireciona após clicar em OK
        window.location.href = redirectUrl;
      </script>";;
       
    }
}else{

    $popupMessage = "Token inválido";
    $redirectUrl = "https://www.instagram.com/itlfibraprovedor/";
    echo "<script>
        var popupMessage = '" . addslashes($popupMessage) . "';
        var redirectUrl = '" . addslashes($redirectUrl) . "';

        // Exibe o popup
        alert(popupMessage);

        // Redireciona após clicar em OK
        window.location.href = redirectUrl;
      </script>";
}

}

?>