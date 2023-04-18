<?php
include_once 'classes/dao/FinanceiroDAO.php';

$acao = $_GET['acao'];

if($acao == 'i'){
    
    FinanceiroDAO::getInstancia()->inserirDespesa($_GET['competencia'], $_GET['descricao'], $_GET['data'], $_GET['valor']);
    
} else if($acao == 'e'){
    
    FinanceiroDAO::getInstancia()->excluirDespesa($_GET['id']);

} else if($acao == 'a'){
    
    FinanceiroDAO::getInstancia()->atualizarDespesa($_GET['id'], $_GET['competencia'], $_GET['descricao'], $_GET['data'], $_GET['valor']);

} else if($acao == 'get'){

    $dadosDespesas = FinanceiroDAO::getInstancia()->obterDespesasPorCompetencia($_GET['competencia']);
    header("Content-Type: application/json");
    http_response_code(200);
    echo json_encode($dadosDespesas, JSON_FORCE_OBJECT);
    
}

?>