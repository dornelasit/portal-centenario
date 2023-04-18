<?php
require_once 'DAO.php';
require_once 'classes/application_config.php';
require_once 'classes/util/Log4Php.php';
require_once 'classes/dto/ControleReceitaDTO.php';

class BenfeitoriaDAO extends DAO {
    
    public static $instancia = null;
    
    public static function getInstancia() {
        
        if (self::$instancia == NULL) {
            self::$instancia = new BenfeitoriaDAO();
        }
        return self::$instancia;
    }
    
    private function __construct() {}
    
    
    public function obterBenfeitoriasPorCompetencia($mesAnoCompetencia){
        
        $retorno = array();
        
        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "SELECT id, date_format(mes_ano_referencia,'%Y-%m-%d') AS mes_ano, descricao FROM benfeitoria WHERE date_format(mes_ano_referencia, '%m/%Y') = '{$mesAnoCompetencia}'";
            
            $stm = $pdo->query($sql);
            
            if ($stm->rowCount() > 0) {
                
                while ($linha = $stm->fetch(PDO::FETCH_ASSOC)) {
                    $benfeitoria = new stdClass();
                    $benfeitoria->id = ($linha['id']);
                    $benfeitoria->mesAno = ($linha['mes_ano']);
                    $benfeitoria->descricao = ($linha['descricao']);
                    
                    $retorno[] = $benfeitoria;
                }
            }
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao obter benfeitorias: ". $erro->getMessage());
        }
        
