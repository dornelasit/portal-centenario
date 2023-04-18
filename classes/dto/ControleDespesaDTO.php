<?php

class ControleDespesaDTO {
    
    private $id;
    private $competencia;
    private $descricao;
    private $dataDespesa;
    private $valorDespesa;
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCompetencia()
    {
        return $this->competencia;
    }

    /**
     * @return mixed
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @return mixed
     */
    public function getDataDespesa()
    {
        return $this->dataDespesa;
    }

    /**
     * @return mixed
     */
    public function getValorDespesa()
    {
        return $this->valorDespesa;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $competencia
     */
    public function setCompetencia($competencia)
    {
        $this->competencia = $competencia;
    }

    /**
     * @param mixed $descricao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    /**
     * @param mixed $dataDespesa
     */
    public function setDataDespesa($dataDespesa)
    {
        $this->dataDespesa = $dataDespesa;
    }

    /**
     * @param mixed $valorDespesa
     */
    public function setValorDespesa($valorDespesa)
    {
        $this->valorDespesa = $valorDespesa;
    }

    function serialize(){
        return json_encode(get_object_vars($this));
    }
}