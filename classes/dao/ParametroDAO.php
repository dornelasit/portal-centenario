<?php
require_once 'DAO.php';
require_once 'classes/application_config.php';

class ParametroDAO extends DAO {
    
    public static $instancia = null;
    
    public static function getInstancia() {
        
        if (self::$instancia == NULL) {
            self::$instancia = new ParametroDAO();
        }
        return self::$instancia;
    }
    
    private function __construct() {}
    
    
    public function obterValorParametro($chave){
        
        $retorno = null;
        
        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "SELECT valor FROM param WHERE chave = '{$chave}'";
            
            $stm = $pdo->query($sql);
            
            if ($stm->rowCount() > 0) {
                
                while ($linha = $stm->fetch(PDO::FETCH_ASSOC)) {
                    $retorno = $linha['valor'];
                    break;
                }
            }
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao obter parametro: ". $erro->getMessage());
        }
        
        return $retorno;
        
    }
}