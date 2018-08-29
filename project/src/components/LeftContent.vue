<template>
    <div class="leftContent" is="sui-container">
        <LeftMenu v-show="mainMenuActive" @activated="switchContent"></LeftMenu>
        <TeamMenu v-show="teamMenuActive" @activated="switchContent"></TeamMenu>
        <div is="sui-container" class="leftContainer">
            <div id="sui-container" class="teamList" v-if="teamsActive" >
                <TeamList @teamMenuActive="switchMenu"></TeamList>
            </div>
            <div v-else-if="notifActive" class="teamList"  >
                <!--<h3>Invitations</h3>-->
                <Invitations></Invitations>
                <!--<h3>Private messages</h3>-->
                <UnseenPMs></UnseenPMs>
                <!--<h3>Messages</h3>-->
                <UnseenMessages></UnseenMessages>
                <!--<h3>Events</h3>-->
                <EventsNotif></EventsNotif>
            </div>
            <div v-else-if="aboutActive" class="teamList"  >
                <aboutTeam 
                    v-bind:team="selectedTeam" 
                    v-bind:initMenu="true"
                    @teamDisband="switchContent"
                    ></aboutTeam>
            </div>
            <div v-else-if="membersActive" class="teamList"  >
                <teamMembers v-bind:team="selectedTeam" ></teamMembers>
            </div>
        </div>
        <div is="sui-container" class="newTeamMenu">
            <sui-button @click.native="showNewTeamModal = true" class='basicBtn' fluid v-if="teamsActive" >New Team</sui-button>
            <Modal v-if="showNewTeamModal" @close="showNewTeamModal = false">
                <div slot="header">
                    <h3>New Team</h3>
                </div>
                <div slot="body">
                    <form class="ui form">
                        <div class="field">
                            <label>Team Name</label>
                            <span class="errorMsg">{{errorTeamName}}</span>
                            <input type="text" name="team-name" placeholder="Team Name" v-model="teamName">
                        </div>
                        <div class="field">
                            <label>Sport</label>
                            <select class="ui dropdown" v-model="idSport">
                                <option v-for="option in sports" v-bind:value="option.idSport">
                                    {{ option.sport }}
                                </option>
                            </select>
                        </div>
                        <div class="field">
                            <label>Description</label>
                            <input type="text" name="description" placeholder="Description" v-model="teamDesc">
                        </div>
                        <!--<div class="field">
                            <label>Team Logo</label>
                            <input type="file" name="team-logo" placeholder="Team Logo">
                        </div>-->
                    </form>
                </div>
                <div slot="footer">
                    <sui-button @click.native="createTeam" class='basicBtn newTeamBtn'>Submit</sui-button>
                    <sui-button @click.native="cancel" class='basicBtn'>Cancel</sui-button>
                </div>
            </Modal>
            <Modal v-if="$store.state.loading">
                <div slot="header">
                    <h3>Loading data</h3>
                </div>
                <div slot="body">
                    <sui-icon name="large spinner" loading />
                </div>
                <div slot="footer">

                </div>
          
            </Modal>
        </div>
    </div>
</template>

