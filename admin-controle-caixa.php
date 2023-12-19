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
			<a href="admin-controle-caixa">Controle de Caixa</a>
		</li>
	</ul>
  	<p></p>
	<div class="row">
		<div id="content" class="col-sm-12">
		
			<h2>Controle Caixa</h2>
			<br/>
			
			<label>Competência:</label><br/>
    		<select class="form-select" aria-label=".form-select-sm example" id="selCompetencia" onchange="onSelectCompetenciaCaixa();">
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
        	  
        	    $dadosCaixaCompetencia = FinanceiroDAO::getInstancia()->obterCaixaPorCompetencia($comp);
        	
        	?>
        			<div class="table-responsive">
        				<table class="table table-bordered table-hover">
        					<thead>
        						<tr>
        							<td class="text-center" style="background-color: #ebebeb;">Valor em caixa</td>
        						</tr>
        					</thead>
        					<tbody>
        						<tr>
        							
        							<td class="text-center">
        								<input type="text" 
        									   class="dinheiro" 
        									   id="valor_caixa" 
        									   value="<?php echo $dadosCaixaCompetencia->getValor(); ?>"
        									   maxlength="10"
        									   onblur="atualizarCaixa(<?php echo $dadosCaixaCompetencia->getId(); ?>);" />
        							</td>
        							
        						</tr>
        					</tbody>
        				</table>
        			</div>
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