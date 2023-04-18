<?php
    include_once 'template.php';
?>  

<div id="account-account" class="container">
    <ul class="breadcrumb">
		<li>
			<a href="">
				<i class="fa fa-home"></i>
			</a>
		</li>
		<li>
			<a href="account">Minha Conta</a>
		</li>
	</ul>
    <div class="row">
        <div id="content" class="col-sm-12">
            <h2>Minha conta</h2>
            <ul class="list-unstyled">
                <li><a href="account-info">Informações da conta</a></li>
                <li><a href="password-reset">Modificar senha</a></li>
            </ul>
            <div id="menu-admin" style='display : none;'>
                <h2>Administração</h2>
                <ul class="list-unstyled">
                    <li><a href="admin-cadastro-lote">Cadastro de Lotes</a></li>
                    <li><a href="admin-controle-caixa">Valor Caixa</a></li>
                    <li><a href="admin-controle-despesa">Lançar Despesas Mensais</a></li>
                    <li><a href="admin-controle-receita">Lançar Receitas Mensais</a></li>
                    <li><a href="admin-controle-receita-benfeitoria">Lançar Receita de Benfeitorias</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    verifyUserAdmin();
    register('<?php echo $_SERVER['REQUEST_URI']; ?>');
</script>

<?php include_once 'footer.php'; ?>