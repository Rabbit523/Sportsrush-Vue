<template>
    <div>
        <div id="app">
            <MainVue></MainVue>
        </div>
    </div>
</template>

<script>
import store from "../store/store.js";
import MainVue from "./MainVue.vue";
import NavigationBar from "./NavigationBar.vue"
import FooterBar from "./FooterBar.vue"

export default {
  store,
  components: { MainVue, NavigationBar, FooterBar },
  name: "app"
};
</script>

<style scoped>
#app {
  height: 100%;
  display: flex;
  align-items: center;
  flex-direction: column;
  flex-wrap: wrap;
  justify-content: center;
  align-content: center;
}
html,
body {
  height: auto;
  min-height: 100%;
  margin: 0px;
}
</style>
