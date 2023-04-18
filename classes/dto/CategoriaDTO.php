<?php

/**
 * Classe que representa uma categoria no menu do portal
 * 
 * @author Andre Dornelas
 * @version 12/12/2022
 *
 */
class CategoriaDTO {
    
    private $id;
    
    private $nome;
    
    private $page;
    
    private $subCategorias;
    /**
     * @return mixed
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param mixed $page
     */
    public function setPage($page)
    {
        $this->page = $page;
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
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @return mixed
     */
    public function getSubCategorias()
    {
        return $this->subCategorias;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @param mixed $subCategorias
     */
    public function setSubCategorias($subCategorias)
    {
        $this->subCategorias = $subCategorias;
    }
    
    function serialize(){
        return json_encode(get_object_vars($this));
    }
    
}