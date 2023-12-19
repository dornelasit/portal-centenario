<?php
include_once 'template.php';
require_once 'classes/application_config.php';
require_once 'classes/dao/FinanceiroDAO.php';

$mesAnterior = new DateTime('now');
$mesAnterior->modify('first day of previous month');
$mesAnterior = $mesAnterior->format('m/Y');

$mesAtual = new DateTime('now');
$mesAtual = $mesAtual->format('m/Y');

$proximoMes = new DateTime('now');
$proximoMes->modify('first day of next month');
$proximoMes = $proximoMes->format('m/Y');

$competencias = array();
$competencias[] = $mesAnterior;
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
			<a href="admin-controle-despesa">Controle de Despesas</a>
		</li>
	</ul>
  	<p></p>
	<div class="row">
		<div id="content" class="col-sm-12">
		
			<h2>Controle Despesa</h2>
			<br/>
			
			<label>Competência:</label><br/>
    		<select class="form-select" aria-label=".form-select-sm example" id="selCompetencia" onchange="onSelectCompetencia();">
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
        	   $dadosCaixaCompetencia = FinanceiroDAO::getInstancia()->obterDespesasPorCompetencia($comp);
        	?>
        		
        		<div class="modal fade" id="modal-novadespesa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limparDadosModal();">×</button>
                        <h4 class="modal-title">Informe os dados da despesa</h4>
                      </div>
                      <div class="modal-body">
                        <form>
                          <div class="form-group">
                            <label for="descricaoNovaDespesa" class="col-form-label">Descrição:</label>
                            <input type="text" class="form-control" id="descricaoNovaDespesa" maxlength="150"/>
                          </div>
                          <div class="form-group">
                            <label for="dataNovaDespesa" class="col-form-label">Data:</label>
                            <input type="date" class="form-control" id="dataNovaDespesa"/>
                          </div>
                          <div class="form-group">
                            <label for="valorNovaDespesa">Valor</label>
                            <input type="text" class="form-control dinheiro" id="valorNovaDespesa"  maxlength="10" />
                          </div>
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-primary"   id="btn-salvar" onclick="inserirDespesa();">Salvar</button>
                        <button type="button" class="btn btn-secondary" id="btn-fechar" data-dismiss="modal" onclick="limparDadosModal();">Fechar</button>
                      </div>
                    </div>
                  </div>
                </div>
                
                <input type="button" style="background-color: #a6ffc1;" value="Inserir Despesa" data-toggle="modal" data-target="#modal-novadespesa" onclick="carregarModal();" data-backdrop="static" data-keyboard="false"/>
        		<hr/>
        	<?php   
        	   if(count($dadosCaixaCompetencia) > 0){
        	   
            	   $totalDespesas = 0;
            	   foreach ($dadosCaixaCompetencia as $despesa){
            	       $totalDespesas = $totalDespesas + $despesa->valorDespesa;
            	   }
        	?>
            		Total Despesas: <label>R$ <?php echo number_format($totalDespesas,2,",","."); ?></label><br/>
            		<br/>
                	<input type="button" value="Atualizar Dados" onclick="atualizarDados();"/>&nbsp;&nbsp;&nbsp;
        			<br/><br/>
        			
        			<div class="table-responsive">
        				<table class="table table-bordered table-hover">
        					<thead>
        						<tr>
        							<td class="text-center" style="background-color: #ebebeb;">Descrição</td>
        							<td class="text-center" style="background-color: #ebebeb;">Data Despesa</td>
        							<td class="text-center" style="background-color: #ebebeb;">Valor Despesa</td>
        							<td class="text-center" style="background-color: #ebebeb;">&nbsp;</td>
        						</tr>
        					</thead>
        					<tbody>
        						<?php 
        						foreach ($dadosCaixaCompetencia as $despesa){
        						?>
        						<tr>
        							<td class="text-center">
        								<input type="text" 
        								       id="descricao_<?php echo $despesa->id; ?>" 
        									   style="width: 100%;" 
        									   maxlength="150" 
        									   value="<?php echo $despesa->descricao; ?>"
        									   onblur="atualizarDespesa(<?php echo $despesa->id; ?>);" />
        							</td>
        							
        							<td class="text-left">
        								<input id="data_pagto_<?php echo $despesa->id; ?>" 
        									   type="date"
        									   value="<?php echo $despesa->dataDespesa; ?>"    									   
        									   onblur="atualizarDespesa(<?php echo $despesa->id; ?>);" />
        							</td>
        							
        							<td class="text-center">
        								<input type="text" 
        									   class="dinheiro" 
        									   id="valor_despesa_<?php echo $despesa->id; ?>" 
        									   value="<?php echo $despesa->valorDespesa; ?>"
        									   maxlength="10"
        									   onblur="atualizarDespesa(<?php echo $despesa->id; ?>);" />
        							</td>
        							
        							<td class="text-center">
        								<input type="button" value="Excluir" id="btn_excluir_<?php echo $despesa->id; ?>" onclick="excluirDespesa(<?php echo $despesa->id; ?>);"/>
        							</td>
        							
        						</tr>
        						<?php 
        						  } 
        						 ?>					
        					</tbody>
        				</table>
        			</div>
			<?php 
        	   }
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