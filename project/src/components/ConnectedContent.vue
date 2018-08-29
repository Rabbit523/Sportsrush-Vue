<!--
    File        : ConnectedContent.Vue
    Project     : Sportsrush
    Description : Handles all the components for connected user
-->

<template>
    <sui-container class="connectedContent">
        <sui-grid :columns="nbColumns"  divided="vertically">
            <sui-grid-row class="connectedContent">
                <sui-grid-column class="leftContent" :width="leftContentWidth">
                    <LeftContent></LeftContent>
                </sui-grid-column>
                <sui-grid-column class="MainContent" v-bind:width="mainContentWidth" v-bind:style='{ "margin-top": marginTopMain }'>
                    <MainContent></MainContent>
                </sui-grid-column>       
            </sui-grid-row>
        </sui-grid>
        

    </sui-container>
</template>

<script>
            import LeftContent from './LeftContent.vue'
            import MainContent from './MainContent.vue'
            import { mapGetters } from 'vuex'
            export default {
                components: {LeftContent, MainContent},
                data() {
                    return {
                        description: 'Connected',
                        windowWidth: 0,
                        windowHeight: 0,
                        nbColumns: 2,
                        leftContentWidth: 4,
                        mainContentWidth: 12,
                        marginTopMain: "0%",
                        teamInit: true,
                        shortPolling: null
                    }
                },
                watch: {
                    getTeamList() {
                        this.teams = this.$store.state.teams;
                        // selects the first team in the list if none selected
                        if (this.teamInit){
                            this.$store.commit('SET_TEAM', this.teams[0]);
                            this.$store.commit('SET_SELECTED_TEAM', this.teams[0]);
                            this.$store.dispatch('setSeenDateM', {
                                idTeam: this.$store.state.team.idTeam,
                                idUser: this.$store.state.userInfo.idUser,
                                seenDate: this.$moment(Date.now()).format(this.$store.state.dateFormat)
                            });
                            this.teamInit = false;
                        }
                        // get private messages if talking to another user
                        if (this.$store.state.pMActive === true) {
                            this.$store.dispatch('getPrivateMessages', {idUser: this.$store.state.userInfo.idUser, idSender: this.$store.state.receiverUser.idUser});
                        } else {
                        // get messages if talking with a team
                            this.$store.dispatch('getMessages', {
                                idTeam: this.$store.state.team.idTeam
                            });
                        }
                        this.$store.dispatch('getEventsTeams', this.$store.state.teams);
                        this.$store.dispatch('getEvents',{
                            idTeam: this.$store.state.team.idTeam
                        });
                    }
                },
                created() {
                    //API calls to update the data
                    this.$store.dispatch('getTeams', {idUser: this.$store.state.userInfo.idUser});
                    //
                    this.$store.dispatch('getInvitations', {idEmail: this.$store.state.userInfo.idEmail});
                    this.$store.dispatch('getUnseenPMs', {
                        idUser: this.$store.state.userInfo.idUser
                    });
                    this.$store.dispatch('getUnseenMessages', {
                            idUser: this.$store.state.userInfo.idUser
                    });

                    this.teams = this.$store.state.teams;
                    if (this.$store.state.team){
                            //set messages as seen so they wont appear in the notifications
                            this.$store.dispatch('setSeenDateM', {
                                idTeam: this.$store.state.team.idTeam,
                                idUser: this.$store.state.userInfo.idUser,
                                seenDate: this.$moment(Date.now()).format(this.$store.state.dateFormat)
                            });
                    }


                },
                computed: {
                    ...mapGetters([
                            'getTeamList',
                            'getMessages',
                            'getInvitations'
                    ])
                    
                },
                mounted() {
                    // Creates an event listener to know when the user resizes his browser
                    this.$nextTick(function () {
                        window.addEventListener('resize', this.getWindowWidth);

                        //Init
                        this.getWindowWidth()
                    });
                    // Calls the short polling function to update the user data
                    this.getNewData();      
                    
                },
                methods: {
                    //adapts the size of the page to the new size
                    getWindowWidth(event) {
                        this.windowWidth = document.documentElement.clientWidth;
                        if (this.windowWidth <= 900) {
                            this.nbColumns = 1;
                            this.leftContentWidth = 16;
                            this.mainContentWidth = 16;
                            this.marginTopMain = "15%";
                        } else {
                            this.nbColumns = 2;
                            this.leftContentWidth = 4;
                            this.mainContentWidth = 12;
                            this.marginTopMain = "0";
                        }
                    },
                    // short polling function to get new data
                    getNewData() {
                        let s = this;
                        this.$store.dispatch('getTeams', {idUser: this.$store.state.userInfo.idUser});
                        this.$store.dispatch('getInvitations', {idEmail: this.$store.state.userInfo.idEmail});
                        if (this.$store.state.pMActive === true) {
                            this.$store.dispatch('getPrivateMessages', {idUser: this.$store.state.userInfo.idUser, idSender: this.$store.state.receiverUser.idUser});
                        } else {
                            this.$store.dispatch('getMessages', {
                                idTeam: this.$store.state.team.idTeam
                            });
                        }
                        this.$store.dispatch('getUnseenPMs', {
                            idUser: this.$store.state.userInfo.idUser
                        });
                        this.$store.dispatch('getUnseenMessages', {
                            idUser: this.$store.state.userInfo.idUser
                        });
                        this.$store.dispatch('getEvents',{
                            idTeam: this.$store.state.team.idTeam
                        });
                        this.$store.dispatch('getEventsTeams', this.$store.state.teams);
                        // we call the function back 10 seconds later
                        this.shortPolling = setTimeout(s.getNewData, 10000);
                    }

                },
                // we clear the timeout and the event listener
                beforeDestroy() {
                    window.removeEventListener('resize', this.getWindowWidth);
                    clearTimeout(this.shortPolling);
                },
                ready(){
                    
                }
            }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    .grid:before {
        position: absolute;
        top: 1rem;
        left: 1rem;
        background-color: #FAFAFA;
        width: calc(100% - 2rem);
        height: calc(100% - 2rem);
        box-shadow: 0px 0px 0px 1px #DDDDDD inset;
    }
    .column:after {
        background-color: rgba(86, 61, 124, .1);
        box-shadow: 0px 0px 0px 1px rgba(86, 61, 124, 0.2) inset;
        display: block;
        min-height: 50px;
    }
    .column{
        padding: 2%;
    }
    .connectedContent{
        height: 100%;
        display: flex;    
        width: 100%;
    }
    .connectedContent.ui.container{
        width: 100%;
    }
</style>
