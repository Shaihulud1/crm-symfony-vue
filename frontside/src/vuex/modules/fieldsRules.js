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
        sectionRequireFields: [
            {
                name: 'all',
                require: {prod_name: 'Наименование', section: 'Раздел', subsection: 'Подраздел',  
                          formProd: 'Форма выпуска', formProdShort: 'Сокращенная форма выпуска', 
                          manufactory: 'Производитель'},
            },
            {
                name: 'Лекарства и Бады',
                require: {dosage: 'Дозировка', unit: 'Единица измерения', 
                          volume: 'Кол-во в упаковке'},
            }, 
            {
                name: 'Активная косметика',
                require: {volume: 'Кол-во в упаковке', latinName: 'Название на латинском', 
                          rusName: 'Название на русском', brand: 'Бренд'},
            },
            {
                name: 'Мама и малыш',
                require: {brand: 'Бренд', unit: 'Единица измерения', 
                          latinName: 'Название на латинском', rusName: 'Название на русском'},
            },
            {
                name: 'Медицинские приборы',
                require: {latinName: 'Название на латинском', rusName: 'Название на русском',
                          brand: 'Бренд'},
            },
            {
                name: 'Ортопедия',
                require: {brand: 'Бренд', volume: 'Кол-во в упаковке', 
                          latinName: 'Название на латинском', rusName: 'Название на русском'},
            },
            {
                name: 'Красота и здоровье',
                require: {brand: 'Бренд', volume: 'Кол-во в упаковке', 
                          latinName: 'Название на латинском', rusName: 'Название на русском'},
            }
        ]
    },
    getters: {
        sectionRequireFields(state) {
            return state.sectionRequireFields
        }
    },
}