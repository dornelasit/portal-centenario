<?php
include_once 'template.php';
require_once 'classes/application_config.php';
require_once 'classes/dao/FinanceiroDAO.php';

$detalhes = array();

if(isset($_GET['comp'])){
    $detalhes = FinanceiroDAO::getInstancia()->obterDetalhesFinanceirosCompetencia($_GET['comp']);    
}

$valorReceita = 0;
$valorReceitaExtra = 0;
$valorDespesas = 0;

?>

<div id="common-home" class="container">
  	<ul class="breadcrumb">
		<li>
			<a href="">
				<i class="fa fa-home"></i>
			</a>
		</li>
		<li>
			<a href="dashboard-transparencia">Transparência</a>
		</li>	
		<li>
			Detalhes da Competência - <?php echo $_GET['comp'];?>
		</li>		
	</ul>
  	<p></p>
	<div class="row">
		<div id="content" class="col-sm-12">
			
			<h2>Detalhes da Competência - <?php echo $_GET['comp'];?></h2>
			<br/>
			
			<h3>Lotes Contribuintes</h3>
			<div class="table-responsive">
				<table class="table table-bordered">
					<thead>
						<tr>
							<td class="text-center" style="background: #d6e5ff;">Lote</td>
							<td class="text-center" style="background: #d6e5ff;">Data Pagamento</td>
							<td class="text-center" style="background: #d6e5ff;">Valor Pago</td>						
						</tr>
					</thead>
					<tbody>
						<?php foreach ($detalhes->receitas as $receita) { 
						    $valorReceita = $valorReceita + $receita->valor;
						?>
						<tr>
							<td class="text-center"><?php echo $receita->lote; ?></td>
							<td class="text-center"><?php echo $receita->dataPagamento; ?></td>
							<td class="text-right">R$ <?php echo number_format($receita->valor,2,',','.') ; ?></td>							
						</tr>
						<?php }?>
					</tbody>
				</table>
			</div>
			
			<?php if(count($detalhes->receitasExtras) > 0){ ?>
				<h3>Receitas Extras</h3>
    			<div class="table-responsive">
    				<table class="table table-bordered">
    					<thead>
    						<tr>
    							<td class="text-center" style="background: #d6e5ff;">Descrição</td>
    							<td class="text-center" style="background: #d6e5ff;">Valor</td>						
    						</tr>
    					</thead>
    					<tbody>
    						<?php foreach ($detalhes->receitasExtras as $receitaExtra) { 
    						    $valorReceitaExtra = $valorReceitaExtra + $receitaExtra->valor;
    						?>
    						<tr>
    							<td class="text-center"><?php echo $receitaExtra->descricao; ?></td>
    							<td class="text-right">R$ <?php echo number_format($receitaExtra->valor,2,',','.') ; ?></td>							
    						</tr>
    						<?php }?>
    					</tbody>
    				</table>
    			</div>			
			<?php } ?>
			
			<h3>Despesas</h3>
			<div class="table-responsive">
				<table class="table table-bordered">
					<thead>
						<tr>
							<td class="text-center" style="background: #ffd0d0;">Descrição</td>
							<td class="text-center" style="background: #ffd0d0;">Valor Pago</td>						
						</tr>
					</thead>
					<tbody>
						<?php foreach ($detalhes->despesas as $despesa) { 
						    $valorDespesas = $valorDespesas + $despesa->valorDespesa;
						?>
						<tr>
							<td class="text-center"><?php echo $despesa->descricao; ?></td>
							<td class="text-right">R$ <?php echo number_format($despesa->valorDespesa,2,',','.') ; ?></td>							
						</tr>
						<?php }?>
					</tbody>
				</table>
			</div>
			
			<h3>Resumo do Mês</h3>
			<label>Valor Total Contribuições: <span style="font-weight: bold;color: blue;" >R$ <?php echo number_format($valorReceita,2,',','.');?></span></label>
			<br/>
			<?php if($valorReceitaExtra > 0) { ?>
				<label>Valor Receitas Extras: <span style="font-weight: bold;color: blue;" >R$ <?php echo number_format($valorReceitaExtra,2,',','.');?></span></label><br/>
			<?php } ?>
			<label>Valor Total Despesas: <span style="font-weight: bold;color: #ffb100;" >R$ <?php echo number_format($valorDespesas,2,',','.');?></span></label><br><br>
			<?php 
			     $saldo = (($valorReceita+$valorReceitaExtra) - $valorDespesas);
			     $cor = $saldo >= 0 ? "blue" : "red";
			?>
			
			
			<label>Saldo Final: <span style="font-weight: bold;color: <?php echo $cor; ?>;" >R$ 
				<?php echo number_format($saldo,2,',','.');?>
				</span>
			</label>
			<br><br>			
		</div>
	</div>
</div>

<script>
    register('<?php echo $_SERVER['REQUEST_URI']; ?>');
</script>

<?php include_once 'footer.php'; ?>