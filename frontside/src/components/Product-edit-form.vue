<template>
    <v-dialog v-model="show" persistent>
      <v-card>

        <v-toolbar color="blue white--text">
          <v-toolbar-title>Товар (*Создание) + Нурофен 2.5 гр</v-toolbar-title>
          <div class="flex-grow-1"></div>
          <v-btn icon @click="collapseProduct">
            <v-icon>mdi-arrow-collapse-left</v-icon>
          </v-btn>
          <v-btn icon @click="closeProduct">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-toolbar>

        <v-card-title class="headline">
          ID: {{ id_mp }} <br>
          Название из Вита-системы: {{ name }}
        </v-card-title>
        <v-card-text>
          <v-switch v-model="isProductProcessed" v-bind:label="processStatus" color="success" hide-details disabled></v-switch>
        </v-card-text>

        <v-form lazy-validation>
        <v-card-text>
          <v-btn class="prod-popup-btn" color="success" @click="saveProduct">Записать и закрыть</v-btn>
          <v-btn class="prod-popup-btn" color="warning" @click="closeProduct">Закрыть без изменений</v-btn>
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
                    label="Бренд"
                    :items="brandSelect"
                    outlined
                    >
                  </v-select>
                  <v-select
                    v-model="gammas"
                    :items="gammaSelect"
                    label="Гамма"
                    multiple
                    outlined
                    >
                  </v-select>
                  <v-select
                    v-model="section"
                    :rules="requiredSelectRules"
                    :items="sectionSelect"
                    label="Раздел"
                    outlined
                    required
                    >
                  </v-select>
                  <v-select
                    v-model="subsection"
                    :rules="requiredSelectRules"
                    :items="subSectionSelect"
                    label="Подраздел"
                    outlined
                    required
                    >
                  </v-select>
                  <v-select
                    v-model="formProd"
                    :rules="requiredSelectRules"
                    :items="prodformSelect"
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
                          <v-textarea
                            background-color="amber lighten-4"
                            color="blue"
                            label="Подробное описание"
                            v-model="detail"
                          ></v-textarea>
                      </v-card-text>
                    </v-card>
                  </v-tab-item>
                  <v-tab-item>
                    <v-card flat>
                      <v-card-text>
                          <v-textarea
                            background-color="amber lighten-4"
                            color="blue"
                            label="Показания к применению"
                            v-model="howuse"
                          ></v-textarea>
                      </v-card-text>
                    </v-card>
                  </v-tab-item>
                  <v-tab-item>
                    <v-card flat>
                      <v-card-text>
                          <v-textarea
                            background-color="amber lighten-4"
                            color="blue"
                            label="Способ применения"
                            v-model="methoduse"
                          ></v-textarea>
                      </v-card-text>
                    </v-card>
                  </v-tab-item>
                  <v-tab-item>
                    <v-card flat>
                      <v-card-text>
                          <v-textarea
                            background-color="amber lighten-4"
                            color="blue"
                            label="Состав"
                            v-model="struct"
                          ></v-textarea>
                      </v-card-text>
                    </v-card>
                  </v-tab-item>
                  <v-tab-item>
                    <v-card flat>
                      <v-card-text>
                          <v-textarea
                            background-color="amber lighten-4"
                            color="blue"
                            label="Противопоказания"
                            v-model="contra"
                          ></v-textarea>
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

import axios from 'axios';
import cookie from '../components/Cookie';
import axiosXHR from '../components/AxiosXHR';

