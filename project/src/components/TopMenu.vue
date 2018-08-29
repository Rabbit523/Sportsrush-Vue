<template>
    <div class="TopMenu" is="sui-container">
        <sui-menu :widths="3">
            <sui-menu-item v-if="!$store.state.pMActive" class="TopItem" icon="comments big" @click.native="activeItem('chat')" :class="{'active' : chatActive}"><p>{{ $store.state.team.teamName }}</p></sui-menu-item>
            <sui-menu-item v-else class="TopItem" icon="comment big" @click.native="activeItem('chat')" :class="{'active' : chatActive}"><p>{{ $store.state.receiverUser.firstName }} {{$store.state.receiverUser.lastName}}</p></sui-menu-item>
            <sui-menu-item class="TopItem" icon="calendar big" @click.native="activeItem('calendar')" :class="{'active' : calActive}"><p>{{ calMessage }}</p></sui-menu-item>
            <sui-menu-item class="TopItem dropdown">
                <UserMenu></UserMenu>
            </sui-menu-item>
        </sui-menu>
    </div>
</template>

<script>
    import UserMenu from "./UserMenu.vue"
    export default {
        components: {UserMenu},
        data() {
            return {
                chatActive: true,
                calActive: false,
                calMessage: 'Calendar',
                chatMessage: ''
            }
        },
        methods:{
            activeItem(item, event){
                if (item == 'calendar'){
                    this.calActive = true;
                    this.chatActive = false;
                    this.$emit('activated', 'cal');
                } else if (item == 'chat'){
                    this.calActive = false;
                    this.chatActive = true;
                    this.$emit('activated', 'chat');
                }
            }
        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    .TopItem.item{
        width: 20%;
    }
    .TopItem.item.active{
        width: 65%;
    }
    .TopItem.item.dropdown{
        width: 15%;
    }
    
    .TopItem :hover {
            color: darkgray;
    }

</style>