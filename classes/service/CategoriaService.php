<?php 

require_once 'classes/util/Log4Php.php';
require_once 'classes/application_config.php';
require_once 'classes/dao/CategoriaDAO.php';
require_once 'classes/dto/CategoriaDTO.php';
require_once 'classes/dto/SubCategoriaDTO.php';


class CategoriaService {
    
    public static $instancia = null;
    
    public static function getInstancia() {
        
        if (self::$instancia == NULL) {
            self::$instancia = new CategoriaService();
        }
        return self::$instancia;
    }
    
    private function __construct() {}
    
    
    public function obterCategoriasAtivas(){
        
        $retorno = array();
        
        try {
            
            $categoriasPai = 
                CategoriaDAO::getInstancia()->obterTodasCategoriasAtivas(0);
            
            foreach ( $categoriasPai as $catPai ){
            
                $categoriaPaiDTO = new CategoriaDTO();
                $categoriaPaiDTO->setId($catPai->getId());
                $categoriaPaiDTO->setNome($catPai->getNome());
                $categoriaPaiDTO->setPage($catPai->getPage());
                
                $catFilhas = array();
                $categoriasFilhas = 
                    CategoriaDAO::getInstancia()->obterTodasCategoriasAtivas($catPai->getId());
                
                foreach ($categoriasFilhas as $catFilha){
                    $subCategoria = new SubCategoriaDTO();
                    $subCategoria->setId($catFilha->getId());
                    $subCategoria->setNome($catFilha->getNome());
                    $subCategoria->setPage($catFilha->getPage());
                    
                    $catFilhas[] = $subCategoria;
                }
                
                $categoriaPaiDTO->setSubCategorias($catFilhas);
                
                $retorno[] = $categoriaPaiDTO;
            }
                
            
        } catch (Exception $e){
            Log4Php::logarFatal("Erro ao obter as categorias ativas: ". $e->getMessage());
            throw $e;
        }
        
        return $retorno;
    }
}

