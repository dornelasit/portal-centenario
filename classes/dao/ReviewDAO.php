<?php
require_once 'DAO.php';
require_once 'classes/application_config.php';
require_once 'classes/dto/ReviewDTO.php';

class ReviewDAO extends DAO {
    
    public static $instancia = null;
    
    public static function getInstancia() {
        
        if (self::$instancia == NULL) {
            self::$instancia = new ReviewDAO();
        }
        return self::$instancia;
    }
    
    private function __construct() {}
    
    public function obterReviewsServicoMaterial($id){
        
        $retorno = array();
        
        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "SELECT id, id_servicomaterial, user_id, author, text, rating, status, date_format(date_added,'%d/%m/%Y - %T') AS data FROM review_servicomaterial WHERE id_servicomaterial = {$id} ORDER BY date_added DESC";
            
            $stm = $pdo->query($sql);
            
            if ($stm->rowCount() > 0) {
                
                while ($linha = $stm->fetch(PDO::FETCH_ASSOC)) {
                    $review = new ReviewDTO();
                    $review->setId($linha['id']);
                    $review->setAutor($linha['author']);
                    $review->setTexto($linha['text']);
                    $review->setRating($linha['rating']);
                    $review->setData($linha['data']);
                    
                    $retorno[] = $review;
                }
            }
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao obter reviews: ". $erro->getMessage());
        }
        return $retorno;
    }

    public function inserirReview($idServico, $userId,$autor,$texto,$rating){

        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "INSERT INTO review_servicomaterial (id_servicomaterial,user_id,author,text,rating,status,date_added) VALUES ({$idServico},{$userId},'{$autor}','{$texto}', {$rating}, 1, now())";
            
            $pdo->exec($sql);

        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao gerar review: ". $erro->getMessage());
        }

    }

    public function calcularReview($idServicoMaterial){

        $retorno = 0;

        $qtd = 0;
        $soma = 0;

        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "SELECT COUNT(*) AS qtd, SUM(r.rating) AS soma FROM review_servicomaterial r WHERE r.id_servicomaterial = {$idServicoMaterial} AND r.status = 1";
            
            $stm = $pdo->query($sql);
            
            if ($stm->rowCount() > 0) {
                
                if ($linha = $stm->fetch(PDO::FETCH_ASSOC)) {
                    $qtd  = intval($linha['qtd']);
                    $soma = intval($linha['soma']);                    
                }
            }

            if($qtd != 0 && $soma != 0){
                $retorno = intval($soma / $qtd);
            }
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao obter qtd review do servico / material: ". $erro->getMessage());
        }

        return $retorno;
    }

}