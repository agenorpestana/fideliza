<?php 
$query4 = $pdo->query("
	UPDATE $tabela AS os
	SET os.pontos = (
		SELECT ap.pontos
		FROM assunto_pontua AS ap
		WHERE os.id_assunto = ap.id_assunto
		)
	WHERE os.status != 'F';
	");

?>