export default {
    name: "PopupProductEditor",
    props:{
      value:Boolean,
      modalData:Object,
      uploadInputs: Boolean,
    },
    watch: {
        section: function(e)
        {
          let self = this;
          let tempSubsect = [];
          e = (typeof e.value !== 'undefined') ? e.value : e;
          if(typeof this.sectionStorage !== 'undefined')
          {
              this.sectionStorage.forEach(function(sect, indexSect){
                  let chooseSect = true;
                  if(sect.id != e){
                    chooseSect = false;
                  }
                  sect.childs.forEach(function(child){
                    tempSubsect.push({value:child.id, text:child.name, disabled:!chooseSect});
                    if(self.subsection == child.id && !chooseSect)
                    {
                      self.subsection = '';
                    }
                  });
              });
              self.subSectionSelect = tempSubsect;
          }
          self.subSectionSelect = tempSubsect;
        },
        subsection: function(e)
        {
            let self = this;
            if(typeof this.sectionStorage !== 'undefined')
            {
                this.sectionStorage.forEach(function(sect, indexSect){
                  if(typeof sect.childs !== 'undefined'){
                      sect.childs.forEach(function(child){
                          if(e == child.id){
                              self.section = {value: sect.id, text: sect.name};
                          }
                      });
                  }
                });
            }
        },
        brand: function(e)
        {
            let self = this;
            let tempGamma = [];
            e = (typeof e.value !== 'undefined') ? e.value : e;
            if(typeof this.brandStorage !== 'undefined')
            {
                this.brandStorage.forEach(function(brand, indexSect){
                    let brandChoose = true;
                    if(brand.id != e){
                      brandChoose = false;
                    }
                    if(typeof brand.childs !== 'undefined')
                    {
                      brand.childs.forEach(function(child){
                        tempGamma.push({value: child.id, text: child.name, disabled: !brandChoose});
                        if(self.gammas.length > 0 && !brandChoose){
                            self.gammas.forEach(function(gammaItem, index){
                              if(gammaItem == child.id){
                                self.gammas.splice(index, 1);
                              }
                            });
                        }
                      });
                    }
                });
            }
            self.gammaSelect = tempGamma;
        },
        gammas: function(e)
        {
            let self = this;
            if(typeof this.brandStorage !== 'undefined')
            {
                this.brandStorage.forEach(function(brand, indexBrand){
                  if(typeof brand.childs !== 'undefined'){
                      brand.childs.forEach(function(child){
                          if(e == child.id){
                              self.brand = {value: brand.id, text: brand.name};
                          }
                      });
                  }
                });
            }
        },
        modalData: function(val)
        {
            this.id_mp = val.id_mp || "";
            this.name = val.name || "";
        }
    },
    methods: {
      getSelect: function(select, getChild = false)
      {
          let result = [];
          if(typeof select !== 'undefined' && select.length > 0){
              select.forEach(function(val){
                  let insertObj = {};
                  if(!getChild)
                  {
                      insertObj = {'text' : val.name, 'value' : val.id};
                      result.push(insertObj);
                  }
                  else if(typeof val.childs !== 'undefined' && val.childs.length > 0)
                  {
                      val.childs.forEach(function(childVal){
                          insertObj = {'text' : childVal.name, 'value' : childVal.id};
                          result.push(insertObj);
                      });
                  }
              });
          }
          return result;
      },
      collapseProduct: function()
      {
          this.show = false;
      },
      closeProduct: function()
      {
          if(confirm("Вы уверены, что хотите закрыть товар? Изменения не будут сохранены.")){
              let self = this;
              self.collapsedProducts.forEach(function(elem, key){
                  if(elem.id_mp == self.id_mp){
                      self.collapsedProducts.splice(key, 1);
                  }
              });
              this.show = false;
          }
      },
      saveProduct: function()
      {

      }
    },
    computed: {
      brandSelect:{
          set: function(val)
          {
              this.brandSelectData = val;
          },
          get: function(val)
          {
              if(typeof this.brandSelectData !== 'undefined' && this.brandSelectData.length < 1)
              {
                  this.brandSelectData = this.getSelect(this.brandStorage);
              }
              return this.brandSelectData;            
          }
      },
      gammaSelect:{
          set: function(val)
          {
              this.gammaSelectData = val;
          },
          get: function(val)
          {
              if(typeof this.gammaSelectData !== 'undefined' && this.gammaSelectData.length < 1)
              {
                  this.gammaSelectData = this.getSelect(this.brandStorage, true);
              }
              return this.gammaSelectData;            
          }
      },
      sectionSelect: {
          set: function(val)
          {
              this.sectionSelectData = val;
          },
          get: function()
          {
              if(typeof this.sectionSelectData !== 'undefined' && this.sectionSelectData.length < 1)
              {
                  this.sectionSelectData = this.getSelect(this.sectionStorage);
              }
              return this.sectionSelectData;
          }
      },
      subSectionSelect:{
          set: function(val)
          {
              this.subSectionSelectData = val;
          },
          get: function()
          {
              if(typeof this.subSectionSelectData !== 'undefined' && this.subSectionSelectData.length < 1)
              {
                  this.subSectionSelectData = this.getSelect(this.sectionStorage, true);
              }
              return this.subSectionSelectData;
          }

      },
      prodformSelect: function()
      {
          return this.getSelect(this.prodformStorage);
      },


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
        sectionSelectData: [],
        subSectionSelectData: [],
        brandSelectData: [],
        gammaSelectData: [],
        selectData: false,
        isProductProcessed: true,
        /*form*/
          /*tab1*/
            brandItems: [],
            sectionItems: [],
            propItems: [],
            prodItems: [],
            id_mp: 124,
            name: "Ношпа",
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
                v => !!v || 'Название не может быть пустым',
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
           /*tab3*/
            detail: "",
            howuse: "",
            methoduse: "",
            struct: "",
            contra: "",
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
