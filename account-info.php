<?php
    include_once 'template.php';
?>

<div id="account-edit" class="container">
    <ul class="breadcrumb">
		<li>
			<a href="">
				<i class="fa fa-home"></i>
			</a>
		</li>
		<li>
			<a href="account">Minha Conta</a>
        </li>
        <li>Informações da Conta</li>
	</ul>
    <div class="row">
        <div id="content" class="col-sm-9">
            <h1>Informações da conta</h1>
            <form action="" onSubmit="return updateCustomerData();" method="post" enctype="multipart/form-data" onSubmit="return updateCustomerData();" class="form-horizontal">
                <fieldset>
                    <legend style="background-color: #3d8945;">Caso deseje, modifique as informações da sua conta</legend>
                    <br/><br/>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-fullname">Nome</label>
                        <div class="col-sm-10">
                        <input type="text" name="fullname" value="" placeholder="Nome" id="input-fullname" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-email">E-mail</label>
                        <div class="col-sm-10">
                        <input type="email" name="email" value="" placeholder="E-mail" id="input-email" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-telephone">Telefone</label>
                        <div class="col-sm-10">
                        <input type="tel" name="telephone" value="" placeholder="Telefone" id="input-telephone" class="form-control telefone" maxlength="11" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-lote">Lote</label>
                        <div class="col-sm-10">
                        <input type="number" name="lote" value="" placeholder="Número do lote (opcional)" id="input-lote" class="form-control" maxlength="3"/>
                        </div>
                    </div>
                </fieldset>
                <div class="buttons clearfix">
                    <div class="pull-left"><a href="account" class="btn btn-default">Voltar</a></div>
                    <div class="pull-right">
                        <input type="submit" value="Salvar" class="btn btn-primary">&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="button" value="Excluir Conta" class="btn btn-danger" onclick="excluirConta();">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    loadCustomerData();
    register('<?php echo $_SERVER['REQUEST_URI']; ?>');
</script>

<?php include_once 'footer.php'; ?>