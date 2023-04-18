<?php
include_once 'classes/dao/ServicoMaterialDAO.php';

$acao = $_GET['acao'];

if($acao == 'i'){
    
    ServicoMaterialDAO::getInstancia()->inserirIndicacao($_GET['titulo'], nl2br($_GET['texto']), $_GET['user']);
    
} 
?>