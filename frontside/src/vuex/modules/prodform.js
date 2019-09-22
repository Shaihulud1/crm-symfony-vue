import axiosXHR from "../../components/AxiosXHR";
export default {
    actions: {
        fetchProdForms: function (ctx) {
            axiosXHR.methods.sendRequest('rest/inputs/prodform', function (response) {
                if (response.data == 'BAD_AUTH') {
                    router.push('login');
                } else {
                    ctx.commit('updateProdForms', response.data);
                }
            });
        }
    },
    mutations: {
        updateProdForms: function (state, prodForms) {
            state.prodForms = prodForms;
        }
    },
    state: {
        prodForms: [],
    },
    getters: {
        prodFormSelect(state) {
            return state.prodForms
        }
    },
}