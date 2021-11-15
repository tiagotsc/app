frmValidate(
	"#frm",
	{
		username: {
			required: true
		},
		name: {
			required: true
		},
		email: {
			required: true
		},
		cpf_cnpj: {
			required: true
		},
		password: {
			required: {
				depends: function(){
					var status = false;
					if($("input[name='_method']").length == 0 && $("input[name='_method']").val() != 'PUT'){ // Se tela cadastro, obriga preenchimento senha
						var status = true;
					}
					return status;
				}
			},
			minlength: 8
		},
        confirm_password: {
            required:{
				depends: function(element){
					var status = false;
					if( $("#password").val() != ''){
						var status = true;
					}
					return status;
				}
			},
            equalTo: "#password"
        }
	},
	{
		username: {
			required: "Informe, por favor!"
		},
		name: {
			required: "Informe, por favor!"
		},
		email: {
			required: "Informe, por favor!",
			email: "Informe um email válido, por favor!"
		},
		cpf_cnpj: {
			required: "Informe, por favor!"
		},
		password: {
			required: "Informe, por favor!",
			minlength: "Mínimo de 8 caracteres"
		},
		confirm_password: {
			required: "Informe, por favor!",
            equalTo: "Repita a mesma senha, por favor!"
        }
	}
);

$("#cpf_cnpj").keydown(function(){
	try {
		$("#cpf_cnpj").unmask();
	} catch (e) {}

	let content = $("#cpf_cnpj").val().length;

	if(content < 11){
		$("#cpf_cnpj").mask("999.999.999-99");
	} else {
		$("#cpf_cnpj").mask("99.999.999/9999-99");
	}

	// ajustando foco
	var elem = this;
	setTimeout(function(){
		// mudo a posição do seletor
		elem.selectionStart = elem.selectionEnd = 10000;
	}, 0);
	// reaplico o valor para mudar o foco
	var currentValue = $(this).val();
	$(this).val('');
	$(this).val(currentValue);
});