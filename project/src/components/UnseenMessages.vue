<template lang="html">
    <div>
        <sui-message class="notif">
            <sui-message-header>Messages</sui-message-header>
            <sui-item-group divided v-if="unseenMessages.length">
                <sui-item  v-for="msg in unseenMessages" key="msg.idMessage" class="teamList invitationsList" @click.native="switchTeam(msg.idReceiver)">
                    <sui-item-content>
                        <h5>team : {{ msg.team.teamName }}</h5>
                        <div>
                            <img src="../assets/teamLogo.png" />
                        </div>
                        <div>
                            <sui-item-content vertical-align="middle"> <h4>{{ msg.sender }} :</h4> 
                                <p>{{msg.message}}</p>
                            </sui-item-content>
                        </div>
                    </sui-item-content>    
                </sui-item>
            </sui-item-group>
            <p v-else >
                No new messages
            </p>
        </sui-message>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'
            export default {
                data() {
                    return {
                        unseenMessages: []
                    };
                },
                watch: {
                    getUnseenPMs() {
                        if (this.$store.getters.unseenMessages)
                            this.unseenMessages = this.$store.getters.unseenMessages;
                        else
                            this.unseenMessages = [];

                        this.$forceUpdate();
                    }
                },
                created() {
                    this.$store.dispatch('getUnseenMessages', {
                        idUser: this.$store.state.userInfo.idUser
                    });
                    this.unseenMessages = this.$store.state.unseenMessages;
                },
                computed: {

                    ...mapGetters([
                            'getUnseenMessages'
                    ])
                },
                methods: {
                    switchTeam(idTeam){
                        for (var i = 0; i < this.$store.state.teams.length; i++){
                            if (this.$store.state.teams[i].idTeam == idTeam){
                                this.$store.commit('SET_SELECTED_TEAM', this.$store.state.teams[i]);
                                this.$store.commit('SET_TEAM', this.$store.state.teams[i]);
                                this.$store.commit('SET_PM_ACTIVE', false);
                                this.$store.commit('SET_SELECTED', this.$store.state.teams[i].idTeam);
                                
                                this.$store.dispatch('getMessages', this.$store.state.teams[i]);
                                this.$store.dispatch('setSeenDateM', {
                                    idTeam: this.$store.state.teams[i].idTeam,
                                    idUser: this.$store.state.userInfo.idUser,
                                    seenDate: this.$moment(Date.now()).format(this.$store.state.dateFormat)
                                });
                                break;
                            }
                        }
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
