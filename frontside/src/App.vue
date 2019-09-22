<template>
    <component :is="layout">

    </component>
</template>

<script>

const defaultLayout = "basic";

import router from './router';

import cookie from './components/Cookie';
import axiosXHR from './components/AxiosXHR';

router.beforeEach((to, from, next) => {
    let token = cookie.methods.getCookie("token");
    if(to.name != 'login' && !token){
        next('/login');
    }
    next();
});
export default {
  computed: {
    layout() {
      return (this.$route.meta.layout || defaultLayout)
    }
  },
  components:{},
  name: 'App',

  data: () => ({
    //
  }),
};
</script>
