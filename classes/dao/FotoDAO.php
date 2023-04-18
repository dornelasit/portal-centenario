<?php
require_once 'DAO.php';
require_once 'classes/application_config.php';
require_once 'classes/dto/FotoDTO.php';

class FotoDAO extends DAO {
    
    public static $instancia = null;
    
    public static function getInstancia() {
        
        if (self::$instancia == NULL) {
            self::$instancia = new FotoDAO();
        }
        return self::$instancia;
    }
    
    private function __construct() {}
    
    
    public function obterPastasAlbum(){
        
        $retorno = array();
        
        try {
            
            $dirs = array_diff(scandir(DIRETORIO_RAIZ_ALBUM), array('..', '.'));
            
            foreach($dirs as $dir) {
                
                $albumAno = new FotoDTO();
                $albumAno->setAno($dir);
                $primeiraFoto = self::obterPrimeiraFotoAno($dir);
                if(!isset($primeiraFoto)){
                    $albumAno->setFotoPrincipal("./img/semfoto.jpg");
                } else {
                    $albumAno->setFotoPrincipal(DIRETORIO_RAIZ_ALBUM."/".$dir."/".$primeiraFoto);
                }
                
                $retorno [] = $albumAno;
            }
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao obter fotos: ". $erro->getMessage());
        }
        
        return $retorno;
    }
    
    
    public function obterFotosAno($ano){
        
        $retorno = array();
        
        try {
            
            $files = array_diff(scandir(DIRETORIO_RAIZ_ALBUM."/".$ano), array('..', '.'));
            
            foreach($files as $file) {
                
                $fotoVideo = new FotoDTO();
                $fotoVideo->setAno($ano);
                $fotoVideo->setFotoPrincipal(DIRETORIO_RAIZ_ALBUM."/".$ano."/". $file);
                
                $ext = pathinfo($file, PATHINFO_EXTENSION);
                
                if(strcmp($ext, "mp4") == 0){
                    $fotoVideo->setIsVideo(true);
                } else {
                    $fotoVideo->setIsVideo(false);
                }
                
                $retorno [] = $fotoVideo;
            }
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao obter fotos: ". $erro->getMessage());
        }
        
        return $retorno;
        
    }
    
    private function obterPrimeiraFotoAno($ano){
        
        $primeiraFoto = null;
        
        $scan = array_diff(scandir(DIRETORIO_RAIZ_ALBUM."/".$ano), array('..', '.'));
        
        foreach($scan as $file) {
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            if(strcmp($ext, "mp4") == 0){
                continue;
            }
            $primeiraFoto = $file;
            break;
        }
        return $primeiraFoto;
    }
    
}