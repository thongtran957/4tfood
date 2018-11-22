<template>
	<div class="form-login-wrapper">
		<main class="login-form">
      	 <v-container fluid fill-height class="loginOverlay">
          <v-layout flex align-center justify-center>
            <v-flex xs12 sm4 elevation-6>
              <v-toolbar class="pt-5 blue darken-4">
                <v-toolbar-title class="white--text"><h4>Welcome To Cook Cook</h4></v-toolbar-title>
                </v-toolbar-items>
              </v-toolbar>
              <v-card>
                <v-card-text class="pt-4">
                  <div>
                      <v-form ref="form">
                        <v-text-field
			              	label="Username"
			              	v-model="item.email"
                        ></v-text-field>
                        <v-text-field
                          	label="Password"
                         	type="password"
                         	v-model="item.password"
                        ></v-text-field>
                        <v-layout >
                            <v-btn >Submit</v-btn>
                            <v-btn @click="clear">Clear</v-btn>
                        </v-layout>
                      </v-form>
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
export default {

  name: 'Index',

  data () {
    return {
    	item:{
    		email : '',
    		password : '',
    	}
    }
  },

  methods : {
  	clear(){
  		this.item.email = '',
  		this.item.password = ''
  	}
  }
}
</script>

<style lang="css" scoped>

</style>