        return $retorno;
    }
    
    public function inserirBenfeitoria($competencia, $descricao){
        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "INSERT INTO benfeitoria values (null,STR_TO_DATE('{$competencia}', '%d/%m/%Y'),'{$descricao}')";
            
            $pdo->exec($sql);
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao inserir benfeitoria: ". $erro->getMessage());
        }
    }
    
    public function excluirBenfeitoria($id) {
        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "SELECT url_arquivo FROM nota_fiscal where benfeitoria_id ={$id}";
            $stm = $pdo->query($sql);
            
            if ($stm->rowCount() > 0) {
                
                while ($linha = $stm->fetch(PDO::FETCH_ASSOC)) {
                    unlink(DIRETORIO_RAIZ_NF.$linha['url_arquivo']);
                }
            }
            
            $sql = "DELETE FROM benfeitoria WHERE id = {$id}";
            $pdo->exec($sql);
            
            $sql = "DELETE FROM fi_receita_benfeitoria WHERE id_benfeitoria = {$id}";
            $pdo->exec($sql);
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao excluir benfeitoria : ". $erro->getMessage());
        }
    }
    
    public function inserirReceitaBenfeitoria($lote, $idBenfeitoria, $dataPagto, $valor){
        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "INSERT INTO fi_receita_benfeitoria (id_benfeitoria, id_lote, data_receita, valor_receita) VALUES ({$idBenfeitoria},{$lote},'{$dataPagto}',{$valor})";
            
            $pdo->exec($sql);
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao inserir receita benfeitoria: ". $erro->getMessage());
        }
    }
    
    public function atualizarDespesaBenfeitoria($lote, $idBenfeitoria, $dataPagto, $valor){
        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "UPDATE fi_receita_benfeitoria SET data_receita = STR_TO_DATE('{$dataPagto}', '%Y-%m-%d'), valor_receita = {$valor} WHERE id_lote = {$lote} AND id_benfeitoria = {$idBenfeitoria}";
            
            $pdo->exec($sql);
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao atualizar receita benfeitoria: ". $erro->getMessage());
        }
    }
    
    public function excluirReceitaBeneficio($lote, $idBenfeitoria){
        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "DELETE FROM fi_receita_benfeitoria WHERE id_lote = {$lote} AND id_benfeitoria = {$idBenfeitoria}";
            
            $pdo->exec($sql);
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao excluir receita beneficio: ". $erro->getMessage());
        }
    }
 
    public function obterValorArrecadadoBenfeitoria($idBenfeitoria){
        $retorno = 0;
        
        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "SELECT SUM(valor_receita) AS total FROM fi_receita_benfeitoria WHERE id_benfeitoria = {$idBenfeitoria}";
            
            $stm = $pdo->query($sql);
            
            if ($stm->rowCount() > 0) {
                
                if ($linha = $stm->fetch(PDO::FETCH_ASSOC)) {
                    $retorno = ($linha['total']);
                    if(is_null($retorno)){
                       $retorno = 0;    
                    }                    
                }
            }
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao obter valor arrecadado benfeitoria: ". $erro->getMessage());
        }
        
        return $retorno;
    }
    
    public function obterQuantidadeContribuintesBenfeitoria($idBenfeitoria){
        $retorno = 0;
        
        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "SELECT COUNT(*) AS qtd FROM fi_receita_benfeitoria WHERE id_benfeitoria = {$idBenfeitoria}";
            
            $stm = $pdo->query($sql);
            
            if ($stm->rowCount() > 0) {
                
                if ($linha = $stm->fetch(PDO::FETCH_ASSOC)) {
                    $retorno = ($linha['qtd']);
                    if(is_null($retorno)){
                        $retorno = 0;
                    }
                }
            }
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao obter valor arrecadado benfeitoria: ". $erro->getMessage());
        }
        
        return $retorno;
    }
    
    public function gravarNotaFiscalBenfeitoria($benfeitoria_id, $urlNotaFiscal){
        
        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "INSERT INTO nota_fiscal (benfeitoria_id, url_arquivo) VALUES ({$benfeitoria_id},'{$urlNotaFiscal}')";
            
            $pdo->exec($sql);
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao inserir nota fiscal da benfeitoria: ". $erro->getMessage());
        }
    }
    
    public function obterNotaFiscal($nfId){
        
        $retorno = null;
        
        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "SELECT id,benfeitoria_id,url_arquivo FROM nota_fiscal WHERE id = {$nfId}";
            
            $stm = $pdo->query($sql);
            
            if ($stm->rowCount() > 0) {
                
                while ($linha = $stm->fetch(PDO::FETCH_ASSOC)) {
                    $retorno = new stdClass();
                    $retorno->id = ($linha['id']);
                    $retorno->idBenfeitoria = ($linha['benfeitoria_id']);
                    $retorno->urlNf = ($linha['url_arquivo']);
                    
                }
            }
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao obter nf: ". $erro->getMessage());
        }
        
        return $retorno;
    }
    
    public function excluirNotaFiscalBenfeitoria($idNf){
        try {
            
            $nf = self::obterNotaFiscal($idNf);
            unlink(DIRETORIO_RAIZ_NF.$nf->urlNf);
            
            $pdo = self::obterConexaoBaseDados();            
            $sql = "DELETE FROM nota_fiscal WHERE id = {$idNf}";            
            $pdo->exec($sql);
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao excluir nf: ". $erro->getMessage());
        }
    }
    
    public function obterNotasFiscaisBenfeitoria($benfeitoria_id){
        
        $retorno = array();
        
        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "SELECT id,benfeitoria_id,url_arquivo FROM nota_fiscal WHERE benfeitoria_id = {$benfeitoria_id}";
            
            $stm = $pdo->query($sql);
            
            if ($stm->rowCount() > 0) {
                
                while ($linha = $stm->fetch(PDO::FETCH_ASSOC)) {
                    $notaFiscal = new stdClass();
                    $notaFiscal->id = ($linha['id']);
                    $notaFiscal->idBenfeitoria = ($linha['benfeitoria_id']);
                    $notaFiscal->urlNf = ($linha['url_arquivo']);
                    
                    $retorno[] = $notaFiscal;
                }
            }
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao obter notas fiscais da benfeitoria: ". $erro->getMessage());
        }
        
        return $retorno;
    }
 
    public function obterContribuicoesBenfeitoriasPorLote($numeroLote){
        
        $retorno = array();
        
        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "SELECT date_format(mes_ano_referencia, '%m/%Y') AS competencia ,b.descricao, rb.id,rb.id_benfeitoria,rb.id_lote, rb.data_receita, rb.valor_receita
                    FROM fi_receita_benfeitoria rb
                    INNER JOIN benfeitoria b 
                    ON (b.id = rb.id_benfeitoria)
                    WHERE rb.id_lote = {$numeroLote}
                    ORDER BY competencia, descricao";
            
            $stm = $pdo->query($sql);
            
            if ($stm->rowCount() > 0) {
                
                while ($linha = $stm->fetch(PDO::FETCH_ASSOC)) {
                    $contribuicaoLote = new stdClass();
                    $contribuicaoLote->id = ($linha['id']);
                    $contribuicaoLote->idBenfeitoria = ($linha['id_benfeitoria']);
                    $contribuicaoLote->numeroLote = ($linha['id_lote']);
                    $contribuicaoLote->dataContribuicao = ($linha['data_receita']);
                    $contribuicaoLote->valorContribuicao = ($linha['valor_receita']);
                    $contribuicaoLote->competencia = ($linha['competencia']);
                    $contribuicaoLote->descricao = ($linha['descricao']);
                    
                    $retorno[] = $contribuicaoLote;
                }
            }
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao obter contribuicoes do lote: ". $erro->getMessage());
        }
        
        return $retorno;
    }
    
    public function obterLotesPagantesBenfeitoria($idBenfeitoria){
        
        $retorno = array();
        
        try {
            
            $pdo = self::obterConexaoBaseDados();
            $sql = "SELECT id_lote, date_format(data_receita,'%d/%m/%Y') as data_receita, valor_receita FROM fi_receita_benfeitoria WHERE id_benfeitoria = {$idBenfeitoria} ORDER BY id_lote ASC";
            $stm = $pdo->query($sql);
            if ($stm->rowCount() > 0) {
                while ($linha = $stm->fetch(PDO::FETCH_ASSOC)) {
                    $controleReceitaPagos = new ControleReceitaDTO();
                    $controleReceitaPagos->setNumeroLote($linha['id_lote']);
                    $controleReceitaPagos->setDataPagamento($linha['data_receita']);
                    $controleReceitaPagos->setValorPago($linha['valor_receita']);
                    $retorno[] = $controleReceitaPagos;
                }
            }
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao obter lotes pagantes da benfeitoria: ". $erro->getMessage());
        }
        
        return $retorno;
    }
}