<?php
include_once 'classes/dao/FinanceiroDAO.php';

$acao = $_GET['acao'];

if($acao == 'i'){
    
    FinanceiroDAO::getInstancia()->inserirCaixa($_GET['competencia'], $_GET['valorCaixa']);
    
} else if($acao == 'a'){
    
    FinanceiroDAO::getInstancia()->atualizarCaixa($_GET['id'], $_GET['valorCaixa']);
}

?>