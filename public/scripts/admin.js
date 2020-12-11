$(document).ready(function(ev){

	/**
		CONFIGURÇÃO PARA AJUSTAR O MODAL QUANDO ESTIVER GRANDE
	*/
	$('html body').delegate('.modal-dialog-lg #closeModal', 'click', function(ev){

		$('html footer #assistenteModal').css('display', 'none').removeClass('show');
		$('html .modal-backdrop').remove();
	})
	

	


	/**
	*	CHAMA O MODAL DE OPÇÕES DE MARCAS
	*/
	$('body').delegate('.assistenteModalMarca', 'click', function(ev){

		let id = $(this).find('input:hidden').val();

		$.ajax({
			type:'POST',
			url: '#',
			data:true,
			dataType: 'HTML',
			success: function(response){
				console.log(response)
			}
		})

		let arrLinks = [
			['Ediar', '/marca/edit/'+id+'', 'btn btn-lg btn-outline-success', 'id_marca_editar'],
			['Visualizar', '/marca/show/'+id+'', 'btn btn-lg btn-outline-primary', 'id_marca_visualizar'],
			['Excluir', '/marca/info/'+id+'', 'btn btn-lg btn-outline-danger', 'id_marca_deletar']

		];

		Utilitarios.assitentOpcoes(arrLinks);
	})


	

	//edita uma marca específica
	$('body').delegate('#assistenteModal #id_marca_editar', 'click', function(ev){


		ev.preventDefault();
		let url = $(this).attr('href');
		
		Utilitarios.assistentAjaxModal('GET',url, 'HTML','Marca-Editar')

	});

	//cadastra uma marca
	$('body').delegate('div.card a#cadastrar_marca', 'click', function(ev){

		ev.preventDefault();
		let url = $(this).attr('href');
		
		Utilitarios.assistentAjaxModal('GET',url, 'HTML','Marca-Cadastrar')
		Utilitarios.toggleFiltro();

	});

	//chama o preview de deletar marca
	$('body').delegate('#assistenteModal #id_marca_deletar', 'click', function(ev){

		ev.preventDefault();
		let url = $(this).attr('href');
		
		Utilitarios.assistentAjaxModal('GET',url, 'HTML','Marca-Deletar')

	});

	//deleta uma marca
	$('body').delegate('#assistenteModal #id_marca_destroy', 'click', function(ev){

		ev.preventDefault();
		let url = $(this).attr('href');
		
		Utilitarios.assistentAjaxModal('GET',url, 'HTML','Marca-Deletar')

	});

	$('html body').delegate('form#form_marca_cadastrar, form#form_marca_atualizar','submit', function(ev){

		try{

			let url = $(this).attr('action');
			let id = $(this).attr('id');

			let form = new FormData($(this)[0]);
			$.ajax({
				url:url,
				type:'POST',
				dataType:'json',
				data:form,
				processData:false,
				contentType:false,
				success:function(response){
					console.log(response);
					console.log(response.mensagem.id);

					if(response.mensagem.hasOwnProperty('id') || response.mensagem == true){

						if(id == 'form_marca_atualizar'){

							Utilitarios.assistenteMensageAlert('Registro atualizado com sucesso');

						}else{

							Utilitarios.assistenteMensageAlert('Registro cadastrado com sucesso');

						}

					}else{

						if(id == 'form_marca_atualizar'){

							Utilitarios.assistenteMensageAlert('Erro ao atuaolizar registro', 'warning');

						}else{

							Utilitarios.assistenteMensageAlert('Erro ao cadastrar registro', 'warning');

						}

						
					}
				},
				error:function(response, status, error){
					//console.log(response, status, error)
					console.log(response.responseJSON);
					let objErros = response.responseJSON.errors
					let msg = 'Atenção, os seguintes erros foram encontrados: <br/>';
					for (let prop in objErros){
						msg+='<strong>'+prop+': </strong>'+objErros[prop]+'<br/>';
					}

					Utilitarios.assistenteMensageAlert(msg, 'warning');
				}


			})

		}catch(ex){

			console.log(ex.message);
		}

		ev.preventDefault();
	});
	

	/**
	*	CHAMA O MODAL DE OPÇÕES DE CATEGORIAS
	*/
	$('body').delegate('.assistenteModalCategoria', 'click', function(ev){

		let id = $(this).find('input:hidden').val();

		$.ajax({
			type:'POST',
			url: '#',
			data:true,
			dataType: 'HTML',
			success: function(response){
				console.log(response)
			}
		})

		let arrLinks = [
			['Ediar', '/categoria/edit/'+id+'', 'btn btn-lg btn-outline-success', 'id_categoria_editar'],
			['Visualizar', '/categoria/show/'+id+'', 'btn btn-lg btn-outline-primary', 'id_categoria_visualizar'],
			['Excluir', '/categoria/info/'+id+'', 'btn btn-lg btn-outline-danger', 'id_categoria_deletar']

		];

		Utilitarios.assitentOpcoes(arrLinks);
	})


	//edita um categoria específica
	$('body').delegate('#assistenteModal #id_categoria_editar', 'click', function(ev){


		ev.preventDefault();
		let url = $(this).attr('href');
		
		Utilitarios.assistentAjaxModal('GET',url, 'HTML','Categoria-Editar')

	});

	//cadastra um categoria
	$('body').delegate('div.card a#cadastrar_categoria', 'click', function(ev){

		ev.preventDefault();
		let url = $(this).attr('href');
		
		Utilitarios.assistentAjaxModal('GET',url, 'HTML','Categoria-Cadastrar')
		Utilitarios.toggleFiltro();

	});

	//chama o preview de deletar categoria
	$('body').delegate('#assistenteModal #id_categoria_deletar', 'click', function(ev){

		ev.preventDefault();
		let url = $(this).attr('href');
		
		Utilitarios.assistentAjaxModal('GET',url, 'HTML','Categoria-Deletar')

	});

	//deleta um categoria
	$('body').delegate('#assistenteModal #id_categoria_destroy', 'click', function(ev){

		ev.preventDefault();
		let url = $(this).attr('href');
		
		Utilitarios.assistentAjaxModal('GET',url, 'HTML','Categoria-Deletar')

	});


	

	

	



})



