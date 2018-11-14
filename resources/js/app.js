
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import App from './components/App.vue'
import Dashboard from './components/Dashboard.vue'
import Example from './components/ExampleComponent.vue'
import Category from './components/modules/category/Index.vue'
import Recipe from './components/modules/recipe/Index.vue'

const router = new VueRouter({
    routes: [            
        {
            path:'/',
            name:'Dashboard',
            component:Dashboard,
            children : [	
				{
					path:'/example',
		            name:'Example',
		            component:Example
				},
                {
                    path:'/category',
                    name:'Category',
                    component:Category
                },
                {
                    path:'/recipe',
                    name:'Recipe',
                    component:Recipe
                }
		
			]
        },
    ],
});

const app = new Vue({
    el: '#app',
   	template: '<app></app>',
    components: { App },
    router
});