function onSelectCompetenciaReceitaBenfeitoria(){
    document.location.href='admin-controle-receita-benfeitoria?comp='+document.getElementById('selCompetencia').value;
}

function limparDadosModalBenfeitoria(){
    $('#descricaoNovaBenfeitoria').val("");
}

function inserirBenfeitoria(){

	let _descricao = $('#descricaoNovaBenfeitoria').val();
	
	if(_descricao == '' || _descricao == null || _descricao == undefined){
		displayMessage('Descrição da Benfeitoria é obrigatória','Descrição da benfeitoria', 'error',3);
		return;
	} 
	
	$('#btn-salvar-benfeitoria').prop("disabled",true);
	$('#btn-salvar-benfeitoria').html("Salvando...");
	$('#btn-fechar-benfeitoria').prop("disabled",true);
	
	let _competencia = '01/'+ $('#selCompetencia').val();
	
	$.ajax({
	      url: 'ajax-benfeitoria.php',
	      type : 'get',
	      dataType: 'json',
	      data: {
	    	acao: 'i',
	        competencia: _competencia,
	        descricao: _descricao
	      }
	    }).done(function (response){    
	    	document.location.reload(true);
	    }).fail(function(data, textStatus, xhr) {
	    	document.location.reload(true);
	    });
}

function excluirBenfeitoria(_id){

    if(confirm('Deseja realmente excluir os dados dessa benfeitoria?')){
        $.ajax({
            url: 'ajax-benfeitoria.php',
            type : 'get',
            dataType: 'json',
            data: {
            acao: 'e',
            id: _id
            }
        }).done(function (response){    
            document.location.reload(true);
        }).fail(function(data, textStatus, xhr) {
            document.location.reload(true);
        });
    }
}

function atualizarReceitaBenfeitoria(_id, _idBenfeitoria, _valorDefault, _corLinha, _isInsert){
	
	let _pago = document.getElementById('contribui_'+_id).checked;
	let _dataPagto = $('#data_pagto_'+ _id).val();
	
	if(_pago){
		
		document.getElementById('linha_'+ _id).style.backgroundColor = '#daebc3';
		document.getElementById('data_pagto_'+ _id).style.display  = "block";
		document.getElementById('valor_pagto_'+ _id).style.display = "block";
		
		if(_dataPagto == '' || _dataPagto == undefined){
			
			hoje = new Date();
			let _mes = (hoje.getMonth()+1);
			let _dia = hoje.getDate();

			if(_mes.toString().length == 1){
				_mes = '0'+_mes;
			}

			if(_dia.toString().length == 1){
				_dia = '0'+_dia;
			}

			_dataPagto = hoje.getFullYear() +'-'+ _mes + '-' + _dia;
			$('#data_pagto_'+ _id).val(_dataPagto);
		} 
		
		if($('#valor_pagto_'+ _id).val() == ''   || 
		   $('#valor_pagto_'+ _id).val() == null ||
		   $('#valor_pagto_'+ _id).val() == undefined){
		
			$('#valor_pagto_'+ _id).val(_valorDefault);		
		}
		
		if(_isInsert){
			inserirPagamentoBenfeitoria(_id, _idBenfeitoria, $('#data_pagto_'+ _id).val(),$('#valor_pagto_'+ _id).val());
		} else {
			atualizarPagamentoBenfeitoria(_id, _idBenfeitoria, $('#data_pagto_'+ _id).val(),$('#valor_pagto_'+ _id).val());
		}

	} else {
		
		document.getElementById('linha_'+ _id).style.backgroundColor = '#fff';
		document.getElementById('data_pagto_'+ _id).style.display = "none";
		document.getElementById('valor_pagto_'+ _id).style.display = "none";
		
		excluirPagamentoBenfeitoria(_id, _idBenfeitoria);

	}
	
	setTimeout(() => {
		obterValorArrecadado(_idBenfeitoria);
		obterQuantidadeContribuintes(_idBenfeitoria);
	}, 500);
	
}

