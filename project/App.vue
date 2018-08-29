<template>
  <div id="app">
      <MainVue></MainVue>
  </div>
</template>

<script>
import MainVue from "./components/MainVue.vue"
export default {
  components: { MainVue },
  name: 'app'
        
};
</script>

<style scoped>
    #app{
        height:100%;
        display: flex;
        align-items: center;
        flex-direction: column;
        flex-wrap: wrap;
        justify-content: center;
        align-content: center;
    }
    html, body{
        height: auto;
        min-height: 100%;
        margin: 0px;
    }
</style>
