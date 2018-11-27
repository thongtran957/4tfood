<template>
   <div id="app">
		<main class="login-form">
      	 	<v-container fluid fill-height class="loginOverlay">
          		<v-layout flex align-center justify-center>
            		<v-flex xs12 sm4 elevation-6>
              			<v-toolbar class="pt-5 blue darken-4">
                			<v-toolbar-title class="white--text"><h4>Login To Cook Cook</h4></v-toolbar-title>
              			</v-toolbar>
              			<v-card>
                			<v-card-text class="pt-4">
                  				<div>
                    				<v-text-field
			              				label="Email"
			              				v-model="item.email"
                    				></v-text-field>
                    				<v-text-field
	                      				label="Password"
	                     				type="password"
	                     				v-model="item.password"
                    				></v-text-field>
                        			<v-layout >
                            			<v-btn @click="login(item)">Submit</v-btn>
                            			<v-btn @click="clear">Clear</v-btn>
                        			</v-layout>
                  				</div>
                			</v-card-text>
                			<v-card-text class="pt-4">
                  				<div>
                            <p v-if="msg != null" style="color:red">{{msg}}</p>
                    				If you don't have account. <a href="/#/register">Register</a>
                  				</div>
                			</v-card-text>
              			</v-card>
            		</v-flex>
          		</v-layout>
	       </v-container>
	    </main>
	</div>
</template>

<script>
import { get,del,put,post } from '../../../helper/index.js'
import config from '../../../config/index.js'
export default {

  name: 'Index',

  data () {
    return {
    	item:{
    		email:'',
    		password:'',
    		status : 1
    	},
      msg:null
    }
  },

  methods : {
  	clear(){
  		this.item.email = '',
  		this.item.password = ''
  	},

  	login(item){
  		axios.post(config.API_URL+'login',item)
	      .then(response => { 
            this.item.password = ''
            this.msg = response.data.msg
            if(response.data && response.data.data){
				        localStorage.setItem('access_token', response.data.data.access_token)

                axios.defaults.headers.common['Authorization'] =  localStorage.getItem('access_token')
                this.authenticated = true

                this.$router.push({
                	name:'Dashboard'
                })

			} else {
				this.authenticated = false
			}

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
