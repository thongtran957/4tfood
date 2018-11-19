<template>
	<div>
		<v-toolbar flat color="white">
	        <v-toolbar-title>Recipe Table</v-toolbar-title>
	        <v-divider
	          class="mx-2"
	          inset
	          vertical
	        ></v-divider>
		    <v-spacer></v-spacer>
		    <v-btn @click="showAddItem" color="primary" dark class="mb-2">Add</v-btn>
	    </v-toolbar>
	    <recipe-filter></recipe-filter>
		<div v-dragscroll.x class="big-box grab-bing ">
		    <vuetable
		    	 ref="vuetable" 
	            :fields="recipeFields" 
	            :api-url="apiUrl"
	            :css="css.table"
	            data-path="data.data"
	            :per-page="perPage"
	            pagination-path="data"
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
		        <template slot="link_img" slot-scope="props"> 
		            <img v-bind:src="props.rowData.link_img" class="size-img">
		        </template>
		        <template slot="active" slot-scope="props">        
			        <v-checkbox			          
			            color="primary"
			            v-model="props.rowData.active">			                        
			        </v-checkbox>
			    </template>
		    </vuetable>
		    
		</div> 
		<div class="vuetable-pagination">
		      <vuetable-pagination-info ref="paginationInfo"
		          :css="css.paginationInfo"
		      ></vuetable-pagination-info>
		      <vuetable-pagination ref="pagination"
		          :css="css.pagination"
		          @vuetable-pagination:change-page="onChangePage"
		      ></vuetable-pagination>
	    </div> 
		<v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition" @keydown.esc="close">
	        <v-card>
	          	<v-toolbar dark color="primary">
		            <v-btn icon dark  @click.native="close">
		              <v-icon>close</v-icon>
		            </v-btn>
		            <v-toolbar-title>{{ check ? 'Edit Recipe' : 'Add Recipey'}}</v-toolbar-title>
		            <v-spacer></v-spacer>
		            <v-toolbar-items>
		              <v-btn dark flat @click.native="save(item)">Save</v-btn>
	            	</v-toolbar-items>
          		</v-toolbar>
          		<v-card-text>
		            <v-container grid-list-md>
		                <v-layout wrap>
		                  	<v-flex xs12 class="row">
			                    <v-flex xs6>
			                       <v-text-field  label="Name" v-model="item.name"></v-text-field>
			                    </v-flex>
			                    <v-flex xs3>
			                       <v-select  label="Category" v-model="item.cname"  :items="listCategory"></v-select>
			                    </v-flex>
			                    <v-flex xs3>
			                        <v-text-field  label="Suitable For" v-model="item.suitable_for"></v-text-field>
			                    </v-flex>
		                  	</v-flex>
		                  	<v-flex xs12 class="row">
			                    <v-flex xs3>
			                       <v-text-field  label="Cost (VND)" v-model="item.cost"></v-text-field>
			                    </v-flex>
			                    <v-flex xs3>
			                       <v-text-field  label="Prep Time (minute)" v-model="item.prep_time"></v-text-field>
			                    </v-flex>
			                    <v-flex xs3>
			                       <v-text-field  label="Cook Time (minute)" v-model="item.cook_time"></v-text-field>
			                    </v-flex>
			                    <v-flex xs3>
			                       	<v-checkbox			          
							            color="primary"
							            label="Active"
							            v-model="item.active">			                        
							        </v-checkbox>
			                    </v-flex>
		                  	</v-flex> 
		                  	<v-flex xs12 class="row">
		                  		<v-flex xs1>
			                      	<label>Image</label>
			                    </v-flex>
			                    <v-flex xs3>
			                    	<input type="file" id="file" ref="myFiles" @change="previewFiles" >
			                	</v-flex>
				                	<v-flex xs3 >
				                    	<img v-bind:src="item.link_img" class="size-img" v-if="item.link_img != '' ">
				                	</v-flex>
			                	<!-- <v-flex xs3>
			                    	<img v-bind:src="item.link_img" class="size-img">
			                	</v-flex> -->
			                	
		                    </v-flex> 
		                  	<v-flex xs12 class="row">
		                  		<v-textarea
						            outline
						            label="Description"
						            v-model = "item.description"
						        ></v-textarea>
		                  	</v-flex>
		                  	<v-flex xs12 class="row">
		                    	<v-textarea
						            outline
						            label="Ingredient"
						            v-model = "item.ingredient"
					        	></v-textarea>
		                  	</v-flex>
		                  	<v-flex xs12 class="row">
		                		<v-textarea
						            outline
						            label="Instruction"
						            v-model = "item.instruction"
					        	></v-textarea>
		                  	</v-flex>
		                </v-layout>
		            </v-container>
		        </v-card-text>
        	</v-card>
	    </v-dialog>  
    </div>
</template>

<script>
import Vue from 'vue'
import Vuetable from 'vuetable-2/src/components/Vuetable'
import VuetablePagination from 'vuetable-2/src/components/VuetablePagination'
import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
import { VueEditor } from 'vue2-editor'
import Lodash from 'lodash'
import RecipeFilter from './RecipeFilter'
import VueEvents from 'vue-events'

Vue.component('recipe-filter', RecipeFilter)

