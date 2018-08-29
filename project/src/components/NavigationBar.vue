<template>
    <div class="topnav">
        <a class="logo" href="/">
          <img src="../assets/logoSR_mobile_min.png"/>
        </a>
        <sui-dropdown v-if="connected" text="Profile" class="rightnav">
          <sui-dropdown-menu>
            <sui-dropdown-item href="/profile"><router-link to="/profile"><sui-icon name="edit" />Edit profile</router-link></sui-dropdown-item>
            <sui-dropdown-divider/>
            <sui-dropdown-item @click.native="signout"><sui-icon name="sign out alternate" />Sign out</sui-dropdown-item>
          </sui-dropdown-menu>
        </sui-dropdown>
        <router-link to="/who-we-are" class="rightnav">Who we are</router-link>
        <router-link to="/contact-us" class="rightnav">Contact us</router-link>
        <router-link to="/about-us" class="rightnav">About us</router-link>
        <router-link v-if="connected" to="/chat" class="rightnav">Chat</router-link>        
        <sui-dropdown v-if="connected" text="Teams" class="rightnav">
          <sui-dropdown-menu>
            <sui-dropdown-item><router-link to="/teamjoin"><sui-icon name="hand point right outline" />Join Team</router-link></sui-dropdown-item>                       
            <sui-dropdown-item><router-link to="/teamcreate"><sui-icon name="edit" />Create Team</router-link></sui-dropdown-item>                       
          </sui-dropdown-menu>
        </sui-dropdown>
        <router-link v-if="connected" to="/events" class="rightnav">Events</router-link>
    </div>
</template>

<script>
export default {
  methods: {
    signout: function () {
      this.$router.push("/");
      this.$store.dispatch("logout");
    }
  },
  computed: {
    connected() {
      return this.$store.getters.connected;
    }
  }
};
</script>
<style scoped>
html,
body {
  height: 100%;
}
body {
  /* background-color: #af1945; */
}
.topnav .logo img {
  height: 50px;
}
.item > a {
  color: #000;
}
.topnav {
  /* overflow: hidden; */
  background-color: #000;
  padding-left: 50px;
  padding-right: 50px;
  display: table;
  width: 100%;
}

.topnav > a {
  font-family: "Raleway", sans-serif;
  float: left;
  color: #f2f2f2;
  text-align: center;
  padding: 10px 15px;
  text-decoration: none;
  font-size: 14px;
  color: #95a9bb;
  text-transform: uppercase;
  font-weight: bold;
}
.topnav .dropdown {
  font-family: "Raleway", sans-serif;
  float: left;
  color: #f2f2f2;
  text-align: center;
  padding: 10px 15px;
  text-decoration: none;
  font-size: 14px;
  color: #95a9bb;
  text-transform: uppercase;
  font-weight: bold;
}
.topnav .rightnav {
  float: right;
  margin-top: 15px;
  width: auto;
}
.ui.dropdown .menu {
  right: 0;
  left: auto;
}
.topnav a.active {
  background-color: #4caf50;
  color: white;
}
</style>



