<template>
    <v-card>
      <v-card-title>
        <div class="flex-grow-1"></div>
        <v-text-field
          v-model="search"
          append-icon="search"
          label="Поиск"
          single-line
          hide-details
          hide-default-header
          hide-default-footer
        ></v-text-field>
      </v-card-title>
      <v-app>
        <v-data-table
          :headers="headers"
          :items="products"
          :search="search"
        >
        <template v-slot:body="{ items }">
          <tbody>
            <tr v-for="item in items" :key="item.id_mp"  class="product-table-item" @dblclick="openModal">
              <td>{{ item.id_mp }}</td>
              <td>{{ item.prod_name }}</td>
              <td>{{ item.date_insert }}</td>
              <td>{{ item.in_work }}</td>
            </tr>
          </tbody>
        </template>
        </v-data-table>
      </v-app>
      <productFormModal v-model="productFormModalForm"></productFormModal>
  </v-card>

</template>

<style lang="scss">
  .product-table-item{
    cursor: pointer;
  }
</style>

<script>
  import productFormModal from "../components/Product-edit-form.vue";

  export default {
    name: "NewProductsList",
    components:{
        productFormModal
    },
    methods: {
      openModal: function(e)
      {
        this.productFormModalForm = true;
      }
    },
    data: () => {
      return {
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
        products: [
          {
            id_mp: 159,
            prod_name: 'Фенобарбитал',
            in_work: 1,
            date_insert: "19.08.2019",
          },
          {
            id_mp: 31,
            prod_name: 'Ааа',
            in_work: 1,
            date_insert: "19.08.2019",
          },
          {
            id_mp: 54,
            prod_name: 'Нурофен',
            in_work: 1,
            date_insert: "19.08.2019",
          },
          {
            id_mp: 23,
            prod_name: 'Ношпа',
            in_work: 0,
            date_insert: "19.08.2019",
          },

        ],
      }
    },
  }
</script>