class BaseModelo{

	constructor(){

		this.errors = [];
	}
}


class Produto extends BaseModelo{

	constructor(){
		super();

		this.nome;
		this.descricao;
		this.imagem;
		this.estoque;
		this.preco;
		this.status;
		this.destaque;
	}


}

class Logradouro extends BaseModelo{
	constructor(){
		super();
	}

}

class Utilitarios{

	constructor(){
		this.inputsArray = [];
		this.table;
	}
	setTableInputs(table){
		this.table = table;
	}
	adicionaFielsTable(data){
		let index = this.inputsArray.length;

		data.index = index
		let leng = this.inputsArray.push(data);
		return leng;
	}

	removeFieldsTable(index){
		if(this.inputsArray.length > 0){
			for(let i=0; !(i == this.inputsArray.length); i++){
				if(this.inputsArray[i] != null){
					if(this.inputsArray[i].hasOwnProperty('index')){						
						if(this.inputsArray[i].index == index){
							console.log(this.inputsArray[i].index +' '+index )
							this.inputsArray[i] = null;
							break;
						}
						
						
					}
				}
			}
		}

		this.retornaFieldsTable();
		return true;
	}

	retornaFieldsTable(only = []){
		if(Array.isArray(only) && (only.length > 0)){
			
			let trs = '';
			for(let i=0; !(i == this.inputsArray.length); i++){
				let tr = '<tr>';
				let index = null;
				for(let item in this.inputsArray[i]){
					if(this.inputsArray[i] != null){
						
						for(let j = 0; !(j == only.length); j++){
							if(item == only[j]){
								if(this.inputsArray[i].hasOwnProperty(item) && (item != 'index')){
									tr += '<td>'+this.inputsArray[i][item]+'</td>'
									
								}
															
							}

							if(item == 'index'){
								
								index = this.inputsArray[i][item];
							}
						}
					}
				}
				if(index != null){
					
					tr+= '<td><button type="button" class="btn btn-sm btn-outline-danger" id="'+index+'"><i class="fa fa-trash"></i></button></td></tr>';
					trs += tr;
				}
				
			}
			this.table.html(trs);
		}else{

			let trs = '';
			for(let i=0; !(i == this.inputsArray.length); i++){
				let tr = '<tr>';
				let index = null;
				for(let item in this.inputsArray[i]){
					if(this.inputsArray[i] != null){
						
						if(this.inputsArray[i].hasOwnProperty(item) && (item != 'index')){
							tr += '<td>'+this.inputsArray[i][item]+'</td>'
						}
						if(item == 'index'){
							index = this.inputsArray[i][item];
						}


					}
				}
				if(index != null){

					tr+= '<td><button type="button" class="btn btn-sm btn-outline-danger" id="'+index+'"><i class="fa fa-trash"></i></button></td></tr>';
					trs += tr;
				}
				
			}
			this.table.html(trs);
		}
		
		return true;
	}

