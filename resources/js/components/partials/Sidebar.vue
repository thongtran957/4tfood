<template>
  <div id="app">
    <v-list dense class="pt-0">
      <v-list-tile
        v-for="item in items"
        :key="item.title"
        :to="item.link"
        ripple="ripple"
        :exact="item.exact" 
        class="black--text"
        active-class="red--text"
      >
        <v-list-tile-action>
            <v-icon color="red">{{ item.icon }}</v-icon>
        </v-list-tile-action>

        <v-list-tile-content>
            <v-list-tile-title color="red">{{ item.title }}</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>
    </v-list>
</div>
</template>

<script>
export default {

  name: 'Sidebar',

  data () {
    return {
        items: [
          { title: 'Home', icon: 'dashboard', link: '/'},
          { title: 'About', icon: 'people', link: 'example' },
          { title: 'Category', icon: 'category', link: 'category' },
          { title: 'Recipe', icon: 'receipt', link: 'recipe' }
        ]
    }
  },
}
</script>

<style lang="css" scoped>
</style>