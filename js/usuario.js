const STORAGE_CUSTOMER_LOGGED = "usuarioPortalLogado";
const ID_PERFIL_ADMIN = 777;

function putCustomer(_customer){
	localStorage.setItem(STORAGE_CUSTOMER_LOGGED, _customer);
}

function getCustomer(){    
    return JSON.parse(localStorage.getItem(STORAGE_CUSTOMER_LOGGED));    
}

function logOffCustomer(){
	localStorage.removeItem(STORAGE_CUSTOMER_LOGGED);
	document.location.href = '';
}

function verifyCustomerNav(){
	let _customer = getCustomer();
	if(_customer){
	   document.getElementById('liCustomerNameTopNav').style.display = 'block';
	   document.getElementById('labelCustomerNameTopNav').innerText  = _customer.nome;
 
	   document.getElementById('maAccess').style.display = 'none';
	   document.getElementById('maDataAndOrders').style.display = 'block';
	   document.getElementById('maExit').style.display = 'block';
	} else {
	   
		document.getElementById('liCustomerNameTopNav').style.display = 'none';
		document.getElementById('labelCustomerNameTopNav').innerText  = '';

		document.getElementById('maAccess').style.display = 'block';
		document.getElementById('maDataAndOrders').style.display = 'none';
		document.getElementById('maExit').style.display = 'none';
	}
}

function verifyUserAdmin(){
	let _customer = getCustomer();
	if(_customer){
		if(_customer.perfil == ID_PERFIL_ADMIN){
			document.getElementById('menu-admin').style.display = 'block';
		} else {
			document.getElementById('menu-admin').style.display = 'none';
		}
	} else {
		logOffCustomer();
	}
}

function verifyUserPermission(){
	let _customer = getCustomer();
	if(_customer){
		if(_customer.perfil != ID_PERFIL_ADMIN){
			document.location.href = '';
		}
	} else {
		document.location.href = '';
	}
}

function login(){
	let _email = $("#input-email").val();
	let _senha = $("#input-password").val();

	$.ajax({
		url: 'ajax-usuario.php',
		type : 'get',
		dataType: 'json',
		data: {
		  acao: 'login',
		  email: _email,
		  senha: _senha
		},
		statusCode: {
			500: function(responseObject, textStatus, jqXHR) {
				displayMessage("Erro ao cadastrar novo usuário!","Erro Sistêmico","error", 4);
				return false;
			},
			401: function(responseObject, textStatus, jqXHR) {
				displayMessage("Senha incorreta!","Senha inválida","error", 4);
				return false;
			},
			404: function(responseObject, textStatus, jqXHR) {
				displayMessage("Usuário não cadastrado com esse email!","Usuário não cadastrado","error", 4);
				return false;
			}
		}
	  }).done(function(_data){
		  putCustomer(JSON.stringify(_data));
		  document.location.href = '';
		  return false;
	  });	

	  return false;
}

function createNewUser(){

	let _name = $("#input-fullname").val();
	let _email = $("#input-email").val();
	let _tel = $("#input-telephone").val();
	let _lote = $("#input-lote").val();
	let _senha = $("#input-password").val();
	let _confirmacao = $("#input-confirm").val();
	
	if(_senha != _confirmacao){
		displayMessage("As senhas não coincidem!","Senhas informadas","error",4);
		return false;
	}
	
	$.ajax({
	      url: 'ajax-usuario.php',
	      type : 'get',
	      dataType: 'json',
	      data: {
	    	acao: 'inserir',
	    	email: _email,
	    	celular: _tel,
	        nome: _name,
	        lote: _lote,
	        senha: _senha
	      },
	      statusCode: {
	          500: function(responseObject, textStatus, jqXHR) {
	        	  displayMessage("Erro ao cadastrar novo usuário!","Erro Sistêmico","error", 4);
				  return false;
	          },
	          409: function(responseObject, textStatus, jqXHR) {
	        	  displayMessage("Já existe um cadastro para esse email!","Email já cadastrado","warning", 4);
	        	  return false;
	          }
	      }
	    }).done(function(data){

			let _customer = {};
			_customer.id = data.id;
			_customer.perfil = 0;
			_customer.nome = _name;
			_customer.numeroLote = _lote;
			_customer.email = _email;
			_customer.celular = _tel;

			putCustomer(JSON.stringify(_customer));
	        
			document.location.href = 'customer-saved';
			return false;
	    });	
		return false;
}

