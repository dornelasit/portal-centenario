<?php


class LoteDTO {
    
    private $id;
    
    private $nomeProprietario;
    
    private $telefone;
    
    private $contribui;
    
    private $construindo;
    
    private $construido;
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
    public function getNomeProprietario()
    {
        return $this->nomeProprietario;
    }

    /**
     * @return mixed
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * @return mixed
     */
    public function getContribui()
    {
        return $this->contribui;
    }

    /**
     * @return mixed
     */
    public function getConstruindo()
    {
        return $this->construindo;
    }

    /**
     * @return mixed
     */
    public function getConstruido()
    {
        return $this->construido;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $nomeProprietario
     */
    public function setNomeProprietario($nomeProprietario)
    {
        $this->nomeProprietario = $nomeProprietario;
    }

    /**
     * @param mixed $telefone
     */
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

    /**
     * @param mixed $contribui
     */
    public function setContribui($contribui)
    {
        $this->contribui = $contribui;
    }

    /**
     * @param mixed $construindo
     */
    public function setConstruindo($construindo)
    {
        $this->construindo = $construindo;
    }

    /**
     * @param mixed $construido
     */
    public function setConstruido($construido)
    {
        $this->construido = $construido;
    }

}