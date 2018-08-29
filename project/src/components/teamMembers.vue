<template lang="html">
    <div>
        <div>
            <h3>Coaches</h3>
            <sui-item-group divided>
                <sui-item v-if="$store.state.team.coach == 1">
                    <div>
                        <img src="../assets/teamLogo.png" />
                    </div>
                    <sui-item-content vertical-align="middle">You</sui-item-content>
                </sui-item>
                <sui-item  v-for="coach in team.coaches" key="coach.idUser"  v-if="coach.idUser != $store.state.userInfo.idUser" >
                    <div>
                        <img src="../assets/teamLogo.png" />
                    </div>
                    <sui-item-content vertical-align="middle">{{ coach.firstName }} {{coach.lastName}}</sui-item-content>
                    <sui-icon name="envelope outline big" @click.native="setPMActive(coach)" />
                </sui-item>
            </sui-item-group>
        </div>
        <div>
            <h3>Players</h3>
            <sui-item-group divided>
                <sui-item v-if="$store.state.team.coach == 0">
                    <div>
                        <img src="../assets/teamLogo.png" />
                    </div>
                    <sui-item-content vertical-align="middle">You</sui-item-content>
                </sui-item>
                <sui-item  v-for="player in team.players" key="player.idUser" v-if="player.idUser != $store.state.userInfo.idUser">
                    <div>
                        <img src="../assets/teamLogo.png" />
                    </div>
                    <sui-item-content vertical-align="middle">{{ player.firstName }} {{player.lastName}}</sui-item-content>
                    <sui-icon name="envelope outline big" @click.native="setPMActive(player)" />
                    <sui-icon name="star" @click.native="showPromoteModal(player)" v-if='$store.state.team.coach == 1' />
                    <sui-icon name="window close" @click.native="showRemoveModal(player)" v-if='$store.state.team.coach == 1' />
                </sui-item>
            </sui-item-group>
            
        </div>
        <Modal v-if="showRemovePlayerModal" @close="showRemovePlayerModal = false">
            <div slot="header">
                <h3>Removing player from team </h3>
            </div>
            <div slot="body">
                <p>Are you sure you want to remove this player from the team ?</p>
                <p>Name : {{ player.firstName }} {{ player.lastName }}</p>
                <p>Team : {{ $store.state.team.teamName }}</p>

            </div>
            <div slot="footer">
                <sui-button @click.native="removePlayer(player)" class='basicBtn newTeamBtn'>Remove</sui-button>
                <sui-button @click.native="cancel" class='basicBtn'>Cancel</sui-button>
            </div>
        </Modal>
        <Modal v-if="showPromotePlayerModal" @close="showPromotePlayerModal = false">
            <div slot="header">
                <h3>Promote to coach</h3>
            </div>
            <div slot="body">
                <p>Are you sure you want to promote this player to coach ?</p>
                <p>Name : {{ player.firstName }} {{ player.lastName }}</p>
                <p>Team : {{ $store.state.team.teamName }}</p>

            </div>
            <div slot="footer">
                <sui-button @click.native="setCoach(player)" class='basicBtn newTeamBtn'>Promote</sui-button>
                <sui-button @click.native="cancel" class='basicBtn'>Cancel</sui-button>
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
                            players: [],
                        },
                        showRemovePlayerModal: false,
                        showPromotePlayerModal: false,
                        player: {
                            firstName: '',
                            lastName: ''
                        }
                    };
                },
                watch: {
                    getSelectedTeam() {
                        this.team = this.$store.state.selectedTeam;
                    }
                },
                created() {
                    this.team = this.$store.state.selectedTeam;
                },
                computed: {

                    ...mapGetters([
                            'getSelectedTeam'
                    ])
                },
                methods: {
                    setPMActive(user){
                        this.$store.commit('SET_RECEIVER_USER', user);
                        this.$store.commit('SET_PM_ACTIVE', true);
                        this.$store.dispatch('getPrivateMessages', {idUser: this.$store.state.userInfo.idUser, idSender: user.idUser});
                    },
                    removePlayer(player){
                        var idTeamArray = 0;
                        var idPlayerArray = 0;
                        for (var i = 0; i < this.$store.state.teams.length; i++){
                            if (this.$store.state.team.idTeam == this.$store.state.teams[i].idTeam){
                                idTeamArray = i;
                                for (var j = 0; j < this.$store.state.teams[i].players.length ; j++){
                                    if (this.$store.state.teams[i].players[j].idUser == player.idUser){
                                        idPlayerArray = j;
                                    }
                                }
                            }
                        }
                        
                        this.$store.dispatch('deleteMembership', {
                            idTeam: this.$store.state.team.idTeam,
                            idUser: player.idUser,
                            player: player,
                            idTeamArray: idTeamArray,
                            idPlayerArray: idPlayerArray
                        })
                        this.showRemovePlayerModal = false;
                    },
                    setCoach(player){
                        this.$store.dispatch('setCoach', {
                            idUser: player.idUser,
                            idTeam: this.$store.state.team.idTeam
                        });
                        this.showPromotePlayerModal = false;
                    },
                    showRemoveModal(player){
                        this.player = player;
                        this.showRemovePlayerModal = true;
                    },
                    showPromoteModal(player){
                        this.player = player;
                        this.showPromotePlayerModal = true;
                    },
                    cancel(){
                        this.showRemovePlayerModal = false;
                        this.showPromotePlayerModal = false;
                    }
                }

            };
</script>

<style scoped>
    .teamList item{
        color: black;
        background-color: #ffffff;
    }
    img{
        border-radius: 50%;
        size: 100px
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
</style>
