<?php
require_once 'DAO.php';
require_once 'classes/application_config.php';
require_once 'classes/dto/NoticiaDTO.php';

class NoticiaDAO extends DAO {
    
    public static $instancia = null;
    
    public static function getInstancia() {
        
        if (self::$instancia == NULL) {
            self::$instancia = new NoticiaDAO();
        }
        return self::$instancia;
    }
    
    private function __construct() {}
    
    
    public function obterTodasNoticias(){
        
        $retorno = array();
        
        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "SELECT id, titulo, conteudo, date_format(data_noticia,'%d/%m/%Y - %T') AS data_noticia, url_foto_noticia FROM noticia ORDER BY data_noticia DESC";
            
            $stm = $pdo->query($sql);
            
            if ($stm->rowCount() > 0) {
                
                while ($linha = $stm->fetch(PDO::FETCH_ASSOC)) {
                    $noticia = new NoticiaDTO();
                    $noticia->setId($linha['id']);
                    $noticia->setTitulo($linha['titulo']);
                    $noticia->setConteudo($linha['conteudo']);
                    $noticia->setData($linha['data_noticia']);
                    $noticia->setFoto($linha['url_foto_noticia']);
                    
                    $retorno[] = $noticia;
                }
            }
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao obter noticias: ". $erro->getMessage());
        }
        
        return $retorno;
        
    }

    public function obterUltimasNoticias(){
        
        $retorno = array();
        
        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "SELECT id, titulo, conteudo, date_format(data_noticia,'%d/%m/%Y - %T') AS data_noticia, url_foto_noticia FROM noticia ORDER BY data_noticia DESC LIMIT 30";
            
            $stm = $pdo->query($sql);
            
            if ($stm->rowCount() > 0) {
                
                while ($linha = $stm->fetch(PDO::FETCH_ASSOC)) {
                    $noticia = new NoticiaDTO();
                    $noticia->setId($linha['id']);
                    $noticia->setTitulo($linha['titulo']);
                    $noticia->setConteudo($linha['conteudo']);
                    $noticia->setData($linha['data_noticia']);
                    $noticia->setFoto($linha['url_foto_noticia']);
                    
                    $retorno[] = $noticia;
                }
            }
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao obter noticias: ". $erro->getMessage());
        }
        
        return $retorno;
        
    }

    public function obterNoticiaPorId($id){

        $retorno = null;

        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "SELECT id, titulo, conteudo, date_format(data_noticia,'%d/%m/%Y - %T') AS data_noticia, url_foto_noticia FROM noticia WHERE id = {$id}";
            
            $stm = $pdo->query($sql);
            
            if ($stm->rowCount() > 0) {
                
                if ($linha = $stm->fetch(PDO::FETCH_ASSOC)) {
                    $noticia = new NoticiaDTO();
                    $noticia->setId($linha['id']);
                    $noticia->setTitulo($linha['titulo']);
                    $noticia->setConteudo($linha['conteudo']);
                    $noticia->setData($linha['data_noticia']);
                    $noticia->setFoto($linha['url_foto_noticia']);
                    
                    $retorno = $noticia;
                }
            }
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao obter noticia: ". $erro->getMessage());
        }

        return $retorno;
    }
}