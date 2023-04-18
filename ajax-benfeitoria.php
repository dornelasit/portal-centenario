<?php
include_once 'classes/dao/BenfeitoriaDAO.php';

$acao = $_GET['acao'];

if($acao == 'i'){
    
    BenfeitoriaDAO::getInstancia()->inserirBenfeitoria($_GET['competencia'], $_GET['descricao']);
    
} else if($acao == 'e'){
    
    BenfeitoriaDAO::getInstancia()->excluirBenfeitoria($_GET['id']);
    
} else if($acao == 'ib'){
    
    BenfeitoriaDAO::getInstancia()->inserirReceitaBenfeitoria($_GET['lote'],$_GET['idBenfeitoria'],$_GET['dataPagto'],$_GET['valorPagto']);

} else if($acao == 'ab'){
    
    BenfeitoriaDAO::getInstancia()->atualizarDespesaBenfeitoria($_GET['lote'],$_GET['idBenfeitoria'],$_GET['dataPagto'],$_GET['valorPagto']);
    
} else if($acao == 'eb'){
    
    BenfeitoriaDAO::getInstancia()->excluirReceitaBeneficio($_GET['lote'],$_GET['idBenfeitoria']);

} else if($acao == 'v'){
    
    echo BenfeitoriaDAO::getInstancia()->obterValorArrecadadoBenfeitoria($_GET['idBenfeitoria']);
    
} else if($acao == 'enf'){
    
    echo BenfeitoriaDAO::getInstancia()->excluirNotaFiscalBenfeitoria($_GET['idNf']);
    
} else if($acao == 'cb'){
    
    echo BenfeitoriaDAO::getInstancia()->obterQuantidadeContribuintesBenfeitoria($_GET['idBenfeitoria']);
}

?>