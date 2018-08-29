<template lang="html">
    <div>
        <sui-message class="notif">
            <sui-message-header>Private messages</sui-message-header>
            <sui-item-group divided v-if="unseenPMs.length">
                <sui-item  v-for="pm in unseenPMs" key="pm.idMessage" class="teamList invitationsList" @click.native="setPMActive(pm)">
                    <div>
                        <img src="../assets/teamLogo.png" />
                    </div>
                    <div>
                        <sui-item-content vertical-align="middle"> <h4>{{ pm.sender }} :</h4> 
                            <p>{{pm.message}}</p>
                        </sui-item-content>
                    </div>     
                </sui-item>
            </sui-item-group>
            <p v-else>
                No new private messages
            </p>
        </sui-message>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'
            export default {
                data() {
                    return {
                        unseenPMs: []
                    };
                },
                watch: {
                    getUnseenPMs() {
                        if (this.$store.getters.getUnseenPMs)
                            this.unseenPMs = this.$store.getters.getUnseenPMs;
                        else
                            this.unseenPMs = [];

                        this.$forceUpdate();
                    }
                },
                created() {
                    this.$store.dispatch('getUnseenPMs', {
                        idUser: this.$store.state.userInfo.idUser
                    });
                    this.unseenPMs = this.$store.state.unseenPMs;
                },
                computed: {

                    ...mapGetters([
                            'getUnseenPMs'
                    ])
                },
                methods: {
                    setPMActive(message) {
                        this.$store.dispatch('getUser', {idUser: message.idUser});
                        this.$store.dispatch('getPrivateMessages', {idUser: this.$store.state.userInfo.idUser, idSender: message.idUser});
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
