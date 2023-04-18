<?php
require_once 'DAO.php';
require_once 'classes/application_config.php';

class RequisicaoDAO extends DAO {
    
    public static $instancia = null;
    
    public static function getInstancia() {
        
        if (self::$instancia == NULL) {
            self::$instancia = new RequisicaoDAO();
        }
        return self::$instancia;
    }
    
    private function __construct() {}
    
    public function inserirRequisicao($url, $user){

        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "INSERT INTO requisicao (data, url, user) VALUES (now(), '{$url}','{$user}')";
            
            $pdo->exec($sql);

        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao gravar requisicao: ". $erro->getMessage());
        }

    }

}