<template>
    <div>
        <div class="MainVue">
            <div v-if="!connected" class='disconnectedContent' ondragstart="return false;" ondrop="return false;">
                <!-- <MainTitle class='mainTitle'></MainTitle> -->
                    <img src="../assets/index-01.jpg"/>

                <!-- <DescriptionBox></DescriptionBox> -->
                <div class="loginButtons">
                    <LoginButtons></LoginButtons>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import MainTitle from "./MainTitle.vue";
import DescriptionBox from "./DescriptionBox.vue";
import LoginButtons from "./LoginButtons.vue";
import ConnectedContent from "./ConnectedContent.vue";

export default {
  components: { MainTitle, DescriptionBox, LoginButtons, ConnectedContent },
  computed: {
    connected() {
      return this.$store.getters.connected;
    }
  },
  watch: {
    connected: function () {
      if (this.$store.getters.connected) {
        this.$router.push(this.$router.currentRoute.path + "chat");
      }
    }
  },
  created() {
    this.$store.dispatch("loginCheck");
    this.$store.dispatch("getSports");
  }
};
</script>
<style>
body {
  /* background-color: #af1945; */
}
</style>

<style scoped>
.MainVue img {
    width: 100%;
    height: 550px;
    border-radius: 0px;
    object-fit: cover;
}
.MainVue {
  height: 100%;
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
}
.loginButtons {
  display: block;
  margin: auto;
  width: 100%;
  left: 0;
  right: 0;
  margin-top: 20px;
  margin-bottom: 20px;
  text-align: center;
}

html,
body {
  height: 100%;
}
.mainTitle {
  max-width: 100%;
}
.disconnectedContent {
  height: auto;
  /* position: fixed; */
}
</style>



