/**
 * Configura o csrf token em todo o sistema
 */
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

/**
 * Habilite o tooptip do boostrap em todo o sistema
 */
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

/**
 * Encapsula a chamada do jquery validate
 * @param {*} frmId Id do formulário
 * @param {*} rules Campos que serão validados
 * @param {*} messages Mensagens dos campos
 */
function frmValidate(frmId, rules, messages){
	$(frmId).validate({
		debug: false,
		errorClass: 'error',
		errorElement: 'p',
		onfocusout: false,
		invalidHandler: function(form, validator) { // Foca o elemento
			var errors = validator.numberOfInvalids();
			if (errors) {                    
				validator.errorList[0].element.focus();
			}
		},
		errorPlacement: function(error, element) {
		element.parents('.form-group').append(error);
		var msg = $(element).next('.help-block').text();
		$(element).attr('aria-label', msg );
		},
		highlight: function(element, errorClass){
		$(element)
		.attr('aria-invalid', true)
		.parents('.form-group')
		.addClass('has-error');
		},
		unhighlight: function(element, errorClass){
		$(element).removeAttr('aria-invalid')
		.removeAttr('aria-label')
		.parents('.form-group').removeClass('has-error');
		},
		rules: rules,
		messages: messages
	});
}

/**
 * Retorna somente a coluna de um array dimensional
 * Exemplo de uso arrayColumn(twoDimensionalArray, 'conteudo-posicao')
 */
const arrayColumn = (arr, n) => arr.map(x => x[n]);

/**
 * Remove determinado posição do array se baseando no valor
 * @param {*} arr Array que será verificado
 * @param {*} value Valor que será removido do array
 * @returns Retorno o array sem o conteúdo informado
 */
function arrayRemove(arr, value) { 
    
    return arr.filter(function(ele){ 
        return ele != value; 
    });
}
