<template>
    <v-card>
      <v-card-title>
        <v-btn tile outlined @click="reloadTable" :disabled="isDisable">
          <v-icon left>mdi-reload</v-icon>Обновить таблицу <span class="reload-timer" v-if="isDisable">({{timers.disableReloadTimer}})</span>
        </v-btn>
        <div class="flex-grow-1"></div>
        <v-text-field
          v-model="search"
          append-icon="search"
          label="Поиск"
          single-line
        ></v-text-field>
      </v-card-title>
      <v-app>
        <v-data-table
          :headers="headers"
          :items="newProdsList"
          :search="search"

        >
        <template v-slot:body="{ items }">
          <tbody>
            <tr v-for="(item, index) in items" :key="index"  class="product-table-item" @dblclick="openModal(item.id_mp)">
              <td>{{ item.id_mp }}</td>
              <td>{{ item.prod_name }}</td>
              <td>{{ item.date_insert }}</td>
              <td>{{ item.in_work }}</td>
            </tr>
          </tbody>
        </template>
        </v-data-table>
      </v-app>
      <productFormModal v-model="productFormModalForm" :modalData="modalData"></productFormModal>
  </v-card>

</template>

<style lang="scss">
  .product-table-item{
    cursor: pointer;
  }
</style>

<script>
  import productFormModal from "../components/Product-edit-form.vue";
  import cookie from '../components/Cookie';
  import axiosXHR from '../components/AxiosXHR';
  import router from '../router';

  export default {
    name: "NewProductsList",
    mounted: function()
    {
        let self = this;
        self.countDown();
        axiosXHR.methods.sendRequest('rest/product', function(response){
            if(response.data == 'BAD_AUTH'){
                router.push('login');
            }else{
                self.newProdsList = response.data;
            }
        });
    },
    computed: {
        isDisable:{
            set: function(val)
            {
                this.timers.disableReloadTimer = val;
            },
            get: function()
            {
                return this.timers.disableReloadTimer > 0 ? true : false;
            }
        },
        newProdsList:{
            get: function()
            {
                return this.products;
            },
            set: function(val)
            {
                this.products = val;
                return this.products;
            },
        }
    },
    components:{
        productFormModal,
        axiosXHR
    },
    methods: {
      countDown: function() {
        let self = this;
        if (this.timers.disableReloadTimer > 0) {
          return setTimeout(() => {
            let currTime = self.timers.disableReloadTimer -= 1;
            self.isDisable = currTime;
            self.countDown();
          }, 1000);
        }
      },
      reloadTable: function()
      {
          let self = this;
          axiosXHR.methods.sendRequest('rest/product', function(response){
              if(response.data == 'BAD_AUTH'){
                  router.push('login');
              }else{
                  self.newProdsList = response.data;
              }
              self.isDisable = 15;
              self.countDown();
          });
      },
      openModal: function(id_mp)
      {
          let self = this;
          let token = cookie.methods.getCookie("token");
          axiosXHR.methods.sendRequest('rest/product/openproduct/' + id_mp+ '/'+ self.userData.id + '/' + token, function(response){
              if(response.data == 'BAD_AUTH'){
                  router.push('login');
              }else{
                  switch (response.data) {
                    case 'BAD_PROD':
                        alert('Такого товара не существует, обновите страницу');
                        return;
                    break;
                    case 'IN_WORK':
                        alert('Товар уже взят в работу другим пользователем');
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
      }
    },
    data: () => {
      return {
        modalData: {},
        productFormModalForm: false,
        selected:[],
        search: '',
        headers: [
          { text: 'ID Товара', value: 'id_mp' },
          { text: 'Название', value: 'prod_name' },
          { text: 'Дата добавления', value: 'date_insert' },
          { text: 'В работе', value: 'in_work' },
          // { text: 'Правка', value: 'action', sortable: false },
        ],
        products: [],
      }
    },
  }
</script>
