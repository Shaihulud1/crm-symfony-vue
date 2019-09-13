<template>
    <v-dialog>
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
            @click=""
          >
            Disagree
          </v-btn>

          <v-btn
            color="green darken-1"
            text
            @click=""
          >
            Agree
          </v-btn>
        </v-card-actions>
      </v-card>
      </v-dialog>
</template>

<script>


export default {
    name: "ProductEditor",
};
</script>
