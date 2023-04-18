<?php
include_once 'template.php';
require_once 'classes/application_config.php';
require_once 'classes/dao/ServicoMaterialDAO.php';
require_once 'classes/dao/ReviewDAO.php';

$id = $_GET['id'];

$servicoMaterial = ServicoMaterialDAO::getInstancia()->obterDetalheServicoMaterial($id);

$reviews = ReviewDAO::getInstancia()->obterReviewsServicoMaterial($id);

?>

<div id="common-home" class="container">
  <p></p>
	<div class="row">
		<div id="content" class="col-sm-12">

			<div class="row">
				<div class='col-sm-1'>
					<button type="button" class="btn btn-success" onclick="javascript:history.back();">Voltar</button>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-8">
					<h3><?php echo $servicoMaterial->getTitulo() ; ?></h3>
					<div id="resumo">
						<label><?php echo $servicoMaterial->getTexto(); ?></label>
					</div>
				</div>
			</div>
			
			<br><br>
			<hr>
			
			<div class="row">
				<div class="col-sm-8">
				
        			<ul class="nav nav-tabs">
        				<li class="active"><a href="#tab-review" data-toggle="tab">Comentários (<?php  echo count($reviews);?>)</a></li>
        			</ul>
        			<div class="tab-pane" id="tab-review">
        				<form class="form-horizontal" id="form-review">
        					<div id="review">
        
        						<?php  if(count($reviews) == 0) { ?>
        							<p>Não há comentários para este serviço / material.</p>
        						<?php } else { ?>
        
        							<table class="table table-striped table-bordered">
        								<tbody>
        									<?php 
        										foreach ($reviews as $review) {												
        									?>
        											<tr>
        												<td style="width: 50%;"><strong><?php  echo $review->getAutor(); ?></strong></td>
        												<td class="text-right"><?php  echo $review->getData(); ?></td>
        											</tr>
        											<tr>
        												<td colspan="2">
        													<p><?php  echo $review->getTexto(); ?></p>
        					
        													<?php  for($i =1; $i <= 5; $i++) { ?>                                  
        														<span class="fa fa-stack">
        															<?php if($i <= $review->getRating()) { ?>
        																<i class="fa fa-star fa-stack-2x"></i>
        															<?php } ?>
        															<i class="fa fa-star-o fa-stack-2x"></i>
        														</span>
        													<?php } ?>
        
        
        												</td>
        											</tr>
        								  <?php } ?>
        								</tbody>
        							</table>
        						<?php } ?>
        					</div>
        					<h2>Escreva um comentário</h2>
        					<div id="joinToComment" style="display : none;">
        						Você deve <a href="customer-login">acessar</a>
        						ou <a href="register">cadastrar-se</a> para comentar.
        					</div>
        					<div id="customerCommentLogged" style="display : none;">
        						<div class="alert alert-danger alert-dismissible" id="commentSendAlert" style="display : none;">
        								<i class="fa fa-exclamation-circle"></i> 
        								<span id="commentAlertMessage"></span>
        						</div>
        						<div class="alert alert-success alert-dismissible" id="commentSendSuccess" style="display : none;">
        							<i class="fa fa-check-circle"></i> Obrigado por seu comentário.
        						</div>
        						<div class="form-group required">
        							<div class="col-sm-12">
        								<label class="control-label" for="customerNameComment">Seu nome</label>
        								<input type="text" id="customerNameComment" value="" class="form-control" disabled>
        							</div>
        						</div>
        						
        						<div class="form-group required">
              						<div class="col-sm-12">
                						<label class="control-label" for="customerReview">Seu comentário</label>
                						<textarea name="text" rows="5" id="customerReview" class="form-control"></textarea>
                						<div class="help-block">
        									<span class="text-danger">Nota:</span> HTML não suportado.
        								</div>
              						</div>
            					</div>
            					<div class="form-group required">
        							<div class="col-sm-12">
        								<label class="control-label">Avaliação</label>
        								&nbsp;&nbsp;&nbsp; Ruim&nbsp;
        								<input type="radio" name="rating" value="1">
        								&nbsp;
        								<input type="radio" name="rating" value="2">
        								&nbsp;
        								<input type="radio" name="rating" value="3">
        								&nbsp;
        								<input type="radio" name="rating" value="4">
        								&nbsp;
        								<input type="radio" name="rating" value="5">
        								&nbsp;Bom</div>
        							</div>
            						<div class="buttons clearfix">
              						<div class="pull-right">
                						<button type="button" id="button-review" class="btn btn-primary" onclick="sendComment(<?php echo $id; ?>);">Enviar Comentário</button>
              						</div>
            					</div>
        					</div>
        				</form>
        			</div>
        			
				</div>
			</div>
			
		</div>
	</div>
</div>

<script>
	togleCustomerComments();
    register('<?php echo $_SERVER['REQUEST_URI']; ?>');
</script>

<?php include_once 'footer.php'; ?>