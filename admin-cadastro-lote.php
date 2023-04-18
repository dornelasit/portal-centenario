<?php
include_once 'template.php';
require_once 'classes/application_config.php';
require_once 'classes/dao/LoteDAO.php';

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
			<a href="admin-cadastro-lote">Cadastro de Lotes</a>
		</li>
	</ul>
  	<p></p>
	<div class="row">
		<div id="content" class="col-sm-12">
			
			<h2>Cadastro Lotes</h2>
			<br/>
			Total: <label><?php echo $qtdLotes; ?> Lotes </label><br/>
			Contribuintes: <label><?php echo $qtdContribuintes ." Contribuintes ( ". number_format($percent,2,',',' ') . " % )" ;?>  </label>
			<br/>
			<br/>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<td class="text-center" style="background-color: #ebebeb;">Lote Nº</td>
							<td class="text-center" style="background-color: #ebebeb;">Responsável</td>
							<td class="text-center" style="background-color: #ebebeb;">Telefone</td>
							<td class="text-center" style="background-color: #ebebeb;">Contribui?</td>
							<!--
							<td class="text-center" style="background-color: #ebebeb;">Casa já construída?</td>
							<td class="text-center" style="background-color: #ebebeb;">Está construindo?</td>
							-->
						</tr>
					</thead>
					<tbody>
						<?php 
						  foreach ($lotes as $lote){
						?>
						<tr>
							<td class="text-center"><?php echo $lote->getId(); ?></td>
							
							<td class="text-left">
								<input id="nome_<?php echo $lote->getId(); ?>" 
									   type="text" style="width: 100%" 
									   value="<?php echo $lote->getNomeProprietario();?>" 
									   maxlength="150" 
									   onblur="atualizarLote(<?php echo $lote->getId(); ?>, false);"/>
							</td>
							
							<td class="text-center">
								<input type="tel" 
								       id="input-telephone" 
								       name="tel_<?php echo $lote->getId(); ?>" 
								       class="telefone" 
								       maxlength="11" 
								       value="<?php echo $lote->getTelefone(); ?>"
									   onblur="atualizarLote(<?php echo $lote->getId(); ?>, false);"/>
								
							</td>
							
							<td class="text-center"><input id="contribui_<?php echo $lote->getId(); ?>"   onchange="atualizarLote(<?php echo $lote->getId(); ?>, true);" type="checkbox" <?php echo $lote->getContribui() ? "checked": null; ?>></td>
							<!--
							<td class="text-center"><input id="construido_<?php echo $lote->getId(); ?>"  onchange="atualizarLote(<?php echo $lote->getId(); ?>, false);" type="checkbox" <?php echo $lote->getConstruido() ? "checked": null; ?>></td>
							<td class="text-center"><input id="construindo_<?php echo $lote->getId(); ?>" onchange="atualizarLote(<?php echo $lote->getId(); ?>, false);" type="checkbox" <?php echo $lote->getConstruindo() ? "checked": null; ?>></td>
						  	-->
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

<script>
    verifyUserPermission();
    register('<?php echo $_SERVER['REQUEST_URI']; ?>');
</script>

<?php include_once 'footer.php'; ?>