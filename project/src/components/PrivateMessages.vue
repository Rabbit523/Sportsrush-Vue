<template>
    <div class="messageWrapper">
        <div id="msgs" class="Messages" is="sui-container">           
            <div class="Message" is="sui-container" fluid v-for="msg in messagesLocal" v-bind:key="msg.idMessage" v-if="!msg.hidden">
                <transition-group name="fade" appear tag="p">  
                    <div class="Message" is="sui-container" fluid v-for="msg in messagesLocal" v-bind:key="msg.idMessage"  v-if="!msg.hidden">
                        <sui-comment>
                            <img src="../assets/matt.png" alt="Avatar">
                            <sui-comment-content>
                                <a is="sui-comment-author">{{msg.sender}}</a>
                                <sui-comment-metadata>
                                    <div>{{msg.sendingDateTime}}</div>
                                </sui-comment-metadata>
                                <sui-comment-text>{{msg.message}}</sui-comment-text>
                                <!--                                <sui-comment-actions>
                                                                    <sui-comment-action>Reply</sui-comment-action>
                                                                </sui-comment-actions>-->
                            </sui-comment-content>
                        </sui-comment>
                        </sui-comment-group>
                    </div>
                </transition-group>    
            </div> 
        </div>
        <div class="msgMenu" is="sui-container">
            <sui-menu :widths="2">
                <sui-menu-item class="msgItem" ><textarea @keyup.enter="addMessage" v-model="newMessage" type="text-area" placeholder="new message"></textarea></sui-menu-item>
                <sui-menu-item class="" @click.native="" ><button @click="addMessage">Send</button></sui-menu-item>
            </sui-menu>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'
            export default {

                data() {
                    return {
                        messagesLocal: [],
                        newMessage: ''

                    };

                },
                watch: {
                    getMessages() {
                        if (this.$store.state.messages) {
                            this.messagesLocal = this.$store.getters.getMessages;
                        } else {
                            this.messagesLocal = [];
                        }
                        if (this.messagesLocal) {
                            for (var i = 0; i < this.messagesLocal.length; i++) {
                                this.$store.dispatch('setSeenDateP', {
                                    idMessage: this.messagesLocal[i].idMessage,
                                    idUser: this.$store.state.userInfo.idUser,
                                    seenDate: this.$moment(Date.now()).format(this.$store.state.dateFormat)
                                })
                            }
                        }

                        var objDiv = document.getElementById("msgs");
                        objDiv.scrollTop = objDiv.scrollHeight;

                        this.$forceUpdate();
                    }
                },
                methods: {
                    addMessage() {
                        var message = {
                            message: this.newMessage,
                            sendingDateTime: this.$moment(Date.now()).format(this.$store.state.dateFormat),
                            sender: this.fullName,
                            hidden: false,
                            idUser: this.$store.state.userInfo.idUser,
                            idReceiver: this.$store.state.receiverUser.idUser,
                            private: false,
                            idMessage: -1,
                            seen: false
                        };
                        if (this.newMessage !== "") {
                            /* this.messagesLocal.push({
                             message: this.newMessage,
                             sendingDateTime: this.$moment(Date.now()).format('h:mm:ss a'),
                             sender: this.fullName,
                             visible: true,
                             idUser: this.$store.state.userInfo.idUser,
                             idReceiver: this.$store.state.team.idTeam,
                             private: false,
                             
                             });*/
                            this.newMessage = '';
                            this.$store.dispatch('createPrivateMsg', message);
                            //message.idMessage = this.messagesLocal[this.messagesLocal.length].idMessage + 1;
                            this.messagesLocal.push(message);
                            //this.$store.dispatch('getMessages', {idTeam: this.$store.state.team.idTeam})    

                        }
                    }

                },
                computed: {
                    fullName() {
                        return this.$store.getters.fullName;
                    },
                    ...mapGetters([
                            'fullName',
                            'getMessages'
                    ])
                }

            };
</script>

<style scoped>
    .fade-enter-active, .fade-leave-active{
        transition: opacity .5s, transform .5s;
    }
    .fade-enter, .fade-leave-active{
        opacity: 0;
        transform: translateX(20px);
    }
    img{
        border-radius: 50%;
        size: 100px;    
    }
    .avatar{
        background-color: #af1945;
    }

    .msgMenu {
        width: 100%;
    }

    .msgMenu textarea{
        width: 300px; 
        height: 50px;
        max-width: 580px;
    }

    @media (max-width: 580px) { 
        .msgMenu textarea{
            width: 200px; 
            height: 72px;
            max-width: 580px;
        }
    }
    .messageWrapper{
        height: 100%;
    }
    .Messages.ui.container{
        width: 100%;
        margin-left: 0;
        margin-right: 0;
        height: 100%;
    }
    .msgMenu.ui.container{
        width: 100%;
        margin-left: 0;
        margin-right: 0;
        height: 13%;
    }
</style>