function inserirPagamentoBenfeitoria(_id, _idBenfeitoria, _dataPagto, _valorPagto){
	
	_valorPagto = _valorPagto.replace(".","");
	_valorPagto = _valorPagto.replace(",",".");
	
	$.ajax({
	      url: 'ajax-benfeitoria.php',
	      type : 'get',
	      dataType: 'json',
	      data: {
	    	acao: 'ib',
	        lote: _id,
	        idBenfeitoria: _idBenfeitoria,
	        dataPagto: _dataPagto,
	        valorPagto: _valorPagto
	      }
	    }).done(function (response){    
	      
	    }).fail(function(data, textStatus, xhr) {
	    });
}

function atualizarPagamentoBenfeitoria(_id, _idBenfeitoria, _dataPagto, _valorPagto){
	
	_valorPagto = _valorPagto.replace(".","");
	_valorPagto = _valorPagto.replace(",",".");
	
	$.ajax({
	      url: 'ajax-benfeitoria.php',
	      type : 'get',
	      dataType: 'json',
	      data: {
	    	acao: 'ab',
	    	lote: _id,
	        idBenfeitoria: _idBenfeitoria,
	        dataPagto: _dataPagto,
	        valorPagto: _valorPagto
	      }
	    }).done(function (response){    
	      
	    }).fail(function(data, textStatus, xhr) {
	    });
}

function excluirPagamentoBenfeitoria(_id, _idBenfeitoria){
	$.ajax({
	      url: 'ajax-benfeitoria.php',
	      type : 'get',
	      dataType: 'json',
	      data: {
	    	acao: 'eb',
	    	lote: _id,
	        idBenfeitoria: _idBenfeitoria
	      }
	    }).done(function (response){    
	      
	    }).fail(function(data, textStatus, xhr) {
	    });
}

function atualizarDadosBenfeitoria(){
	document.location.reload();
}

function obterValorArrecadado(_idBenfeitoria){
	$.ajax({
	      url: 'ajax-benfeitoria.php',
	      type : 'get',
	      dataType: 'json',
	      data: {
	    	acao: 'v',
	    	idBenfeitoria: _idBenfeitoria
	      }
	    }).done(function (response){
	      document.getElementById("vlrArrecadado_"+_idBenfeitoria).innerHTML = response.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
	    }).fail(function(data, textStatus, xhr) {
	    });
}

function obterQuantidadeContribuintes(_idBenfeitoria){
	$.ajax({
	      url: 'ajax-benfeitoria.php',
	      type : 'get',
	      dataType: 'json',
	      data: {
	    	acao: 'cb',
	    	idBenfeitoria: _idBenfeitoria
	      }
	    }).done(function (response){
	      document.getElementById("qtdContribuintes_"+_idBenfeitoria).innerHTML = response;
	    }).fail(function(data, textStatus, xhr) {
	    });
}

function excluirNotaFiscal(_idNf){
	if(confirm('Deseja realmente excluir essa Nota Fiscal?')){
		$.ajax({
		      url: 'ajax-benfeitoria.php',
		      type : 'get',
		      dataType: 'json',
		      data: {
		    	acao: 'enf',
		    	idNf: _idNf
		      }
		    }).done(function (response){
		    }).fail(function(data, textStatus, xhr) {
		    });
		
		document.location.reload();
	}
}

function verifyContribuicoesBenfeitorias(){
	let _customer = getCustomer();
	if(_customer){ 
		refreshDadosUsuario(_customer.id);
		_customer = getCustomer();
		if(_customer.contribuicoesBenfeitorias && _customer.contribuicoesBenfeitorias.length > 0){
			$('#div-suascontribuicoes').show();
			_customer.contribuicoesBenfeitorias.forEach( contribuicao => {
				$('#contribuicoesLoteTable')
			    .append('<tr><td class="text-center">'+contribuicao.competencia+'</td><td class="text-center">'+contribuicao.descricao+'</td><td class="text-right">'+ Number(contribuicao.valorContribuicao).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})+'</td><td class="text-center"><a href="detalhes-contribuicao?id='+contribuicao.idBenfeitoria+'&nome='+ contribuicao.descricao+'">Clique aqui</a></td></tr>');
			});
		}
	} else {
		$('#div-suascontribuicoes').hide();
	}
}