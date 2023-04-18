<?php
    include_once 'classes/dao/UsuarioDAO.php';
    include_once 'classes/dao/ReviewDAO.php';
    require_once 'classes/util/Log4Php.php';

    $acao = null;
    
    if(isset($_GET['acao'])){
        $acao = $_GET['acao'];
    }
    
    if(strcmp($acao, "login") == 0){
        
        try {
            
            $usuario = UsuarioDAO::getInstancia()->login($_GET['email'], $_GET['senha']);
            
            header("ype: application/json");
            http_response_code(200);
            echo $usuario->serialize();
            
        } catch (Exception $ex){
            Log4Php::logarFatal("Erro ao logar usuario: ". $ex->getMessage());
            http_response_code($ex->getCode());
        }
        
    } else if(strcmp($acao, "inserir") == 0){
        
        try {
            
            $idGerado = UsuarioDAO::getInstancia()->inserirUsuario($_GET['email'],$_GET['senha'], $_GET['nome'], $_GET['lote'], $_GET['celular']);
            header("Content-Type: application/json");
            http_response_code(200);
            echo "{\"id\": {$idGerado}}";
            
        } catch (Exception $ex){
            if($ex->getCode() == 409){
                http_response_code(409);
            } else {
                http_response_code(500);
            }
        }
        
    } else if(strcmp($acao, "update") == 0){

        try {
            
            UsuarioDAO::getInstancia()->atualizarUsuario($_GET['id'], $_GET['email'], $_GET['nome'], $_GET['lote'], $_GET['celular']);
            header("Content-Type: application/json");
            http_response_code(200);
            echo "{\"mensagem\": \"OK\"}";
            
        } catch (Exception $ex){
            if($ex->getCode() == 409){
                http_response_code(409);
            } else {
                http_response_code(500);
            }
        }
        

    } else if(strcmp($acao, "changepwd") == 0){

        try {
            
            UsuarioDAO::getInstancia()->atualizarSenha($_GET['id'], $_GET['novaSenha']);
            header("Content-Type: application/json");
            http_response_code(200);
            echo "{\"mensagem\": \"OK\"}";
            
        } catch (Exception $ex){
            http_response_code(500);
        }

    } else if(strcmp($acao, "delete") == 0){
        
        try {
            
            UsuarioDAO::getInstancia()->excluir($_GET['id']);
            header("Content-Type: application/json");
            http_response_code(200);
            echo "{\"mensagem\": \"OK\"}";
            
        } catch (Exception $ex){
            http_response_code(500);
        }

    } else if(strcmp($acao, "coment") == 0){

        try {
        
            ReviewDAO::getInstancia()->inserirReview($_GET['id'], $_GET['customerId'],$_GET['author'],nl2br($_GET['text']),$_GET['rating']);
            header("Content-Type: application/json");
            http_response_code(200);
            echo "{\"mensagem\": \"OK\"}";
        
        } catch (Exception $ex){
            http_response_code(500);
        }
        
    } else if(strcmp($acao, "obter") == 0){
        
        try {
            
            $usuario = UsuarioDAO::getInstancia()->obterUsuario($_GET['id']);
            
            header("Content-Type: application/json");
            http_response_code(200);
            echo $usuario->serialize();
            
        } catch (Exception $ex){
            Log4Php::logarFatal("Erro ao obter usuario: ". $ex->getMessage());
            http_response_code($ex->getCode());
        }
        
    } else {
        http_response_code(405);	
    }
?>