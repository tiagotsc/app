frmValidate(
	"#frm",
	{
		transfer: {
			required: true
		},
		destiny: {
			required: true
		}
	},
	{
		transfer: {
			required: "Informe, por favor!"
		},
		destiny: {
			required: "Selecione, por favor!"
		}
	}
);

$('.money').maskMoney({thousands:'', decimal:'.'});

