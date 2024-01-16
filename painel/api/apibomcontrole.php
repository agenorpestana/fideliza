<!DOCTYPE html>
<html>
<head>
	<title>Script Email</title>
</head>
<body>

</body>
</html>

<?php 

// URL da API
$url = 'https://apinewintegracao.bomcontrole.com.br/integracao/Fatura/Obter/8';

// Cabeçalho com a chave de autorização
$headers = [
    'Authorization: ApiKey Z0EjZPzTOb_UYToXBw0NChm4K2Lyeq8vRgylQcwUoLQNBpY71c5vijcrQEnDml3pynsbTrCaUm1gcnxVpOfHmshjykfet67p5MI17YjFKwWR432THfaJLwGS8lZDZ2ICmetjjiG2IkW9DCNGpA7fPNyX4F91xTOE'
];

// Inicializar a sessão cURL
$ch = curl_init($url);

// Configurar as opções do cURL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// Fazer a solicitação GET
$response = curl_exec($ch);

// Verificar por erros
if (curl_errno($ch)) {
    echo 'Erro cURL: ' . curl_error($ch);
}

// Fechar a sessão cURL
curl_close($ch);

// Decodificar a resposta JSON
$data = json_decode($response, true);
var_dump($data);
exit()

// Verificar se a solicitação foi bem-sucedida
/*if ($data) {
    // Agora, você pode acessar os dados da resposta, por exemplo:
    echo 'ID da Fatura: ' . $data['Id'] . '<br>';
    echo 'Valor: ' . $data['Valor'] . '<br>';
    // E assim por diante...
} else {
    echo 'Erro ao obter dados da API.';
}*/


?>