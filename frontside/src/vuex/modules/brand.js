import axiosXHR from "../../components/AxiosXHR";
export default{

    actions: {
        fetchBrands: function(ctx){
            axiosXHR.methods.sendRequest('rest/inputs/brand', function (response) {
                if (response.data == 'BAD_AUTH') {
                    router.push('login');
                } else {
                    ctx.commit('updateBrands', response.data);
                }
            });
        }
    },
    mutations: {
        updateBrands: function(state, brands){
            state.brands = brands;
        }
    },
    state: {
        brands: [],
    },
    getters: {
        brandSelect(state)
        {
            return state.brands
        }
    },
}