<template>
    <v-dialog
      v-model="isLoad"
      persistent
      width="300"
    >
      <v-card
        color="primary"
        dark
      >
        <v-card-text>
          Идет загрузка...подождите
          <v-progress-linear
            indeterminate
            color="white"
            class="mb-0"
          ></v-progress-linear>
        </v-card-text>
      </v-card>
    </v-dialog>
</template>

<script>
export default {
  mounted: function()
  {
      this.$store.dispatch('loadMountFalse');
  },
  computed:{
      isLoad: function()
      {
          return this.$store.getters.isLoadStatus;
      }
  }
}
</script>


