<?php
include_once 'template.php';
require_once 'classes/application_config.php';
require_once 'classes/dao/FotoDAO.php';

$ano = $_GET['ano'];

$fotosVideo = null;

if(isset($ano)){
    $fotosVideo = FotoDAO::getInstancia()->obterFotosAno($ano);
}

?>

<div id="common-home" class="container">
	<ul class="breadcrumb">
		<li>
			<a href="">
				<i class="fa fa-home"></i>
			</a>
		</li>
		<li>
			<a href="fotos">Fotos do Bairro</a>
        </li>
        <li><?php echo $ano; ?></li>
	</ul>
  	<p></p>
	<div class="row">
		<div id="content" class="col-sm-12">
		
		    <div class="row" id="panel-upload-fotos" style="display: none;">
                <div class="col-sm-12">
                    <div class="well">
                        <h2>Envie fotos para o álbum do ano <?php echo $ano; ?></h2>
                        <form enctype="multipart/form-data" method="POST" action="upload_fotos?ano=<?php echo $ano; ?>">
                            <input type="file" name="arquivo[]" multiple="multiple" accept="image/*" /><br><br>
                            <input name="enviar" type="submit" value="Enviar">
                        </form>
                    </div>
                </div>
			</div>
			
			<h2>Fotos do Ano <?php echo $ano; ?></h2>
			<br>
			<?php if(count($fotosVideo) > 0){?>
			<div class="row">
					<?php foreach($fotosVideo as $arquivo) { ?> 
						<div  class="product-layout col-lg-3 col-md-3 col-sm-6 col-xs-6">
							<div class="product-thumb transition">
								<div class="image">
									<?php if($arquivo->getIsVideo()){  ?>
										<video src="<?php echo $arquivo->getFotoPrincipal(); ?>" class="img-responsive" style="height:170px; width:269px;" controls/>									    
									<?php } else { ?>
										<a href="<?php echo $arquivo->getFotoPrincipal(); ?>" target="_blank">
									   		<img src="<?php echo $arquivo->getFotoPrincipal(); ?>" class="img-responsive" style="height:170px; width:269px;"/>
									    </a>
									<?php } ?>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
			<?php } else { ?>
			    <div class="row">
                    <div class="col-sm-12">
                        <h2 style="color: #3c9725;">Nenhuma foto no álbum para esse ano</h2>
                    </div>
                </div>
        	<?php } ?>
		
		</div>
	</div>
</div>

<<script type="text/javascript">
<!--
	togleUploadPhotos();
//-->
</script>

<?php include_once 'footer.php'; ?>