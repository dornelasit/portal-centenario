<?php
require_once 'DAO.php';
require_once 'classes/application_config.php';
require_once 'classes/dto/ServicoMaterialDTO.php';
require_once 'classes/dao/ReviewDAO.php';

class ServicoMaterialDAO extends DAO {
    
    public static $instancia = null;
    
    public static function getInstancia() {
        
        if (self::$instancia == NULL) {
            self::$instancia = new ServicoMaterialDAO();
        }
        return self::$instancia;
    }
    
    private function __construct() {}
    
    
    public function obterServicoMaterial($termoPesquisa){
        
        $retorno = array();
        
        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "SELECT id, titulo, CASE WHEN LENGTH(texto) > 100 THEN CONCAT(SUBSTRING(texto,1, 97),'...') ELSE texto END AS texto, date_format(data_criacao,'%d/%m/%Y - %T') AS data_criacao, user FROM servico_material WHERE titulo LIKE '%{$termoPesquisa}%' OR texto LIKE '%{$termoPesquisa}%' ORDER BY data_criacao DESC";
            
            $stm = $pdo->query($sql);
            
            if ($stm->rowCount() > 0) {
                
                while ($linha = $stm->fetch(PDO::FETCH_ASSOC)) {
                    $servico = new ServicoMaterialDTO();
                    $servico->setId($linha['id']);
                    $servico->setTitulo($linha['titulo']);
                    $servico->setTexto($linha['texto']);
                    $servico->setData($linha['data_criacao']);
                    $servico->setNota(self::obterNotaReview($servico->getId()));
                    $servico->setUser($linha['user']);
                    
                    $retorno[] = $servico;
                }
            }
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao obter servicos e materiais: ". $erro->getMessage());
        }
        
        return $retorno;
        
    }
    
    
    public function obterDetalheServicoMaterial($id){
        
        $retorno = new ServicoMaterialDTO();
        
        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "SELECT id, titulo, texto, date_format(data_criacao,'%d/%m/%Y - %T') AS data_criacao, user FROM servico_material WHERE id = {$id}";
            
            $stm = $pdo->query($sql);
            
            if ($stm->rowCount() > 0) {
                
                if ($linha = $stm->fetch(PDO::FETCH_ASSOC)) {
                    $retorno->setId($linha['id']);
                    $retorno->setTitulo($linha['titulo']);
                    $retorno->setTexto($linha['texto']);
                    $retorno->setData($linha['data_criacao']);
                    $retorno->setUser($linha['user']);
                }
            }
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao obter detalhe servicos e materiais: ". $erro->getMessage());
        }
        
        return $retorno;
        
    }
    
    private function obterNotaReview($id){
        return ReviewDAO::getInstancia()->calcularReview($id);
    }

    public function inserirIndicacao($titulo, $texto, $user){

        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "INSERT INTO servico_material (titulo,texto,data_criacao, user) VALUES ('{$titulo}','{$texto}',now(), '{$user}')";
            
            $pdo->exec($sql);

        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao gerar indicacao: ". $erro->getMessage());
        }

    }
}