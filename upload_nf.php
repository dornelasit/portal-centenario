<?php

include_once 'template.php';
include_once 'classes/application_config.php';
include_once 'classes/dao/BenfeitoriaDAO.php';
include_once 'classes/util/Log4Php.php';


    try {
    
        $competencia = $_POST['comp'];
        
        $idBenfeitoria = $_POST['idBenfeitoria'];
        
        $file_form = 'arquivo_'.$idBenfeitoria;
        
        if (isset($_FILES[$file_form])){
            
            $file_name = $_FILES[$file_form]['name'];
            
            if(strlen($file_name) > 0){
            
                $file_tmp = $_FILES[$file_form]['tmp_name'];
                
                move_uploaded_file($file_tmp, DIRETORIO_RAIZ_NF.$file_name);
                
                BenfeitoriaDAO::getInstancia()->gravarNotaFiscalBenfeitoria($idBenfeitoria, $file_name);
                
                echo "<script>
                        document.location.href='admin-controle-receita-benfeitoria?comp=".$competencia."';
                      </script>";
            } else {
                echo "<script>
                    displayMessage('Nenhum arquivo selecionado!','NF não enviada','error', 5);
                    setTimeout(() => {
                        document.location.href='admin-controle-receita-benfeitoria?comp=".$competencia."';
        	        }, 3000);
                  </script>";
            }
        
        } else {
            echo "<script>
                    displayMessage('Não foi possível enviar a NF!','NF não enviada','error', 5);
                    setTimeout(() => {
                        document.location.href='admin-controle-receita-benfeitoria?comp=".$competencia."';
        	        }, 3000);
                  </script>";
        }
        
    } catch (Exception $erro){
        Log4Php::logarFatal("Erro ao inserir nota fiscal da benfeitoria: ". $erro->getMessage());
    }
?>

<?php include_once 'footer.php'; ?>