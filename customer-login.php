<?php
    include_once 'template.php';

    $_isRedirect = 'n';
    if(isset($_GET['v'])){
        $_isRedirect = $_GET['v'];
    }

    $_msg = '';
    if(isset($_GET['msg'])){
        $_msg = $_GET['msg'];
    }

    $_isPasswordRedefinition = 'n';
    if(isset($_GET['r'])){
        $_isPasswordRedefinition = $_GET['r'];
    }

    $_isPasswordChanged = '';
    if(isset($_GET['c'])){
        $_isPasswordChanged = $_GET['c'];
    }
?>

<script>
    let _isRedirect = '<?php echo $_isRedirect; ?>';
    if(_isRedirect == 'y'){
        displayMessage("Por favor, cadastre-se ou efetue o seu login para garantir o menor preço e acessar seus dados!<br/>Ou se preferir, poderá comprar sem se identificar.","Efetuar login","error", 8);
    }

    let _errMsg = '<?php echo $_msg; ?>';

    if(_errMsg == '401'){
        displayMessage("A senha informada é inválida!","Senha Incorreta","error", 8);
    } else if(_errMsg == '404'){
        displayMessage("O email informado não possui cadastro!","Email não cadastrado","error", 8);
    } else if(_errMsg == '403'){
        displayMessage("O email informado possui um processo de exclusão de dados! Por favor, aguarde seus dados serem completamente removidos nos próximos dias.","Email com solicitação de exclusão de dados","error", 8);
    } else if(_errMsg == '500'){
        displayMessage("Desculpe, ocorreu um erro interno ao validar seu login. Tente novamente por favor!","Erro no login","error", 8);
    }

    let _isResetPassword = '<?php echo $_isPasswordRedefinition; ?>';
    if(_isResetPassword == 'y'){
        displayMessage("Foi enviado um email para redefinir a sua senha, caso seu email esteja cadastrado na nossa loja.","Email enviado","info", 8);
    }

    let _isPasswordChanged = '<?php echo $_isPasswordChanged; ?>';
    if(_isPasswordChanged == 'y'){
        displayMessage("Sua senha foi redefinida com sucesso!","Senha redefinida","info", 8);
    }

</script>

<div id="account-login" class="container">
    <ul class="breadcrumb">
		<li>
			<a href="">
				<i class="fa fa-home"></i>
			</a>
		</li>
        <li>
			<span>Minha Conta</span>
		</li>	
		<li>
			<a href="customer-login">Acessar</a>
		</li>		
	</ul>
    
    <div class="row">
        <div id="content" class="col-sm-12">
            <div class="row">
                <div class="col-sm-6">
                    <div class="well">
                        <h2>Ainda não é cadastrado?</h2>
                        <p><strong>Cadastre sua conta.</strong></p>
                        <p>Ao cadastrar sua conta, você terá acesso a mais informações sobre o nosso bairro!</p>
                        <a href="register" class="btn btn-success">Cadastre-se</a>

                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="well">
                        <h2>Já é cadastrado?</h2>
                        <p><strong>Se você já fez o cadastro, coloque os dados da conta abaixo:</strong></p>
                        <form action="" onSubmit="return login();" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="login-type" value="customer"/>
                            <div class="form-group">
                                <label class="control-label" for="input-email">E-mail</label>
                                <input type="email" name="email" value="" placeholder="E-mail" id="input-email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="input-password">Senha</label>
                                <div class="input-group">
                                    <input type="password" name="password" value="" placeholder="Senha" id="input-password" class="form-control" required>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" style="height: 34px;" type="button" onclick="$(&#39;#input-password&#39;).attr(&#39;type&#39;) === &#39;password&#39; ? $(&#39;#input-password&#39;).attr(&#39;type&#39;, &#39;text&#39;) : $(&#39;#input-password&#39;).attr(&#39;type&#39;, &#39;password&#39;); $(&#39;#toggle-password&#39;).toggleClass(&#39;fa-eye fa-eye-slash&#39;);"><i id="toggle-password" class="fa fa-eye-slash"></i></button>
                                    </span>
                                </div>
                            </div>
                            <input type="submit" value="Acessar" class="btn btn-success">                            
                        </form>
                    </div>
                </div>
            </div>
      
        </div>    
  </div>
</div>

<script>
    register('<?php echo $_SERVER['REQUEST_URI']; ?>');
</script>

<?php include_once 'footer.php'; ?>