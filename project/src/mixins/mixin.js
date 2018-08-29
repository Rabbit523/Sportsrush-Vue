/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


export default {
    methods: {
        getNewData(store) {
            store.dispatch('getTeams', {idUser: this.$store.state.userInfo.idUser});
            store.dispatch('getInvitations', {idEmail: this.$store.state.userInfo.idEmail});
            store.dispatch('getMessages', {
                idTeam: this.$store.state.team.idTeam
            });

            setTimeout(getNewData, 5000);
        }
    }
}