<?php
include_once 'template.php';
require_once 'classes/application_config.php';
require_once 'classes/dao/BenfeitoriaDAO.php';

if(isset($_GET['id'])){
    $dadosPagamentoBenfeitorias = BenfeitoriaDAO::getInstancia()->obterLotesPagantesBenfeitoria($_GET['id']);
}

$valorReceita = 0;
$qtdLotesContribuintes = 0;

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
			Detalhes da Contribuição - <?php echo $_GET['nome'];?>
		</li>				
	</ul>
  	<p></p>
	<div class="row">
		<div id="content" class="col-sm-12">
			
			<h2>Detalhes da Contribuição - <?php echo $_GET['nome'];?></h2>
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
						<?php foreach ($dadosPagamentoBenfeitorias as $receita) { 
						    $valorReceita = $valorReceita + $receita->getValorPago();
						    $qtdLotesContribuintes = $qtdLotesContribuintes + 1;
						?>
						<tr>
							<td class="text-center"><?php echo $receita->getNumeroLote(); ?></td>
							<td class="text-center"><?php echo $receita->getDataPagamento(); ?></td>
							<td class="text-right">R$ <?php echo number_format($receita->getValorPago(),2,',','.') ; ?></td>							
						</tr>
						<?php }?>
					</tbody>
				</table>
			</div>
			
			<h3>Notas Fiscais</h3>
			<?php 
			    $nfs = BenfeitoriaDAO::getInstancia()->obterNotasFiscaisBenfeitoria($_GET['id']);

                if(count($nfs) > 0){
                    echo "<label>Notas Fiscais Anexadas:</label><br/>";
                
                    
                    foreach ($nfs as $nf){
                        echo "<a href='nfs/".$nf->urlNf."' target='_blank'>".$nf->urlNf."</a></br>";
                    }
                } else {
                    echo "<label>Nenhuma Nota Fiscal Anexada</label><br/>";
                }
            ?>
			
			<h3>Resumo</h3>
			<label>Valor Total Contribuições: <span style="font-weight: bold;color: blue;" >R$ <?php echo number_format($valorReceita,2,',','.');?></span></label>
			<br/>
			<label>Total de lotes que contribuíram: <span style="font-weight: bold;color: blue;" ><?php echo $qtdLotesContribuintes;?></span></label>
			<br/>
						
		</div>
	</div>
</div>

<script>
    register('<?php echo $_SERVER['REQUEST_URI']; ?>');
</script>

<?php include_once 'footer.php'; ?>