<template>
  <component :is="layout">

  </component>
</template>

<script>

const defaultLayout = "basic";

export default {
  computed:{
    layout() {
      return (this.$route.meta.layout || defaultLayout)
    }
  },
  name: 'App',

  data: () => ({
    //
  }),
};
</script>
