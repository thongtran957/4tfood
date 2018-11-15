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
	    <v-btn @click="" color="primary" dark class="mb-2">Add</v-btn>
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
		    		<!-- <img v-bind:src="props.rowData.link_img"> -->
		    		<img src="https://doc-0k-8k-docs.googleusercontent.com/docs/securesc/ha0ro937gcuc7l7deffksulhg5h7mbp1/kbpbp944ckieoc3jo5ga1bufesgourem/1542304800000/05148497586719943542/*/11o8wslc5mvn5DDeeX645gog6e3bajSQL">
		        </template>
		    </vuetable>
		    
		</div>    
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
                name :'active', 
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

    }
  },
  components: {
    Vuetable  
  },
}
</script>

<style lang="css" scoped>
</style>