<?php

require_once "classes/db_config.php";

/**
 * Classe abstrata DAO para todas as operacoes com banco de dados.
 * @author Andre Dornelas
 * @since 1.0
 */
abstract class DAO {
	
	private static $instancia = null;
	
	/**
	 * Construtor privado
	 */
	private function __construct() {}
	
	/**
	 * Retorna uma instancia DAO.
	 *
	 * @return DAO
	 */
	public static function getInstancia() {
	
		if (self::$instancia == NULL) {
			self::$instancia = new DAO();
		}
	
		return self::$instancia;
	
	}

	/**
	 * Obtem a conexao com a base de dados.
	 * 
	 * @return PDO PDO do banco de dados
	 */
	protected function obterConexaoBaseDados(){
		try{

			$conexao = new PDO(URL, USER, PWD);
			
			$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);		
			
			$conexao->query("SET NAMES 'utf8'");
			$conexao->query("SET character_set_connection=utf8");
			$conexao->query("SET character_set_client=utf8");
			$conexao->query("SET character_set_results=utf8");
			$conexao->query("SET time_zone = '-3:00'");
			
			return $conexao;
			
		} catch (Exception $erro){			
			Log4Php::logarFatal("DAO-001: ". $erro->getMessage());
			throw $erro;
		}
	}
	
}