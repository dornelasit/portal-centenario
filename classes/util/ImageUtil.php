<?php
require_once 'classes/util/Log4Php.php';
require_once 'classes/application_config.php';

/**
 * Classe utilitaria para conversao de imagem
 
 * @author Andre Dornelas
 * @since 1.0
 * @version 27.01.2023
 *
 */
class ImageUtil {
    
    public static function convertToWebp($sourcePath, $dirDestination, $fileNameDestination){
        $retorno = "";
        try {
            
            $jpg=imagecreatefromjpeg($sourcePath);
            $w=imagesx($jpg);
            $h=imagesy($jpg);
            $webp=imagecreatetruecolor($w,$h);
            imagecopy($webp,$jpg,0,0,0,0,$w,$h);
            imagewebp($webp, $dirDestination."/".$fileNameDestination.'.webp', 80);
            imagedestroy($jpg);
            imagedestroy($webp);
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao converter imagem: ". $erro->getMessage());
        }
        return $retorno;
    }

}

