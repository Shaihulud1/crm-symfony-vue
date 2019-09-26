<template>
    <v-dialog v-model="show" persistent>
      <v-card>
        <v-toolbar color="blue white--text">
          <v-toolbar-title>Товар (*Создание) + {{displayName}}</v-toolbar-title>
          <div class="flex-grow-1"></div>
          <v-btn icon @click="collapseProduct(id_mp)">
            <v-icon>mdi-arrow-collapse-left</v-icon>
          </v-btn>
          <v-btn icon @click="closeProduct">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-toolbar>
        <v-card-title class="headline">
          ID: {{ id_mp }} <br>
          Название из Вита-системы: {{displayName}}
        </v-card-title>
        <v-card-text>
          <v-switch v-model="isProductProcessed" v-bind:label="processStatus" color="success" hide-details disabled></v-switch>
        </v-card-text>

        <v-form lazy-validation>
        <v-card-text>
          <v-btn class="prod-popup-btn" color="success" @click="saveProduct">Записать и закрыть</v-btn>
          <v-btn class="prod-popup-btn" color="warning" @click="closeProduct">Закрыть без изменений</v-btn>
          <v-alert type="error" class="saveError">
              I'm an error alert.
          </v-alert>
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
                    v-model="prod_name"
                    :rules="nameRules"
                    class="prod-name-input"
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
                    label="Форма выпуска, короткое название"
                    :rules="requiredSelectRules"
                    required
                  >
                  </v-text-field>
                  <p class="text-left">Свойства:  </p><v-btn small color="success" @click="propsAddPopup"  :disabled="isSectionSelect">Добавить свойство</v-btn>
                  <v-data-table
                      :headers="propHeaders"
                      :items="propItems"
                      class="elevation-1"
                    >
                    <template v-slot:body="{ items }">
                      <tbody>
                        <tr v-for="(item, index) in items" :key="index"  class="product-table-item">
                          <td>{{ item.id }}</td>
                          <td>{{ item.name }}</td>
                          <td>{{ item.group }}</td>
                          <td>{{ item.subsection }}</td>
                          <!-- <td>
                              <v-select
                                v-model="item.isActive"
                                :rules="requiredSelectRules"
                                :items="['Да', 'Нет']"
                                required
                                >
                              </v-select>
                          </td> -->
                        </tr>
                      </tbody>
                    </template>
                  </v-data-table>
                  <v-dialog v-model="propsAdd">
                      <v-card>
                            <v-toolbar>
                              <v-toolbar-title>Справочник cвойств</v-toolbar-title>
                              <div class="flex-grow-1"></div>
                              <v-btn icon @click="propsAdd = false">
                                <v-icon>mdi-close</v-icon>
                              </v-btn>
                            </v-toolbar>
                            <v-card-text>
                              <v-text-field
                                 v-model="searchProp"
                                 append-icon="search"
                                 label="Поиск"
                                 single-line
                                 hide-details
                               ></v-text-field>
                            </v-card-text>
                            <v-data-table
                                v-model="propItems"
                                :headers="propHeaders"
                                :items="propsAll"
                                :search="searchProp"
                                item-key="id"
                                show-select
                                class="elevation-1"
                              >
                            </v-data-table>
                      </v-card>
                    </v-dialog>
              </v-card-text>
            </v-card>
          </v-tab-item>
          <v-tab-item>
            <v-card flat>
              <v-card-text>
                  <v-checkbox v-model="catPrior" label="Приоритетность товара в каталоге"></v-checkbox>
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
                  <v-text-field
                    v-model="formProd2"
                    outlined
                    label="Форма выпуска"
                  >
                  </v-text-field>
                  <v-text-field
                    v-model="dosage"
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

                  <p class="text-left">Активное вещество:  </p><v-btn small color="success" @click="mnnAddPopup">Добавить активное вещество</v-btn>
                  <v-data-table
                      :headers="mnnHeaders"
                      :items="mnnItems" 
                      class="elevation-1"
                    >
                    <template v-slot:body="{ items }">
                      <tbody>
                        <tr v-for="(item, index) in items" :key="index"  class="product-table-item">
                          <td>{{ item.id }}</td>
                          <td>{{ item.name }}</td>
                          <td>
                              <!-- {{ item.isActive }} -->
                              <!-- <v-select
                                v-model="item.isActive"
                                :rules="requiredSelectRules"
                                :items="['Да', 'Нет']"
                                required
                                >
                              </v-select> -->
                          </td>
                        </tr>
                      </tbody>
                    </template>
                  </v-data-table>
                  <v-dialog v-model="mnnAdd">
                      <v-card>
                            <v-toolbar>
                              <v-toolbar-title>Справочник МНН</v-toolbar-title>
                              <div class="flex-grow-1"></div>
                              <v-btn icon @click="mnnAdd = false">
                                <v-icon>mdi-close</v-icon>
                              </v-btn>
                            </v-toolbar>

                            <v-card-text>
                              <v-text-field
                                 v-model="searchMnn"
                                 append-icon="search"
                                 label="Поиск"
                                 single-line
                                 hide-details
                               ></v-text-field>
                            </v-card-text>
                            <v-data-table
                                v-model="mnnItems"
                                :headers="mnnHeaders"
                                :items="mnnAll"
                                :search="searchMnn"
                                item-key="id"
                                show-select
                                class="elevation-1"
                              >
                            </v-data-table>
                      </v-card>
                    </v-dialog>
              </v-card-text>
            </v-card>
          </v-tab-item>

          <v-tab-item>
            <v-card flat>
              <v-card-text>
                <v-btn small color="blue white--text" @click="descUploadDB">Загрузить из справочника</v-btn>
                <v-dialog v-model="descUpload">
                  <v-card>
                        <v-toolbar>
                          <v-toolbar-title>Справочник описаний</v-toolbar-title>
                          <div class="flex-grow-1"></div>
                          <v-btn icon @click="descUpload = false">
                            <v-icon>mdi-close</v-icon>
                          </v-btn>
                        </v-toolbar>
                        <v-card-text>
                          <v-text-field
                              v-model="searchDesc"
                              append-icon="search"
                              label="Поиск"
                              single-line
                              hide-details
                            ></v-text-field>
                        </v-card-text>
                        <v-data-table
                            v-model="selectedDesc"
                            :headers="descHeaders"
                            :items="descsAll"
                            :search="searchDesc"
                            item-key="id"
                            show-select
                            single-select
                            class="elevation-1"
                          >
                        </v-data-table>
                        <v-card-text>
                            <p style="color:red;" v-if="uploadDescError">{{ uploadDescError }}</p>
                            <v-btn class="prod-popup-btn" color="success" small @click="uploadDescFun">Загрузить выбранное описание</v-btn>
                        </v-card-text>
                  </v-card>
              </v-dialog>
              </v-card-text>
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
                           <v-text-field
                            background-color="amber lighten-4"
                            v-model="descName"
                            label="Название описания"
                            hide-details
                            disabled
                          ></v-text-field>
                          <v-textarea
                            background-color="amber lighten-4"
                            color="blue"
                            label="Подробное описание"
                            v-model="detail"
                            :value="detail"
                            disabled
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
                            :value="howuse"
                            disabled
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
                            :value="methoduse"
                            disabled
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
                            :value="struct"
                            disabled
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
                            :value="contra"
                            disabled
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


