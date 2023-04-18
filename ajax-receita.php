<?php
include_once 'classes/dao/FinanceiroDAO.php';

$acao = $_GET['acao'];

if($acao == 'i'){
    
    FinanceiroDAO::getInstancia()->inserirReceita($_GET['id'], $_GET['competencia'], $_GET['dataPagto'], $_GET['valorPagto']);
    
} else if($acao == 'e'){
    
    FinanceiroDAO::getInstancia()->excluirReceita($_GET['id'], $_GET['competencia']);

} else if($acao == 'a'){
    
    FinanceiroDAO::getInstancia()->atualizarReceita($_GET['id'], $_GET['competencia'], $_GET['dataPagto'], $_GET['valorPagto']);
    
} else if($acao == 'ex'){
    
    FinanceiroDAO::getInstancia()->inserirReceitaExtra($_GET['competencia'], $_GET['descricao'], $_GET['data'], $_GET['valor']);
}

?>