	getDataTable(){
		return this.inputsArray;
	}


	static assistenteModal(response, widthModal='lg', title='Titulo', height = null){

		Utilitarios.assistenteMensageAlertClear();
		Utilitarios.widthAssistenteModal(widthModal, height);
		$('html #assistenteModal').find('.modal-body #content_modal').html(response).css({margin: 'auto'});
		$('html #assistenteModal').find('.modal-header h4.modal-title').html(title)
		$('html #assistenteModal').modal('show');
	}

	static assistenteMensageAlert(response, cls='success'){

		$('html #assistenteModal').find('.modal-body #messagem_modal').html($('<h5/>').addClass('alert alert-'+cls).html(response).css({textAlign: 'center'}));
		
	}

	static assistenteMensageAlertClear(){

		$('html #assistenteModal').find('.modal-body #messagem_modal').html('');
		
	}


	static assitentOpcoes(arrLInks, widthOptions='200px', widModal = 'md', height=null){

		let ul = $('<ul/>').addClass('navbar-nav');

		for(let i=0; !(i == arrLInks.length); i++){

			let li = $('<li/>').append($('<a/>')
				.attr('href', arrLInks[i][1]).html(arrLInks[i][0])
				.addClass(arrLInks[i][2]).css('width',widthOptions)
				.attr('id',arrLInks[i][3] ).css('box-sizing', 'border-box')
				).css('box-sizing', 'border-box');

			ul.append(li);
			li.addClass('col-md-12 mb-3')
		}
		ul.css('margin', 'auto')
		let nav = $('<nav/>').html(ul).addClass('nav row');
		nav.css('margin', 'auto');

		this.assistenteModal(nav, widModal, 'Opções')
	}


	static assistentAjax(type,url, typeResponse, objRender){

		if(type == 'GET'){

			$.ajax({
				url:url,
				type:type,
				dataType:typeResponse,
				success:function(response){

					$(objRender).html(response,);

				}

			});



		}else{


		}
	}

	static assistentAjaxModal(type,url, typeResponse, title='titulo', width='lg', heigh = null){

		if(type == 'GET'){

			$.ajax({
				url:url,
				type:type,
				dataType:typeResponse,
				success:function(response){
					Utilitarios.assistenteModal(response, width, title, heigh);
					
				}

			});



		}else{


		}
	}


