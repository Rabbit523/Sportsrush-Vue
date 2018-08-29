<template lang="html">
    <div>
        <Modal v-if="showTeamMembersModal" @close="showTeamMembersModal = false">
            <div slot="header">
                <h3>Invite Members From Other Teams</h3>
                <h5>{{ this.$store.state.team.teamName }}</h5>
            </div>
            <div slot="body">
                <sui-item-group divided>
                    <sui-item  v-for="team in teams" key="team.idTeam" class="teamList">
                        <h4>{{ team.teamName }}</h4>
                        <div v-if="team.idTeam != $store.state.team.idTeam">
                            <div v-if="team.coach == 1">
                                <div v-for="player in team.players">
                                    <div v-if="player !== null">
                                        <div>
                                            <img src="../assets/teamSmall.png" />
                                        </div>
                                        <sui-item-content vertical-align="middle">{{ player.firstname }} {{ player.lastName }}</sui-item-content>
                                        <div class="teamMenu" >
                                            <sui-button @click.native="showAddMembers(team)" class='basicBtn'>Add Member</sui-button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </sui-item>
                </sui-item-group>
            </div>
            <div slot="footer">
                <sui-button @click.native="cancelTeamMembers" class='basicBtn'>Close</sui-button>
            </div>
        </Modal>
        <Modal v-if="showAddMembersModal" @close="showAddMembersModal = false">
            <div slot="header">
                <h3>Invite New Members</h3>
                <h5>{{ this.$store.state.team.teamName }}</h5>
            </div>
            <div slot="body">
                <form class="ui form">
                    <div class="fields">
                        <div class="field">
                            <input type="text" name="first-name" placeholder="Email" v-model="newEmail">
                        </div>
                        <div class="field">
                            <div>
                                <input type="checkbox" tabindex="0" class="hidden" v-model="coach">
                                    <label>As coach</label>
                            </div>
                        </div>
                    </div>
                    <!--<sui-button @click.native="switchAddMembersMenu" class='basicBtn'>Other teams</sui-button>-->
                </form>
            </div>
            <div slot="footer">
                <sui-button @click.native="inviteMember" class='basicBtn'>Invite</sui-button>
                <sui-button @click.native="cancel" class='basicBtn'>Cancel</sui-button>
            </div>
        </Modal>
        <sui-item-group divided>
            <sui-item  v-for="team in teams" key="team.idTeam" @click.native="changeTeam(team)"  class="teamList"  v-bind:class="{highlight:team.idTeam == selectedOrFirst}">
                <div>
                    <img src="../assets/teamLogo.png" />
                </div>
                <sui-item-content vertical-align="middle">{{ team.teamName }}</sui-item-content>
                <div class="teamMenu" >

                    <sui-icon class="teamSidebar" name="sidebar big" @click.native="showTeamInfo(team)" />
                    <template v-if="team.coach == 1" >
                        <sui-button @click.native="showAddMembers(team)" class='basicBtn'>Add Member</sui-button>
                    </template>

                </div>
            </sui-item>
        </sui-item-group>
    </div>
</template>

<script>
    import Modal from './Modal.vue'
            import { mapGetters } from 'vuex'
            export default {
                components: {Modal},
                data() {
                    return {
                        teams: [],
                        showAddMembersModal: false,
                        newEmail: '',
                        coach: false,
                        currentTeamCoach: false,
                        showTeamMembersModal: false,
                        selected: undefined,
                    };
                },
                watch: {
                    getTeamList() {
                        this.teams = this.$store.state.teams;
                       /* if (!this.selected){
                            if (this.teams.length){
                                this.selected = this.teams[0].idTeam;
                            }
                        }*/
                        this.$forceUpdate();
                    },
                    getSelected(){
                        this.selected = this.$store.state.selected;
                    }
                },
                created() {
                    this.$store.dispatch('getTeams', {idUser: this.$store.state.userInfo.idUser});
                    this.teams = this.$store.state.teams;
                    /*if (!this.selected){
                        if (this.teams.length){
                            this.changeTeam(this.teams[0]);
                        }
                    }*/
                },
                mounted() {
                    /*if (!this.selected){
                        if (this.teams.length){
                            this.changeTeam(this.teams[0]);
                        }
                    }*/
                },
                computed: {

                    ...mapGetters([
                            'getTeamList',
                            'getSelected'
                    ]),
                    selectedOrFirst(){
                        if (this.$store.state.selected){
                            return this.$store.state.selected;
                        } else {
                            if (this.teams.length){
                                return this.teams[0].idTeam
                            } else {
                                return undefined;
                            }
                        }
                    }
                },
                methods: {
                    changeTeam(team) {
                        this.selected = team.idTeam;
                        this.$store.commit('SET_SELECTED', this.selected);
                        this.$store.commit('SET_TEAM', team);
                        this.$store.dispatch('getEvents', {idTeam: this.$store.state.team.idTeam});
                        this.$store.dispatch('setSeenDateM', {
                            idTeam: this.$store.state.team.idTeam,
                            idUser: this.$store.state.userInfo.idUser,
                            seenDate: this.$moment(Date.now()).format(this.$store.state.dateFormat)
                        });
                        this.$store.commit('SET_PM_ACTIVE', false);
                        this.$store.dispatch('getMessages', {
                            idTeam: this.$store.state.team.idTeam
                        });
                        team.clicked = !team.clicked;
                        
                        //this.$emit('changeTeam', id);
                    },
                    cancel() {
                        this.showAddMembersModal = false;
                    },
                    cancelTeamMembers() {
                        this.showTeamMembersModal = false;
                    },
                    inviteMember() {
                        if (this.newEmail) {
                            this.$store.dispatch('invite', {
                                idTeam: this.$store.state.team.idTeam,
                                email: this.newEmail,
                                coach: this.coach
                            });
                            this.showAddMembersModal = false;
                        }
                    },
                    showTeamInfo(selectedTeam) {
                        this.$emit('teamMenuActive', selectedTeam);
                    },
                    showAddMembers(clickedTeam) {
                        this.$store.commit('SET_TEAM', clickedTeam);
                        this.showAddMembersModal = true;

                    },
                    switchAddMembersMenu() {
                        this.showAddMembersModal = !this.showAddMembersModal;
                        this.showTeamMembersModal = !this.showTeamMembersModal;
                    }
                }
            };
</script>

<style scoped>
    .teamSidebar:hover {
        color: darkgray;
    }
    
    .teamList item{
        color: blue;
        background-color: #ffffff;
    }
    
    img{
        border-radius: 50%;
        size: 100px
    }
    .teamList.Selected{
        background-color: #d7d9dd;
    }
    .teamMenu{
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        flex-direction: column;
    }
    .teamList.item.highlight {
        background: lightgrey;
        border: solid darkgray 1px;
    }
</style>
