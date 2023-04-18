<?php
    include_once 'template.php';
?>

<div id="account-register" class="container">
    <ul class="breadcrumb">
		<li>
			<a href="">
				<i class="fa fa-home"></i>
			</a>
		</li>
		<li>
			<a href="register">Cadastre-se</a>
		</li>		
	</ul>
    <div class="row">
     <div id="content" class="col-sm-9">
      <h1>Cadastre sua conta</h1>
      <p>Se você já fez o cadastro, acesse sua conta <a href="customer-login">clicando aqui</a>.</p>
      <form action="" onSubmit="return createNewUser();" method="post" enctype="multipart/form-data" class="form-horizontal">
        <fieldset id="account">
          <legend style="background-color: #3d8945;">Seus dados de contato</legend>
          <br/>
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
        <fieldset>
          <legend style="background-color: #3d8945;">Sua senha de acesso</legend>
          <br/>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-password">Senha</label>
            <div class="col-sm-10">
              <div class="input-group">
                <input type="password" name="password" value="" placeholder="Senha" id="input-password" class="form-control" required>
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button" onclick="$(&#39;#input-password&#39;).attr(&#39;type&#39;) === &#39;password&#39; ? $(&#39;#input-password&#39;).attr(&#39;type&#39;, &#39;text&#39;) : $(&#39;#input-password&#39;).attr(&#39;type&#39;, &#39;password&#39;); $(&#39;#toggle-password&#39;).toggleClass(&#39;fa-eye fa-eye-slash&#39;);"><i id="toggle-password" class="fa fa-eye-slash"></i></button>
                </span>
              </div>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-confirm">Repetir a senha</label>
            <div class="col-sm-10">
              <div class="input-group">
                <input type="password" name="confirm" value="" placeholder="Repetir a senha" id="input-confirm" class="form-control" required>
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button" onclick="$(&#39;#input-confirm&#39;).attr(&#39;type&#39;) === &#39;password&#39; ? $(&#39;#input-confirm&#39;).attr(&#39;type&#39;, &#39;text&#39;) : $(&#39;#input-confirm&#39;).attr(&#39;type&#39;, &#39;password&#39;); $(&#39;#toggle-confirm&#39;).toggleClass(&#39;fa-eye fa-eye-slash&#39;);"><i id="toggle-confirm" class="fa fa-eye-slash"></i></button>
                </span>
              </div>
            </div>
          </div>
        </fieldset>
        <div class="buttons">
          <div class="pull-right">
            Eu li e concordo com o contrato de 
            <button type="button" style="border: none;background: white;color: #23a1d1;" data-toggle="modal" data-target="#modal-agree">
              <b>Política de privacidade</b>
            </button>
            <input type="checkbox" name="agree" value="1" required>
            &nbsp;
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

<div id="modal-agree" class="modal" style="display: none;">
  <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Política de privacidade</h4>
        </div>
        <div class="modal-body">
          <p>Os seus dados são gravados apenas com o propósito de facilitar a comunicação entre os moradores.</p>
          <p>A qualquer momento você poderá excluir sua conta pelo caminho : Minha Conta > Meus Dados > Excluir Conta.</p>
        </div>
      </div>
  </div>
</div>
