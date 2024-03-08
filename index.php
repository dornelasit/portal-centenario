<?php 
    include_once 'template.php';
    require_once 'classes/application_config.php';
    require_once 'classes/dao/NoticiaDAO.php';
    
    $noticias = NoticiaDAO::getInstancia()->obterUltimasNoticias();
?>

<div id="common-home" class="container">
  <p></p>
	<div class="row">
		<div id="content" class="col-sm-12">
			<div class="slideshow swiper-viewport">
				<div id="slideshow0" class="swiper-container swiper-container-horizontal">
					<div class="swiper-wrapper" style="transform: translate3d(-2324px, 0px, 0px); transition-duration: 0ms;">
						<div class="swiper-slide text-center swiper-slide-duplicate swiper-slide-duplicate-active" data-swiper-slide-index="1" style="width: 1132px; margin-right: 30px;">
							<img src="img/banner/banner1.jpg" class="img-responsive">
						</div>
                        <div class="swiper-slide text-center swiper-slide-prev swiper-slide-duplicate-next" data-swiper-slide-index="0" style="width: 1132px; margin-right: 30px;">
                        	<img src="img/banner/banner1.jpg" class="img-responsive">
                        </div>
        				<div class="swiper-slide text-center swiper-slide-duplicate swiper-slide-next swiper-slide-duplicate-prev" data-swiper-slide-index="0" style="width: 1132px; margin-right: 30px;">
        					<img src="img/banner/banner1.jpg" class="img-responsive">        					
        				</div>
        				
                        <div class="swiper-slide text-center swiper-slide-duplicate swiper-slide-duplicate-active" data-swiper-slide-index="1" style="width: 1132px; margin-right: 30px;">
                            <a href='noticia-page?id=1'>
                                <img src="img/banner/banner2.jpg" class="img-responsive">
                            </a>
						</div>
                        <div class="swiper-slide text-center swiper-slide-prev swiper-slide-duplicate-next" data-swiper-slide-index="0" style="width: 1132px; margin-right: 30px;">
                            <a href='noticia-page?id=1'>    
                                <img src="img/banner/banner2.jpg" class="img-responsive">
                            </a>
                        </div>
        				<div class="swiper-slide text-center swiper-slide-duplicate swiper-slide-next swiper-slide-duplicate-prev" data-swiper-slide-index="0" style="width: 1132px; margin-right: 30px;">
                            <a href='noticia-page?id=1'>    
                                <img src="img/banner/banner2.jpg" class="img-responsive">
                            </a>
        				</div>

                        <div class="swiper-slide text-center swiper-slide-duplicate swiper-slide-duplicate-active" data-swiper-slide-index="1" style="width: 1132px; margin-right: 30px;">
                            <a href='noticia-page?id=1'>
                                <img src="img/banner/banner3.jpg" class="img-responsive">
                            </a>
						</div>
                        <div class="swiper-slide text-center swiper-slide-prev swiper-slide-duplicate-next" data-swiper-slide-index="0" style="width: 1132px; margin-right: 30px;">
                            <a href='noticia-page?id=1'>    
                                <img src="img/banner/banner3.jpg" class="img-responsive">
                            </a>
                        </div>
        				<div class="swiper-slide text-center swiper-slide-duplicate swiper-slide-next swiper-slide-duplicate-prev" data-swiper-slide-index="0" style="width: 1132px; margin-right: 30px;">
                            <a href='noticia-page?id=1'>    
                                <img src="img/banner/banner3.jpg" class="img-responsive">
                            </a>
        				</div>
					</div>
				</div>
				<div class="swiper-pagination slideshow0 swiper-pagination-clickable swiper-pagination-bullets">
					<span class="swiper-pagination-bullet swiper-pagination-bullet-active"></span>
					<span class="swiper-pagination-bullet"></span>
				</div>
				<div class="swiper-pager">
					<div class="swiper-button-next"></div>
					<div class="swiper-button-prev"></div>
				</div>
			</div>
			<script type="text/javascript"><!--
  $('#slideshow0').swiper({
    mode: 'horizontal',
    slidesPerView: 1,
    pagination: '.slideshow0',
    paginationClickable: true,
    nextButton: '.slideshow .swiper-button-next',
    prevButton: '.slideshow .swiper-button-prev',
    spaceBetween: 30,
    autoplay: $('#slideshow0 img').length > 1 ? 2500 : 0,
    autoplayDisableOnInteraction: true,
    loop: true
  });
//--></script>

        <h2>Últimas Notícias</h2>

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
<?php } ?>
			
		</div>
	</div>
</div>

<script>
    register('<?php echo $_SERVER['REQUEST_URI']; ?>');
</script>

<?php include_once 'footer.php'; ?>