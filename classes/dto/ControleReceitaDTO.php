<?php

class ControleReceitaDTO {
    
    private $pago;
    private $numeroLote;
    private $nome;
    private $dataPagamento;
    private $valorPago;
    private $corLinha;
    
    /**
     * @return mixed
     */
    public function getCorLinha()
    {
        return $this->corLinha;
    }

    /**
     * @param mixed $corLinha
     */
    public function setCorLinha($corLinha)
    {
        $this->corLinha = $corLinha;
    }

    /**
     * @return mixed
     */
    public function getPago()
    {
        return $this->pago;
    }

    /**
     * @return mixed
     */
    public function getNumeroLote()
    {
        return $this->numeroLote;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @return mixed
     */
    public function getDataPagamento()
    {
        return $this->dataPagamento;
    }

    /**
     * @return mixed
     */
    public function getValorPago()
    {
        return $this->valorPago;
    }

    /**
     * @param mixed $pago
     */
    public function setPago($pago)
    {
        $this->pago = $pago;
    }

    /**
     * @param mixed $numeroLote
     */
    public function setNumeroLote($numeroLote)
    {
        $this->numeroLote = $numeroLote;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @param mixed $dataPagamento
     */
    public function setDataPagamento($dataPagamento)
    {
        $this->dataPagamento = $dataPagamento;
    }

    /**
     * @param mixed $valorPago
     */
    public function setValorPago($valorPago)
    {
        $this->valorPago = $valorPago;
    }
    
}