function updateCustomerData(){

	let _name = $("#input-fullname").val();
	let _email = $("#input-email").val();
	let _tel = $("#input-telephone").val();
	let _lote = $("#input-lote").val();
	let _customer = getCustomer();
	let _customerId = _customer.id;
	let _customerProfile = _customer.perfil;

	$.ajax({
		url: 'ajax-usuario.php',
		type : 'get',
		dataType: 'json',
		data: {
		  acao: 'update',
		  id: _customerId,
		  email: _email,
		  celular: _tel,
		  nome: _name,
		  lote: _lote
		},
		statusCode: {
			500: function(responseObject, textStatus, jqXHR) {
				displayMessage("Erro ao atualizar usuário!","Erro Sistêmico","error", 4);
				return false;
			},
			409: function(responseObject, textStatus, jqXHR) {
				displayMessage("Já existe um cadastro para esse email!","Email já cadastrado","warning", 4);
				return false;
			}
		}
	  }).done(function(data){

		localStorage.removeItem(STORAGE_CUSTOMER_LOGGED);

		let _customer = {};
		_customer.id = _customerId;
		_customer.perfil = _customerProfile;
		_customer.nome = _name;
		_customer.numeroLote = _lote;
		_customer.email = _email;
		_customer.celular = _tel;
		

		putCustomer(JSON.stringify(_customer));
		  
		document.location.href = 'account';
		return false;
	  });	
	  return false;

}

function loadCustomerData(){
	let _customer = getCustomer();
	if(_customer){
		$("#input-fullname").val(_customer.nome);
		$("#input-email").val(_customer.email);
		$("#input-telephone").val(_customer.celular);
		$("#input-lote").val(_customer.numeroLote);
	}
}

function passwordRedefinition(){
	let _senha = $('#input-password').val();
	let _confirmSenha = $('#input-confirm').val();

	if(_senha != _confirmSenha){
		displayMessage("As senhas não coincidem!","Senhas informadas","error",4);
		return false;
	}

	let _customer = getCustomer();

	$.ajax({
		url: 'ajax-usuario.php',
		type : 'get',
		dataType: 'json',
		data: {
		  acao: 'changepwd',
		  id: _customer.id,
		  novaSenha: _senha
		},
		statusCode: {
			500: function(responseObject, textStatus, jqXHR) {
				displayMessage("Erro ao atualizar senha do usuário!","Erro Sistêmico","error", 4);
				return false;
			}
		}
	  }).done(function(data){
		document.location.href = 'account';
		return false;
	  });	
	  return false;

}

function excluirConta(){
	
	if(confirm("Deseja realmente excluir seu cadastro?")){

		let _customer = getCustomer();

		if(_customer){

			$.ajax({
				url: 'ajax-usuario.php',
				type : 'get',
				dataType: 'json',
				data: {
				acao: 'delete',
				id: _customer.id
				},
				statusCode: {
					500: function(responseObject, textStatus, jqXHR) {
						displayMessage("Erro ao excluir usuário!","Erro Sistêmico","error", 4);
						return false;
					}
				}
			}).done(function(data){
				logOffCustomer();
			});
		}
	}
}

function togleCustomerComments(){
	let _customer = getCustomer();
	if(_customer){
	  $('#customerCommentLogged').show();
	  $('#joinToComment').hide();
	  $('#customerNameComment').val(_customer.nome);
	} else {
	  $('#customerCommentLogged').hide();
	  $('#joinToComment').show();
	}
}

function sendComment(_idMaterialServico){
	let _customerAlias = $('#customerNameComment').val();
	let _customerComment = $('#customerReview').val();
	let _ratingCustomer = $("input[name=rating]:checked" ).val();

	if(!_customerAlias){
		$('#commentSendAlert').show();
		$('#commentAlertMessage').text("Informe o nome para o comentário.");
		return;
	}
	if(!_customerComment){
		$('#commentSendAlert').show();
		$('#commentAlertMessage').text("Escreva seu comentário.");
		return;
	}
	if(!_ratingCustomer){
		$('#commentSendAlert').show();
		$('#commentAlertMessage').text("Escolha a sua avaliação.");
		return;
	}
	let _customer = getCustomer();  
	$.ajax({
		url: 'ajax-usuario.php',
		type : 'get',
		dataType: 'json',
		data: {
			acao: 'coment',
			id: _idMaterialServico,
			customerId: _customer.id,
			author: _customerAlias,
			text: _customerComment,
			rating: _ratingCustomer
		}
	}).done(function (response){
		
	}).fail(function(data, textStatus, xhr) {
		
	});
	$('#commentSendAlert').hide();
	$('#commentSendSuccess').show();
	$('#customerNameComment').val("");
	$('#customerReview').val("");
	$("input[name=rating]" ).attr('checked', false);
	
	setTimeout(() => {
		document.location.reload(true);
	}, 3000);
	
}

function togleUploadPhotos(){
	let _customer = getCustomer();
	if(_customer){
		if(_customer.perfil == ID_PERFIL_ADMIN){
			$('#panel-upload-fotos').show();
		} else {
			$('#panel-upload-fotos').hide();
		}
	}
}

function refreshDadosUsuario(_idUsuario){
	let _customer = getCustomer();  
	$.ajax({
		url: 'ajax-usuario.php',
		type : 'get',
		dataType: 'json',
		data: {
			acao: 'obter',
			id: _customer.id
		}
	}).done(function (response){
		putCustomer(JSON.stringify(response));
	});
}
