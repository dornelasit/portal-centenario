<?php
    include_once 'template.php';
?>

<div id="account-password" class="container">
	<ul class="breadcrumb">
		<li>
            <a href="">
                <i class="fa fa-home"></i>
            </a>
        </li>
		<li><a href="account">Minha Conta</a></li>
		<li>Modificar Senha</li>        
	</ul>
	<div class="row">
		<div id="content" class="col-sm-9">
			<h1>Modificar senha</h1>
			<form action="#" method="post" enctype="multipart/form-data" class="form-horizontal" onSubmit="return passwordRedefinition();">
				<fieldset>
					<legend style="background-color: #3d8945;">Preencha abaixo a sua nova senha.</legend>
                    <br/>
					<div class="form-group required">
						<label class="col-sm-2 control-label" for="input-password">Senha</label>
						<div class="col-sm-10">
							<div class="input-group">
								<input type="password" name="password"  value=""	placeholder="Senha" id="input-password" class="form-control" maxlength="15" required>
								<span class="input-group-btn">
									<button class="btn btn-default" type="button"
										onclick="$('#input-password').attr('type') === 'password' ? $('#input-password').attr('type', 'text') : $('#input-password').attr('type', 'password'); $('#toggle-password').toggleClass('fa-eye fa-eye-slash');">
										<i id="toggle-password" class="fa fa-eye-slash"></i>
									</button>
								</span>
							</div>
						</div>
					</div>
					<div class="form-group required">
						<label class="col-sm-2 control-label" for="input-confirm">Repetir a senha</label>
						<div class="col-sm-10">
							<div class="input-group">
								<input type="password" name="confirm" value="" placeholder="Repetir a senha" id="input-confirm" class="form-control" maxlength="15" required>
                                <span class="input-group-btn">
									<button class="btn btn-default" type="button" onclick="$('#input-confirm').attr('type') === 'password' ? $('#input-confirm').attr('type', 'text') : $('#input-confirm').attr('type', 'password'); $('#toggle-confirm').toggleClass('fa-eye fa-eye-slash');">
										<i id="toggle-confirm" class="fa fa-eye-slash"></i>
									</button>
								</span>
							</div>
						</div>
					</div>
				</fieldset>
				<div class="buttons clearfix">
					<div class="pull-right">
						<input type="submit" value="Continuar" class="btn btn-primary">
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
    register('<?php echo $_SERVER['REQUEST_URI']; ?>');
</script>

<?php include_once 'footer.php'; ?>