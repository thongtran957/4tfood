<template>
	<v-form>
        <v-container>
          <v-layout wrap>
            <v-flex xs12 sm6 md2>
              <v-text-field label="Category" v-model="filter.name" @keyup.enter="doFilter"></v-text-field>
            </v-flex>
	            <v-spacer></v-spacer>
                <v-btn @click="doFilter()"  color="primary" dark class="mb-2">Search</v-btn>
                <v-btn @click="resetFilter()" color="primary" dark class="mb-2">Reset</v-btn>
          </v-layout>
        </v-container>
    </v-form>
</template>

<script>
export default {

 	 name: 'CategoryFilter',

  	data () {
		return {
			filter:{
	          name:'',
	        },
		}
  	},
  
  	methods: {
		doFilter () {
		    this.$events.fire('filter-set', this.filter)
		},

		resetFilter () {
		    this.filter.name = '',
		    this.$events.fire('filter-reset')
		}
	}
}
</script>

<style lang="css" scoped>
</style>