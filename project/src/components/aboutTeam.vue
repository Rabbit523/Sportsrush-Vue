<template lang="html">
    <div class="aboutContent">
        <div class="aboutItems">
            <h2>{{ team.teamName }}</h2>
        </div>

        <div class="aboutItems">
            <img src="../assets/logoMINI.png" />
        </div>

        <div class="aboutItems">
            <sui-message>
                <sui-message-header>Team members</sui-message-header>
                <h4>{{ team.nbCoaches }} coaches</h4>
                <ul class="coachList" style="list-style-type:none">
                    <li v-for="coach in team.coaches" key="coach.idCoach"><sui-icon name="star"/> {{ coach.firstName }} {{ coach.lastName }}</li>
                </ul>
                <h4>{{ team.nbPlayers }} players</h4>
            </sui-message>
        </div>

        <div class="aboutItems">
            <sui-message>
                <sui-message-header>Team description</sui-message-header>
                <p class="justify">
                    {{ team.description }}
                </p>
            </sui-message>
            <sui-button @click.native="showModTeamModal = true" class='basicBtn' v-if="team.coach == 1">Modify Team</sui-button>
            <sui-button @click.native="showDeleteTeamModal = true" class='basicBtn' v-if="team.coach == 1">Delete Team</sui-button>
            <sui-button @click.native="showLeaveTeamModal = true" class='basicBtn' v-if='team.coaches.length > 1'>Leave Team</sui-button>
        </div>


        <Modal v-if="showModTeamModal" @close="showModTeamModal = false">
            <div slot="header">
                <h3>Modify Team</h3>
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
                        <!-- <input type="text" name="description" placeholder="Description" v-model="teamDesc">-->
                        <textarea name="description" placeholder="Description" v-model="teamDesc"></textarea>
                    </div>
                    <!--<div class="field">
                        <label>Team Logo</label>
                        <input type="file" name="team-logo" placeholder="Team Logo">
                    </div>-->
                </form>
            </div>
            <div slot="footer">
                <sui-button @click.native="updateTeam" class='basicBtn newTeamBtn'>Update</sui-button>
                <sui-button @click.native="cancel" class='basicBtn'>Cancel</sui-button>
            </div>
        </Modal>
        <Modal v-if="showDeleteTeamModal" @close="showDeleteTeamModal = false">
            <div slot="header">
                <h3>Team Disband</h3>
            </div>
            <div slot="body">
                <p>Are you sure you want to disband {{ $store.state.team.teamName }}</p>
            </div>
            <div slot="footer">
                <sui-button @click.native="deleteTeam($store.state.team)" class='basicBtn newTeamBtn'>Disband</sui-button>
                <sui-button @click.native="cancel" class='basicBtn'>Cancel</sui-button>
            </div>
        </Modal>
        <Modal v-if="showLeaveTeamModal" @close="showLeaveTeamModal = false">
            <div slot="header">
                <h3>Leaving team</h3>
            </div>
            <div slot="body">
                <p>Are you sure you want to leave the team : {{ $store.state.team.teamName }}</p>
            </div>
            <div slot="footer">
                <sui-button @click.native="leaveTeam($store.state.team)" class='basicBtn newTeamBtn'>Disband</sui-button>
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
</template>

