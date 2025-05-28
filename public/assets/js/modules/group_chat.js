const API = axios.create({
    // baseURL: 'http://192.168.1.8/user',
    baseURL: 'http://127.0.0.0/user/',
    timeout: 1000,
});

new Vue({
    el:'#__groupchat_app',
    data(){
        return{
            messages:[],
            my_message:'',
            is_sent:false,
            chat_error:false,
            loading_message:false,
        }
    },
    watch:{
        is_sent(){
            document.querySelector('.user_last_msg')?.scrollIntoView();
        }
    },
    methods:{
        group_messages(){
            this.loading_message=true;
            var group_id=this.$refs.group_id.value;
            axios.post('/user/get_group_messages',{
                group_id:group_id,
            })
            .then(response =>{
                if(response.status===200){
                    var {status,data}=response.data;
                    if(status){
                        this.messages=data;
                        this.loading_message=false;
                    }
                }
            })
            .catch(error =>{
                if(!this.chat_error){
                    window.alert(error.response.statusText || "Something went wrong");
                }
                this.chat_error=true;
            });
        },
        send_message(){
            this.is_sent=true;
            var group_id=this.$refs.group_id.value;
            axios.post('/user/send_group_message',{
                message:this.my_message,
                group_id:group_id,
            })
            .then(response =>{
                if(response.status===200){
                    var {status}=response.data;
                    if(status){
                    }
                    this.is_sent=false;
                    this.my_message='';
                    // this.group_messages();
                }
            })
            .catch(error =>{
                window.alert(error.response.statusText);
                this.is_sent=false;
            });
        }
    },
    mounted(){
        this.group_messages();
        // var group_message_area=document.querySelector('.group_message_area');
        // group_message_area.scrollBy(0,group_message_area.scrollHeight+100);
        setInterval(() => {
            this.group_messages();
        }, 2500);
    }
})