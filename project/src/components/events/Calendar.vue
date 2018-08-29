<template>
  <div id="calendar">
    <sui-divider hidden />
      <vue-event-calendar :events="demoEvents"></vue-event-calendar>
    <sui-divider hidden />
  </div>
</template>

<script>
export default {
  computed: {
    connected() {
      return this.$store.getters.connected;
    }
  },
  watch: {
    connected: function () {
      if (!this.$store.getters.connected) {
        this.$router.push("/");
      }
    }
  },
  data() {
    return {
      demoEvents: [
        {
          date: "2016/11/12", // Required
          title: "Foo" // Required
        },
        {
          date: "2016/12/15",
          title: "Bar",
          desc: "description",
          customClass: "disabled highlight" // Custom classes to an calendar cell
        }
      ]
    };
  }
};
</script>
