<?php

require_once 'classes/application_config.php';
##############################
# Configuracao da API de log #
##############################

#----------------------------------------------------------
# Caminho da pasta dos logs de todas as aplicacoes
#----------------------------------------------------------
if ( !defined('FOLDER_LOGS') ){
    
    if(strcmp(AMBIENTE, 'PRODUCAO') == 0){
        # Producao
        define('FOLDER_LOGS', '/home/u256381077/public_html/logs/');
    } else {
        # Testes
        define('FOLDER_LOGS', 'C:\\xampp\\htdocs\\logs\\');
    }
}

#----------------------------------------------------------
# Nome do arquivo de log da aplicacao
#----------------------------------------------------------
define('PATH_LOG', FOLDER_LOGS.'portal-centenario.log');

#----------------------------------------------------------
# Nivel de log (DEBUG, INFO,AVISO, ERRO)
#----------------------------------------------------------
define('NIVEL_LOG', 'DEBUG');