Vue.use(Vuetable)
Vue.use(VueEvents)
export default {

  name: 'Index',

  data () {
    return {
    	perPage : 10,
        moreParams : {},
    	apiUrl : 'api/recipes',
    	recipeFields : [
            {   
                name :'id', 
                title:'ID', 
                sortField:'id',
            }, 
            {   
                name :'name', 
                title:'Name', 
            }, 
            {   
                name :'cname', 
                title:'Category', 
            },
            {   
                name :'cost', 
                title:'Cost', 
                sortField:'cost',
            },
            {   
                name :'prep_time', 
                title:'Prep Time',
                sortField:'prep_time', 
            },
            {   
                name :'cook_time', 
                title:'Cook Time', 
                sortField:'cook_time',
            },
            {   
                name :'__slot:active', 
                title:'Active', 
            },
            {   
                name :'__slot:link_img', 
                title:'Image', 
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
        item:{
        	name : '',
        	cname : '',
        	cost : '',
        	prep_time: '',
        	cook_time: '',
        	description: '',
        	ingredient : '',
        	instruction : '',
        	active : '',
        	suitable_for : '', 
        	link_img: ''    
        },

        listCategory : [],
        check : false,
        rules: {
          required: value => !!value || 'Required.',
          counter: value => value.length <= 20 || 'Max 20 characters',
          email: value => {
            const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
            return pattern.test(value) || 'Invalid e-mail.'
          },

        },

    }
  },
  components: {
    Vuetable,
    VueEditor ,
    VuetablePagination,
    VuetablePaginationInfo 
  },

   mounted(){
    this.$events.$on('filter-set', eventData => this.onFilterSet(eventData))
    this.$events.$on('filter-reset', e => this.onFilterReset())
   
  },

  created(){
  	this.getCategory();
  },
 
  methods:{
  	showAddItem(){
  		this.dialog = true,
  		this.item = {
  			id: '',
         	name : '',
        	cname : '',
        	cost : '',
        	prep_time: '',
        	cook_time: '',
        	description: '',
        	ingredient : '',
        	instruction : '',
        	active : '',
        	suitable_for : '',
        	link_img: ''
        }
  	},

  	showEditItem(param){
        this.check = true,
        this.dialog = true,
        this.item = {
          	id: param.id,
         	name : param.name,
        	cname : param.cname,
        	cost : param.cost,
        	prep_time: param.prep_time,
        	cook_time: param.cook_time,
        	description: param.description,
        	ingredient : param.ingredient,
        	instruction : param.instruction,
        	active : param.active,
        	suitable_for : param.suitable_for,
        	link_img : param.link_img,
        }
    },

  	close(){
  		this.dialog =false
  	},
  	previewFiles(){
  		this.item.name_img = this.$refs.myFiles.files[0]      
  	},

  	destroy(id){
  		if (confirm("Do you really want to delete it?")) {
              axios.delete('api/recipes/'+id)
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

  	save(item){
      	if(this.check){
        	this.edit(item)
      	}else{
        	this.add(item)
      	}
  	},

  	add(item){
  		let formData = new FormData();
        formData.append('file_name', this.item.name_img);
        formData.append('name', this.item.name);
        formData.append('cname', this.item.cname);
        formData.append('suitable_for', this.item.suitable_for);
        formData.append('cost', this.item.cost);
        formData.append('prep_time', this.item.prep_time);
        formData.append('cook_time', this.item.cook_time);
        formData.append('active', this.item.active);
        formData.append('description', this.item.description);
        formData.append('ingredient', this.item.ingredient);
        formData.append('instruction', this.item.instruction);
        
  		axios.post('api/add/recipes', formData)
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
  		let formData = new FormData();
        formData.append('file_name', this.item.name_img);
        formData.append('id', this.item.id);
        formData.append('name', this.item.name);
        formData.append('cname', this.item.cname);
        formData.append('suitable_for', this.item.suitable_for);
        formData.append('cost', this.item.cost);
        formData.append('prep_time', this.item.prep_time);
        formData.append('cook_time', this.item.cook_time);
        formData.append('active', this.item.active);
        formData.append('description', this.item.description);
        formData.append('ingredient', this.item.ingredient);
        formData.append('instruction', this.item.instruction);
        
  		axios.post('api/edit/recipes', formData)
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

  	getCategory(){
  		var data =[];
  		axios.get('api/list/categories')
        .then(response => { 
         	_.forEach(response.data, function(value) {
                data.push(value.name);
            });
        })
        .catch(
          error => console.log(error)
        )
       	this.listCategory = data
  	},

	onPaginationData (paginationData) {
	    this.$refs.pagination.setPaginationData(paginationData)
	    this.$refs.paginationInfo.setPaginationData(paginationData)
	},

	onChangePage (page) {
	    this.$refs.vuetable.changePage(page)
	},

	onFilterSet (filterText) {
	    this.moreParams = {
	        'filter': filterText
	    }
	    Vue.nextTick( () => this.$refs.vuetable.refresh())
	},

	onFilterReset () {
	    this.moreParams = {}
	    Vue.nextTick( () => this.$refs.vuetable.refresh())
	},
  }
}
</script>

<style lang="css" scoped>
	
</style>