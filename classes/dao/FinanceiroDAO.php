<?php
require_once 'DAO.php';
require_once 'classes/util/Log4Php.php';
require_once 'classes/application_config.php';
require_once 'classes/dto/ControleReceitaDTO.php';
require_once 'classes/dto/ControleDespesaDTO.php';
require_once 'classes/dao/ParametroDAO.php';
require_once 'classes/dto/ControleCaixaDTO.php';
require_once 'classes/dto/TransparenciaDTO.php';

class FinanceiroDAO extends DAO {
    
    public static $instancia = null;
    
    public static function getInstancia() {
        
        if (self::$instancia == NULL) {
            self::$instancia = new FinanceiroDAO();
        }
        return self::$instancia;
    }
    
    private function __construct() {}
    
    public function obterDadosReceitaPorCompetencia($mesAnoCompetencia){
        
        $retorno = array();
        
        try {
            
            $paramDiaFechamento = intval(ParametroDAO::getInstancia()->obterValorParametro("DIA_FECHAMENTO"));
            $paramQtdDiasAlerta = intval(ParametroDAO::getInstancia()->obterValorParametro("QTD_DIAS_ALERTA"));
            
            //-- Primeiro obtem os lotes contribuintes
            $lotesContribuintes = array();
            $pdo = self::obterConexaoBaseDados();
            $sql = "SELECT id, nome_proprietario FROM lote WHERE flag_contribui = 1 ORDER BY 1 ASC";
            $stm = $pdo->query($sql);
            if ($stm->rowCount() > 0) {
                while ($linha = $stm->fetch(PDO::FETCH_ASSOC)) {
                    $controleReceita = new ControleReceitaDTO();
                    $controleReceita->setNumeroLote($linha['id']);
                    $controleReceita->setNome($linha['nome_proprietario']);
                    $controleReceita->setPago(false);
                    $controleReceita->setCorLinha("#fff");
                    $lotesContribuintes[] = $controleReceita;
                }
            }
            
            //-- Obtem os que ja pagaram na competencia informada
            $lotesPagosCompetencia = array();
            $pdo = self::obterConexaoBaseDados();
            $sql = "SELECT id_lote, date_format(data_receita,'%Y-%m-%d') as data_receita, valor_receita FROM fi_receita WHERE date_format(mes_ano_referencia, '%m/%Y') = '{$mesAnoCompetencia}' ORDER BY id_lote ASC";
            $stm = $pdo->query($sql);
            if ($stm->rowCount() > 0) {
                while ($linha = $stm->fetch(PDO::FETCH_ASSOC)) {
                    $controleReceitaPagos = new ControleReceitaDTO();
                    $controleReceitaPagos->setNumeroLote($linha['id_lote']);
                    $controleReceitaPagos->setDataPagamento($linha['data_receita']);
                    $controleReceitaPagos->setValorPago($linha['valor_receita']);
                    $lotesPagosCompetencia[] = $controleReceitaPagos;
                }
            }
            
            //-- Agora cruza os dados no retorno
            foreach ($lotesContribuintes as $loteContribuinte){
                foreach ($lotesPagosCompetencia as $lotePagoCompetencia){
                    if($loteContribuinte->getNumeroLote() == $lotePagoCompetencia->getNumeroLote()){
                        $loteContribuinte->setDataPagamento($lotePagoCompetencia->getDataPagamento());
                        $loteContribuinte->setPago(true);
                        $loteContribuinte->setCorLinha("#daebc3");
                        $loteContribuinte->setValorPago($lotePagoCompetencia->getValorPago());
                        break;
                    } 
                }
                
                $retorno[] = $loteContribuinte;
            }
            
            //-- verifica a cor de cada registro
            $diaAtual = intval(date('d'));
            $diaAtual = 10;
            
            $diaAlerta = new DateTime('now');
            $diaAlerta->modify("-".($paramQtdDiasAlerta + 1)." days");
            $diaAlerta = intval($diaAlerta->format('d'));
            
            foreach ($retorno as $registro){
                if(!$registro->getPago()){
                    if($diaAtual >= $paramDiaFechamento){
                        $registro->setCorLinha("#ffb5b5");
                    } else if($diaAtual >= $diaAlerta){
                        $registro->setCorLinha("#fffac1");
                    }
                }
            }
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao obter pagamento das receitas: ". $erro->getMessage());
        }
        
        return $retorno;
    }

    
    public function inserirReceita($lote, $competencia, $dataPagto, $valor){
        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "INSERT INTO fi_receita (id_lote, mes_ano_referencia, data_receita, valor_receita) VALUES ({$lote}, STR_TO_DATE('{$competencia}', '%d/%m/%Y') ,'{$dataPagto}',{$valor})";
            
            $pdo->exec($sql);
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao inserir receita: ". $erro->getMessage());
        }
    }

    public function inserirReceitaExtra($competencia, $descricao, $dataPagto, $valor){
        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "INSERT INTO fi_receita_extra (mes_ano_referencia, data_receita_extra, valor_receita_extra, descricao) VALUES (STR_TO_DATE('{$competencia}', '%d/%m/%Y') ,'{$dataPagto}',{$valor},'{$descricao}')";
            
            $pdo->exec($sql);
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao inserir receita extra: ". $erro->getMessage());
        }
    }
    
    public function atualizarReceita($lote, $competencia, $dataPagto, $valor){
        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "UPDATE fi_receita SET data_receita = '{$dataPagto}',valor_receita = {$valor} WHERE id_lote = {$lote} AND mes_ano_referencia = STR_TO_DATE('{$competencia}', '%d/%m/%Y')";
            
            $pdo->exec($sql);
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao inserir receita: ". $erro->getMessage());
        }
    }
    
    public function excluirReceita($lote, $competencia){
        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "DELETE FROM fi_receita WHERE id_lote = {$lote} AND mes_ano_referencia = STR_TO_DATE('{$competencia}', '%d/%m/%Y')";
            
            $pdo->exec($sql);
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao excluir receita: ". $erro->getMessage());
        }
    }
    
    public function inserirDespesa($competencia,$descricao,$dataDespesa,$valor){
        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "INSERT INTO fi_despesa (mes_ano_referencia, descricao, data_despesa, valor_despesa) VALUES (STR_TO_DATE('{$competencia}', '%d/%m/%Y') , '{$descricao}', '{$dataDespesa}',{$valor})";
            
            $pdo->exec($sql);
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao inserir despesa: ". $erro->getMessage());
        }
    }
    
    public function excluirDespesa($idDespesa){
        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "DELETE FROM fi_despesa WHERE id = {$idDespesa}";
            
            $pdo->exec($sql);
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao excluir despesa: ". $erro->getMessage());
        }
    }
    
    public function atualizarDespesa($idDespesa,$competencia,$descricao,$dataDespesa,$valor){
        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "UPDATE fi_despesa SET mes_ano_referencia = STR_TO_DATE('{$competencia}', '%d/%m/%Y'), descricao = '{$descricao}', data_despesa = '{$dataDespesa}', valor_despesa = {$valor} WHERE id = {$idDespesa}";
            
            $pdo->exec($sql);
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao atualizar despesa: ". $erro->getMessage());
        }
    }
    
    public function obterDespesasPorCompetencia($mesAnoCompetencia){
        
        $retorno = array();
        
        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "SELECT id, mes_ano_referencia, date_format(data_despesa,'%Y-%m-%d') as data_despesa, descricao, valor_despesa  FROM fi_despesa WHERE date_format(mes_ano_referencia, '%m/%Y') = '{$mesAnoCompetencia}' ORDER BY 1 DESC";
            
            $stm = $pdo->query($sql);
            
            if ($stm->rowCount() > 0) {
                
                while ($linha = $stm->fetch(PDO::FETCH_ASSOC)) {
                    $despesa = new stdClass();
                    $despesa->id = ($linha['id']);
                    $despesa->competencia = ($linha['mes_ano_referencia']);
                    $despesa->descricao = ($linha['descricao']);
                    $despesa->dataDespesa = ($linha['data_despesa']);
                    $despesa->valorDespesa = ($linha['valor_despesa']);
                    
                    $retorno[] = $despesa;
                }
            }
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao obter despesas: ". $erro->getMessage());
        }
        
        return $retorno;
    }
    
    public function obterCaixaPorCompetencia($mesAnoCompetencia){
        
        $retorno = new ControleCaixaDTO();
        
        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "SELECT id, valor_caixa, mes_ano_referencia FROM fi_main WHERE date_format(mes_ano_referencia, '%m/%Y') = '{$mesAnoCompetencia}' ORDER BY 1 DESC";
            
            $stm = $pdo->query($sql);
            
            if ($stm->rowCount() > 0) {
                
                if ($linha = $stm->fetch(PDO::FETCH_ASSOC)) {
                    $retorno->setId($linha['id']);
                    $retorno->setCompetencia($linha['mes_ano_referencia']);
                    $retorno->setValor($linha['valor_caixa']);
                }
            }
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao obter caixa: ". $erro->getMessage());
        }
        
        return $retorno;
    }

    public function obterCaixaAtual(){
        
        $retorno = new ControleCaixaDTO();
        
        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "SELECT id, valor_caixa, mes_ano_referencia FROM fi_main ORDER BY id DESC";
            
            $stm = $pdo->query($sql);
            
            if ($stm->rowCount() > 0) {
                
                if ($linha = $stm->fetch(PDO::FETCH_ASSOC)) {
                    $retorno->setId($linha['id']);
                    $retorno->setCompetencia($linha['mes_ano_referencia']);
                    $retorno->setValor($linha['valor_caixa']);
                }
            }
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao obter caixa: ". $erro->getMessage());
        }
        
        return $retorno;
    }
    
    
    public function obterDadosTransparencia(){
        
        $retorno = array();
        
        try {
            
            $dadosReceita = array();
            $pdo = self::obterConexaoBaseDados();
            $sql = "SELECT date_format(mes_ano_referencia, '%m/%Y') AS competencia, SUM(valor_receita) AS total_receita FROM fi_receita GROUP BY mes_ano_referencia LIMIT 12";
            $stm = $pdo->query($sql);
            if ($stm->rowCount() > 0) {
                while ($linha = $stm->fetch(PDO::FETCH_ASSOC)) {
                    $receita = new TransparenciaDTO();
                    $receita->setCompetencia($linha['competencia']);
                    $valorReceitaExtra = self::obterValorReceitaExtra($receita->getCompetencia());
                    $receita->setValorTotalReceita(($linha['total_receita'] + $valorReceitaExtra));
                    $dadosReceita[] = $receita;
                }
            }
            
            $dadosDespesa = array();
            $pdo = self::obterConexaoBaseDados();
            $sql = "SELECT date_format(mes_ano_referencia, '%m/%Y') AS competencia, SUM(valor_despesa) AS total_despesa FROM fi_despesa GROUP BY mes_ano_referencia LIMIT 12";
            $stm = $pdo->query($sql);
            if ($stm->rowCount() > 0) {
                while ($linha = $stm->fetch(PDO::FETCH_ASSOC)) {
                    $despesa = new TransparenciaDTO();
                    $despesa->setCompetencia($linha['competencia']);
                    $despesa->setValorTotalDespesa($linha['total_despesa']);
                    $dadosDespesa[] = $despesa;
                }
            }
            
            foreach ($dadosReceita as $receita){
                foreach ($dadosDespesa as $despesa) {
                    if(strcmp($receita->getCompetencia(), $despesa->getCompetencia()) == 0){
                        $receita->setValorTotalDespesa($despesa->getValorTotalDespesa());
                        $retorno[] = $receita;
                        break;
                    }
                }
            }
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao obter dados transparencia: ". $erro->getMessage());
        }
        
        return $retorno;
    }

    public function inserirCaixa($competencia,$valor){
        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "INSERT INTO fi_main (valor_caixa, mes_ano_referencia) VALUES ({$valor}, STR_TO_DATE('{$competencia}', '%d/%m/%Y'))";

            $pdo->exec($sql);
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao inserir caixa: ". $erro->getMessage());
        }
    }

    public function atualizarCaixa($id, $valorAtualizado){
        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "UPDATE fi_main SET valor_caixa = {$valorAtualizado} WHERE id = {$id}";

            $pdo->exec($sql);
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao atualizar caixa: ". $erro->getMessage());
        }
    }
    
    public function obterValorReceitaExtra($mesAnoCompetencia){
        
        $retorno = 0;
        
        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "SELECT SUM(valor_receita_extra) AS valor_receita_extra FROM fi_receita_extra WHERE date_format(mes_ano_referencia, '%m/%Y') = '{$mesAnoCompetencia}'";
            
            $stm = $pdo->query($sql);
            
            if ($stm->rowCount() > 0) {
                if ($linha = $stm->fetch(PDO::FETCH_ASSOC)) {
                    $retorno = $linha['valor_receita_extra'];
                }
            }
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao obter receitas extras: ". $erro->getMessage());
        }
        
        return $retorno;
    }
    
    public function obterDetalhesFinanceirosCompetencia($mesAnoCompetencia){
 
        $retorno = new stdClass();
        $receitas = array();
        $receitasExtras = array();
        $despesas = array();        
        
        try {
            
            //-- Receitas
            $pdo = self::obterConexaoBaseDados();            
            $sql = "SELECT id_lote,valor_receita, date_format(data_receita, '%d/%m/%Y') AS data_pagto  FROM fi_receita WHERE date_format(mes_ano_referencia, '%m/%Y') = '{$mesAnoCompetencia}' ORDER BY 1 ASC";            
            $stm = $pdo->query($sql);            
            if ($stm->rowCount() > 0) {
                while($linha = $stm->fetch(PDO::FETCH_ASSOC)) {
                    $receita = new stdClass();
                    $receita->lote  = $linha['id_lote'];
                    $receita->valor = $linha['valor_receita'];
                    $receita->dataPagamento = $linha['data_pagto'];
                    
                    $receitas[] = $receita;
                }
            }
            
            //-- Receitas extras
            $sql = "SELECT valor_receita_extra, descricao FROM fi_receita_extra WHERE date_format(mes_ano_referencia, '%m/%Y') = '{$mesAnoCompetencia}'";
            $stm = $pdo->query($sql);
            if ($stm->rowCount() > 0) {
                while ($linha = $stm->fetch(PDO::FETCH_ASSOC)) {
                    $receitaExtra = new stdClass();
                    $receitaExtra->valor = $linha['valor_receita_extra'];
                    $receitaExtra->descricao = $linha['descricao'];
                    
                    $receitasExtras[] = $receitaExtra;
                }
            }
            
            //-- Despesas
            $despesas = self::obterDespesasPorCompetencia($mesAnoCompetencia);
            
            //-- Montando o retorno
            $retorno->receitas = $receitas;
            $retorno->receitasExtras = $receitasExtras;
            $retorno->despesas = $despesas;
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao obter dados detalhes financeiros: ". $erro->getMessage());
        }
        
        return $retorno;
    }

    public function obterReceitasExtrasPorCompetencia($mesAnoCompetencia){

        $retorno = array();
        
        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "SELECT valor_receita_extra, descricao FROM fi_receita_extra WHERE date_format(mes_ano_referencia, '%m/%Y') = '{$mesAnoCompetencia}'";
            $stm = $pdo->query($sql);
            if ($stm->rowCount() > 0) {
                while ($linha = $stm->fetch(PDO::FETCH_ASSOC)) {
                    $receitaExtra = new stdClass();
                    $receitaExtra->valor = $linha['valor_receita_extra'];
                    $receitaExtra->descricao = $linha['descricao'];
                    
                    $retorno[] = $receitaExtra;
                }
            }
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao obter receitas extras: ". $erro->getMessage());
        }
        
        return $retorno;


    }
    
    public function obterDadosReceitasBenfeitoria($idBenfeitoria){
        
        $retorno = array();
        
        try {
            
            //-- Primeiro obtem todos os lotes
            $todosLotes = array();
            $pdo = self::obterConexaoBaseDados();
            $sql = "SELECT id, nome_proprietario FROM lote order by 1 ASC";
            $stm = $pdo->query($sql);
            if ($stm->rowCount() > 0) {
                while ($linha = $stm->fetch(PDO::FETCH_ASSOC)) {
                    $controleReceita = new ControleReceitaDTO();
                    $controleReceita->setNumeroLote($linha['id']);
                    $controleReceita->setNome($linha['nome_proprietario']);
                    $controleReceita->setPago(false);
                    $todosLotes[] = $controleReceita;
                }
            }
            
            //-- Obtem os que ja pagaram na competencia informada
            $lotesPagosBenfeitoria = array();
            $pdo = self::obterConexaoBaseDados();
            $sql = "SELECT id_lote, date_format(data_receita,'%Y-%m-%d') as data_receita, valor_receita FROM fi_receita_benfeitoria WHERE id_benfeitoria = {$idBenfeitoria} ORDER BY id_lote ASC";
            $stm = $pdo->query($sql);
            if ($stm->rowCount() > 0) {
                while ($linha = $stm->fetch(PDO::FETCH_ASSOC)) {
                    $controleReceitaPagos = new ControleReceitaDTO();
                    $controleReceitaPagos->setNumeroLote($linha['id_lote']);
                    $controleReceitaPagos->setDataPagamento($linha['data_receita']);
                    $controleReceitaPagos->setValorPago($linha['valor_receita']);
                    $lotesPagosBenfeitoria[] = $controleReceitaPagos;
                }
            }
            
            //-- Agora cruza os dados no retorno
            foreach ($todosLotes as $loteContribuinte){
                foreach ($lotesPagosBenfeitoria as $lotePagoBenfeitoria){
                    if($loteContribuinte->getNumeroLote() == $lotePagoBenfeitoria->getNumeroLote()){
                        $loteContribuinte->setDataPagamento($lotePagoBenfeitoria->getDataPagamento());
                        $loteContribuinte->setPago(true);
                        $loteContribuinte->setCorLinha("#daebc3");
                        $loteContribuinte->setValorPago($lotePagoBenfeitoria->getValorPago());
                        break;
                    }
                }
                
                $retorno[] = $loteContribuinte;
            }
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao obter pagamento das receitas de benfeitorias: ". $erro->getMessage());
        }
        
        return $retorno;
    }
    
}