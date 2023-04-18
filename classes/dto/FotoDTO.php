<?php

class FotoDTO {
    
    private $ano;
    
    private $fotoPrincipal;
    
    private $isVideo;
    
    /**
     * @return mixed
     */
    public function getIsVideo()
    {
        return $this->isVideo;
    }

    /**
     * @param mixed $isVideo
     */
    public function setIsVideo($isVideo)
    {
        $this->isVideo = $isVideo;
    }

    /**
     * @return mixed
     */
    public function getAno()
    {
        return $this->ano;
    }

    /**
     * @return mixed
     */
    public function getFotoPrincipal()
    {
        return $this->fotoPrincipal;
    }

    /**
     * @param mixed $ano
     */
    public function setAno($ano)
    {
        $this->ano = $ano;
    }

    /**
     * @param mixed $fotoPrincipal
     */
    public function setFotoPrincipal($fotoPrincipal)
    {
        $this->fotoPrincipal = $fotoPrincipal;
    }
    
    function serialize(){
        return json_encode(get_object_vars($this));
    }
    
}