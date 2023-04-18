<?php 
    require_once 'classes/service/CategoriaService.php';
    
    $categorias = CategoriaService::getInstancia()->obterCategoriasAtivas();
    
?>
<div class="container">
	<nav id="menu" class="navbar">
		<div class="navbar-header">
			<span id="category" class="visible-xs">Menu</span>
			<button type="button" class="btn btn-navbar navbar-toggle"
				data-toggle="collapse" data-target=".navbar-ex1-collapse">
				<i class="fa fa-bars"></i>
			</button>
		</div>
		<div class="collapse navbar-collapse navbar-ex1-collapse">
			<ul class="nav navbar-nav">
				<li>
					<a href="">Home</a>
				</li>
				<?php 
				foreach ($categorias as $category){                    
                			
                    if(count($category->getSubCategorias()) > 0){ ?>
                		<li class="dropdown">
                            <a href="<?php echo $category->getPage(); ?>" class="dropdown-toggle" data-toggle="dropdown"><?php echo $category->getNome() ?></a>
            				<div class="dropdown-menu">
                                <div class="dropdown-inner">               
                                    <ul class="list-unstyled">
                                    	<?php 
                                    	   foreach ($category->getSubCategorias() as $subCategory){                    
                                        ?>
                                        <li>
                                            <a href="<?php echo $category->getPage(); ?>"><?php echo $subCategory->getNome(); ?></a>
                                        </li> 
                                        <?php } ?>                   
                                    </ul>
                                </div>
                            </div>
        				</li>
				<?php } else { ?>
						<li>
							<a href="<?php echo $category->getPage(); ?>"><?php echo $category->getNome() ?></a>
						</li>
				<?php } ?>
			<?php }?>				
			</ul>
		</div>
	</nav>
</div>