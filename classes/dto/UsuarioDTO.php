<?php

class UsuarioDTO {
    
    private $id;
    private $perfil;
    private $senha;
    private $nome;
    private $numeroLote;
    private $email;
    private $celular;
    private $contribui;
    private $contribuicoesBenfeitorias;

    /**
     * @return mixed
     */
    public function getContribuicoesBenfeitorias()
    {
        return $this->contribuicoesBenfeitorias;
    }

    /**
     * @param mixed $contribuicoesBenfeitorias
     */
    public function setContribuicoesBenfeitorias($contribuicoesBenfeitorias)
    {
        $this->contribuicoesBenfeitorias = $contribuicoesBenfeitorias;
    }

    /**
     * @return mixed
     */
    public function getContribui()
    {
        return $this->contribui;
    }

    /**
     * @param mixed $contribui
     */
    public function setContribui($contribui)
    {
        $this->contribui = $contribui;
    }

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
    public function getPerfil()
    {
        return $this->perfil;
    }

    /**
     * @return mixed
     */
    public function getSenha()
    {
        return $this->senha;
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
    public function getNumeroLote()
    {
        return $this->numeroLote;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $perfil
     */
    public function setPerfil($perfil)
    {
        $this->perfil = $perfil;
    }

    /**
     * @param mixed $senha
     */
    public function setSenha($senha)
    {
        $this->senha = $senha;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @param mixed $numeroLote
     */
    public function setNumeroLote($numeroLote)
    {
        $this->numeroLote = $numeroLote;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param mixed $celular
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;
    }
    
    function serialize(){
        return json_encode(get_object_vars($this));
    }

}