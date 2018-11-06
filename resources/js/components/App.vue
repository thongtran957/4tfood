<template>
     <div id="app">
        <router-view></router-view>
    </div>
</template>

<script>

  export default {
    data() {
      return {
        height: $(window).height(),
        hidden: 'auto'
      }
    },
    name: 'App',
    components: {
    }
  }
</script>