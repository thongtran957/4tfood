<template>
	<div id="app">
	  	<v-app id="inspire">
		    <v-navigation-drawer
		      fixed
		      :clipped="$vuetify.breakpoint.mdAndUp"
		      app
		      v-model="drawer"
		    >
		    <side-bar></side-bar>  
		    </v-navigation-drawer>
		    <v-toolbar
		      color="red"
		      dark
		      app
		      :clipped-left="$vuetify.breakpoint.mdAndUp"
		      fixed
		      class="transparent"
		      flat
		    >
			    <v-toolbar-title style="width: 300px" class="ml-0 pl-3">
			        <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
			        <span class="hidden-sm-and-down">Thong Tran</span>
			    </v-toolbar-title>
			    <v-spacer></v-spacer>
			     <v-icon @click="logout">logout</v-icon>			    
	    	</v-toolbar>
	    	<v-content>
              	<v-container>
                  	<router-view></router-view>
              	</v-container>
            </v-content>
	    	
  		</v-app>
	</div>
</template>

<script>
import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import SideBar from './partials/Sidebar.vue'
 
 Vue.use(Vuetify,{
    iconfont: 'md'
 })
export default {

  	name: 'Dashboard',

	data () {
	    return {
	    	height: $(window).height(),
        	hidden: 'auto',
	    	drawer: null,
	    }
	},

	components: {
      	'side-bar':SideBar,
    },

    methods:{
    	logout(){
	    	localStorage.removeItem('access_token')
	        this.$router.push({
	            name: 'Login'
	        })

    	}
    }
}
</script>

<style lang="css" scoped>
</style>