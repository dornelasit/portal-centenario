<?php
    include_once 'template.php';
?>  

<div id="common-success" class="container">
    <ul class="breadcrumb">
		<li>
			<a href="">
				<i class="fa fa-home"></i>
			</a>
		</li>
		<li>
			Conta Cadastrada
		</li>		
	</ul>
    <div class="row">
        <div id="content" class="col-sm-12">
            <h1>Sua conta foi cadastrada.</h1>
            <br/>
            <p>É com grande satisfação que lhe agradecemos por se cadastrar em nosso portal.</p> 
            <p>Ele visa melhorar a comunicação e compartilhar informações do nosso bairro.</p>             
            <div class="buttons">
                <div class="pull-right"><a href="" class="btn btn-primary">Continuar</a></div>
            </div>
        </div>
    </div>
</div>

<script>
    register('<?php echo $_SERVER['REQUEST_URI']; ?>');
</script>

<?php include_once 'footer.php'; ?>