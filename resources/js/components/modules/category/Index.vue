<template>
  <div>
    <vuetable 
          ref="vuetable" 
          :fields="categoryFields" 
          :api-url="apiUrl"
          :css="css.table"
          data-path="data"
          :per-page="perPage"
          pagination-path="data.data"
          :append-params="moreParams"
          @vuetable:pagination-data="onPaginationData"
    >
      <template slot="actions" slot-scope="props">        
          <v-icon
            color="blue"
            @click="">
            delete
          </v-icon>
      </template>
    </vuetable>
    <div class="vuetable-pagination">
      <vuetable-pagination-info ref="paginationInfo"
          :css="css.paginationInfo"
      ></vuetable-pagination-info>
      <vuetable-pagination ref="pagination"
          :css="css.pagination"
          @vuetable-pagination:change-page="onChangePage"
      ></vuetable-pagination>
    </div>
  </div>
</template>

<script>
import Vue from 'vue'
import Vuetable from 'vuetable-2/src/components/Vuetable'
import VuetablePagination from 'vuetable-2/src/components/VuetablePagination'
import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'

Vue.use(Vuetable)
export default {

  name: 'Index',

  data () {
    return {
        perPage : 10,
        moreParams : {},
    	  apiUrl : 'api/categories',
        categoryFields : [
            {   
                name :'id', 
                title:'ID', 
                sortField:'id'
            }, 
            {   
                name :'name', 
                title:'Name', 
                sortField:'name'
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
    Vuetable ,
    VuetablePagination,
    VuetablePaginationInfo     
  },
  methods: {

      
      onPaginationData (paginationData) {
          this.$refs.pagination.setPaginationData(paginationData)
          this.$refs.paginationInfo.setPaginationData(paginationData)
      },

      onChangePage (page) {
          this.$refs.vuetable.changePage(page)
      }

      

      
  },

}
</script>

<style lang="css" scoped>
</style>