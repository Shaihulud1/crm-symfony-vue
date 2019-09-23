export default {
    actions: {
        // loadMountFalse: function (ctx) {
        //     ctx.commit('updateLoad', false);
        // }
    },
    mutations: {
        // updateLoad: function (state, loadStatus) {
        //     state.isLoad = loadStatus;
        // }
    },
    state: {
        sectionRequireFields: {
            1: {
                name: 'Лекарства и Бады',
                require: ['dosage', 'unit', 'volume'],
            }, 
            2: {
                name: 'Активная косметика',
                require: ['dosage', 'unit', 'volume'],
            },
            3: {
                name: 'Мама и малыш',
                require: ['dosage', 'unit', 'volume'],
            },
            4: {
                name: 'Медицинские приборы',
                require: ['dosage', 'unit', 'volume'],
            },
            5: {
                name: 'Ортопедия',
                require: ['dosage', 'unit', 'volume'],
            },
            6: {
                name: 'Красота и здоровье',
                require: ['dosage', 'unit', 'volume'],
            }
        }
    },
    getters: {
        sectionRequireFields: function (state, sectID){
            let sectRequire = state.sectionRequireFields;
            if (sectRequire.sectID != 'undefined'){
                return sectRequire.sectID;
            }
        },
    },
}