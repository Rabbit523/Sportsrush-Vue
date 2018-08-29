<template>
    <div>
        <NavigationBar></NavigationBar>
        <router-view></router-view>
        <FooterBar></FooterBar>
    </div>
</template>

<script>
import store from "./store/store.js";
import MainVue from "./components/MainVue.vue";
import NavigationBar from "./components/NavigationBar.vue"
import FooterBar from "./components/FooterBar.vue"

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
