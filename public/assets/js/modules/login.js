new Vue({
    el:'#__login_app',
    data(){
        return{
            form:{
                email:'',
                password:'',
            },
            login_error:'',
            success_login:false,
            forgot_password_instructions:false
        }
    },
    methods:{
        login_user(){
            axios.post('/user/check_login',{
                email:this.form.email,
                password:this.form.password,
            })
            .then(response =>{
                if(response.status===200){
                    var {status,message}=response.data;
                    if(status){
                        this.success_login=true;
                        this.form.email='';
                        this.form.password='';
                        setTimeout(() => {
                            window.location.href="user/dashboard"
                        }, 1000);
                    }
                    else{
                        this.login_error=message;
                    }
                }
            })
            .catch(error =>{
                window.alert(error.response.statusText);
            });
        },
    }
})