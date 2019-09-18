
<script>
import axios from 'axios';
import cookie from '../components/Cookie';

export default {
    name: "AxiosXHR",
    methods: {
        sendRequest: function(rest, successFunc, method = 'get', data = false, domain = 'http://vita-crm.ru')
        {
            let token = cookie.methods.getCookie("token");
            let axiosConfig = {
                method: method,
                url: domain + '/' + rest + (rest == 'api/login' ? '' : '?auth=' + token), //'?auth=' + token,             
            }
            if(!!data){
                axiosConfig.data = data;
            }
            axios(axiosConfig).then(function(response) {
                if(response.data == 'BAD_AUTH'){
                    router.push('login');
                }else{
                    successFunc(response);
                }
            }).catch(error => {
                console.log(error);
                //router.push('login');
            });
        }
    }
};
</script>
