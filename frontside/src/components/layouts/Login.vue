<template>
    <router-view></router-view>
</template>

<script>
  export default {
    name:"LoginLayout",
    props: {
      source: String,
    },
    data: () => ({
      drawer: null,
    }),
  }
</script>
