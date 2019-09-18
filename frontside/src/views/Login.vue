<template>
    <v-app id="inspire">
      <v-content>
        <v-container class="fill-height" fluid>
          <v-row align="center" justify="center" >
            <v-col cols="12" sm="8" md="4">
              <v-card class="elevation-12">
                <v-toolbar color="blue" dark flat >
                  <v-toolbar-title>Вход в систему</v-toolbar-title>
                  <div class="flex-grow-1"></div>
                </v-toolbar>
                <v-card-text>
                  <v-form @submit="auth">
                    <v-text-field require label="Логин" name="login" v-model="login" prepend-icon="person" type="text" :rules="emptyRules"></v-text-field>
                    <v-text-field require id="password" label="Пароль" v-model="pass" name="password" prepend-icon="lock" type="password" :rules="emptyRules"></v-text-field>
                  </v-form>
                </v-card-text>
                <v-alert type="error" v-if="error">{{error}}</v-alert>
                <v-card-actions>
                  <div class="flex-grow-1"></div>
                  <v-btn color="blue white--text" @click="auth" :disabled="isDisabled">Войти</v-btn>
                </v-card-actions>
              </v-card>
            </v-col>
          </v-row>
        </v-container>
      </v-content>
    </v-app>
</template>

<script>

import cookie from '../components/Cookie';
import axiosXHR from '../components/AxiosXHR';
import router from '../router';

export default {
    name: "Login",
    components: {
        axiosXHR
    },
    methods:{
        auth: function(e)
        {
            this.isDisabled = true;
            this.error = false;
            if(!this.login || !this.pass){
                this.error = "Не все поля заполненны";
                this.isDisabled = false;
                return;
            }
            let self = this;
            let data = new FormData();
            data.append('username', this.login);
            data.append('password', this.pass);
            axiosXHR.methods.sendRequest('api/login', function(response){
                if(response.data.errors == 'BAD_AUTH')
                {
                    self.error = "Неверный логин или пароль";
                }
                else if(response.data){
                    cookie.methods.setCookie('token', response.data);
                    router.push({path: '/'});
                }
                self.isDisabled = false;
                return; 
            }, 'post', data);
        },
    },
    data: () => {
        return {
            isDisabled: false,
            error: false,
            login: "",
            pass: "",
            emptyRules: [
              v => !!v || 'Пустое поле',
            ],
        }
    }
};
</script>
