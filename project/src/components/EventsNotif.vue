<template lang="html">
    <div>
        <sui-message class="notif">
            <sui-message-header>Events</sui-message-header>
            <sui-item-group divided v-if="events.length" v-for="eventGroup in $store.getters.getEventsTeams" key="events.indexOf(eventGroup)">
                <h5>Team : {{eventGroup.team.teamName}}</h5>
                <sui-item  v-for="event in eventGroup" key="event.idEvent" v-if="event.title">
                    <div class="eventItem">
                        <sui-item-content vertical-align="middle">{{ event.title }} : {{ event.description }} </sui-item-content>
                    </div>
                    <div class="eventItem">
                        <sui-item-content vertical-align="middle">{{ event.startDate }} - {{ event.endDate }} </sui-item-content>
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
                        events: []
                    };
                },
                watch: {
                    getEventsTeams() {
                        if (this.$store.getters.getEventsTeams)
                            this.events = this.$store.getters.getEventsTeams;
                        else
                            this.events = [];
                        this.$forceUpdate();
                    }
                },
                created() {
                    this.$store.dispatch('getEventsTeams', this.$store.state.teams);
                    this.events = this.$store.state.eventsTeams;
                    
                },
                computed: {

                    ...mapGetters([
                            'getEventsTeams'
                    ])
                },
                methods: {

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
    .eventItem{
        width: 100%;
    }

</style>
