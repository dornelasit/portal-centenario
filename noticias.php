<?php
include_once 'template.php';
require_once 'classes/application_config.php';
require_once 'classes/dao/NoticiaDAO.php';

$noticias = NoticiaDAO::getInstancia()->obterTodasNoticias();

?>

<div id="common-home" class="container">
	<ul class="breadcrumb">
		<li>
			<a href="">
				<i class="fa fa-home"></i>
			</a>
		</li>
		<li>
			<a href="noticias">Notícias</a>
		</li>		
	</ul>
  	<p></p>
    <h2>Notícias</h2>
	<div class="row">
		<div id="content" class="col-sm-12">
			<?php if(count($noticias) > 0) { ?> 

				<div class="row">
					<?php foreach ($noticias as $noticia) { ?> 
						<div  class="product-layout col-lg-3 col-md-3 col-sm-6 col-xs-6">
							<div class="product-thumb transition">
								<div class="image">
									<a href="noticia-page?id=<?php echo $noticia->getId(); ?>">
										<img src="<?php echo $noticia->getFoto(); ?>" alt="<?php echo $noticia->getTitulo(); ?>" title="<?php echo $noticia->getTitulo(); ?>" 
											class="img-responsive" style="height:170px; width:269px;">
									</a>
								</div>
								<div class="caption">
									<h4 style="min-height: 30px;">
										<a href="noticia-page?id=<?php echo $noticia->getId(); ?>"><?php echo $noticia->getTitulo(); ?></a>
									</h4>
									
									<div id="dataNoticia" style="min-height: 31px;">
										<h5 style="color : #959595;font-weight: bold;"><?php echo $noticia->getData(); ?></h5>                                     
									</div>
									
									<div>
										<a href="noticia-page?id=<?php echo $noticia->getId(); ?>" target="_self" class="readmorebtn">Continuar Lendo</a>
									</div>
								</div>
							</div>
						</div>
				<?php } ?>
            	</div>
				
			<?php } else { ?>	
				<h4>Nenhuma notícia</h4>
			<?php } ?>	
		</div>
	</div>		
</div>

<script>
    register('<?php echo $_SERVER['REQUEST_URI']; ?>');
</script>

<?php include_once 'footer.php'; ?>