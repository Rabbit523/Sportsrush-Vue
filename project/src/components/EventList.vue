<template lang="html">
    <div>
        <table id="eventList">
            <tr>
                <th>Title</th>
                <th>Starting date</th>
                <th>Ending date</th>
                <th>Time</th>
                <th>Description</th>
                <th v-if='$store.state.team.coach == 1'>Delete Event</th>
            </tr>     
            <tr v-for="event in events" key='event.idEvent'>
                <td>{{event.title}}</td>
                <td>{{event.startDate}}</td>
                <td>{{event.endDate}}</td>
                <td>{{event.startTime}} - {{event.endTime}}</td>
                <td>{{event.description}}</td>
                <td v-if='$store.state.team.coach == 1'>
            <sui-icon name="window close" @click.native="showEventModal(event)" />
            </td>
            </tr> 
        </table>
        <Modal v-if="showDeleteEventModal" @close="showDeleteEventModal = false">
            <div slot="header">
                <h3>Deleting event</h3>
            </div>
            <div slot="body">
                <p>Are you sure you want to delete this event ?</p>
                <label>title : {{ event.title }}</label>
                
                <p>Description : {{ event.description }}</p>
            </div>
            <div slot="footer">
                <sui-button @click.native="deleteEvent(event)" class='basicBtn newTeamBtn'>Delete</sui-button>
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
                        name: "eventList",
                        events: [],
                        showDeleteEventModal: false,
                        event: {
                            title: '',
                            description: ''
                        }
                    };
                },
                watch: {
                    getEvents() {
                        if (this.$store.getters.getEvents)
                            this.events = this.$store.state.events;
                        else 
                            this.events = [];
                    }
                },
                created() {
                    this.events = this.$store.state.events;

                },
                computed: {

                    ...mapGetters([
                            'getEvents'
                    ])
                },
                methods: {
                    deleteEvent(event) {
                        this.$store.dispatch('deleteEvent', event);
                        this.showDeleteEventModal = false;
                    },
                    showEventModal(event){
                        this.event = event;
                        this.showDeleteEventModal = true;
                    },
                    cancel(){
                        this.showDeleteEventModal = false;
                    }
                }
            };
</script>

<style scoped>
    table {
        margin-top: 20px;
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        border-radius: 5px;
        background-color: #FFF;
    }

    td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;

    }


</style>
