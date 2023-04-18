<?php
    include_once 'classes/dao/LoteDAO.php';

    LoteDAO::getInstancia()->atualizarDadosLote($_GET['id'], $_GET['nome'],$_GET['telefone'], $_GET['contribui'], $_GET['construido'], $_GET['construindo']);

    header("Content-Type: application/json");
    http_response_code(200);
    echo "{\"message\": \"OK\"}";

    
?>