/**
 * 
 * Script em AlpineJS, mas mescla com alguns recursos do Jquery
 */

 function managerFrm(){
	return {
        search: '', // campo de busca
        data: {}, // dados do formulário
        allDestinations: {}, // todos os destinatários
        loading: false, // Loading botão
        buttonLabel: 'Salvar', // Texto botão
        loadData(){ // carrega dados tela
            fetch(document.getElementById("base_url").value+'/wallet/datajson')
                                .then(res => res.json())
                                .then(res => {
                                    //this.data = res.data;
                                    this.allDestinations = res.destinations;
                                    document.getElementById('balance').innerHTML = res.data.balance;
                                    document.getElementById("frm").action = res.link_update;
                                    document.getElementById("link_wallet").href = res.link_wallet;
                                })
        },
        submitData(){
            if($("#frm").valid()){

                swal({
                    title: "Deseja realizar transferência?",
                    text: '',
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    buttons: ["Cancelar", "OK"]
                  })
                  .then((yes) => {
                    if (yes) {

                        this.buttonLabel = 'Aguarde...'
                        this.loading = true;
                        let _method = document.querySelector('input[name="_method"]') !== null ? document.querySelector('input[name="_method"]').value: '';
                        
                        this.data._method = _method;
                        this.data._token = document.head.querySelector('meta[name=csrf-token]').content;
                        this.data.transfer = document.getElementById("transfer").value;
        
                        fetch(document.getElementById("frm").action, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify(this.data)
                        })
                        .then((response) => { 
                            if(response.ok != true){ // Se algo errado ocorrer
                                swal("Algo errado!", "Se persistir, fale com o administrador!", "error");
                            }
                            response.json().then(data => {
                                swal(data.title, data.msg, data.status);
                                document.getElementById('balance').innerHTML = data.balance_now;
                            })
                        })
                        .catch(() => {
                            swal("Error grave!", "Se persistir, fale com o administrador!", "error");
                        }).finally(() => {
                            this.loading = false;
                            this.buttonLabel = 'Salvar';
                            document.getElementById('transfer').value = '';
                            this.data = {};
                        })
                      
                    }
                  });                

            }
        }
    }
}