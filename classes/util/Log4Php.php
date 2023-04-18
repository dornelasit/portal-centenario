<?php

require_once 'classes/log_config.php';
require_once 'classes/application_config.php';

/**
 * Classe utilitaria para gerar logs
 *  
 * @author Andre Dornelas
 */
class Log4Php{

		/**
	 * Loga debug.
	 * 
	 * @param string $msg
	 */
	public static  function logarDebug($msg){
	    date_default_timezone_set(SERVER_TIMEZONE);
		if (NIVEL_LOG == 'DEBUG'){
		    $msg = "[".date("d-m-Y - G:i:s")."] - [DEBUG] - ".$msg."\r\n";
		    self::logar($msg);
		}
	}
	
	/**
	 * Loga info.
	 *
	 * @param string $msg
	 */
	public static  function logarInfo($msg){
	    date_default_timezone_set(SERVER_TIMEZONE);
	    if (NIVEL_LOG === 'INFO' || NIVEL_LOG === 'DEBUG'){
	        $msg = "[".date("d-m-Y - G:i:s")."] - [INFO] - ".$msg."\r\n";
	        self::logar($msg);
		}
	}	
	
	/**
	 * Loga aviso.
	 *
	 * @param string $msg
	 */
	public static  function logarAviso($msg){
	    date_default_timezone_set(SERVER_TIMEZONE);
	    $msg = "[".date("d-m-Y - G:i:s")."] - [AVISO] - ".$msg."\r\n";
	    self::logar($msg);
	}
	
	/**
	 * Loga erros.
	 * 
	 * @param string $msg
	 */
	public static  function logarErro($msg){
	    date_default_timezone_set(SERVER_TIMEZONE);
	    $msg = "[".date("d-m-Y - G:i:s")."] - [ERRO] - ".$msg."\r\n";
	    self::logar($msg);
	}
	
	/**
	 * Loga erros fatais.
	 *
	 * @param string $msg
	 */
	public static  function logarFatal($msg){
	    date_default_timezone_set(SERVER_TIMEZONE);
	    $msg = "[".date("d-m-Y - G:i:s")."] - [FATAL] - ".$msg."\r\n";
	    self::logar($msg);
	}
	
	/**
	 * Loga a mensagem informada.
	 *
	 * @param string $msg Mensagem
	 */
	private static function logar($msg){
	    $fp = fopen(PATH_LOG,'a');
	    fwrite($fp,$msg);
	    fclose($fp);
	}
	
	/**
	 * Loga a auditoria.
	 *
	 * @param string $systemId - Id do sistema
	 * @param string $text - Texto informativo da auditoria
	 */
	public static function logarAuditoria($systemId, $text) {
	    $fp = fopen(PATH_AUDIT_LOG,'a');
	    $msg = "[".date("d-m-Y - G:i:s")."] - [AUDIT] - [".$systemId."] : ".$text."\r\n";
	    fwrite($fp,$msg);
	    fclose($fp);
	}
	
}