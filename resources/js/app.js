
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
import Login from './components/Login.vue'
import LoginIndex from './components/modules/login/Index.vue'
import Register from './components/modules/register/Index.vue'


var access_token = localStorage.getItem('access_token')

axios.defaults.baseURL = 'http://chefguidecenter.herokuapp.com/';
axios.defaults.headers.common['Authorization'] =  access_token;
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';

const router = new VueRouter({
    routes: [ 
        {
            path:'/login',
            name:'Login',
            component:Login,
            children : [    
                {
                    path:'/register',
                    name: 'Register',
                    component: Register,
                },  
                {
                    path:'/login',
                    name: 'LoginIndex',
                    component: LoginIndex,
                },  
                
            ]
        },

        {
            path:'/',
            name:'Dashboard',
            component:Dashboard,
            meta: { requiresAuth: true },
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

router.beforeEach((to, from, next) => { 

    var access_token = localStorage.getItem('access_token')  

    if (to.matched.some(record => record.meta.requiresAuth) && !access_token) {

        next('/login');
    }else if(to.path === '/login' && access_token){
        next('/');
    } 
    else {
        next();
    }
    
});

const app = new Vue({
    el: '#app',
    template: '<app></app>',
    components: { App },
    router
});
