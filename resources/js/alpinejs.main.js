/**
 * Usado em todo o sistema
 */
function main(){
        return {
            btn_block: true,
            new_password: '',
            again_new_password: '',
            message1: '',
            show1: false,
            message2: '',
            show2: false,
            statusResetPass: '',
            clearFrmResetPass(){
                this.statusResetPass = '';
                this.new_password = '';
                this.again_new_password = '';
                this.show1 = false;
                this.show2 = false;
            },
            validationResetPassword(){
               
                if(this.new_password.trim() != '' && this.new_password.trim().length < 8){
                    this.message1 = 'Mínimo de 8 caracteres!';
                    this.show1 = true;
                }else{
                    this.message1 = '';
                    this.show1 = false;
                }

                if(this.again_new_password.trim() != '' && this.again_new_password.trim() != this.new_password.trim()){
                    this.message2 = 'Senha diferente!';
                    this.show2 = true;
                }else{
                    this.message2 = '';
                    this.show2 = false;
                }
    
                if(this.show1 == false && this.show2 == false && this.again_new_password.trim() == this.new_password.trim()){
                    this.btn_block = false;
                }else{
                    this.btn_block = true;
                }
                
            },
            resetPassword(){

                let formResetPass = {
                    password: this.new_password,
                    _method: 'PUT',
                    _token: document.head.querySelector('meta[name=csrf-token]').content
                };

                fetch(document.getElementById("frm-reset-password").action, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(formResetPass)
                })
                .then((response) => { 
                    if(response.ok){
                        this.statusResetPass = '<b class="color-blue">Senha alterada com sucesso!</b>';
                    }else{
                        this.statusResetPass = '<b class="color-red">Algo errado! Se persistir, fale com o administrador!</b>';
                    }
                })
                .catch(() => {
                    this.statusResetPass = '<b class="color-red">Error grave! Se persistir, fale com o administrador!</b>';
                }).finally(() => {
                    this.new_password = '';
                    this.again_new_password = '';
                    this.btn_block = true
                })
            }
        }
    }