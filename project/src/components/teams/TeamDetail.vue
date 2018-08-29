<template>
  <sui-container>
    <sui-divider hidden />
    <sui-grid divided>
      <sui-grid-row class="team-content" stretched>
        <sui-grid-column>
          <google-map
            :center="{lat:10, lng:10}"
            :zoom="7"
            map-type-id="terrain"
            style="width: 500px; height: 300px"
          >           
          </google-map>
          <sui-segment>
            <sui-button @click.native="joinPlayer" class='basicBtn'>Join</sui-button>
          </sui-segment>
          <sui-segment>
            <h1 is="sui-header">{{team.teamName}}</h1>
            <sui-list divided relaxed>
              <sui-list-item>
                <sui-list-content>
                  <a is="sui-list-header">Coaches</a>
                  <a is="sui-list-description" v-for="(coach, key) in team.coaches" :key="key">{{coach.firstName}} {{coach.lastName }}</a>
                </sui-list-content>
              </sui-list-item>
              <sui-list-item>
                <sui-list-content>
                  <a is="sui-list-header">Players</a>
                  <a is="sui-list-description" v-for="(coach, key) in team.players" :key="key">{{coach.firstName}} {{coach.lastName }}</a>
                </sui-list-content>
              </sui-list-item>
            </sui-list>
          </sui-segment>
        </sui-grid-column>
      </sui-grid-row>
    </sui-grid>
    <sui-divider hidden />
  </sui-container>
</template>

<style>
.team-content {
  min-height: 576px;
}
.vue-map-container {
  width: 100% !important;
}
</style>
<script>
import Modal from "../Modal.vue";
import DatePicker from "vue2-datepicker";
import moment from 'moment';

export default {
  components: { Modal, DatePicker },
  name: 'StretchedExample',
  data() {
    return {
      team: {},
    }
  },
  mounted: function () {     
    this.team = this.getSelectedTeam;   
  },
  computed: {
    getSelectedTeam() {
      return this.$store.getters.getSelectedTeam;
    }
  },
  methods: {
    joinPlayer() {
      this.$store.commit("SET_LOADING", true);      
      this.$store.dispatch("joinTeam", {
        idUser: this.$store.state.userInfo.idUser,
        idTeam: this.team.idTeam
      });
    }
  }
};
</script>