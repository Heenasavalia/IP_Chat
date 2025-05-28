// const API = axios.create({
//     // baseURL: 'http://192.168.1.8/user',
//     baseURL: 'http://127.0.0.0/user',
// });
new Vue({
    el:'#__dashboard_app',
    data(){
        return{
            group_form:{
                name:'',
                members:[]
            },
            users_group:[],
            create_group_modal:false,
            search_user:'',
            searched_users:[],
            disable_user_search:false,
        }
    },
    watch:{
        create_group_modal(value){
            if(value==true){
                this.group_form.name='';
                this.group_form.members=[];
                this.search_user='';
                this.searched_users=[];
            }
        }
    },
    computed:{
        isDisableCreateGroupSubmit(){
            var is_disabled=true;
            if(this.group_form.name!='' && this.group_form.members.length > 0){
                is_disabled=false;
            }
            return is_disabled;
        }
    },
    methods:{
        delete_group(){

        },
        get_users_group(){
            axios.post('/user/userwise_group_list')
            .then(response =>{
                if(response.status===200){
                    var {status,data}=response.data;
                    if(status){
                        this.users_group=data;
                    }
                }
            })
            .catch(error =>{
                window.alert(error.response.statusText);
            });
        },
        create_group(){
            this.$refs.groupSubmitBtn.disabled=true;
            if(this.group_form.name!='' && this.group_form.members.length > 0){
                var form_data={
                    name:this.group_form.name,
                    members:this.group_form.members.map(item => item.id)
                };
                axios.post('/user/create_group',form_data)
                .then(response =>{
                    if(response.status===200){
                        var {status,message}=response.data;
                        if(status){
                            this.group_form.name='';
                            this.group_form.members=[];
                            this.search_user='';
                            this.searched_users=[];
                            this.create_group_modal=false;
                            this.$refs.groupSubmitBtn.disabled=false;
                            this.get_users_group();
                        }
                        else{
                            window.alert(message);
                            this.$refs.groupSubmitBtn.disabled=false;
                        }
                    }
                })
                .catch(error =>{
                    window.alert(error.response.statusText);
                    this.disable_user_search=false;
                });
            }
        },
        searchUser(){
            // this.group_form.members=[];
            this.searched_users=[];
            if(this.search_user!=''){
                this.disable_user_search=true;
                axios.post('/user/search_user',{
                    search_user:this.search_user,
                })
                .then(response =>{
                    if(response.status===200){
                        var {status,data,message}=response.data;
                        if(status){
                            // this.group_form.members=[];
                            this.searched_users=data;
                        }
                        else{
                            window.alert(message);
                        }
                        this.search_user='';
                        this.disable_user_search=false;
                    }
                })
                .catch(error =>{
                    window.alert(error.response.statusText);
                    this.disable_user_search=false;
                });
            }
        },
        add_user_to_group(user){
            var group_members=this.group_form.members;
            group_members.push({
                id:user.id,
                name:user.name,
            });
            this.group_form.members=group_members;
        },
        remove_user_to_group(uid){
            this.group_form.members=this.group_form.members.filter(item => item.id !=uid);
            
        }
    },
    mounted(){
        this.get_users_group();
    }
})