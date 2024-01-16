<?php

//listar-----------------------------

$host = 'https://ixc.itlfibra/webservice/v1';
$token = '75:b938ef38b4a4154c32248aaf79025b169bff1f2380a0163fb6109922c60d3ea9';//token gerado no cadastro do usuario (verificar permissões)
$selfSigned = true; //true para certificado auto assinado
$api = new IXCsoft\WebserviceClient($host, $token, $selfSigned);
$params = array(
    'qtype' => 'su_oss_chamado.id',//campo de filtro
    'query' => 'A',//valor para consultar
    'oper' => '=',//operador da consulta
    'page' => '1',//página a ser mostrada
    'rp' => '20',//quantidade de registros por página
    'sortname' => 'su_oss_chamado.id',//campo para ordenar a consulta
    'sortorder' => 'desc'//ordenação (asc= crescente | desc=decrescente)
);
$api->get('su_oss_chamado', $params);
$retorno = $api->getRespostaConteudo(false);// false para json | true para array



?>
                    