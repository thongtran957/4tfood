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
		<div v-dragscroll.x class="big-box grab-bing ">
		    <vuetable
		    	 ref="vuetable" 
	            :fields="recipeFields" 
	            :api-url="apiUrl"
	            :css="css.table"
	            data-path="data"
		    >
		    	<template slot="actions" slot-scope="props">  
		    		<v-icon
		              color="blue">
		              visibility	
		            </v-icon>      
		            <v-icon
		              color="blue">
		              delete
		            </v-icon>
		             <v-icon
		              color="blue">
		              edit
		            </v-icon>
		        </template>
		        <template slot="link_img" slot-scope="props"> 
				    <v-avatar
		            :tile="true"
		            color="grey lighten-4"
		            :size="120"
		          	>
		            	<img v-bind:src="props.rowData.link_img">
		          	</v-avatar> 
		        </template>
		        <template slot="active" slot-scope="props">        
			        <v-checkbox			          
			            color="primary"
			            v-model="props.rowData.active">			                        
			        </v-checkbox>
			    </template>
		    </vuetable>
		    
		</div>  
		<v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition" @keydown.esc="close">
	        <v-card>
	          	<v-toolbar dark color="primary">
		            <v-btn icon dark  @click.native="close">
		              <v-icon>close</v-icon>
		            </v-btn>
		            <v-toolbar-title>Add Recipe</v-toolbar-title>
		            <v-spacer></v-spacer>
		            <v-toolbar-items>
		              <v-btn dark flat @click.native="save(item)">Save</v-btn>
	            	</v-toolbar-items>
          		</v-toolbar>
          		<v-card-text>
		            <v-container grid-list-md>
		                <v-layout wrap>
		                	<v-flex xs12 class="row">
		                  		<v-flex xs3>
			                      	<input type="file" id="file" ref="myFiles" @change="previewFiles" >
			                    </v-flex>
			                    <!-- <v-flex xs3 v-if="check">
			                      	<v-avatar
						            :tile="true"
						            color="grey lighten-4"
						            :size="150"

						          	>
						            	<img v-bind:src="" >
						          	</v-avatar>
			                    </v-flex> -->
		                  	</v-flex>  
		                  	<v-flex xs12 class="row">
			                    <v-flex xs6>
			                       <v-text-field  label="Name" v-model="item.name"></v-text-field>
			                    </v-flex>
			                    <v-flex xs3>
			                       <v-select  label="Category" v-model="item.cname"></v-select>
			                    </v-flex>
			                    <v-flex xs3>
			                       <v-select  label="Suitable For" v-model="item.suitable_for"></v-select>
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
			                    <v-textarea
						            outline
						            label="Description"
						            color="orange"
						            v-model="item.description"
						        ></v-textarea>
		                  	</v-flex>
		                  	<v-flex xs12 class="row">
			                    <v-textarea
						            outline
						            label="Ingredient"
						            color="green"
						            v-model="item.ingredient"
						        ></v-textarea>
		                  	</v-flex>
		                  	<v-flex xs12 class="row">
			                    <v-textarea
						            outline
						            label="Instruction"
						            color="pink"
						            v-model="item.instruction"
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

Vue.use(Vuetable)
export default {

  name: 'Index',

  data () {
    return {
    	apiUrl : 'api/recipes',
    	recipeFields : [
            {   
                name :'id', 
                title:'ID', 
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
            },
            {   
                name :'prep_time', 
                title:'Prep Time', 
            },
            {   
                name :'cook_time', 
                title:'Cook Time', 
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
        	name_img : '',
        	link_img : '',
        	link_youtube:'',        
        }
    }
  },
  components: {
    Vuetable  
  },

  methods:{
  	showAddItem(){
  		this.dialog = true
  	},

  	close(){
  		this.dialog =false
  	},
  	previewFiles(){
  		this.item.name_img = this.$refs.myFiles.files[0]
  		
       
       
  	},

  	save(item){
  		var formData = new FormData();
        formData.append('file_name', this.item.name_img);


        
  		axios.post('api/add/recipes', formData)
        .then(response => { 
          // this.$refs.vuetable.reload()
          // this.dialog = false,
          // this.snack = true,
          // this.snackColor = 'success',
          // this.snackText = 'Data saved'
        })
        .catch(
          error => console.log(error)
        )

  	}
  }
}
</script>

<style lang="css" scoped>
</style>