	static widthAssistenteModal(width, height = null){
		let base 	= 'modal-dialog modal-dialog-centered';
		let lg 		= 'modal-lg '+base;
		let sm 		= 'modal-sm '+base;
		let md 		= 'modal-md '+base;
		let xs 		= 'modal-xs '+base;
		let obj 	= $('html #assistenteModal #modal-size');

		switch(width){
			case'sm':
				obj.removeClass(lg).removeClass(xs).removeClass(md).addClass(sm).css('max-width', '');
			break;
			case'xs':
				obj.removeClass(lg).removeClass(sm).removeClass(md).addClass(xs).css('max-width', '');
			break;
			case'md':
				obj.removeClass(lg).removeClass(sm).removeClass(xs).addClass(md).css('max-width', '');
			break;
			default:
				obj.removeClass(sm).removeClass(xs).removeClass(md).addClass(lg).css('max-width', '90%');
			break;
			
		}


		if(height != null){
			obj.find('.modal-content').css('height', height)
		}else{
			obj.find('.modal-content').css('height', 'auto')
		}
	}

	static menssageForUser(message){
		$('html body').find('#menssageForUser')
		.html(
				$('<p/>').css('text-align', 'center').addClass('alert alert-warning').html(message)
			)
	}

	static clearMenssageForUser(){
		$('html body').find('#menssageForUser')
		.html('');
	}

	static toggleFiltro(){
		$('.card-togle').find('.card-body').toggle('fast');
		$('.card-togle').find('.card-footer').toggle('fast');
	}

	static useDataTable(container){
		container.dataTable({
	        "bJQueryUI": true,
	        //"sPaginationType": "full_numbers",
	        "sDom": '<"H"Tlfr>t<"F"ip>',
	        "oTableTools": {
	            "sSwfPath": "../../js/DataTables-1.9.4/extras/TableTools/media/swf/copy_csv_xls_pdf.swf",
	            "aButtons": [
	                {
	                    "sExtends": "xls",
	                    "sButtonText": "Exportar para Excel",
	                    "sTitle": "Usuarios",
	                    "mColumns": [0, 1, 2, 3]
	                },
	                {
	                    "sExtends": "pdf",
	                    "sButtonText": "Exportar para PDF",
	                    "sTitle": "Usuarios",
	                    "sPdfOrientation": "landscape",
	                    "mColumns": [0, 1, 2, 3]
	                }
	            ]
	        },
	        "oLanguage": {
	            "sLengthMenu": "",//Mostrar _MENU_ registros por página
	            "sZeroRecords": "Nenhum registro encontrado",
	            "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
	            "sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
	            "sInfoFiltered": "(filtrado de _MAX_ registros)",
	            "sSearch": "Pesquisar: ",
	            "oPaginate": {
	                "sFirst": "",//Início
	                "sPrevious": "",//Anterior
	                "sNext": "",//Próximo
	                "sLast": ""//Último
	            }
	        },
	        "aaSorting": [[0, 'desc']],
	        "aoColumnDefs": [
	            {"sType": "num-html", "aTargets": [0]}

	        ]
	    });
	}

	static foramtCalcCod(number){
  

    number = String(number);
    

    if(number.length == 0){
      return 0;
    }

    if(number.indexOf(',') > -1){
    	number = number.replace(/\./g, '');
    	number = number.replace(/,/g, '.');
    }

    number = Number(number);
    if(isNaN(number)){
    	return 0;
    }

    return number.toFixed(2);


  }

  static formatMoney(amount, decimalCount = 2, decimal = ',', thousands = '.'){
	  try{

	    decimalCount = Math.abs(decimalCount);
	    decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

	    const negativeSing = amount < 0 ? '-' : '';

	    let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
	    let j = (i.length > 3) ? i.length % 3 : 0;

	    let fomartted = negativeSing;
	    fomartted += (j ? i.substr(0, j) + thousands : '');
	    fomartted += i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands);
	    fomartted += (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : '');

	    return fomartted;


	  }catch(e){

	    console.log(e);
	  }


	}
	
}
