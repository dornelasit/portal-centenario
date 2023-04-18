<?php


class TransparenciaDTO {
    
    private $competencia;
    private $valorTotalReceita;
    private $valorTotalDespesa;
    
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
    public function getValorTotalReceita()
    {
        return $this->valorTotalReceita;
    }

    /**
     * @return mixed
     */
    public function getValorTotalDespesa()
    {
        return $this->valorTotalDespesa;
    }

    /**
     * @param mixed $competencia
     */
    public function setCompetencia($competencia)
    {
        $this->competencia = $competencia;
    }

    /**
     * @param mixed $valorTotalReceita
     */
    public function setValorTotalReceita($valorTotalReceita)
    {
        $this->valorTotalReceita = $valorTotalReceita;
    }

    /**
     * @param mixed $valorTotalDespesa
     */
    public function setValorTotalDespesa($valorTotalDespesa)
    {
        $this->valorTotalDespesa = $valorTotalDespesa;
    }
    
    function serialize(){
        return json_encode(get_object_vars($this));
    }
}