<template>
  <sui-container>
    <sui-divider hidden />
    <sui-grid class="team-content" divided>
      <sui-grid-row stretched>
        <sui-grid-column>
          <sui-segment v-if="nb_public">
            <h1 is="sui-header">Public Teams</h1>
            <sui-list v-for="(team, key) in public_teams" :key="key" divided relaxed>
              <sui-list-item>
                <sui-list-icon name="github" size="large" vertical-align="middle" />
                <sui-list-content>
                  <a is="sui-list-header" @click.native="TeamDetail(team)">{{team.teamName}}</a>
                  <a is="sui-list-description">Updated 10 mins ago</a>
                </sui-list-content>
              </sui-list-item>             
            </sui-list>
          </sui-segment>
          <sui-segment v-if="nb_private">
            <h1 is="sui-header">Private Teams</h1>
            <sui-list v-for="(team, key) in private_teams" :key="key" divided relaxed>
              <sui-list-item>
                <sui-list-icon name="github" size="large" vertical-align="middle" />
                <sui-list-content>
                  <a is="sui-list-header" @click.native="TeamDetail(team)">{{team.teamName}}</a>
                  <a is="sui-list-description">Updated 10 mins ago</a>
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

<script>
export default {
  name: 'StretchedExample',
  data() {
    return {
      public_teams: [],
      private_teams: [],
      nb_public: false,
      nb_private: false,
    }
  },
  mounted: function () {
    this.getTeamList.forEach(element => {      
      if (element.type == "public") {
        this.public_teams.push(element);
        if (this.public_teams.length > 0) {
          this.nb_public = true;
        } else {
          this.nb_public = false;
        }
      } else if (element.type == "private") {
        element.coaches.forEach(coach => {
          if (coach.idUser == this.getUser) {
            this.private_teams.push(element);
            if (this.private_teams.length > 0) {
              this.nb_private = true;
            } else {
              this.nb_private = false;
            }
          }
        });        
      } 
    }); 
  },
  computed: {
    getUser() {      
      return this.$store.getters.getUser;
    },
    connected() {
      return this.$store.getters.connected;
    },
    getTeamList() {
      return this.$store.getters.getTeamList;
    }
  },
  watch: {
    connected: function () {
      if (!this.$store.getters.connected) {
        this.$router.push("/");
      }
    }
  },
  methods: {
    TeamDetail: function (team) {
      this.$store.dispatch("SelectedTeam", team);      
      this.$router.push("teamdetail");
    }
  }
};
</script>

<style>
.team-content {
  min-height: 576px;
}
</style>