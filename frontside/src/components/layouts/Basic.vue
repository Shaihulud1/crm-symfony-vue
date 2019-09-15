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
          <v-system-bar window dark class="collapsed-product" v-for="prod in collapsedProds" v-bind:key="prod.id_mp">
            <span>{{ prod.name | truncate(25, '...') }}</span>
            <div class="flex-grow-1"></div>
            <v-icon>mdi-checkbox-blank-outline</v-icon>
          </v-system-bar>
        </v-navigation-drawer>

        <v-app-bar app color="blue" dark >
          <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
          <v-toolbar-title>
              {{pageLabel}}
              <!-- Application -->
          </v-toolbar-title>
          <div class="flex-grow-1"></div>
          <v-btn tile outlined color="white" @click="reloadTable">
            <v-icon left>mdi-reload</v-icon>Обновить таблицу
          </v-btn>
          <!-- <v-btn icon text>
            <v-icon>mdi-reload</v-icon>
            <v-text>Обновить страницу</v-text>
          </v-btn> -->
        </v-app-bar>

        <v-content>
            <router-view></router-view>
        </v-content>
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
export default {
    computed: {
        pageLabel: function()
        {
            return this.$route.meta.label || "";
        }
    },
    props: {
      source: String,
    },
    methods:{
        reloadTable: function(e)
        {
            this.$router.go();
        }
    },
    data: () => ({
        collapsedProds: [
            { name: "Нурофен 25 грам с апельсином в упаковке", id_mp: 1321},
            { name: "Нурофен 25 грам с апельсином в упаковке", id_mp: 1331},
            { name: "Нурофен 25 грам с апельсином в упаковке", id_mp: 13651},
        ],
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
