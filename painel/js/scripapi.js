// Função para realizar a chamada da API e atualizar a lista
function realizarChamadaAPI() {
    listar();
}

// Configurar a chamada da API a cada minuto (60.000 milissegundos)
setInterval(realizarChamadaAPI, 60000); // 1 minuto

$(document).ready(function() {
    // ...

    // Iniciar a chamada da API a cada minuto
    realizarChamadaAPI();
});