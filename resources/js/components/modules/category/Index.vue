<template>
  <div>
    <v-toolbar flat color="white">
        <v-toolbar-title>Categoty Table</v-toolbar-title>
        <v-divider
          class="mx-2"
          inset
          vertical
        ></v-divider>
    <v-spacer></v-spacer>
    <v-btn @click="showAddItem" color="primary" dark class="mb-2">Add</v-btn>
    </v-toolbar>
    <vuetable 
          ref="vuetable" 
          :fields="categoryFields" 
          :api-url="apiUrl"
          :css="css.table"
          data-path="data"
          :per-page="perPage"
          pagination-path="data.data"
          :append-params="moreParams"
          @vuetable:pagination-data="onPaginationData"
    >
      <template slot="actions" slot-scope="props">        
          <v-icon
            color="blue"
            @click="destroy(props.rowData.id)">
            delete
          </v-icon>
           <v-icon
            color="blue"
            @click="showEditItem(props.rowData)">
            edit
          </v-icon>
      </template>
    </vuetable>
    <div class="vuetable-pagination">
      <vuetable-pagination-info ref="paginationInfo"
          :css="css.paginationInfo"
      ></vuetable-pagination-info>
      <vuetable-pagination ref="pagination"
          :css="css.pagination"
          @vuetable-pagination:change-page="onChangePage"
      ></vuetable-pagination>
    </div>

    <v-dialog v-model="dialog" max-width="500px" @keydown.esc="close">
        <v-card>
          <v-card-title>
            <v-spacer></v-spacer>
            <span class="headline">{{ check ? 'Edit Category' : 'Add Category'}}</span>
            <v-spacer></v-spacer>
          </v-card-title>
            <v-card-text>
              <v-container grid-list-md>
                <v-layout wrap>
                  <v-flex xs12 sm12 md12 class="row">
                      <v-text-field v-model="item.name" label="Category" :rules="[rules.required]"></v-text-field>
                      <span v-show="checkValid" style="color:red"></span>
                  </v-flex>
                 
                </v-layout>
            </v-container>
          </v-card-text>
          <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="primary"  @click.native="close" >Cancel</v-btn>
              <v-btn color="primary"  @click.native="save(item)" :disabled="!item.name">Save</v-btn>
          </v-card-actions>
        </v-card>
    </v-dialog>
    <v-snackbar v-model="snack" :timeout="3000" :color="snackColor" right bottom>
        {{ snackText }}
        <v-btn flat @click="snack = false">Close</v-btn>
    </v-snackbar>
  </div>
</template>

<script>
import Vue from 'vue'
import Vuetable from 'vuetable-2/src/components/Vuetable'
import VuetablePagination from 'vuetable-2/src/components/VuetablePagination'
import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
import axios from 'axios'
Vue.use(Vuetable)
export default {

  name: 'Index',

  data () {
    return {
        perPage : 10,
        moreParams : {},
    	  apiUrl : 'api/categories',
        categoryFields : [
            {   
                name :'id', 
                title:'ID', 
                sortField:'id'
            }, 
            {   
                name :'name', 
                title:'Name', 
                sortField:'name'
            }, 
            {   
              name :'__slot:actions', 
                title:'Actions'
            },
          
        ],

        css: {
            table: {
                tableClass: 'table table-bordered table-striped table-hover ',
                ascendingIcon: 'glyphicon glyphicon-chevron-up',
                descendingIcon: 'glyphicon glyphicon-chevron-down '
            },
            pagination: {
              infoClass: 'pull-left',
              wrapperClass: 'vuetable-pagination pull-left',
              activeClass: 'btn-primary',
              disabledClass: 'disabled',
              pageClass: 'btn btn-default',
              linkClass: 'btn btn-default',
              icons: {
                first: '',
                prev: '',
                next: '',
                last: '',
              },
            },
            paginationInfo:{
                infoClass: 'pagination-info'
            },
            icons: {
                first: 'glyphicon glyphicon-step-backward',
                prev: 'glyphicon glyphicon-chevron-left',
                next: 'glyphicon glyphicon-chevron-right',
                last: 'glyphicon glyphicon-step-forward',
            },
        },
        snack: false,
        snackColor: '',
        snackText: '',

        dialog : false,
        check : false,
        item :{
          id :'',
          name: ''
        },
        rules: {
          required: value => !!value || 'Required.',
          counter: value => value.length <= 20 || 'Max 20 characters',
          email: value => {
            const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
            return pattern.test(value) || 'Invalid e-mail.'
          },

        },
        checkValid: false

    }
  },

  components: {
    Vuetable ,
    VuetablePagination,
    VuetablePaginationInfo     
  },
  methods: {
      close(){
        this.dialog =false 
      },

      destroy(id){
        if (confirm("Do you really want to delete it?")) {
              axios.delete('api/categories/'+id)
              .then(response => { 
                this.$refs.vuetable.reload()
                this.snack = true,
                this.snackColor = 'success',
                this.snackText = 'Data deleted'
              })
              .catch(
                error => console.log(error)
              )
          }
      },

      showAddItem(){
        this.dialog = true,
        this.item = {
          id:'',
          name : ''
        }
      },

      showEditItem(param){
        this.check = true,
        this.dialog = true,
        this.item = {
          id : param.id,
          name : param.name
        }
      },

      save(item){
          if(this.check){
            this.edit(item)
          }else{
            this.add(item)
          }
      },

      add(item){
         axios.post('api/categories',item)
        .then(response => { 
          this.$refs.vuetable.reload()
          this.dialog = false,
          this.snack = true,
          this.snackColor = 'success',
          this.snackText = 'Data saved'
        })
        .catch(
          error => console.log(error)
        )
      },
      

      edit(item){
        // console.log(item)
        axios.put('api/categories/'+item.id,item)
        .then(response => { 
          this.$refs.vuetable.reload()
          this.dialog = false,
          this.snack = true,
          this.snackColor = 'success',
          this.snackText = 'Data edited'
        })
        .catch(
          error => console.log(error)
        )
      },

      onPaginationData (paginationData) {
          this.$refs.pagination.setPaginationData(paginationData)
          this.$refs.paginationInfo.setPaginationData(paginationData)
      },

      onChangePage (page) {
          this.$refs.vuetable.changePage(page)
      }

      

      
  },

}
</script>

<style lang="css" scoped>
</style>