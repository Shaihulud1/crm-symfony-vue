import axiosXHR from "../../components/AxiosXHR";
export default {

    actions: {
        fetchSections: function (ctx) {
            axiosXHR.methods.sendRequest('rest/inputs/section', function (response) {
                if (response.data == 'BAD_AUTH') {
                    router.push('login');
                } else {
                    ctx.commit('updateSections', response.data);
                }
            });
        }
    },
    mutations: {
        updateSections: function (state, sections) {
            state.sections = sections;
        }
    },
    state: {
        sections: [],
    },
    getters: {
        sectionSelect(state) {
            return state.sections
        }
    },
}