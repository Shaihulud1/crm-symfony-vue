<template>
    <v-card>
      <v-card-title>
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
          hide-default-footer
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
  import axios from 'axios';
  import cookie from '../components/Cookie';
  import router from '../router';

  export default {
    name: "NewProductsList",
    mounted: function()
    {
        let token = cookie.methods.getCookie("token"),
            self = this;
        axios({
            method: 'get',
            url: 'http://127.2.2.2/rest/product?auth=' + token,
        }).then(function(response) {
            if(response.data == 'BAD_AUTH'){
                router.push('login');
            }else{
                self.newProdsList = response.data;
            }
        }).catch(error => {
            router.push('login');
        });
    },
    computed: {
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
    },
    methods: {
      openModal: function(id_mp)
      {
          let token = cookie.methods.getCookie("token"),
              self = this;
          axios({
              method: 'get',
              url: 'http://127.2.2.2/rest/product/'+id_mp+'?auth=' + token,
          }).then(function(response) {
              if(response.data == 'BAD_AUTH'){
                  router.push('login');
              }else{
                 self.modalData = {
                     id_mp: response.data.id_mp || "",
                     name: response.data.prod_name || "",
                 };
                 self.productFormModalForm = true;
              }
          }).catch(error => {
              router.push('login');
          });;
        // this.modalData = false;
        // let savedProducts = JSON.parse(localStorage.getItem('storageProducts'));
        // if(savedProducts !== null)
        // {
        //     savedProducts.forEach(element => {
        //         if(element.id_mp == id_mp){
        //             this.modalData = element;
        //         }
        //     });
        // }
        // if(!this.modalData)
        // {
        //   //get from DB;
        //   if(savedProducts == null){
        //     savedProducts = [];
        //   }
        //   this.modalData = {name: 'Nurofen', id_mp: 676};
        //   savedProducts.push(this.modalData);
        //   localStorage.setItem('storageProducts', JSON.stringify(savedProducts))
        // }



      }
    },
    data: () => {
      return {
        modalData: {name: 'Нурофен'},
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
