<template>
    <v-app id="inspire">
      <v-content>
        <v-container class="fill-height" fluid>
          <v-row align="center"justify="center" >
            <v-col cols="12" sm="8" md="4">
              <v-card class="elevation-12">
                <v-toolbar color="blue" dark flat >
                  <v-toolbar-title>Вход в систему</v-toolbar-title>
                  <div class="flex-grow-1"></div>
                </v-toolbar>
                <v-card-text>
                  <v-form @submit="auth">
                    <v-text-field label="Логин" name="login" v-model="login" prepend-icon="person" type="text" :rules="emptyRules"></v-text-field>
                    <v-text-field id="password" label="Пароль" v-model="pass" name="password" prepend-icon="lock" type="password" :rules="emptyRules"></v-text-field>
                  </v-form>
                </v-card-text>
                <v-card-actions>
                  <div class="flex-grow-1"></div>
                  <v-btn color="blue white--text" @click="auth">Войти</v-btn>
                </v-card-actions>
              </v-card>
            </v-col>
          </v-row>
        </v-container>
      </v-content>
    </v-app>
</template>

<script>


export default {
    name: "Login",
    methods:{
        auth: function(e)
        {
            let login = this.login,
                pass = this.pass;
            
        },
    },
    data: () => {
        return {
            login: "",
            pass: "",
            emptyRules: [
              v => !!v || 'Пустое поле',
            ],
        }
    }
};
</script>
