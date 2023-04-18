<?php
include_once 'template.php';
require_once 'classes/application_config.php';
require_once 'classes/dao/ServicoMaterialDAO.php';

$termo = null;

if(isset($_GET['q'])){
    $termo = $_GET['q'];
}

$servicosMateriais = null;

if(isset($termo)){
    $servicosMateriais = ServicoMaterialDAO::getInstancia()->obterServicoMaterial($termo);
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
			<a href="servicos-materiais">Serviços e Materiais</a>
		</li>		
	</ul>
  	<p></p>
    <h2>Pesquisa de Serviço ou Material</h2>
	<div class="row">
		<div id="content" class="col-sm-12">

			<div id="showifServicoMaterial" style="display : none;">
				
				<div class="modal fade" id="modal-novaindicacao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limparDadosModalIndicacao();">×</button>
									<h4 class="modal-title">Informe os dados da Indicação</h4>
								</div>
								<div class="modal-body">
									<form>
										<div class="form-group">
											<label for="tituloNovaIndicacao">Título</label>
											<input type="text" class="form-control" id="tituloNovaIndicacao" placeholder="Insira uma breve descrição do serviço ou material..." maxlength="150" required/>
										</div>
										<div class="form-group">
											<label for="descricaoNovaIndicacao" class="col-form-label">Descrição:</label>
											<textarea placeholder="Insira um texto descrevendo e os dados para contato. Se possível, informe os valores para facilitar a pesquisa de outras pessoas..." class="form-control" id="descricaoNovaIndicacao" rows="5" required></textarea>
										</div>
									</form>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-primary"   id="btn-salvar" onclick="inserirIndicacao();">Salvar</button>
									<button type="button" class="btn btn-secondary" id="btn-fechar" data-dismiss="modal" onclick="limparDadosModalIndicacao();">Fechar</button>
								</div>
							</div>
						</div>
					</div>

					<div class="row" id="div-inserir-indicacao" style="display: none;">
						<div class="col-sm-3">
							<input type="button" class="btn btn-primary" value="Inserir Nova Indicação" title="Clique aqui para inserir uma nova indicação de Serviço ou Material" data-toggle="modal" data-target="#modal-novaindicacao" data-backdrop="static" data-keyboard="false"/>
						</div>
					</div>
					<div id="join-to-indicate" style="display : none;">
						Você deve <a href="customer-login">acessar</a>
						ou <a href="register">cadastrar-se</a> para fazer uma indicação.
					</div>
					<br/>
					<div class="row">
						<form action="servicos-materiais" method="get">
							<div class="col-sm-5">
								<div id="search">
									<input type="text" id="search-bar" name='q' value="<?php echo $termo ; ?>" placeholder="Digite o que está procurando ou apenas aperte o botão Pesquisar..." class="form-control input-lg" autocomplete="off">							
								</div>
							</div>
							<div class='col-sm-5'>
								<button type="submit" class="btn btn-success" style="margin-top: 4px;">Pesquisar</button>						
							</div>
						</form>
					</div>

					<?php 
					if(isset($servicosMateriais) && count($servicosMateriais) > 0){
					?>
						<h3>Resultados da busca por: <span style="color: #3c9725;font-weight: bold;"><?php echo $termo ; ?></span> </h3>
						
						<?php
						foreach ($servicosMateriais as $servicoMaterial){
						?>
						
						<hr/>
						<div class="row">
							<div class="col-sm-8">
								<a href="servicos-materiais-detalhe?id=<?php echo $servicoMaterial->getId() ; ?>">
									<span style="font-size: 16px;"><?php echo $servicoMaterial->getTitulo() ; ?></span>
								</a>
								<div id="resumo">
									<label><?php echo $servicoMaterial->getTexto(); ?></label>
								</div>
								<div id="rating">
									<?php if($servicoMaterial->getNota() > 0) { ?>
										<div class="rating">    
											<?php  for($i =1; $i <= 5; $i++) { ?>                                  
												<span class="fa fa-stack">
													<?php if($i <= $servicoMaterial->getNota()) { ?>
														<i class="fa fa-star fa-stack-2x"></i>
													<?php } ?>
													<i class="fa fa-star-o fa-stack-2x"></i>
												</span>
											<?php } ?>
										</div>
									<?php } ?>
								</div>
								<div id="data">
									<label style="font-size: 9px;">Criado em: <?php echo $servicoMaterial->getData(). " por : ". $servicoMaterial->getUser() ; ?> </label>
								</div>
							</div>
						</div>
						
						<?php 
						}
						
					} else if(isset($termo)) {
					?>
						<h3>Nenhum resultado na sua busca por: <span style="color: #3c9725;font-weight: bold;"><?php echo $termo ; ?></span></h3>
					<?php 
					} 
					?>
				
			</div>
			<div id="showifServicoMaterial-nc" style="display : none;">
				<h3 style="color: #3c9725;">Essa funcionalidade é habilitada apenas para os lotes contribuintes.</h3>
			</div>
			<div id="joinSystem" style="display : none;">
				Você deve <a href="customer-login">acessar</a>
				ou <a href="register">cadastrar-se</a> para prosseguir.
			</div>
			<br/>
		</div>
	</div>
</div>

<script>
	verifyContribui("showifServicoMaterial");
	displayIndicacao();
    register('<?php echo $_SERVER['REQUEST_URI']; ?>');
	document.getElementById("search-bar").focus();
</script>

<?php include_once 'footer.php'; ?>