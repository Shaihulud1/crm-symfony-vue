<template>
    <v-dialog v-model="show">
      <v-card>

        <v-toolbar color="blue white--text">
          <v-toolbar-title>Товар (*Создание) + Нурофен 2.5 гр</v-toolbar-title>
          <div class="flex-grow-1"></div>
          <v-btn icon @click="show=false">
            <v-icon>mdi-arrow-collapse-left</v-icon>
          </v-btn>
          <v-btn icon @click="show=false">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-toolbar>

        <v-card-title class="headline">
          ID: 1321 <br>
          Название из Вита-системы: Нурофен 2.5 гр
        </v-card-title>
        <v-card-text>
          <v-switch v-model="isProductProcessed" v-bind:label="processStatus" color="success" hide-details disabled></v-switch>
        </v-card-text>
        
        <v-form lazy-validation>
        <v-card-text>
          <v-btn class="prod-popup-btn" color="success" @click="submit">Записать и закрыть</v-btn>
          <v-btn class="prod-popup-btn" color="warning" @click="submit">Закрыть без изменений</v-btn>
        </v-card-text>
        <v-tabs centered>
          <v-tab>
            <v-icon left>mdi-filter-outline</v-icon>
            Фильтры
          </v-tab>
          <v-tab>
            <v-icon left>mdi-settings</v-icon>
            Параметры
          </v-tab>
          <v-tab>
            <v-icon left>mdi-card-text-outline</v-icon>
            Описание
          </v-tab>

          <v-tab-item>
            <v-card flat>
              <v-card-text>
                  <v-text-field
                    v-model="name"
                    :rules="nameRules"
                    outlined
                    label="Наименование"
                    required
                  >
                  </v-text-field>
                  <v-select
                    v-model="brand"
                    :items="['','La-roche', 'Brand 2']"
                    label="Бренд"
                    outlined
                    >
                  </v-select>
                  <v-select
                    v-model="gammas"
                    :items="['Gamma 1', 'Gamma 2']"
                    label="Гамма"
                    multiple
                    outlined
                    >
                  </v-select>
                  <v-select
                    v-model="section"
                    :rules="requiredSelectRules"
                    :items="['Section 1', 'Section 2']"
                    label="Раздел"
                    outlined
                    required
                    >
                  </v-select>
                  <v-select
                    v-model="subsection"
                    :rules="requiredSelectRules"
                    :items="['subsect 1', 'subsect 2']"
                    label="Подраздел"
                    outlined
                    required
                    >
                  </v-select>
                  <v-select
                    v-model="formProd"
                    :rules="requiredSelectRules"
                    :items="['Form 1', 'Form 2']"
                    label="Форма выпуска"
                    outlined
                    required
                    >
                  </v-select>
                  <v-text-field
                    v-model="formProdShort"
                    outlined
                    readonly
                  >         
                  </v-text-field>         
              </v-card-text>
            </v-card>
          </v-tab-item>

          <v-tab-item>
            <v-card flat>
              <v-card-text>
                  <v-text-field
                    v-model="box"
                    outlined
                    label="Вид упаковки"
                  >
                  </v-text-field>
                  <v-text-field
                    v-model="manufactory"
                    :rules="manufactoryRules"
                    required
                    outlined
                    label="Производитель"
                  >
                  </v-text-field>
                  <v-select
                    v-model="formProd2"
                    :items="['Form 1', 'Form 2']"
                    label="Форма выпуска"
                    outlined
                    >
                  </v-select> 
                  <v-text-field
                    v-model="dosage"
                    :rules="dosageRules"
                    outlined
                    label="Дозировка"
                  >
                  </v-text-field>                                   
                  <v-text-field
                    v-model="unit"
                    outlined
                    label="Единица измерения"
                  >
                  </v-text-field>                                   
                  <v-text-field
                    v-model="volume"
                    outlined
                    label="Кол-во (объем) в упаковке"
                  >
                  </v-text-field>                                   
                  <v-text-field
                    v-model="storageCond"
                    outlined
                    label="Условия хранения"
                  >
                  </v-text-field>                                   
                  <v-text-field
                    v-model="latinName"
                    outlined
                    label="Название на латинице"
                  >     
                  </v-text-field>                              
                  <v-text-field
                    v-model="rusName"
                    outlined
                    label="Русское название"
                  >     
                  </v-text-field>                              
                  <v-text-field
                    v-model="rusName"
                    outlined
                    label="Русское название"
                  >     
                  </v-text-field>
                  <v-switch v-model="isRecipeNeeded" label="Товар по рецепту" color="success"></v-switch>                           
              </v-card-text>
            </v-card>
          </v-tab-item>

          <v-tab-item>
            <v-card flat>
              <v-card-text>
                <v-tabs vertical>
                  <v-tab>
                    Подробное описание
                  </v-tab>
                  <v-tab>
                    Показания к применению
                  </v-tab>
                  <v-tab>
                    Способ применения
                  </v-tab>
                  <v-tab>
                    Состав
                  </v-tab>
                  <v-tab>
                    Противопоказания
                  </v-tab>
                  <v-tab-item>
                    <v-card flat>
                      <v-card-text>
                        test
                      </v-card-text>
                    </v-card>
                  </v-tab-item>
                  <v-tab-item>
                    <v-card flat>
                      <v-card-text>
                        test
                      </v-card-text>
                    </v-card>
                  </v-tab-item>
                  <v-tab-item>
                    <v-card flat>
                      <v-card-text>
                        test
                      </v-card-text>
                    </v-card>
                  </v-tab-item>
                  <v-tab-item>
                    <v-card flat>
                      <v-card-text>
                        test
                      </v-card-text>
                    </v-card>
                  </v-tab-item>
                  <v-tab-item>
                    <v-card flat>
                      <v-card-text>
                        test
                      </v-card-text>
                    </v-card>
                  </v-tab-item>
                </v-tabs>
              </v-card-text>
            </v-card>
          </v-tab-item>

              
        </v-tabs>

        </v-form>

      </v-card>
      </v-dialog>
</template>

<script>


export default {
    name: "PopupProductEditor",
    props:{
      value:Boolean,
    },
    computed: {
      processStatus: function()
      {
        return this.isProductProcessed ? "Обработан" : "Не обработан";
      },
      show: {
        get () {
          return this.value
        },
        set (value) {
          this.$emit('input', value)
        },
      }
    },    
    data: () => {
      return {
        isProductProcessed: true,
        /*form*/
          /*tab1*/
            name: "",
            nameRules: [
              v => !!v || 'Название не может быть пустым',
              v => (v && v.length > 2) || 'Неверное заполнение',
            ],
            brand: "",
            gammas: [],
            section: "",
            subsection: "",
            formProd: "",
            formProdShort:"",
            requiredSelectRules: [
              v => v.length > 0 || 'Должен быть выбран элемент',
            ],
           /**/
           /*tab2*/
            box: "",
            manufactory:"",
            manufactoryRules: [
              v => !!v || 'Производитель не может быть пустым',
              v => (v && v.length > 2) || 'Неверное заполнение',
            ],
            formProd2: "",
            dosage: "",
            dosageRules: [
              v => (v && /^[0-9]+$/.test(v) ) || 'Должно быть число',
            ],
            unit: "",
            volume: "",
            storageCond: "",
            latinName: "",
            rusName: "",
            isRecipeNeeded: false,
           /**/

        /**/
      
      }
    }
};
</script>

<style lang="scss" scoped>
  .prod-popup-btn{
    margin-right: 15px;
  }
</style>
