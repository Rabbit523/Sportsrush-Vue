<!--
    File        : Calendar.Vue
    Project     : Sportsrush
    Description : Team calendar using v-calendar
-->

<template>
    <div class="MainContent">
        <div>
            <h2>View calendar</h2>
            <v-calendar :attributes='attributesTest' is-expanded>
            </v-calendar>
            <sui-button @click.native="showDatePicker" >Add Events</sui-button>
        </div>
        <EventList :events='events'></EventList>
        <Modal v-if="showAddEventsModal" @close="showAddEventsModal = false" class="calendarContainer">
                <h3 slot="header">Add Events</h3>
                <div slot="body" >
                    <div>
                        <h2>Add events</h2>
                          <input type="radio" name="pickerMode" value="single" checked @click="setPickerMode('single')"> Single date<br>
                          <input type="radio" name="pickerMode" value="range" @click="setPickerMode('range')"> Date range<br>
                        <v-date-picker :attributes='attrs' :mode="pickerMode" v-model="selectedDate" is-inline is-expanded is-double-paned>
                        </v-date-picker>
                    </div>
                    <form class="ui form">
                        <div class="dateFields" v-if="pickerMode == 'range'">
                            <div class="field">
                                <label>Start Date</label>
                                <input type="text" name="startDate" v-model="startDate">
                            </div>
                            <div class="field">
                                <label>End Date</label>
                                <input type="text" name="endDate" v-model="endDate">
                            </div>
                        </div>
                        <div class="dateFields" v-else>
                            <div class="field">
                                <div class='dateField'>
                                    <label>Date</label>
                                    <input type="text" name="startDate" v-model="selectedDate">
                                </div>
                                <div class='checkBoxField'>
                                    <input type="checkbox" id="checkBoxWRepeat" v-model="wRepeat" class='checkBoxRepeat'>
                                    <label for="checkbox">Repeat every week</label>
                                </div>
                            </div>

                        </div>
                        <div class="field">
                            <label>Starting time</label>
                            <input type="time" name="eventTime" v-model="event.startTime">
                            <label>Ending time</label>
                            <input type="time" name="eventTime" v-model="event.endTime">
                        </div>
                        <div class="field">
                            <label>Title</label>
                            <input type="text" name="title" v-model="event.title">
                        </div>
                        <div class="field">
                            <label>Description</label>
                            <input type="text" name="desc" v-model="event.desc">
                        </div>

                    </form>
                </div>
                <h3 slot="footer">
                    <sui-button @click.native="addEvent" class='basicBtn'>Add event</sui-button>
                    <sui-button @click.native="cancel" class='basicBtn'>Cancel</sui-button>
                </h3>
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
    import EventList from './EventList.vue'
            export default {
                components: {Modal, EventList},
                data() {
                    return {
                        attrs: [
                            {
                                key: 'today',
                                highlight: {
                                    backgroundColor: '#ff8080',
                                },
                                // Just use a normal style
                                contentStyle: {
                                    color: '#fafafa',
                                },
                                dates: [
                                    {start: new Date(0, 0 ,0), end: new Date(0, 0, 0)}
                                ],
                                popover: {
                                    label: 'You just hovered over today\'s date!',
                                }
                            },
                        ],
                        showAddEventsModal: false,
                        selectedDate: null,
                        event: {
                            title: '',
                            startTime: '',
                            endTime: '',
                            startDate: '',
                            endDate: '',
                            desc: '',
                            startDateTime: '',
                            endDateTime: ''
                        },
                        events: [],
                        pickerMode: "single",
                        wRepeat: false,
                        mRepeat: false

                    }
                },
                watch: {
                    // Method called when events are updated in store
                    getEvents() {
                        if (this.$store.getters.getEvents){
                            this.events = this.$store.state.events;
                            // event formatting
                            for (var i = 0; i < this.events.length; i++){
                                var startDateString = this.events[i].startDate.split(' ');
                                var startDateArray = startDateString[0].split('-');
                                var endDateString = this.events[i].endDate.split(' ');
                                var endDateArray = endDateString[0].split('-');
                                var startYear = parseInt(startDateArray[0]);
                                var startMonth = parseInt(startDateArray[1]);
                                var startDay = parseInt(startDateArray[2]);
                                var endYear = parseInt(endDateArray[0]);
                                var endMonth = parseInt(endDateArray[1]);
                                var endDay = parseInt(endDateArray[2]);
                                this.events[i].formatStart = new Date(startYear, startMonth - 1, startDay);
                                this.events[i].formatEnd = new Date(endYear, endMonth - 1, endDay);
                            }                  
                            this.$forceUpdate();
                        } else {
                            this.events = [];
                        }
                    }
                },
                methods: {
                    // shows the modal to add an event
                    showDatePicker() {
                        this.showAddEventsModal = true;
                    },
                    // cancels the modal forms
                    cancel() {
                        this.showAddEventsModal = false;
                    },
                    // sends a create event request to the api
                    addEvent(){
                        this.$store.commit('SET_LOADING', true);
                        // range mode
                        if (this.pickerMode === "range"){
                            this.event.startDateTime = this.$moment(this.startDate).format('YYYY-MM-DD ') + this.event.startTime;
                            this.event.endDateTime = this.$moment(this.endDate).format('YYYY-MM-DD ') + this.event.endTime;
                            this.event.wRepeat = false;
                            this.event.mRepeat = false;
                        } else {
                        // single date mode
                            this.event.startDateTime = this.$moment(this.selectedDate).format('YYYY-MM-DD ') + this.event.startTime;
                            this.event.endDateTime = this.$moment(this.selectedDate).format('YYYY-MM-DD ') + this.event.endTime;
                            this.event.wRepeat = this.wRepeat;
                            this.event.mRepeat = false;
                        }
                        this.$store.dispatch('createEvent', this.event);
                        this.showAddEventsModal = false;
                    },
                    // change date time picker mode => range or single date
                    setPickerMode(value){
                        this.pickerMode = value;
                    }
                },
                computed: {
                    startDate(){
                        if (this.selectedDate)
                            return this.selectedDate.start;
                        else
                            return null;
                    },
                    endDate(){
                        if (this.selectedDate)
                            return this.selectedDate.end;
                        else
                            return null;
                    },
                    ...mapGetters([
                            'getEvents',
                    ]),
                    // attributes built with the map function
                    attributes() {
                          return this.events.map(e => ({
                            key: `event.${e.idEvent}`,
                            highlight: {
                              backgroundColor: 'lightblue',
                            },
                            dates: { start: e.formatStart, end: e.formatEnd }
                            ,
                            popover: {
                                label:  e.title + ": " + e.description + "\n"
                            },
                            customData: e,
                      }));
                      
                    },
                    // attributes built with a loop => useful because we can't put conditions to build the attributes with the map function
                    attributesTest(){
                    
                        var eventsOut = [];
                        for (var i = 0; i < this.events.length; i++){
                            var event = {};
                            event.key = 'event.' + this.events[i].idEvent;
                            event.highlight = {backgroundColor: 'lightblue'};
                            event.contentStyle = {color: '#fafafa'};
                            if (this.events[i].wRepeat === "1"){
                                event.dates = {weekdays: this.events[i].formatStart.getDay() + 1};
                            } else {
                                event.dates = { start: this.events[i].formatStart, end: this.events[i].formatEnd };
                            }

                            event.popover = { 
                                label : this.events[i].title + ": " + this.events[i].description
                            };
                            
                            
                            event.customData = this.events[i];
                            eventsOut.push(event);
                            
                        }
                        return eventsOut;
                    }
                },
                created(){
                    this.events = this.$store.state.events;
                    // events formatting
                    for (var i = 0; i < this.events.length; i++){
                                var startDateString = this.events[i].startDate.split(' ');
                                var startDateArray = startDateString[0].split('-');
                                var endDateString = this.events[i].endDate.split(' ');
                                var endDateArray = endDateString[0].split('-');
                                var startYear = parseInt(startDateArray[0]);
                                var startMonth = parseInt(startDateArray[1]);
                                var startDay = parseInt(startDateArray[2]);
                                var endYear = parseInt(startDateArray[0]);
                                var endMonth = parseInt(startDateArray[1]);
                                var endDay = parseInt(startDateArray[2]);
                                this.events[i].formatStart = new Date(startYear, startMonth, startDay);
                                this.events[i].formatEnd = new Date(endYear, endMonth, endDay);
                            }
                },
                mounted(){
                    // Calls API to update the events array
                    this.$store.dispatch('getEvents', {idTeam: this.$store.state.team.idTeam});
                    this.events = this.$store.state.events;
                    // events formatting
                    for (var i = 0; i < this.events.length; i++){
                                var startDateString = this.events[i].startDate.split(' ');
                                var startDateArray = startDateString[0].split('-');
                                var endDateString = this.events[i].endDate.split(' ');
                                var endDateArray = endDateString[0].split('-');
                                var startYear = parseInt(startDateArray[0]);
                                var startMonth = parseInt(startDateArray[1]);
                                var startDay = parseInt(startDateArray[2]);
                                var endYear = parseInt(startDateArray[0]);
                                var endMonth = parseInt(startDateArray[1]);
                                var endDay = parseInt(startDateArray[2]);
                                this.events[i].formatStart = new Date(startYear, startMonth, startDay);
                                this.events[i].formatEnd = new Date(endYear, endMonth, endDay);
                            }
                    
                    
                }

            }

</script>

<style scoped>

    .MainContent{
        width: 100%;
        margin-left: 0;
        margin-right: 0;
        height: 100%;
    }
    .modal-container{
        max-height: 90%;
        overflow-y: auto;
    }
    .dateField{
            width: 50%;
    }
    .checkBoxField{
            width: 50%;
    }
    .field{
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
    }
   
</style>
