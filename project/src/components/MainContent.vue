<template>
    <sui-container class="MainContent">
        <TopMenu @activated="switchContent" id="Topmenu"></TopMenu>
        <div v-show="chatActive" class="MainContent">
            <PrivateMessages v-if="$store.state.pMActive"></PrivateMessages>
            <Messages v-else></Messages>
        </div>
        <Calendar v-show="calActive" class="MainContent">
            
        </Calendar>
    </sui-container>
</template>

<script>
    import TopMenu from "./TopMenu.vue"
            import Messages from "./Messages.vue"
            import Calendar from "./Calendar.vue"
            import ModalForms from "./ModalForms.vue"
            import PrivateMessages from "./PrivateMessages.vue"

            export default {
                components: {TopMenu, Messages, Calendar, ModalForms, PrivateMessages},
                data() {
                    return {
                        chatActive: true,
                        calActive: false,
                        events: [
                            {
                                title: 'Event1',
                                start: '2015-10-10 12:30:00',
                                end: '2015-10-10 16:30:00'
                            },
                            {
                                title: 'Event2',
                                start: '2015-10-07 17:30:00',
                                end: '2015-10-07 21:30:00'
                            }
                        ],
                        editable: false,
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
                                dates: new Date(2018, 0, 1),
                                popover: {
                                    label: 'You just hovered over today\'s date!',
                                }
                            },
                        ],
                        selectedDates: null

                    }
                },
                methods: {
                    switchContent(value) {
                        if (value == "cal") {
                            this.chatActive = false;
                            this.calActive = true;
                        } else {
                            this.chatActive = true;
                            this.calActive = false;
                        }
                    },
                    addEvent(){
                        //
                    }
                }
            }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    .MainContent{
        width: 100%;
        margin-left: 0;
        margin-right: 0;
        height: 100%;
    }
    #Topmenu{
        width: 100%;
    }
    .MainContent.ui.container{
        width: 100%;
        margin-left: 0;
        margin-right: 0;
        height: 100%;
    }
</style>
