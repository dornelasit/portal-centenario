<?php
include_once 'classes/dao/RequisicaoDAO.php';

RequisicaoDAO::getInstancia()->inserirRequisicao($_GET['url'], $_GET['user']);
 
?>