<template>
    <div class="LeftMenu" is="sui-container">
        <sui-menu fluid two>
            <sui-menu-item class="LeftItem" icon="angle double left big" @click.native="activeItem('back')"></sui-menu-item>
            <sui-menu-item class="LeftItem" @click.native="activeItem('about')" :class="{'active' : aboutActive}" >About</sui-menu-item>
            <sui-menu-item class="LeftItem" icon="users big" @click.native="activeItem('members')" :class="{'active' : membersActive}" ></sui-menu-item>
           <sui-menu-item class="LeftItem" icon="alarm big" @click.native="activeItem('notif')" :class="{'active' : notifActive}" ><span class="badge red">{{ getInvitationsCount + getUnseenPMsCount }}</span></sui-menu-item>        </sui-menu>
        </sui-menu>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'
            export default {
                data() {
                    return {
                        aboutActive: true,
                        notifActive: false,
                        membersActive: false,
                        getInvitationsCount: 0,
                        getUnseenPMsCount: 0,
                        getUnseenMessagesCount: 0,
                        initMenu: false
                    }
                },
                methods: {
                    activeItem(item, event) {
                        if (item == 'about') {
                            this.aboutActive = true;
                            this.notifActive = false;
                            this.membersActive = false;
                            this.$emit('activated', 'about');
                        } else if (item == 'notif') {
                            this.aboutActive = false;
                            this.notifActive = true;
                            this.membersActive = false;
                            this.$emit('activated', 'notif');
                        } else if (item == "members") {
                            this.aboutActive = false;
                            this.notifActive = false;
                            this.membersActive = true;
                            this.$emit('activated', 'members');
                        } else if (item == 'back') {
                            this.$emit('activated', 'leftMenu');
                            this.aboutActive = true;
                            this.notifActive = false;
                            this.membersActive = false;
                            this.$store.commit('SET_SELECTED', this.$store.state.team.idTeam);
                        }
                    }
                },
                watch: {
                    invitationsCount() {
                        if (this.$store.getters.invitationsCount)
                            this.getInvitationsCount = this.$store.getters.invitationsCount;
                        else
                            this.getInvitationsCount = 0;
                    },
                    unseenPMsCount() {
                        if(this.$store.getters.unseenPMsCount)
                            this.getUnseenPMsCount = this.$store.getters.unseenPMsCount;
                        else
                            this.getUnseenPMsCount = 0;
                    },
                    unseenMessagesCount() {
                        if(this.$store.getters.unseenMessagesCount)
                            this.getUnseenMessagesCount = this.$store.getters.unseenMessagesCount;
                        else
                            this.getUnseenMessagesCount = 0;
                        
                    }
                },
                computed: {
                    ...mapGetters([
                            'getInvitations',
                            'invitationsCount',
                            'unseenPMsCount',
                            'unseenMessagesCount'
                    ])
                },
                mounted(){
                        this.aboutActive = true;
                        this.notifActive = false;
                        this.membersActive = false;
                        this.initMenu = false;
                        this.$forceUpdate();
                    
                }
            }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    .LeftItem.item{
        width: 25%;
    }
    .LeftItem.item.icon{
        width: 25%;
    }

    .leftMenu{
        background-color: #fff;
    }
    .column{
        height: 100%;
    }


</style>
