<?php
    // Defina os dados da mensagem
$data = [
        'api_key' => $token_whatsapp, // Token do dispositivo
        'number' => $telefone_envio, // Número do destinatário
        'message' => $mensagem, // Mensagem a ser enviada
        'sender' => '73981945369' // Número do remetente

      ];

      $curl = curl_init();
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://sendzap.conectazapi2.com.br/send-message',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => array(
          'Content-Type: application/json'
        ),
      ));

      $response = curl_exec($curl);

      $responseData = json_decode($response, true);
      curl_close($curl);

      //var_dump($token_ixc);
     // var_dump($telefone_envio);
      //var_dump($mensagem);
      //echo $telefone_envio;


?>