<script>
    import Modal from './Modal.vue'
            import { mapGetters } from 'vuex'
            export default {
                components: {Modal},
                data() {
                    return {
                        team: {
                            idTeam: null,
                            teamName: null,
                            description: null,
                            clicked: false,
                            nbCoaches: 0,
                            nbPlayers: 0,
                            coaches: [],
                            players: []
                        },
                        showModTeamModal: false,
                        showDeleteTeamModal: false,
                        showLeaveTeamModal: false,
                        teamName: '',
                        sports: [],
                        idSport: null,
                        teamDesc: null,
                        errorTeamName: '',
                        updateValid: true
                        
                    };
                },
                watch: {
                    getSelectedTeam() {
                        this.team = this.$store.state.team;
                        this.$forceUpdate();
                    }
                },
                created() {
                    this.team = this.$store.state.selectedTeam;
                    this.sports = this.$store.state.sports;
                    if(this.sports.length){
                        this.idSport = this.sports[0].idSport;
                    }
                    if (this.team){
                        this.teamName = this.team.teamName;
                        this.teamDesc = this.team.description;
                    }
                },
                computed: {

                    ...mapGetters([
                            'getSelectedTeam',
                    ])
                },
                methods: {
                    cancel() {
                        this.showModTeamModal = false;
                        if(this.sports.length){
                            this.idSport = this.sports[0].idSport;
                        }
                        if (this.team){
                            this.teamName = this.team.teamName;
                            this.teamDesc = this.team.description;
                        }
                        this.showDeleteTeamModal = false;
                        this.showLeaveTeamModal = false;
                    },
                    updateTeam(){
                        if (this.teamName === ''){
                            this.errorTeamName = 'No team name entered';
                            this.updateValid = false;
                        } else {
                            this.errorTeamname = '';
                        }
                        if (this.updateValid){
                            this.$store.commit('SET_LOADING', true);
                            this.$store.dispatch('updateTeam',{
                                idTeam: this.team.idTeam,
                                teamName: this.teamName,
                                teamDesc: this.teamDesc,
                                idSport: this.idSport
                            });
                            this.showModTeamModal = false;
                            if(this.sports.length){
                                this.idSport = this.sports[0].idSport;
                            }
                            if (this.team){
                                this.teamName = this.team.teamName;
                                this.teamDesc = this.team.description;
                            }
                        }
                        this.updateValid = true;
                    },
                    deleteTeam(team){
                        this.$store.commit('SET_LOADING', true);
                        var idTeamArray = null;
                        for (var i = 0; i < this.$store.state.teams.length; i++){
                            if (this.$store.state.teams[i].idTeam == team.idTeam){
                                idTeamArray = i;
                                break;
                            }
                        }
                        this.$store.dispatch('deleteTeam', {
                            idTeam : team.idTeam,
                            idTeamArray: idTeamArray
                        });
                        this.showDeleteTeamModal = false;
                        this.$store.commit('SET_SELECTED', undefined);
                        this.$emit('teamDisband', 'teams');
                    },
                    leaveTeam(theTeam){
                        this.$store.commit('SET_LOADING', true);
                        var idTeamArray = null;
                        for (var i = 0; i < this.$store.state.teams.length; i++){
                            if (this.$store.state.teams[i].idTeam == theTeam.idTeam){
                                idTeamArray = i;
                                break;
                            }
                        }
                        this.$store.dispatch('leaveTeam', {
                            idUser: this.$store.state.userInfo.idUser,
                            idTeam: theTeam.idTeam,
                            idTeamArray: idTeamArray
                        });
                        this.showLeaveTeamModal = false;
                        this.$emit('teamDisband', 'teams');
                    }
                },

            };
</script>

<style scoped>
    .aboutContent {

        display: flex;
        flex-flow: row wrap;
        justify-content: flex-start;
        align-content: center;
    }

    .aboutItems {
        width: 90%;
        text-align: center;
        margin-left: 5%;
        margin-right: 5%;
        margin-top: 5%;
    }

    .justify {
        text-align: justify;
        text-justify: inter-word;
    }

    .teamList item{
        color: black;
        background-color: #ffffff;
    }

    .teamImg {
    }

    img{
        size: 250px;
        border: solid black 1px;
    }
    .teamList.Selected{
        background-color: #d7d9dd;
    }
    .teamList{
        margin-top: 5px;
    }
    .invitationsList{
        margin-top: 5px;
    }
    .basicBtn{
        margin: 5px;
    }

    .teamDescription {
        font-size: 10px;
    }

    h4 {
        margin: 0;
    }

    p {
    }
</style>
