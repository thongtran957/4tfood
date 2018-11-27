<template>
	<div id="app">
		<main class="login-form">
      	 	<v-container fluid fill-height class="loginOverlay">
          		<v-layout flex align-center justify-center>
            		<v-flex xs12 sm4 elevation-6>
              			<v-toolbar class="pt-5 blue darken-4">
                			<v-toolbar-title class="white--text"><h4>Register To Cook Cook</h4></v-toolbar-title>
                			</v-toolbar-items>
              			</v-toolbar>
              			<v-card>
                			<v-card-text class="pt-4">
                  				<div>
                            <v-flex>
                      				<v-text-field
  			              				label="Username"
  			              				v-model="item.username"
                      				></v-text-field>
                            </v-flex>
                            <v-flex>
                      				<v-text-field
  			              				label="Email"
  			              				v-model="item.email"
                      				></v-text-field>
                            </v-flex>
                            <v-flex>
                      				<v-text-field
  	                      				label="Password"
  	                     				type="password"
  	                     				v-model="item.password"
                      				></v-text-field>
                            </v-flex>
                      			<v-layout >
                          			<v-btn @click="register(item)">Submit</v-btn>
                          			<v-btn @click="clear">Clear</v-btn>
                      			</v-layout>
                  				</div>
                			</v-card-text>
                      <v-card-text class="pt-4">
                          <div>
                            <p v-if="msg != null" style="color:red">{{msg}}</p>
                            If you had account. <a href="/#/login">Login</a>
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
    		username:'',
    		email:'',
    		password:''
    	},
      msg: null
    }
  },

  methods : {
  	clear(){
  		this.item.username = '',
  		this.item.email = '',
  		this.item.password = ''
  	},

  	register(item){
  		axios.post(config.API_URL+'register',item)
	      .then(response => { 
            this.item.password = ''
            this.msg = response.data.msg
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