<script>
    import LeftMenu from './LeftMenu.vue'
            import TeamMenu from './TeamMenu.vue'
            import aboutTeam from './aboutTeam.vue'
            import teamMembers from './teamMembers.vue'
            import Modal from './Modal.vue'
            import TeamList from './TeamList.vue'
            import Invitations from './Invitations.vue'
            import UnseenPMs from './UnseenPMs.vue'
            import UnseenMessages from './UnseenMessages.vue'
            import EventsNotif from './EventsNotif.vue'
            import { mapGetters } from 'vuex'
            export default {
                components: {LeftMenu, Modal, TeamList, Invitations, TeamMenu, aboutTeam, teamMembers, UnseenPMs, UnseenMessages, EventsNotif},
                data() {
                    return {
                        description: 'Connected',
                        showNewTeamModal: false,
                        teamName: '',
                        sports: [],
                        idSport: null,
                        teamDesc: null,
                        teams: [],
                        teamsActive: true,
                        notifActive: false,
                        aboutActive: true,
                        membersActive: true,
                        invitations: [],
                        mainMenuActive: true,
                        teamMenuActive: false,
                        selectedTeam: null,
                        errorTeamName: '',
                        teamValid: true

                    }
                },
                watch: {
                    getInvitations() {
                        this.invitations = this.$store.state.invitations;
                    }
                },
                created() {
                    this.sports = this.$store.state.sports;
                    if (this.sports){
                        this.idSport = this.sports[0].idSport;
                    }
                    this.invitations = this.$store.state.invitations;
                },
                methods: {
                    cancel() {
                        this.showNewTeamModal = false;
                    },
                    createTeam() {
                        if (this.teamName === ''){
                            this.errorTeamName = 'No team name entered'
                            this.teamValid = false;
                        } else {
                            this.errorTeamName = '';
                        }
                        if (this.teamValid){
                            var sport = {
                                idSport: this.idSport,
                                sport: null
                            };
                            this.$store.commit('SET_LOADING', true);
                            this.$store.dispatch('createTeam', {
                                teamName: this.teamName,
                                sport: sport,
                                teamDesc: this.teamDesc,
                                idUser: this.$store.state.userInfo.idUser
                            });
                            this.showNewTeamModal = false;
                        }
                        this.teamValid = true;
                        
                    },
                    changeTeamChat(id) {
                        //this.$emit('changeTeamChat', id);
                    },

                    switchContent(value) {
                        if (value == "teams") {
                            this.teamsActive = true;
                            this.notifActive = false;
                            this.aboutActive = false;
                            this.membersActive = false;
                        } else if (value == "notif") {
                            this.notifActive = true;
                            this.teamsActive = false;
                            this.aboutActive = false;
                            this.membersActive = false;
                        } else if (value == "leftMenu") {
                            this.switchMenu();
                            this.teamsActive = true;
                            this.notifActive = false;
                            this.aboutActive = false;
                            this.membersActive = false;

                        } else if (value == "about") {
                            this.aboutActive = true;
                            this.notifActive = false;
                            this.membersActive = false;
                            this.teamsActive = false;
                        } else if (value == "members") {
                            this.membersActive = true;
                            this.aboutActive = false;
                            this.notifActive = false;
                            this.teamsActive = false;
                        }
                    },
                    switchMenu(team) {
                        this.mainMenuActive = !this.mainMenuActive;
                        this.teamMenuActive = !this.teamMenuActive;
                        if (this.mainMenuActive) {
                            this.switchContent('teams');
                        } else {
                            this.aboutActive = true;
                            this.notifActive = false;
                            this.membersActive = false;
                            this.teamsActive = false;
                            this.switchContent('about');
                        }
                        this.selectedTeam = team;
                        this.$store.commit('SET_SELECTED_TEAM', this.selectedTeam);

                    }
                },
                mounted() {
                    this.$store.dispatch('getInvitations', {idEmail: this.$store.state.userInfo.idEmail});
                    this.invitations = this.$store.state.invitations;
                },
                computed: {
                    ...mapGetters([
                            'getInvitations',
                            'invitationsCount'
                    ])
                }
            }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    .LeftMenu .ui .container{
        height: 100%;
    }
    .leftContainer{
        display: flex;
        width: 100%;
        height: 90%;
        overflow-y: auto;
        overflow-x: hidden;
        background-color: #fff;
        align-items: flex-start;
    }
    .leftContent{
        height: 100%;
        margin-bottom: 10%;
    }
    .newTeamMenu{
        height: 5%;
        align-self:flex-start;
        margin: auto;
        background-color: #fff; 
    }
    .errorMsg{
        color: red;
    }

</style>
