<?php
include_once 'template.php';
require_once 'classes/application_config.php';
require_once 'classes/dao/FinanceiroDAO.php';
require_once 'classes/dao/ParametroDAO.php';
require_once 'classes/dao/BenfeitoriaDAO.php';

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
			<a href="admin-controle-receita-benfeitoria">Controle Receita de Benfeitorias</a>
		</li>
	</ul>
  	<p></p>
	<div class="row">
		<div id="content" class="col-sm-12">
		
			<h2>Controle Receita de Benfeitorias</h2>
			<br/>
			
			<label>Competência:</label><br/>
    		<select class="form-select" aria-label=".form-select-sm example" id="selCompetencia" onchange="onSelectCompetenciaReceitaBenfeitoria();">
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
        	if($comp != 0){  ?>
        	    
        	   <input type="button" style="background-color: #a6ffc1;" value="Nova Benfeitoria pra esta competência" data-toggle="modal" data-target="#modal-benfeitoria" onclick="carregarModalReceitaExtra();" data-backdrop="static" data-keyboard="false"/>
        	   <hr/>
        	    
        	<?php       
        	   $benfeitoriasCompetencia = BenfeitoriaDAO::getInstancia()->obterBenfeitoriasPorCompetencia($comp);
        	   
        	   if(count($benfeitoriasCompetencia) > 0){ ?>
        	   	   <div class="panel-group" id="accordion">
        	   <?php
        	       $cont = 0;
        	       foreach ( $benfeitoriasCompetencia as $benfeitoria ) { 
            	           $cont = $cont +1;
            	   ?>
                          <div class="panel panel-default">
                            <div class="panel-heading">
                              <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $cont;?>">
                                	<?php echo $benfeitoria->descricao;?>
                                </a>
                                <div style="float: right;"><a onclick="excluirBenfeitoria(<?php echo $benfeitoria->id;?>);"><img title="Excluir Benfeitoria" src="img/trash.svg"></a> </div>
                              </h4>
                              
                            </div>
                            <div id="collapse<?php echo $cont;?>" class="panel-collapse collapse">
                              <div class="panel-body">
                              	
                              	<?php 
                              	     $dadosPagamentoBenfeitorias = FinanceiroDAO::getInstancia()->obterDadosReceitasBenfeitoria($benfeitoria->id);
                              	     $total = BenfeitoriaDAO::getInstancia()->obterValorArrecadadoBenfeitoria($benfeitoria->id);
                              	     $qtd = BenfeitoriaDAO::getInstancia()->obterQuantidadeContribuintesBenfeitoria($benfeitoria->id);
                              	?>
                              		<h3>Contribuições da Benfeitoria : <?php echo $benfeitoria->descricao;?></h3>
                              		<h4>Total Arrecadado: <span style="color: blue;font-weight: bold;" id="vlrArrecadado_<?php echo $benfeitoria->id;?>">R$ <?php echo number_format($total,2,",",".")?></span></h4>
                              		<h4>Quantidade Contribuintes: <span style="color: blue;font-weight: bold;" id="qtdContribuintes_<?php echo $benfeitoria->id;?>"><?php echo $qtd ?></span></h4>
                              		
                              		<hr/>
                              		<form enctype="multipart/form-data" method="POST" action="upload_nf.php">
                              			<input type="hidden" name="idBenfeitoria" value="<?php echo $benfeitoria->id; ?>"/>
                              			<input type="hidden" name="comp" value="<?php echo $comp; ?>"/>
                                       	<div>
                                       		<input id="selecao-arquivo" type="file" name="arquivo_<?php echo $benfeitoria->id;?>" accept=".pdf" required="required" /><br/>
                                        	<input name="enviar" type="submit" value="Enviar Arquivo" style="background-color: #a6ffc1;">
                                        </div>
                                        <br/>
                                    </form>
                                    <br/>
                                    <?php 
                                        $nfs = BenfeitoriaDAO::getInstancia()->obterNotasFiscaisBenfeitoria($benfeitoria->id);

                                        if(count($nfs) > 0){
                                            echo "<label>Notas Fiscais Anexadas:</label><br/>";
                                        
                                            
                                            foreach ($nfs as $nf){
                                                echo "<a onclick='excluirNotaFiscal(". $nf->id .");'><img title='Excluir Nota Fiscal' src='img/trash.svg'></a>&nbsp;&nbsp;
                                                      <a href='nfs/".$nf->urlNf."' target='_blank'>".$nf->urlNf."</a></br>  
                                                     ";
                                            }
                                        } else {
                                         
                                            echo "<label>Nenhuma Nota Fiscal Anexada</label><br/>";
                                            
                                        }
                                    ?>
                                    
                                    <hr/>
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
                        						foreach ($dadosPagamentoBenfeitorias as $pagamentoBenfeitoria){
                        						?>
                        						<tr id="linha_<?php echo $pagamentoBenfeitoria->getNumeroLote()."_".$benfeitoria->id; ?>" style="background-color: <?php echo $pagamentoBenfeitoria->getCorLinha(); ?>">
                        							<td class="text-center">
                        								<input id="contribui_<?php echo $pagamentoBenfeitoria->getNumeroLote()."_".$benfeitoria->id; ?>"
                        							    	   onchange="atualizarReceitaBenfeitoria(<?php echo $pagamentoBenfeitoria->getNumeroLote() .",". $benfeitoria->id .",0,'".$pagamentoBenfeitoria->getCorLinha()."', true"; ?>);" 
                        							    	   type="checkbox" <?php echo $pagamentoBenfeitoria->getPago() ? "checked": null; ?>>
                        							</td>
                        							
                        							<td class="text-center"><?php echo $pagamentoBenfeitoria->getNumeroLote(); ?></td>
                        							
                        							<td class="text-left"><?php echo $pagamentoBenfeitoria->getNome(); ?></td>
                        							
                        							<td class="text-left">
                        								<input id="data_pagto_<?php echo $pagamentoBenfeitoria->getNumeroLote()."_".$benfeitoria->id; ?>" 
                        									   type="date"
                        									   value="<?php echo $pagamentoBenfeitoria->getDataPagamento(); ?>"    									   
                        									   onblur="atualizarReceitaBenfeitoria(<?php echo $pagamentoBenfeitoria->getNumeroLote() .",". $benfeitoria->id .",0,'".$pagamentoBenfeitoria->getCorLinha()."', false"; ?>);"
                        									   style="display: <?php echo $pagamentoBenfeitoria->getPago() ? "block": "none"; ?>;"/>
                        							</td>
                        							
                        							<td class="text-center">
                        								<input type="text" 
                        									   id="valor_pagto_<?php echo $pagamentoBenfeitoria->getNumeroLote()."_".$benfeitoria->id; ?>" 
                        									   class="dinheiro" 
                        									   value="<?php echo $pagamentoBenfeitoria->getValorPago(); ?>"
                        									   onblur="atualizarReceitaBenfeitoria(<?php echo $pagamentoBenfeitoria->getNumeroLote() .",". $benfeitoria->id .",0,'".$pagamentoBenfeitoria->getCorLinha()."', false"; ?>);"
                        									   style="display: <?php echo $pagamentoBenfeitoria->getPago() ? "block": "none"; ?>;"/>
                        							</td>
                        							
                        						</tr>
                        						<?php 
                        						  } 
                        						 ?>					
                        					</tbody>
                        				</table>
                        			</div>
                              
                              </div>
                            </div>
                          </div>
                       
                  <?php } ?>   
                  </div>         	
             	  <br/><br/>
            	
			<?php 
        	   }
        	?>
        	
				<div class="modal fade" id="modal-benfeitoria" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limparDadosModalBenfeitoria();">×</button>
                        <h4 class="modal-title">Informe os dados da Benfeitoria</h4>
                      </div>
                      <div class="modal-body">
                        <form onsubmit="inserirBenfeitoria();">
                          <div class="form-group">
                            <label for="descricaoReceitaExtra" class="col-form-label">Descrição:</label>
                            <input type="text" class="form-control" id="descricaoNovaBenfeitoria" maxlength="120" autocomplete="off"/>
                          </div>                          
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-primary"   id="btn-salvar-benfeitoria" onclick="inserirBenfeitoria();">Salvar</button>
                        <button type="button" class="btn btn-secondary" id="btn-fechar-benfeitoria" data-dismiss="modal" onclick="limparDadosModalBenfeitoria();">Fechar</button>
                      </div>
                    </div>
                  </div>
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