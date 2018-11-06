<template>
	<div id="app">
	  	<v-app id="inspire">
		    <v-navigation-drawer
		      fixed
		      :clipped="$vuetify.breakpoint.mdAndUp"
		      app
		      v-model="drawer"
		      :mini-variant.sync="mini"
		    >
		    <side-bar></side-bar>  
		    </v-navigation-drawer>
		    <v-toolbar
		      color="red"
		      dark
		      app
		      :clipped-left="$vuetify.breakpoint.mdAndUp"
		      fixed
		    >
			    <v-toolbar-title style="width: 300px" class="ml-0 pl-3">
			        <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
			        <span class="hidden-sm-and-down">Cook Cook</span>
			    </v-toolbar-title>
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
 
Vue.use(Vuetify)
export default {

  	name: 'Dashboard',

	data () {
	    return {
	    	drawer: null,
	    }
	},

	components: {
      	'side-bar':SideBar,
    },
}
</script>

<style lang="css" scoped>
</style>