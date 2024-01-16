<?php

require_once("../conexao.php");

if (isset($_POST['import'])) {
    // Verifica se o arquivo foi enviado corretamente
    if (isset($_FILES['csvFile']) && $_FILES['csvFile']['error'] == 0) {
        // Processar o arquivo CSV
        $csvFile = $_FILES['csvFile']['tmp_name'];
        $lines = file($csvFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        // Verifica se o arquivo não está vazio
        if ($lines !== false) {
            echo "Conteúdo do arquivo CSV:";
            echo "<pre>";

            // Loop para ler as linhas do CSV
            foreach ($lines as $line) {

                // Convertendo a linha para UTF-8 usando iconv
                $line = iconv('ISO-8859-1', 'UTF-8', $line);
                // Explode a linha usando ponto e vírgula como delimitador
                $data = str_getcsv($line, ";");
                // Exibir os dados de cada linha
                print_r($data);

                // Verificar se o array possui os índices esperados
                if (count($data) >= 8) {
                   
                    $id_cliente = $data[0];
                    $nome = $data[1];
                    $cpfcnpj = $data[2];
                    $telefone = $data[3];
                    $email = $data[4];
                    // Verificar se a data está no formato esperado
                    $data_cadastro = DateTime::createFromFormat('d/m/Y', $data[5]);
                    if ($data_cadastro !== false) {
                        $data_cadastro = $data_cadastro->format('Y-m-d');
                    } else {
                    // Defina uma data padrão ou lide com a situação de outra maneira
                        $data_cadastro = '0000-00-00';
                    }

                    $ativo = $data[6];
                    $endereco = $data[7];

                    // Verificar se o id_cliente já existe no banco de dados
                    $query = $pdo->prepare("SELECT * FROM ixclientes WHERE id_cliente = :id_cliente");
                    $query->bindParam(":id_cliente", $id_cliente, PDO::PARAM_INT);

                    $query->execute();

                    if ($query->rowCount() == 0) {
                        // Se não existir, inserir os dados

                        $query = $pdo->prepare("INSERT INTO ixclientes (id_cliente, nome, cpfcnpj, telefone, email, data_cadastro, ativo, endereco) VALUES (:id_cliente, :nome, :cpfcnpj, :telefone, :email, :data_cadastro, :ativo, :endereco)");

                        $query->bindParam(":id_cliente", $id_cliente, PDO::PARAM_INT);
                        $query->bindParam(":nome", $nome);
                        $query->bindParam(":cpfcnpj", $cpfcnpj);
                        $query->bindParam(":telefone", $telefone);
                        $query->bindParam(":email", $email);
                        $query->bindParam(":data_cadastro", $data_cadastro);
                        $query->bindParam(":ativo", $ativo);
                        $query->bindParam(":endereco", $endereco);
                        $query->execute();
                    }
                }
            }

            echo "</pre>";
            echo "Importação concluída com sucesso!";
        } else {
            echo "Erro ao abrir o arquivo CSV.";
        }
    } else {
        echo "Erro no envio do arquivo CSV.";
    }

}
// Fechar a conexão com o banco de dados
$pdo = null;

?>
