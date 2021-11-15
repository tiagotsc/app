/**
 * 
 * Script em AlpineJS
 */

function managerFrm(){
	return {
        search: '', // campo de busca
        data: {}, // dados do formulário
        selectall: false, /* seleção de todos começa desmarcado */
        clicked: false, /* verifica se função allChecked já foi clicada */
        selectedPermissions: [], // permissões que já vieram selecionadas
        allPermissions: [], // todas as permissões
        loading: false, // Loading botão
        buttonLabel: 'Salvar', // Texto botão
        selected(id){ // Verifica se checkbox foi marcado ou não
 
            let checkbox = document.getElementById(`permission[${id}]`);
            if(checkbox.checked == true){
                this.selectedPermissions.push(checkbox.value);
            }else{
                this.selectedPermissions = arrayRemove(this.selectedPermissions, checkbox.value);
            }
         
        },
        loadData(){ // carrega dados tela
            fetch(document.getElementById("route_list").value)
                                .then(res => res.json())
                                .then(res => {
                                    this.data = res.data;
                                    this.selectedPermissions = arrayColumn(res.data.permissions, 'name');
                                    this.allPermissions = res.allPermissions;
                                })
        },
        allChecked(){ // Marca ou desmarca todos os checkboxs
            this.clicked = true; /* marca como true quando a função allChecked é executada */
            this.selectall = !this.selectall;
        },
        get filteredIPermissions() { // Filtra busca de permissões
            return this.allPermissions.filter(
                (i) => {
                    if(i.name.toLowerCase().indexOf(this.search.toLowerCase()) > -1){ // Se retorno do indexof for maior que 0 exibe registro
                        i.show = true; // Exibe determinado registro
                    }else{
                        i.show = false; // Oculta determinado registro
                    }
                    return i;
                }
            )
        },
        submitData(){
            if($("#frm").valid()){
                
                this.buttonLabel = 'Aguarde...'
                this.loading = true;
                let _method = document.querySelector('input[name="_method"]') !== null ? document.querySelector('input[name="_method"]').value: '';
                
                this.data.permission = this.selectedPermissions;
                this.data._method = _method;
                this.data._token = document.head.querySelector('meta[name=csrf-token]').content;

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
                        swal('Muito bom!', 'Salvo com sucesso!', 'success')
                        .then(() => {
                            if (data.redirect != undefined) { // Se foi cadastrado, redireciona para tela de edição
                                window.location.href = data.redirect;
                            }
                        });
                    })
                })
                .catch(() => {
                    swal("Error grave!", "Se persistir, fale com o administrador!", "error");
                }).finally(() => {
                    this.loading = false;
                    this.buttonLabel = 'Salvar'
                })
            }
        }
    }
}