import {mapGetters} from 'vuex';

export default {
    name: "PopupProductEditor",
    props:{
      value:Boolean,
      modalData:Object,
      uploadInputs: Boolean,
    },
    watch: {

        formProd: function(e)
        {
            let formsSelect = this.$store.getters.prodFormSelect;
            if(formsSelect != 'undefined' && formsSelect.length > 0)
            {
                for (var i = 0, len = formsSelect.length; i < len; i++) {
                    if(e == formsSelect[i].id){
                        this.formProdShort = formsSelect[i].shortName;
                        return;
                    }
                }
            }
        },
        name: function(e)
        {
          this.name = this.toUpperCaseFirstLetter(e);
        },
        box: function(e)
        {
            this.box = this.toUpperCaseFirstLetter(e);
        },
        section: function(e, oldE)
        {
          let self = this;
          let tempSubsect = [];
          let sectionStorage = this.$store.getters.sectionSelect;
          let isConfirmChanges = {choose: true, mess: false};
          e = (typeof e.value !== 'undefined') ? e.value : e;
          if(typeof sectionStorage !== 'undefined')
          {
              sectionStorage.forEach(function(sect, indexSect){
                  let chooseSect = true;
                  if(sect.id != e){
                    chooseSect = false;
                  }
                  if(typeof sect.childs !== 'undefined')
                  {
                      sect.childs.forEach(function(child){
                        tempSubsect.push({value:child.id, text:child.name, disabled:!chooseSect});
                        if(self.subsection == child.id && !chooseSect)
                        {
                            if(!isConfirmChanges.mess)
                            {
                                isConfirmChanges.mess = true;
                                if(!confirm('Вы уверены, что хотите изменить Раздел? Поле Подраздел будет очищено, прикрепленные Свойства будут удалены.'))
                                {
                                    isConfirmChanges.choose = false;
                                }
                            }
                            if(isConfirmChanges.choose)
                            {
                                self.subsection = [];
                            }
                        }
                      });
                  }
              });
              if(isConfirmChanges.choose)
              {
                  self.subSectionSelect = tempSubsect;
              }
          }
          if(!isConfirmChanges.choose){
              self.section = {text:oldE.text, value: oldE.value};
          }else{
              self.subSectionSelect = tempSubsect;
          }
        },
        subsection: function(e)
        {
            let self = this;
            let sectionStorage = this.$store.getters.sectionSelect;
            if(typeof sectionStorage !== 'undefined')
            {
                sectionStorage.forEach(function(sect, indexSect){
                  if(typeof sect.childs !== 'undefined'){
                      sect.childs.forEach(function(child){
                          if(e == child.id){
                              self.section = {value: sect.id, text: sect.name};
                          }
                      });
                  }
                });
            }
            self.isSectionSelect = !self.subsection;
            if(!self.modalInit){
                self.propItems = [];
            }else{
                self.modalInit = false;
            }

        },
        brand: function(e, oldE)
        {
            let self = this;
            let brandStorage = this.$store.getters.brandSelect;
            let tempGamma = [];
            let isConfirmChanges = {choose: true, mess: false};
            e = (typeof e.value !== 'undefined') ? e.value : e;
            //oldE = (typeof oldE.value !== 'undefined') ? oldE.value : oldE;
            if(typeof brandStorage !== 'undefined')
            {
                brandStorage.forEach(function(brand, indexSect){
                    let brandChoose = true;
                    if(brand.id != e){
                      brandChoose = false;
                    }
                    if(typeof brand.childs !== 'undefined')
                    {
                      brand.childs.forEach(function(child){
                        tempGamma.push({value: child.id, text: child.name, disabled: !brandChoose});
                        if(self.gammas && !brandChoose){
                            if(self.gammas == child.id){
                                if(!isConfirmChanges.mess)
                                {
                                    isConfirmChanges.mess = true;
                                    if(!confirm('Вы уверены, что хотите изменить Бренд? Поле Гамма будет очищено.'))
                                    {
                                        isConfirmChanges.choose = false;
                                    }
                                }
                                if(isConfirmChanges.choose)
                                {
                                  self.gammas = [];

                                }
                            }
                        }
                      });
                    }
                });
            }
            if(!isConfirmChanges.choose){
                self.brand = {text:oldE.text, value: oldE.value};
                return;
            }else{
              self.gammaSelect = tempGamma;
            }
        },
        gammas: function(e)
        {
            let self = this;
            let brandStorage = this.$store.getters.brandSelect;
            if(typeof brandStorage !== 'undefined')
            {
                brandStorage.forEach(function(brand, indexBrand){
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
        {//modal form init 
            let self = this;
            self.modalInit = true;
            self.id_mp = val.id_mp;
            self.prod_name = val.prod_name;
            self.displayName = val.displayName;
            self.catPrior = typeof val.catPrior != 'undefined' ? val.catPrior : false;
            self.brand = typeof val.brand != 'undefined' ? val.brand : "";
            self.gammas = typeof val.gammas != 'undefined' ? val.gammas : [];
            self.section = typeof val.section != 'undefined' ? val.section : "";
            self.subsection = typeof val.subsection != 'undefined' ? val.subsection : "";
            self.formProd = typeof val.formProd != 'undefined' ? val.formProd : "";
            self.formProdShort = typeof val.formProdShort != 'undefined' ? val.formProdShort : "";
            self.propItems = typeof val.propItems != 'undefined' ? val.propItems : [];
            self.box = typeof val.box != 'undefined' ? val.box : "";
            self.manufactory = typeof val.manufactory != 'undefined' ? val.manufactory : "";
            self.formProd2 = typeof val.formProd2 != 'undefined' ? val.formProd2 : "";
            self.dosage = typeof val.dosage != 'undefined' ? val.dosage : "";
            self.unit = typeof val.unit != 'undefined' ? val.unit : "";
            self.volume = typeof val.volume != 'undefined' ? val.volume : "";
            self.storageCond = typeof val.storageCond != 'undefined' ? val.storageCond : "";
            self.latinName = typeof val.latinName != 'undefined' ? val.latinName : "";
            self.rusName = typeof val.rusName != 'undefined' ? val.rusName : "";
            self.isRecipeNeeded = typeof val.isRecipeNeeded != 'undefined' ? val.isRecipeNeeded : false;
            self.selectedDesc = typeof val.selectedDesc != 'undefined' ? val.selectedDesc : [];
            let emptyDesc = false;
            if(typeof self.selectedDesc[0] != 'undefined'){
                axiosXHR.methods.sendRequest('rest/inputs/desc/' + self.selectedDesc[0].id, function(response){
                    if(response.data == 'BAD_AUTH'){
                        router.push('login');
                    }
                    else if(response.data != 'EMPTY_DATA')
                    {
                        emptyDesc = true;
                        self.descName = response.data.name;
                        self.detail = response.data.detail;
                        self.contra = response.data.contra;
                        self.struct = response.data.struct;
                        self.methoduse = response.data.methoduse;
                        self.howuse = response.data.how_use;
                    }
                });
            }else{
                emptyDesc = true;
            }
            if(emptyDesc){
                self.descName = "";
                self.detail = "";
                self.contra = "";
                self.struct = "";
                self.methoduse = "";
                self.howuse = "";
            }
            console.log('test');
        }
    },
    methods: { 
      uploadDescFun: function()
      {
          let self = this;
          if(self.selectedDesc.length == 0 || !self.selectedDesc[0].id)
          {
              self.uploadDescError = "Описание не выбрано";
              return;
          }
          let selectedDesc = self.selectedDesc[0].id;

          self.$store.commit('updateLoad', true);
          axiosXHR.methods.sendRequest('rest/inputs/desc/' + selectedDesc, function(response){
              self.$store.commit('updateLoad', false);
              if(response.data == 'BAD_AUTH'){
                  router.push('login');
              }
              else if(response.data == 'EMPTY_DATA')
              {
                  self.uploadDescError = "Описание не найдено в справочнике";
              }else{
                  self.selectedDesc = [{id: response.data.id, name: response.data.name}];
                  self.descName = response.data.name;
                  self.detail = response.data.detail;
                  self.contra = response.data.contra;
                  self.struct = response.data.struct;
                  self.methoduse = response.data.methoduse;
                  self.howuse = response.data.how_use;
                  self.descUpload = false;
              }
          });
      },
      descUploadDB: function()
      {
        let self = this;
        self.uploadDescError = "";
         self.$store.commit('updateLoad', true); 
         axiosXHR.methods.sendRequest('rest/inputs/desc', function(response){
           self.$store.commit('updateLoad', false);
              if(response.data == 'BAD_AUTH'){
                router.push('login');
              }
              self.descsAll = [];
              response.data.forEach(function(elem){
                self.descsAll.push({
                      id: elem.id, 
                      name: elem.name, 
                  });
              });
              self.descUpload = true;
         });
      },
      toUpperCaseFirstLetter: function(string)
      {
          return string.charAt(0).toUpperCase() + string.slice(1);
      },
      propsAddPopup: function()
      {
          let self = this;
          if(!self.subsection){
              return;
          }
          self.isSectionSelect = true;
          self.propsAll = [];
          self.$store.commit('updateLoad', true);
          axiosXHR.methods.sendRequest('rest/inputs/prop/' + self.subsection, function(response){
              self.$store.commit('updateLoad', false);
              if(response.data == 'BAD_AUTH'){
                  router.push('login');
              }
              else if(response.data == 'EMPTY_DATA')
              {
                  alert('У выбранного подраздела нет доступных свойств');
                  self.isSectionSelect = false;
                  return;
              }
              else if(typeof response.data !== 'undefined'){
                  response.data.forEach(function(elem){
                      self.propsAll.push({id: elem.id, name: elem.name, group: elem.group, subsection: elem.subsection, isActive: 'Да'});
                  });
              }
              self.isSectionSelect = false;
              self.propsAdd = true;
          });
      },
      mnnAddPopup: function()
      {
          let self = this;
          self.mnnAll = [];
          self.$store.commit('updateLoad', true);
          axiosXHR.methods.sendRequest('rest/inputs/mnn', function(response){
              self.$store.commit('updateLoad', false);
              if(response.data == 'BAD_AUTH'){
                  router.push('login');
              }else if(typeof response.data !== 'undefined'){
                  response.data.forEach(function(elem){
                      self.mnnAll.push({id: elem.id, name: elem.name, isActive: 'Да'});
                  });
              }
              self.mnnAdd = true;
          });
      },
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
      collapseProduct: function(id_mp)
      {
          let self = this;
          let foundCollapseIndex = false;
          self.$store.commit('updateLoad', true);
          if(typeof self.collapsedProducts.newProds != 'undefined' && id_mp){
              self.collapsedProducts.newProds.forEach(function(elem, index){
                  if(elem.id_mp == id_mp)
                  {
                      foundCollapseIndex = index;
                  }
              }); 
          }
          if(foundCollapseIndex !== false)
          {//make loop from this shit
              console.log( self.collapsedProducts.newProds[foundCollapseIndex]);
              self.collapsedProducts.newProds[foundCollapseIndex].prod_name = self.prod_name;
              self.collapsedProducts.newProds[foundCollapseIndex].catPrior = self.catPrior;
              self.collapsedProducts.newProds[foundCollapseIndex].brand = self.brand;
              self.collapsedProducts.newProds[foundCollapseIndex].gammas = self.gammas;
              self.collapsedProducts.newProds[foundCollapseIndex].section = self.section;
              self.collapsedProducts.newProds[foundCollapseIndex].subsection = self.subsection;
              self.collapsedProducts.newProds[foundCollapseIndex].formProd = self.formProd;
              self.collapsedProducts.newProds[foundCollapseIndex].formProdShort = self.formProdShort;
              self.collapsedProducts.newProds[foundCollapseIndex].propItems = self.propItems;
              self.collapsedProducts.newProds[foundCollapseIndex].box = self.box;
              self.collapsedProducts.newProds[foundCollapseIndex].manufactory = self.manufactory;
              self.collapsedProducts.newProds[foundCollapseIndex].formProd2 = self.formProd2;
              self.collapsedProducts.newProds[foundCollapseIndex].dosage = self.dosage;
              self.collapsedProducts.newProds[foundCollapseIndex].unit = self.unit;
              self.collapsedProducts.newProds[foundCollapseIndex].volume = self.volume;
              self.collapsedProducts.newProds[foundCollapseIndex].storageCond = self.storageCond;
              self.collapsedProducts.newProds[foundCollapseIndex].latinName = self.latinName;
              self.collapsedProducts.newProds[foundCollapseIndex].rusName = self.rusName;
              self.collapsedProducts.newProds[foundCollapseIndex].isRecipeNeeded = self.isRecipeNeeded;
              self.collapsedProducts.newProds[foundCollapseIndex].mnnItems = self.mnnItems;
              self.collapsedProducts.newProds[foundCollapseIndex].selectedDesc = self.selectedDesc;
          }
          self.$store.commit('updateLoad', false);
          this.show = false;
      },
      closeProduct: function()
      {
        
        if(confirm("Вы уверены, что хотите закрыть товар? Изменения не будут сохранены.")){
              let token = cookie.methods.getCookie("token");
              let self = this;
              self.$store.commit('updateLoad', true);
              axiosXHR.methods.sendRequest('rest/product/closeproduct/' + self.id_mp + '/'+ self.userData.id + '/' + token, 
                function(response){
                    self.$store.commit('updateLoad', false);
                    if(response.data == 'BAD_AUTH'){
                        router.push('login');
                    }else{  
                        self.collapsedProducts.newProds.forEach(function(elem, key){
                            if(elem.id_mp == self.id_mp){
                                self.collapsedProducts.newProds.splice(key, 1);
                            }
                        });
                        self.show = false;                      
                    }
                }
              );

          }
      },
      saveProduct: function()
      {
          //self.$store.commit('updateLoad', true);
          let token = cookie.methods.getCookie("token");
          let dataProduct = new FormData();
          dataProduct.append('id_mp', this.id_mp);
          dataProduct.append('prod_name', this.prod_name);
          dataProduct.append('box', this.box);
          dataProduct.append('manufactory', this.manufactory);
          dataProduct.append('formprod', this.formProd2);
          dataProduct.append('dosage', this.dosage);
          dataProduct.append('unit', this.unit);
          dataProduct.append('volume', this.volume);
          dataProduct.append('storageCond', this.storageCond);
          dataProduct.append('latinName', this.latinName);
          dataProduct.append('rusName', this.rusName);
          dataProduct.append('isRecipeNeeded', this.isRecipeNeeded);
          dataProduct.append('isProductProcessed', this.isProductProcessed);
          dataProduct.append('formProd', this.formProd);
          dataProduct.append('formProdShort', this.formProdShort);
          dataProduct.append('catPrior', this.catPrior);
          if(typeof this.selectedDesc[0] != 'undefined' && typeof this.selectedDesc[0].id != 'undefined')
          {
              dataProduct.append('selectedDesc', this.selectedDesc[0].id);
          }
          else
          {
              dataProduct.append('selectedDesc', false);
          } 

          dataProduct.append('auth', token);

          dataProduct.append('brand', this.gammas);
          dataProduct.append('gamma', (typeof this.brand.value != 'undefined' ? this.brand.value : false ));
          dataProduct.append('section', (typeof this.section.value != 'undefined' ? this.section.value : false ));
          dataProduct.append('subsection', this.subsection);
 
          dataProduct.append('propItems', JSON.stringify(this.propItems));
          dataProduct.append('mnnItems', JSON.stringify(this.mnnItems));

          axiosXHR.methods.sendRequest('rest/product/save-product', 
              function(response){
                  self.$store.commit('updateLoad', false);
                  if(response.data == 'BAD_AUTH'){
                      router.push('login');
                  }else{  
                      console.log('yeee');
                  }
              }, 'post', dataProduct
          );

      }
    },
    computed: {
      isSectionSelect:{
          set: function(val)
          {
              this.disabledPropBtn = val;
          },
          get: function()
          {
              return this.disabledPropBtn;
          }
      },
      
      brandSelect:{
          set: function(val)
          {
              this.brandSelectData = val;
          },
          get: function(val)
          {
              this.brandSelectData = this.getSelect(this.$store.getters.brandSelect);
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
              if(this.gammaSelectData.length == 0){
                  this.gammaSelectData = this.getSelect(this.$store.getters.brandSelect, true);
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
              this.sectionSelectData = this.getSelect(this.$store.getters.sectionSelect);
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
              if(this.subSectionSelectData.length == 0){
                  this.subSectionSelectData = this.getSelect(this.$store.getters.sectionSelect, true);
              }
              return this.subSectionSelectData;
          }

      },
      prodformSelect: function()
      {
          return this.getSelect(this.$store.getters.prodFormSelect);
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
        modalInit: false,
        saveErrors: [],
        displayName: '',
        mnnHeaders: [
            { text: 'ID', value: 'id' },
            { text: 'Название', value: 'name' },
           // { text: 'Активность', value: 'isActive' },
        ],
        propHeaders: [
            { text: 'ID', value: 'id' },
            { text: 'Название', value: 'name' },
            { text: 'Группа свойства', value: 'group' },
            { text: 'Подраздел', value: 'subsection' },
           // { text: 'Активность', value: 'isActive' },
        ],
        descHeaders: [
            { text: 'ID', value: 'id' },
            { text: 'Название', value: 'name' },
        ],
        propsAll: [],
        descsAll: [],
        mnnAll: [],
        disabledPropBtn: true,
        searchProp: "",
        propsAdd: false,
        descUpload: false,
        searchMnn: "",
        mnnAdd: false,
        searchDesc: "",
        sectionSelectData: [],
        subSectionSelectData: [],
        brandSelectData: [],
        gammaSelectData: [],
        selectData: false,
        isProductProcessed: false,
        /*form*/
          /*tab1*/
            brandItems: [],
            sectionItems: [],
            propItems: [],
            prodItems: [],
            id_mp: 124,
            prod_name: "",
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
              v => !!v || 'Поле не может быть пустым',
            ],
           /**/
           /*tab2*/
            catPrior: false,
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
            mnnItems: [],
           /**/
           /*tab3*/
            uploadDescError: "",
            descName: "",
            selectedDesc: [],
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

<style>
  .saveError{
    margin-top: 20px;
  }
  .prod-popup-btn{
    margin-right: 15px;
  }
  div.v-list-item--disabled{
    display: none !important;
  }

</style>
