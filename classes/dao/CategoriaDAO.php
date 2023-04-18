<?php
require_once 'DAO.php';
require_once 'classes/application_config.php';
require_once 'classes/dto/CategoriaDTO.php';

class CategoriaDAO extends DAO {
    
    public static $instancia = null;
    
    public static function getInstancia() {
        
        if (self::$instancia == NULL) {
            self::$instancia = new CategoriaDAO();
        }
        return self::$instancia;
    }
    
    private function __construct() {}
    
    
    public function obterTodasCategoriasAtivas($idCategoria){
        
        $retorno = array();
        
        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "SELECT * FROM categoria WHERE parent_id = ".$idCategoria." AND status = 1 ORDER BY sort_order";
            
            $stm = $pdo->query($sql);
            
            if ($stm->rowCount() > 0) {
                
                while ($linha = $stm->fetch(PDO::FETCH_ASSOC)) {
                    $categoria = new CategoriaDTO();
                    $categoria->setId($linha['id']);
                    $categoria->setNome($linha['name']);
                    $categoria->setPage($linha['page']);
                    
                    $retorno[] = $categoria;
                }
            }
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao obter categorias: ". $erro->getMessage());
        }
        
        return $retorno;
        
    }
}