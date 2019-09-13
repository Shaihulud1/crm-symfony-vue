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
      <v-data-table
        :headers="headers"
        :items="products"
        :search="search"
      >
          <template v-slot:item.action="{ item }" v-slot:activator="{ on }">
            <v-icon
              small
              class="mr-2"
              @click="openEditProductModal(item)">
              edit
            </v-icon>
          </template>
      </v-data-table>
      <productFormModal></productFormModal>
  </v-card>

</template>
<script>
  import productFormModal from "../components/Product-edit-form.vue";

  export default {
    components:{
        productFormModal
    },
    methods: {
    },
    data: () => {
      return {
        selected:[],
        search: '',
        headers: [
          { text: 'ID Товара', value: 'id_mp' },
          { text: 'Название', value: 'prod_name' },
          { text: 'В работе', value: 'in_work' },
          { text: 'Дата добавления', value: 'date_insert' },
          { text: 'Правка', value: 'action', sortable: false },
        ],
        products: [
          {
            id_mp: 159,
            prod_name: 'Нурофен',
            in_work: 1,
            date_insert: "19.08.2019",
          },
          {
            id_mp: 222,
            prod_name: 'Ношпа',
            in_work: 0,
            date_insert: "19.08.2019",
          },
          {
            id_mp: 21341,
            prod_name: 'Какой-то товар',
            in_work: 1,
            date_insert: "19.08.2019",
          },
          {
            id_mp: 159,
            prod_name: 'Нурофен',
            in_work: 1,
            date_insert: "19.08.2019",
          },
          {
            id_mp: 222,
            prod_name: 'Ношпа',
            in_work: 0,
            date_insert: "19.08.2019",
          },
          {
            id_mp: 21341,
            prod_name: 'Какой-то товар',
            in_work: 1,
            date_insert: "19.08.2019",
          },
        ],
      }
    },
  }
</script>
