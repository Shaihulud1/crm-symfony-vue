<template>
    <v-app>
      <router-view></router-view>
      <loader></loader>
    </v-app>
</template>

<script>
  import loader from '../../components/Loader';
  export default {
    name:"LoginLayout",
    components:{
      loader,
    },
    props: {
      source: String,
    },
    data: () => ({
      drawer: null,
    }),
  }
</script>
