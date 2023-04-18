<?php
include_once 'template.php';
require_once 'classes/application_config.php';
require_once 'classes/dao/FinanceiroDAO.php';
require_once 'classes/dao/LoteDAO.php';

$dadosTransparencia = FinanceiroDAO::getInstancia()->obterDadosTransparencia();

$competencias = "";
$receitas   = "";
$despesas   = "";

foreach ($dadosTransparencia as $dados) {
    $competencias = $competencias."'".$dados->getCompetencia()."',";
    $receitas = $receitas. $dados->getValorTotalReceita().",";
    $despesas = $despesas. $dados->getValorTotalDespesa().",";
}

$valorCaixa = FinanceiroDAO::getInstancia()->obterCaixaAtual();

$lotes = LoteDAO::getInstancia()->obterTodosLotes();

$qtdLotes = count($lotes);
$qtdContribuintes = 0;

foreach ($lotes as $lote){
    if($lote->getContribui()){
        $qtdContribuintes = $qtdContribuintes + 1;
    }
}

$percent = ($qtdContribuintes / $qtdLotes) * 100; 

?>

<script src="js/chart/Chart.min.js"></script>
<script>
	verifyContribuicoesBenfeitorias();
</script>	

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
	</ul>
  	<p></p>
	<h2>Transparência Financeira</h2>
	
	<div class="row">
		<div id="content" class="col-sm-12">
			
			<div id="showifTransparencia-nc" style="display : none;">
				<h3 style="color: #3c9725;">Dados dos pagamentos mensais são exibidos apenas para os lotes contribuintes.</h3>
			</div>
			<div id="joinSystem" style="display : none;">
				Você deve <a href="customer-login">acessar</a>
				ou <a href="register">cadastrar-se</a> para prosseguir.
			</div>
			<div id="showifTransparencia" style="display : none;">
				<div class="row">
					<div class="col-sm-8">
						<div class="card">
							<div class="card-header border-0">
								<div class="d-flex justify-content-between">
									<h4 class="card-title">Dados dos &uacute;ltimos 12 meses:</h4>
								</div>
							</div>
							<div class="card-body">
								<div class="position-relative mb-4">
								<canvas id="sales-chart" height="200"></canvas>
								</div>
			
								<div class="d-flex flex-row justify-content-end">
								<span class="mr-2">
									<i class="fas fa-square" style="color: #007bff;"></i> Receitas
								</span>
				
								<span>
									<i class="fas fa-square" style="color: #FF6347;"></i> Despesas
								</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<br/><br/>
				<div class="row" id="valor-caixa" style="display : none;">
					<div class="col-sm-8">
						<h3>Valor Atual em Caixa: <span style="color:blue;">R$ <?php echo number_format($valorCaixa->getValor(),2,',','.') ; ?></span></h3>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-8">
						Total: <label><?php echo $qtdLotes; ?> Lotes </label><br/>
						Contribuintes: <label><?php echo $qtdContribuintes ." ( ". number_format($percent,2,',','.') . " % )" ;?>  </label>
					</div>
				</div>
			</div>
			<hr/>
			
			<div id="div-suascontribuicoes" style="display: none;">
    			<h3>Suas Contribuições de Benfeitorias</h3>
    			<div class="table-responsive">
    				<table class="table table-bordered" id="contribuicoesLoteTable">
    					<thead>
    						<tr>
    							<td class="text-center" style="background: #d6e5ff;">Competência</td>
    							<td class="text-center" style="background: #d6e5ff;">Descrição</td>
    							<td class="text-center" style="background: #d6e5ff;">Valor Contribuído</td>
    							<td class="text-center" style="background: #d6e5ff;">Ver detalhes</td>					
    						</tr>
    					</thead>
    					<tbody/>
    				</table>
    			</div>
			</div>

		</div>
	</div>
</div>

<script>
	verifyContribui("showifTransparencia");
	setTimeout(() => {
		verifyContribuicoesBenfeitorias();	
	}, 500);
	
	let _customer = getCustomer();
	if(_customer && _customer.contribui){
		document.getElementById('valor-caixa').style.display = 'block';
	}

	  var ticksStyle = {
	    fontColor: '#495057',
	    fontStyle: 'bold'
	  }

	  var mode = 'index'
	  var intersect = true

	  var $salesChart = $('#sales-chart')
	  // eslint-disable-next-line no-unused-vars
	  var salesChart = new Chart($salesChart, {
	    type: 'bar',
	    data: {
	      labels: [<?php echo $competencias;?>],
	      datasets: [
	        {
	          backgroundColor: '#007bff',
	          borderColor: '#007bff',
	          data: [<?php echo $receitas;?>]
	        },
	        {
	          backgroundColor: '#FF6347',
	          borderColor: '#FF6347',
	          data: [<?php echo $despesas;?>]
	        }
	      ]
	    },
	    options: {
		  onClick:function(e){
			let element = this.getElementAtEvent(e);
			if (element.length > 0) {
				var label = element[0]._model.label;
				//var value = this.data.datasets[element[0]._datasetIndex].data[element[0]._index];
				exibirDespesa(label);
			}
		  },
	      maintainAspectRatio: false,
	      tooltips: {
	        mode: mode,
	        intersect: intersect
	      },
	      hover: {
	        mode: mode,
	        intersect: intersect
	      },
	      legend: {
	        display: false
	      },
	      scales: {
	        yAxes: [{
	          // display: false,
	          gridLines: {
	            display: true,
	            lineWidth: '4px',
	            color: 'rgba(0, 0, 0, .2)',
	            zeroLineColor: 'transparent'
	          },
	          ticks: $.extend({
	            beginAtZero: true,

	            // Include a dollar sign in the ticks
	            callback: function (value) {
	              if (value >= 1000) {
	                value /= 1000
	                value += 'k'
	              }

	              return 'R$ ' + value
	            }
	          }, ticksStyle)
	        }],
	        xAxes: [{
	          display: true,
	          gridLines: {
	            display: false
	          },
	          ticks: ticksStyle
	        }]
	      }
	    }
	  });

	  function exibirDespesa(mesReferencia){
		exibirModalDespesaCompetencia(mesReferencia);
	  }

    </script>


<script>
    register('<?php echo $_SERVER['REQUEST_URI']; ?>');
</script>

	<div class="modal fade" id="modal-exibir-despesa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Despesas da competência <span id="mes-competencia"></span> </h4>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table class="table table-bordered" id="table-despesas">
						<thead>
							<tr>
								<td class="text-center" style="background: #d6e5ff;">Despesa</td>
								<td class="text-center" style="background: #d6e5ff;">Valor</td>							
							</tr>
						</thead>
						<tbody id="rows-despesas">
						</tbody>
					</table>
				</div>
				<label id="lblTotalDespesa"></label><br/>
				<a href="#" id="linkDetalheFinanceiro">Ver todos os detalhes</a>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" id="btn-fechar" data-dismiss="modal">Fechar</button>
			</div>
		</div>
		</div>
	</div>

<?php include_once 'footer.php'; ?>