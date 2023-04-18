<?php

include_once 'template.php';
include_once 'classes/util/ImageUtil.php';

//diretório para salvar as imagens
$diretorio = "./img/fotos_loteamento/".$_GET['ano'];

//Verificar a existência do diretório para salvar as imagens e informa se o caminho é um diretório
if(!is_dir($diretorio)){ 
    echo "<script> 
            displayMessage('Pasta inválida!','Pasta invalida','error', 5);
            setTimeout(() => {
		      document.location.href='album?ano=".$_GET['ano'].";
	        }, 3000);
          </script>";
}else{    
    $arquivo = isset($_FILES['arquivo']) ? $_FILES['arquivo'] : FALSE;
    //loop para ler as imagens
    
    $enviouFotos = false;

    for ($controle = 0; $controle < count($arquivo['name']); $controle++){        
        $destino = $diretorio."/".$arquivo['name'][$controle];
        //realizar o upload da imagem em php
        //move_uploaded_file — Move um arquivo enviado para uma nova localização
        if(move_uploaded_file($arquivo['tmp_name'][$controle], $destino)){
            $enviouFotos = true;
            ImageUtil::convertToWebp($destino, $diretorio, $arquivo['name'][$controle]);
            unlink($destino);
        }else{
            $enviouFotos = false;
        }        
    }

    if($enviouFotos){
        echo "<script>
                    displayMessage('Arquivo envido com sucesso!','Foto enviada','success', 5);
                    setTimeout(() => {
                        document.location.href='album?ano=".$_GET['ano']."';
        	        }, 3000);
                  </script>";
    } else {
        echo "<script>
                    displayMessage('Não foi possível enviar a foto!','Foto não enviada','error', 5);
                    setTimeout(() => {
                        document.location.href='album?ano=".$_GET['ano']."';
        	        }, 3000);
                  </script>";
    }
}
?>

<?php include_once 'footer.php'; ?>