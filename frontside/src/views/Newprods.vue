<template>
    <v-card>
    <v-dialog
      v-model="dialog"
    >
      <v-card>
        <v-card-title class="headline">Use Google's location service?</v-card-title>

        <v-card-text>
          Let Google help apps determine location. This means sending anonymous location data to Google, even when no apps are running.
        </v-card-text>

        <v-card-actions>
          <div class="flex-grow-1"></div>

          <v-btn
            color="green darken-1"
            text
            @click="dialog = false"
          >
            Disagree
          </v-btn>

          <v-btn
            color="green darken-1"
            text
            @click="dialog = false"
          >
            Agree
          </v-btn>
        </v-card-actions>
      </v-card>
      </v-dialog>
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
  </v-card>

</template>
<script>

  
  export default {
    methods: {
        openEditProductModal: function(e)
        {
            this.dialog = true;
            console.log(e);
        }
    },
    data () {
      return {
        dialog: false,
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
        ],
      }
    },
  }
</script>
