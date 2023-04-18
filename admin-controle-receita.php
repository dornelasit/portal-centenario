<?php
include_once 'template.php';
require_once 'classes/application_config.php';
require_once 'classes/dao/FinanceiroDAO.php';
require_once 'classes/dao/ParametroDAO.php';

$valorDefault = ParametroDAO::getInstancia()->obterValorParametro("VALOR_CONTRIBUICAO");

$mesAtual = new DateTime('now');
$mesAtual = $mesAtual->format('m/Y');

$proximoMes = new DateTime('now');
$proximoMes->modify('first day of next month');
$proximoMes = $proximoMes->format('m/Y');

$competencias = array();
$competencias[] = $mesAtual;
$competencias[] = $proximoMes;

$comp = 0;

if(isset($_GET['comp'])){
    $comp = $_GET['comp'];
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
			<a href="account">Minha Conta</a>
		</li>
		<li>
			<a href="admin-controle-receita">Controle de Receitas</a>
		</li>
	</ul>
  	<p></p>
	<div class="row">
		<div id="content" class="col-sm-12">
		
			<h2>Controle Receita</h2>
			<br/>
			
			<label>Competência:</label><br/>
    		<select class="form-select" aria-label=".form-select-sm example" id="selCompetencia" onchange="onSelectCompetenciaReceita();">
              <option value="0" <?php if($comp == '0'){ ?> selected <?php } ?>>Selecione o mês de referência...</option>
              <?php foreach ( $competencias as $competencia ) {
                  if($comp === $competencia){ ?>
              		<option selected value="<?php echo $competencia;?>"><?php echo $competencia;?></option>
              	  <?php } else { ?>
              	  	<option value="<?php echo $competencia;?>"><?php echo $competencia;?></option>
              	  <?php }  ?>
              <?php } ?>
            </select>
            
        	
        	<br/><br/>
        	
        	<?php 
        	if($comp != 0){
        	      
        	   $dadosCaixaCompetencia = FinanceiroDAO::getInstancia()->obterDadosReceitaPorCompetencia($comp);
			   $receitasExtras = FinanceiroDAO::getInstancia()->obterReceitasExtrasPorCompetencia($comp);
        	   
        	   $totalArrecadado = 0;
        	   $qtdFaltantes = 0;
        	   foreach ($dadosCaixaCompetencia as $valorLote){
        	       if($valorLote->getPago()){
        	           $totalArrecadado = $totalArrecadado + $valorLote->getValorPago();
        	       } else {
        	           $qtdFaltantes = $qtdFaltantes + 1;
        	       }
        	   }

			   foreach ($receitasExtras as $extra) { 
					$totalArrecadado = $totalArrecadado + $extra->valor;
				}
        	?>
				<div class="modal fade" id="modal-receitaextra" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limparDadosModalReceitaExtra();">×</button>
                        <h4 class="modal-title">Informe os dados da receita extra</h4>
                      </div>
                      <div class="modal-body">
                        <form>
                          <div class="form-group">
                            <label for="descricaoReceitaExtra" class="col-form-label">Descrição:</label>
                            <input type="text" class="form-control" id="descricaoReceitaExtra" maxlength="150"/>
                          </div>
                          <div class="form-group">
                            <label for="dataReceitaExtra" class="col-form-label">Data:</label>
                            <input type="date" class="form-control" id="dataReceitaExtra"/>
                          </div>
                          <div class="form-group">
                            <label for="valorReceitaExtra">Valor</label>
                            <input type="text" class="form-control dinheiro" id="valorReceitaExtra"  maxlength="10" />
                          </div>
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-primary"   id="btn-salvar-receitaextra" onclick="inserirReceitaExtra();">Salvar</button>
                        <button type="button" class="btn btn-secondary" id="btn-fechar-receitaextra" data-dismiss="modal" onclick="limparDadosModalReceitaExtra();">Fechar</button>
                      </div>
                    </div>
                  </div>
                </div>

        		<input type="button" style="background-color: #a6ffc1;" value="Inserir Receita Extra" data-toggle="modal" data-target="#modal-receitaextra" onclick="carregarModalReceitaExtra();" data-backdrop="static" data-keyboard="false"/>
        		<hr/>
        		Total Receita: <label>R$ <?php echo number_format($totalArrecadado,2,",","."); ?></label><br/>
				Contribuintes Restantes: <label><?php echo $qtdFaltantes;?> de <?php echo count($dadosCaixaCompetencia);?></label>
        		<br/><br/>
            	
				
    			
				<h3>Receitas dos lotes contribuintes</h3>
    			<div class="table-responsive">
    				<table class="table table-bordered table-hover">
    					<thead>
    						<tr>
    							<td class="text-center" style="background-color: #ebebeb;">Pago?</td>
    							<td class="text-center" style="background-color: #ebebeb;">Lote Nº</td>
    							<td class="text-center" style="background-color: #ebebeb;">Nome</td>
    							<td class="text-center" style="background-color: #ebebeb;">Data Pagto.</td>
    							<td class="text-center" style="background-color: #ebebeb;">Valor Pago</td>							
    						</tr>
    					</thead>
    					<tbody>
    						<?php 
    						foreach ($dadosCaixaCompetencia as $lote){
    						?>
    						<tr id="linha_<?php echo $lote->getNumeroLote(); ?>" style="background-color: <?php echo $lote->getCorLinha(); ?>">
    							<td class="text-center">
    								<input id="contribui_<?php echo $lote->getNumeroLote(); ?>"
    							    	   onchange="atualizarReceita(<?php echo $lote->getNumeroLote() .",".$valorDefault.",'".$lote->getCorLinha()."', true"; ?>);" 
    							    	   type="checkbox" <?php echo $lote->getPago() ? "checked": null; ?>>
    							</td>
    							
    							<td class="text-center"><?php echo $lote->getNumeroLote(); ?></td>
    							
    							<td class="text-left"><?php echo $lote->getNome(); ?></td>
    							
    							<td class="text-left">
    								<input id="data_pagto_<?php echo $lote->getNumeroLote(); ?>" 
    									   type="date"
    									   value="<?php echo $lote->getDataPagamento(); ?>"    									   
    									   onblur="atualizarReceita(<?php echo $lote->getNumeroLote() .",".$valorDefault.",'".$lote->getCorLinha()."', false"; ?>);"
    									   style="display: <?php echo $lote->getPago() ? "block": "none"; ?>;"/>
    							</td>
    							
    							<td class="text-center">
    								<input type="text" 
    									   id="valor_pagto_<?php echo $lote->getNumeroLote(); ?>" 
    									   class="dinheiro" 
    									   value="<?php echo $lote->getValorPago(); ?>"
    									   onblur="atualizarReceita(<?php echo $lote->getNumeroLote() .",".$valorDefault.",'".$lote->getCorLinha()."', false"; ?>);"
    									   style="display: <?php echo $lote->getPago() ? "block": "none"; ?>;"/>
    							</td>
    							
    						</tr>
    						<?php 
    						  } 
    						 ?>					
    					</tbody>
    				</table>
    			</div>
				<?php if(count($receitasExtras) > 0){ ?>
					<h3>Receitas Extras</h3>
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr>
									<td class="text-center" style="background-color: #ebebeb;">Descrição</td>
									<td class="text-center" style="background-color: #ebebeb;">Valor</td>						
								</tr>
							</thead>
							<tbody>
								<?php foreach ($receitasExtras as $extra) { 
									$totalArrecadado = $totalArrecadado + $extra->valor;
								?>
								<tr>
									<td class="text-center"><?php echo $extra->descricao; ?></td>
									<td class="text-right">R$ <?php echo number_format($extra->valor,2,',','.') ; ?></td>							
								</tr>
								<?php }?>
							</tbody>
						</table>
					</div>
				<?php }?>
			<?php 
        	   }
        	?>
		</div>
	</div>
</div>

<script>
    verifyUserPermission();
    register('<?php echo $_SERVER['REQUEST_URI']; ?>');
</script>

<?php include_once 'footer.php'; ?>