import Vue from 'vue'
import Vuex from 'vuex'
import brand from './modules/brand'
import section from './modules/section'
import prodform from './modules/prodform'
import loader from './modules/loader'
import fieldsRules from './modules/fieldsRules'


Vue.use(Vuex)


export default new Vuex.Store({
    modules: {brand, section, prodform, loader, fieldsRules},
})