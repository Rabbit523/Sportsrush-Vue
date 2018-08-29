<!--
    File        : Invitation.Vue
    Project     : Sportsrush
    Description : Shows all invitations to teams
-->

<template lang="html">
    <div>
        <sui-message class="notif">
            <sui-message-header>Invitation</sui-message-header>
            <sui-item-group divided v-if="invitations.length">
                <sui-item  v-for="invitation in $store.getters.getInvitations" key="invitation.idTeam" class="teamList invitationsList">
                    <div>
                        <img src="../assets/teamLogo.png" />
                    </div>
                    <div>
                        <sui-item-content vertical-align="middle">{{ invitation.teamName }} has invited you</sui-item-content>
                    </div>
                    <div class="basicBtn">
                        <sui-button class='basicBtn' @click.native="joinTeam(invitation)">Accept</sui-button>
                        <sui-button class='basicBtn' @click.native="decline(invitation)">Decline</sui-button>
                    </div>
                </sui-item>
            </sui-item-group>
            <p v-else>
                No invitations
            </p>
        </sui-message>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'
            export default {
                data() {
                    return {
                        invitations: []
                    };
                },
                watch: {
                    getInvitations() {
                        if (this.$store.getters.getInvitations)
                            this.invitations = this.$store.getters.getInvitations;
                        else
                            this.invitations = [];

                        this.$forceUpdate();
                    }
                },
                created() {
                    this.$store.dispatch('getInvitations', {idEmail: this.$store.state.userInfo.idEmail});
                    this.invitations = this.$store.state.invitations;
                },
                computed: {

                    ...mapGetters([
                            'getInvitations'
                    ])
                },
                methods: {

                    joinTeam(invitationJoin) {
                        this.$store.dispatch('joinTeam', {
                            idEmail: invitationJoin.idEmail,
                            idTeam: invitationJoin.idTeam,
                            idUser: this.$store.state.userInfo.idUser
                        });

                    },

                    decline(invitationDecline) {
                        this.$store.dispatch('declineInvitation', {
                            idEmail: invitationDecline.idEmail,
                            idTeam: invitationDecline.idTeam
                        });

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
