<template>
      <v-app id="inspire">
        <v-navigation-drawer v-model="drawer" app >
          <v-list dense>
            <v-list-item  v-for="menuItem in menu" :to="{path:menuItem.link}" v-bind:key="menuItem.name">
              <v-list-item-action>
                <v-icon>{{menuItem.icon}}</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>{{menuItem.label}}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list>
          <v-system-bar window class="collapsed-product" v-for="prod in collapsedProducts.newProds" v-bind:key="prod.id_mp" @click="openCollapse(prod.id_mp)">
            <span>{{ prod.prod_name | truncate(25, '...') }}</span>
            <div class="flex-grow-1"></div>
            <v-icon>mdi-checkbox-blank-outline</v-icon>
            <!-- <v-icon @click="closeProduct(prod.id_mp)">mdi-close</v-icon> -->
          </v-system-bar>
        </v-navigation-drawer>

        <v-app-bar app color="blue" dark >
          <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
          <v-toolbar-title>
              {{pageLabel}}
          </v-toolbar-title>
          <div class="flex-grow-1"></div>
          <h3>{{userData.fullName}}</h3>
        </v-app-bar>

        <v-content>
            <router-view ></router-view>
        </v-content>
        <productFormModal v-model="productFormModalForm" :modalData="modalData"></productFormModal>
        <loader></loader>
      </v-app>
</template>

<style lang="scss">
  .collapsed-product{
    cursor: pointer;
  }
  .collapsed-product{
    margin-top: 5px;
  }
</style>

<script>
import router from '../../router';
import newprods from '../../views/Newprods';
import productFormModal from "../../components/Product-edit-form.vue";
import axiosXHR from "../../components/AxiosXHR.vue";
import cookie from "../../components/Cookie";
import loader from '../../components/Loader';

export default {
    name:"BasicLayout",
    props: {
      source: String,
    },
    mounted: function()
    {
        this.$store.dispatch('fetchBrands');
        this.$store.dispatch('fetchSections');
        this.$store.dispatch('fetchProdForms');


        var self = this;
        let token = cookie.methods.getCookie("token");
        axiosXHR.methods.sendRequest('rest/user/bytoken/' + token, function(response){
            if(response.data == 'BAD_AUTH'){
                router.push('login');
            }else{
                let ids = [];
                self.userData.fullName = response.data.fullName;
                self.userData.id = response.data.id;
                if(typeof response.data.in_work != 'undefined' && typeof response.data.in_work.NP != 'undefined')
                {
                    response.data.in_work.NP.map((el) => {
                        ids.push(el.id_mp);
                    });
                    response.data.in_work.NP.forEach(function(elem, index){
                        let isset = false;
                        self.collapsedProducts.newProds.forEach(function(collapseElem){
                            if(elem.id_mp == collapseElem.id_mp){
                                isset = true;
                            }
                        });
                        if(!isset){
                            self.collapsedProducts.newProds.push(elem);
                        }
                    });
                }
                if(ids.length == 0)
                {
                for (var i = self.collapsedProducts.newProds.length; i > 0; i--) {
                    self.collapsedProducts.newProds.pop();
                }
                }else{
                    self.collapsedProducts.newProds.forEach(function(collapseElem, index, object){
                        if(!ids.includes(collapseElem.id_mp)){
                            object.splice(index, 1);
                        }
                    });
                }
                setTimeout(() => {
                    self.userSession()
                }, 1000);
            }
        });

    },
    methods:{
        userSession: function()
        {
            let token = cookie.methods.getCookie("token");
            let userID = this.userData.id;
            let self = this;
            axiosXHR.methods.sendRequest('rest/user/session/' + userID + '/'+ token, function(response){
                if(response.data == 'BAD_AUTH'){
                    router.push('login');
                }else{
                    setTimeout(() => {
                        self.userSession()
                    }, 30000);
                }
            });
        },
        closeProduct: function(id_mp)
        {
            if(confirm("Вы уверены, что хотите закрыть товар? Изменения не будут сохранены.")){
                let self = this;
                self.collapsedProducts.newProds.forEach(function(elem, key){
                    if(elem.id_mp == id_mp){
                        self.collapsedProducts.newProds.splice(key, 1);
                    }
                });
            }
        },
        openCollapse: function(id_mp)
        {   
            let self = this;
            let token = cookie.methods.getCookie("token");
            self.$store.commit('updateLoad', true);
            axiosXHR.methods.sendRequest('rest/new-product/openproduct/' + id_mp + '/'+ self.userData.id + '/' + token, function(response){
                self.$store.commit('updateLoad', false);
                if(response.data == 'BAD_AUTH'){
                    router.push('login');
                }else{
                    switch (response.data) {
                        case 'BAD_PROD':
                            alert('Такого товара не существует, обновите страницу');
                            return;
                        break;
                        case 'IN_WORK':
                            alert('Товар уже взят в работу другим пользователем, обновите страницу');
                            return;
                        break;
                        default:
                            let modalProduct = false;
                            if(self.collapsedProducts.newProds.length > 0)
                            {
                                self.collapsedProducts.newProds.forEach(function(elem){
                                    if(elem.id_mp == id_mp){
                                        modalProduct = elem;
                                    }
                                });
                            }
                            if(!modalProduct){
                                modalProduct = response.data;
                                self.collapsedProducts.newProds.push(modalProduct);
                            }
                            self.modalData = modalProduct;
                            self.modalData.displayName = response.data.prod_name;
                            self.productFormModalForm = true;
                        break;

                    }

                }
            });
        },
    },
    computed:{
      pageLabel: function()
      {
            return this.$route.meta.label || "";
      },
    },
    components:{
        productFormModal,
        loader
    },
    data: () => ({
        modalData: {},
        productFormModalForm: false,
        menu: [
            { name: "Newprods", label: "Новые товары", icon: "mdi-cube-send", link: "/"},
            { name: "Listprods", label: "Список товаров", icon: "mdi-clipboard-list", link: "/list-prods"},
            { name: "Sections", label: "Дерево разделов", icon: "mdi-file-tree", link: "/sections"},
            { name: "Brands", label: "Дерево брендов", icon: "mdi-file-tree", link: "/brands"},
            { name: "Form", label: "Форма выпуска", icon: "mdi-inbox", link: "/prod-form"},
            { name: "Mnn", label: "МНН", icon: "mdi-rotate-3d-variant", link: "/mnn"},
            { name: "Description", label: "Описания", icon: "mdi-card-text-outline", link: "/description"},
        ],
        drawer: null,
    }),
}
</script>
