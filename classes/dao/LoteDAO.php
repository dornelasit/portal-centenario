<?php
require_once 'DAO.php';
require_once 'classes/application_config.php';
require_once 'classes/dto/LoteDTO.php';

class LoteDAO extends DAO {
    
    public static $instancia = null;
    
    public static function getInstancia() {
        
        if (self::$instancia == NULL) {
            self::$instancia = new LoteDAO();
        }
        return self::$instancia;
    }
    
    private function __construct() {}
    
    public function obterTodosLotes(){
        
        $retorno = array();
        
        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "SELECT * FROM lote ORDER BY 1 ASC";
            
            $stm = $pdo->query($sql);
            
            if ($stm->rowCount() > 0) {
                
                while ($linha = $stm->fetch(PDO::FETCH_ASSOC)) {
                    $lote = new LoteDTO();
                    $lote->setId($linha['id']);
                    $lote->setNomeProprietario($linha['nome_proprietario']);
                    $lote->setTelefone($linha['telefone']);
                    $lote->setContribui($linha['flag_contribui']);
                    $lote->setConstruido($linha['flag_construido']);
                    $lote->setConstruindo($linha['flag_construindo']);
                    
                    $retorno[] = $lote;
                }
            }
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao obter lotes: ". $erro->getMessage());
        }
        
        return $retorno;
        
    }
    
    public function obterLotesQueContribuem(){
        
        $retorno = array();
        
        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "SELECT * FROM lote WHERE flag_contribui = 1 ORDER BY 1 ASC";
            
            $stm = $pdo->query($sql);
            
            if ($stm->rowCount() > 0) {
                
                while ($linha = $stm->fetch(PDO::FETCH_ASSOC)) {
                    $lote = new LoteDTO();
                    $lote->setId($linha['id']);
                    $lote->setNomeProprietario($linha['nome_proprietario']);
                    $lote->setTelefone($linha['telefone']);
                    $lote->setContribui($linha['flag_contribui']);
                    $lote->setConstruido($linha['flag_construido']);
                    $lote->setConstruindo($linha['flag_construindo']);
                    
                    $retorno[] = $lote;
                }
            }
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao obter lotes: ". $erro->getMessage());
        }
        
        return $retorno;
        
    }

    public function verificarSeLoteContribui($lote){
        
        $retorno = false;
        
        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "SELECT * FROM lote WHERE id = {$lote} AND flag_contribui = 1";
            
            $stm = $pdo->query($sql);
            
            if ($stm->rowCount() > 0) {
                $retorno = true;
            }
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao verificar lote contribuinte: ". $erro->getMessage());
        }
        
        return $retorno;
        
    }
    
    public function atualizarDadosLote($id, $nomeResponsavel, $telefone, $contribui, $jaConstruida, $construindo){
        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "update lote set nome_proprietario = '{$nomeResponsavel}', telefone = '{$telefone}', flag_contribui = {$contribui}, flag_construido = {$jaConstruida}, flag_construindo = {$construindo}  WHERE id = {$id}";
            
            $pdo->exec($sql);
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao atualizar lote: ". $erro->getMessage());
        }
    }
    
}