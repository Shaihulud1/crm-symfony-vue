export default {
    actions: {
        loadMountFalse: function(ctx)
        {
            ctx.commit('updateLoad', false);
        }
    },
    mutations: {
        updateLoad: function (state, loadStatus) {         
            state.isLoad = loadStatus;
        }
    },
    state: {
        isLoad: Boolean,
    },
    getters: {
        isLoadStatus(state) 
        {
            return state.isLoad
        }
    },
}