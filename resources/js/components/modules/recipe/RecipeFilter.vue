<template>
	<v-form>
        <v-container>
          <v-layout wrap>
            <v-flex xs12 sm6 md2>
              	<v-select  label="Category" v-model="filter.cname"  :items="listCategory" @keyup.enter="doFilter"></v-select>
            </v-flex>
            <v-flex xs12 sm6 md4>
              	<v-text-field label="Name" v-model="filter.name" @keyup.enter="doFilter"></v-text-field>
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

  name: 'RecipeFilter',

  data () {
    return {
    	filter:{
          name:'',
          cname:'',
          active:''
        },

        listCategory : []
    }
  },
  created(){
  	this.getCategory();
  },
  methods: {
		doFilter () {
		    this.$events.fire('filter-set', this.filter)
		},

		resetFilter () {
		    this.filter.name = '',
		    this.filter.cname = '',
		    this.filter.active = '',
		    this.$events.fire('filter-reset')
		},

		getCategory(){
	  		var data =[];
	  		axios.get('api/list/categories')
	        .then(response => { 
	         	_.forEach(response.data, function(value) {
	                data.push(value.name);
	            });
	        })
	        .catch(
	          error => console.log(error)
	        )
	       	this.listCategory = data
	  	},
	}
}
</script>

<style lang="css" scoped>
</style>