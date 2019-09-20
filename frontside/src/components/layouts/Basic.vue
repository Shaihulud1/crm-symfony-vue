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
          <v-system-bar window class="collapsed-product" v-for="prod in collapsedProducts" v-bind:key="prod.id_mp" @click="openCollapse(prod.id_mp)">
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

export default {
    name:"BasicLayout",
    props: {
      source: String,
    },
    mounted: function()
    {
      var inputs = ["brand", "section", "prodform"],
          self = this;
      inputs.forEach(function(inputItem){
          axiosXHR.methods.sendRequest('rest/inputs/'+ inputItem, function(response){
              if(response.data == 'BAD_AUTH'){
                  router.push('login');
              }else{
                  let storageItem = inputItem + 'Storage';
                  console.log(storageItem)
                  if(self[storageItem] != 'underfied' && self[storageItem].length > 0)
                  {
                      self[storageItem].forEach(function(e, i){
                          self[storageItem].splice(i, 1);
                      });
                  }
                  axiosXHR.methods.sendRequest('rest/inputs/' + inputItem, function(response){
                      response.data.forEach(function(elem){
                          self[storageItem].push(elem);
                      });
                  });
              }
          });
      });
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
                    self.collapsedProducts.forEach(function(collapseElem){
                        if(elem.id_mp == collapseElem.id_mp){
                            isset = true;
                        }
                    });
                    if(!isset){
                        self.collapsedProducts.push(elem);
                    }
                });
            }
            self.collapsedProducts.forEach(function(collapseElem, index){
                if(!ids.includes(collapseElem.id_mp)){
                   self.collapsedProducts.splice(index, 1);
                }
            });
        }
      });

    },
    methods:{
        closeProduct: function(id_mp)
        {
            if(confirm("Вы уверены, что хотите закрыть товар? Изменения не будут сохранены.")){
                let self = this;
                self.collapsedProducts.forEach(function(elem, key){
                    if(elem.id_mp == id_mp){
                        self.collapsedProducts.splice(key, 1);
                    }
                });
            }
        },
        openCollapse: function(id_mp)
        {
            let self = this;
            let token = cookie.methods.getCookie("token");
            axiosXHR.methods.sendRequest('rest/product/openproduct/' + id_mp + '/'+ self.userData.id + '/' + token, function(response){
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
                            if(self.collapsedProducts.length > 0)
                            {
                                self.collapsedProducts.forEach(function(elem){
                                    if(elem.id_mp == id_mp){
                                        modalProduct = elem;
                                    }
                                });
                            }
                            if(!modalProduct){
                                modalProduct = response.data;
                                self.collapsedProducts.push(modalProduct);
                            }
                            self.modalData = {
                              id_mp: modalProduct.id_mp || "",
                              name: modalProduct.prod_name || "",
                            };
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
        productFormModal
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
