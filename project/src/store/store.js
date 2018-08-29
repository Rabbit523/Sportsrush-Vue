/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

import Vue from 'vue'
import Vuex from 'vuex'
import VueResource from 'vue-resource'


Vue.use(Vuex);
Vue.use(VueResource);

const state = {
    //user login
    regSuccess: false,
    userInfo: {
        firstName: null,
        lastName: null,
        email: null,
        password: null,
        idUser: null,
        idEmail: null,
        birthday: null,
        country: null,
        city: null,
        street: null,
        zipcode: null,
        phone: null,
        interest: null,
        type:null
    },
    sport: {
        idSport: null,
        sport: null
    },
    sports: [],
    teams: [],
    team: {
        idTeam: null,
        teamName: null,
        description: null,
        type: null,
        clicked: false,
        sport:0,
        nbCoaches: 0,
        nbPlayers: 0,
        coaches: [],
        players: []
    },
    selectedTeam: {
        idTeam: null,
        teamName: null,
        description: null,
        clicked: false,
        sport:0,
        nbCoaches: 0,
        nbPlayers: 0,
        coaches: [],
        players: []
    },
    messages: [],
    invitations: [],
    email: {
        idEmail: null,
        email: null,
        verified: false,
        idUser: null,
        code: null

    },
    unseenMessages: [],
    unseenPMs: [],
    receiverUser: [],
    pMActive: false,
    selectedDate: null,
    event: {
        title: '',
        startTime: '',
        endTime: '',
        startDate: '',
        endDate: '',
        desc: ''
    },
    events: [],
    dateFormat: 'YYYY-MM-DD HH:mm:ss',
    eventsTeams: [],
    selected: undefined,
    loading: false


};
const getters = {    
    getUserType: state => {
      if (state.userInfo.type == "normal")
        return true;
      else if (state.userInfo.type == "social")
        return false;
    },
    connected: state => {
        if (state.userInfo.idUser)
            return true;
        else
            return false;
    },
    invitationsCount: state => {
        if (state.invitations)
            return state.invitations.length;
        else
            return 0;
    },
    unseenPMsCount: state => {
        if (state.unseenPMs)
            return state.unseenPMs.length;
        else
            return 0;
    },
    unseenMessagesCount: state => {
        if (state.unseenMessages)
            return state.unseenMessages.length;
        else
            return 0;
    },
    getUser: state => state.userInfo.idUser,
    getRegistered: state => state.regSuccess,
    getTeamList: state => state.teams,
    fullName: state => state.userInfo.firstName + ' ' + state.userInfo.lastName,
    getMessages: state => state.messages,
    getInvitations: state => state.invitations,
    getSelectedTeam: state => state.selectedTeam,
    getEmail: state => state.email,
    getUnseenMessages: state => state.unseenMessages,
    getReceiverUser: state => state.receiverUser,
    getPMActive: state => state.pMActive,
    getUnseenPMs: state => state.unseenPM,
    getSelectedDate: state => state.selectedDate,
    getEvent: state => state.event,
    getEvents: state => state.events,
    getTeam: state => state.team,
    getEventsTeams: state => state.eventsTeams,
    getSelected: state => state.selected

};
const mutations = {
    POST_USER: (state, value) => {        
        if (value) {
            state.userInfo.firstName = value.firstName;
            state.userInfo.lastName = value.lastName;
            state.userInfo.email = value.email;
            state.userInfo.password = value.password;
            state.userInfo.idUser = value.idUser;
            state.userInfo.idEmail = value.idEmail;
            state.userInfo.birthday = value.result.birthday;
            state.userInfo.country = value.result.country;
            state.userInfo.city = value.result.city;
            state.userInfo.street = value.result.street;
            state.userInfo.zipcode = value.result.zipcode;
            state.userInfo.phone = value.result.phone;
            state.userInfo.interest = value.result.interests;
            state.userInfo.type = value.result.type;
        }
    },
    SET_REGSUCCESS: (state, value) => {
        state.regSuccess = value;
    },
    SET_SPORTS: (state, value) => {
        state.sports = value;
    },
    SET_TEAMS: (state, value) => {
        state.teams = value;
    },
    SET_TEAM: (state, value) => {
        state.team = value;
    },
    SET_MESSAGES: (state, value) => {
        state.messages = value;
    },
    SET_INVITATIONS: (state, value) => {
        state.invitations = value;
    },
    SET_SELECTED_TEAM: (state, value) => {
        state.selectedTeam = value;
    },
    SET_EMAIL: (state, value) => {
        state.email = value;
    },
    SET_UNSEEN_MESSAGES: (state, value) => {
        state.unseenMessages = value;
    },
    SET_UNSEEN_PMS: (state, value) => {
        state.unseenPMs = value;
    },
    SET_RECEIVER_USER: (state, value) => {
        state.receiverUser = value;
    },
    SET_PM_ACTIVE: (state, value) => {
        state.pMActive = value;
    },
    REMOVE_INVITATION: (state, value) => {
        state.invitations.splice(state.invitations.indexOf(value), 1);
    },
    SET_SELECTED_DATE: (state, value) => {
        state.selectedDate = value;
    },
    SET_EVENT: (state, value) => {
        state.event = value;
    },
    SET_EVENTS: (state, value) => {
        state.events = value;
    },
    SET_EVENTS_TEAMS: (state, value) => {
        state.eventsTeams = value;
    },
    REMOVE_EVENT: (state, value) => {
        state.events.splice(state.events.indexOf(value), 1);
    },
    REMOVE_PLAYER: (state, value) => {
        state.teams[value.idTeamArray].players.splice(value.idPlayerArray, 1);
    },
    SET_UPDATED_TEAM: (state, value) => {
        state.team.teamName = value.teamName;
        state.team.description = value.teamDesc;
        state.team.idSport = value.idSport;
        state.selectedTeam.teamName = value.teamName;
        state.selectedTeam.description = value.teamDesc;
        state.selectedTeam.idSport = value.idSport;
    },
    SET_SELECTED: (state, value) => {
        state.selected = value;
    },
    REMOVE_TEAM: (state, value) => {
        state.teams.splice(value, 1);
    },
    SET_SELECTED_FIRST: (state) => {
        if (state.teams.length) {
            state.selected = state.teams[0].idTeam;
        }
    },
    SET_LOADING: (state, value) => {
        state.loading = value;
    }
};

const actions = {
    test: ({ commit }) => {
        Vue.http.get('http://localhost/api/test').then(response => {
          console.log(response);
        }, response => {
            console.log("this was an error");
        });
    },
    createUser: ({ commit }, user) => {
        Vue.http.post('http://localhost/api/registerUser', user, { emulateJSON: true }).then(response => {
            commit('SET_LOADING', false);
            let r = response.body;
            console.log(response);
            if (r.success) {
                commit('SET_REGSUCCESS', true);
            }
        }), response => {
            console.log(response.body.message);
        };
    },
    connectUser: ({ commit }, user) => {
        Vue.http.post('http://localhost/api/login', user, { emulateJSON: true }).then(response => {
            commit('SET_LOADING', false);
            let r = response.body;
            console.log(r);
            if (r.success) {
                commit('POST_USER', r);
            }
        }), response => {
            console.log(response.body.message);
        };
    },
    resetPassword: ({ commit }, user) => {
      Vue.http.post('http://localhost/api/resetPassword', user, { emulateJSON: true }).then(response => {
          commit('SET_LOADING', false);
          let r = response.body;
          console.log(r);
          if (r.success) {
            this.$router.push("/");
          }
      }), response => {
          console.log(response.body.message);
      };
    },
    loginCheck: ({ commit }) => {
        Vue.http.get('http://localhost/api/loginCheck').then(response => {
            var user = { idUser: null };
            let r = response.body;
            console.log(r);
            if (r.success) {
                user.idUser = r.idUser;
                commit('POST_USER', r.user);

            }
        }, response => {
            console.log("response.body.message");
        });
    },
    getSports: ({ commit }) => {
        Vue.http.get('http://localhost/api/sports').then(response => {
            let r = response.body;
            if (r.success) {
                commit('SET_SPORTS', r.sports);
            }
        }, response => {
            console.log("response.body.message");
        });
    },
    createTeam: ({ dispatch, commit, state }, team) => {
        console.log(team);
        Vue.http.post('http://localhost/api/createTeam', team, { emulateJSON: true }).then(response => {
            commit('SET_LOADING', false);
            let r = response.body;
            console.log(r);
            if (r.success) {
                state.teams.push(team);
            }
        }), response => {
            console.log(response.body.message);
        };
    },
    getTeams: ({ commit }, user) => {        
        Vue.http.post('http://localhost/api/teams', user, { emulateJSON: true }).then(response => {
            let r = response.body;
            console.log(r);
            if (r.success) {
                commit('SET_TEAMS', r.teams);
            }
        }, response => {
            console.log("response.body.message");
        });
    },
    createMsg: ({ commit }, message) => {
        Vue.http.post('http://localhost/api/newMessage', message, { emulateJSON: true }).then(response => {
            let r = response.body;
            if (r.success) {
                //commit('SET_TEAMS', r.teams);
            }
        }, response => {
            console.log("response.body.message");
        });
    },
    createPrivateMsg: ({ commit }, message) => {
        Vue.http.post('http://localhost/api/newPrivateMessage', message, { emulateJSON: true }).then(response => {
            let r = response.body;
            if (r.success) {
                //commit('SET_TEAMS', r.teams);
            }
        }, response => {
            console.log("response.body.message");
        });
    },
    getMessages: ({ state, commit }, team) => {
        team.idUser = state.userInfo.idUser;
        Vue.http.post('http://localhost/api/messages', team, { emulateJSON: true }).then(response => {
            let r = response.body;
            commit('SET_MESSAGES', r.messages);
        }, response => {
            console.log("response.body.message");
        });
    },
    getPrivateMessages: ({ state, commit }, user) => {
        Vue.http.post('http://localhost/api/privateMessages', user, { emulateJSON: true }).then(response => {
            let r = response.body;
            commit('SET_MESSAGES', r.messages);
        }, response => {
            console.log("response.body.message");
        });
    },
    logout: ({ commit }) => {
        Vue.http.get('http://localhost/api/logout').then(response => {
            let r = response.body;
            if (r.success) {
                commit('POST_USER', {
                    firstName: null,
                    lastName: null,
                    email: null,
                    password: null,
                    idUser: null,
                    idEmail: null,
                    result: {
                      birthday: null,
                      country: null,
                      city: null,
                      street: null,
                      zipcode: null,
                      phone: null,
                      interest: null
                    }
                });
                commit('SET_TEAM', {
                    idTeam: null,
                    teamName: null,
                    description: null,
                    clicked: false
                });
                commit('SET_TEAMS', null);
                commit('SET_MESSAGES', null);
                commit('SET_INVITATIONS', null);
            }
        }, response => {
            console.log("response.body.message");
        });
    },
    invite: ({ commit }, invite) => {
        Vue.http.post('http://localhost/api/invite', invite, { emulateJSON: true }).then(response => {
            let r = response.body;
        }, response => {
            console.log("response.body.message");
        });
    },
    getInvitations: ({ commit }, email) => {
        Vue.http.post('http://localhost/api/invitations', email, { emulateJSON: true }).then(response => {
            let r = response.body;
            if (r.success) {
                commit('SET_INVITATIONS', r.invitations);
            }
        }, response => {
            console.log("response.body.message");
        });
    },
    getEmail: ({ commit }, email) => {
        Vue.http.post('http://localhost/api/getEmail', email, { emulateJSON: true }).then(response => {
            let r = response.body;
            console.log(r);
            if (r.success) {
                if (r.emailOutput.verified == 1) {
                    commit('SET_EMAIL', r.emailOutput);
                }
            }
        }, response => {
            console.log("response.body.message");
        });
    },
    joinTeam: ({ commit, dispatch }, invitation) => {
        Vue.http.post('http://localhost/api/joinTeam', invitation, { emulateJSON: true }).then(response => {
            let r = response.body;
            if (r.success) {
                commit('REMOVE_INVITATION', invitation);
            }
        }, response => {
            console.log("response.body.message");
        });
    },
    updateUser: ({ commit }, user) => {
        Vue.http.post('http://localhost/api/updateUser', user, { emulateJSON: true }).then(response => {
            commit('SET_LOADING', false);
            let r = response.body;
            if (r.success) {
                commit('POST_USER', user);
            }
        }, response => {
            console.log("response.body.message");
        });
    },
    declineInvitation: ({ commit }, invitation) => {
        Vue.http.post('http://localhost/api/declineInvitation', invitation, { emulateJSON: true }).then(response => {
            let r = response.body;
            if (r.success) {
                commit('REMOVE_INVITATION', invitation);
            }
        }, response => {
            console.log("response.body.message");
        });
    },

    getUnseenPMs: ({ commit }, user) => {
        Vue.http.post('http://localhost/api/unseenPMs', user, { emulateJSON: true }).then(response => {
            let r = response.body;
            if (r.success) {
                commit('SET_UNSEEN_PMS', r.messages);
            }

        }, response => {
            console.log("response.body.message");
        });
    },
    getUnseenMessages: ({ commit }, team) => {
        Vue.http.post('http://localhost/api/unseenMessages', team, { emulateJSON: true }).then(response => {
            let r = response.body;
            if (r.success) {
                commit('SET_UNSEEN_MESSAGES', r.messages);
            }

        }, response => {
            console.log("response.body.message");
        });
    },
    getUser: ({ commit }, user) => {
        Vue.http.post('http://localhost/api/getUser', user, { emulateJSON: true }).then(response => {
            let r = response.body;
            if (r.success) {
                commit('SET_RECEIVER_USER', r.user);
                commit('SET_PM_ACTIVE', true);
            }

        }, response => {
            console.log("response.body.message");
        });
    },
    createEvent: ({ commit, state }, event) => {

        event.idTeam = state.team.idTeam;
        Vue.http.post('http://localhost/api/createEvent', event, { emulateJSON: true }).then(response => {
            commit('SET_LOADING', false);
            let r = response.body;
            if (r.success) {
                commit('SET_EVENT', event);
            }

        }, response => {
            console.log("response.body.message");
        });
    },
    getEvents: ({ commit }, team) => {
        Vue.http.post('http://localhost/api/events', team, { emulateJSON: true }).then(response => {
            let r = response.body;
            commit('SET_EVENTS', r.events);

        }, response => {
            console.log("response.body.message");
        });
    },
    getEventsTeams: ({ commit }, teams) => {
        Vue.http.post('http://localhost/api/eventsTeams', { teams }, { emulateJSON: true }).then(response => {
            let r = response.body;
            commit('SET_EVENTS_TEAMS', r.eventsTeams);

        }, response => {
            console.log("response.body.message");
        });
    },
    deleteEvent: ({ commit }, event) => {
        Vue.http.post('http://localhost/api/deleteEvent', event, { emulateJSON: true }).then(response => {
            commit('SET_LOADING', false);
            let r = response.body;
            if (r.success) {
                commit('REMOVE_EVENT', event);
            }
        }, response => {
            console.log("response.body.message");
        });
    },
    deleteTeam: ({ commit }, team) => {
        Vue.http.post('http://localhost/api/deleteTeam', team, { emulateJSON: true }).then(response => {
            commit('SET_LOADING', false);
            let r = response.body;
            if (r.success) {
                commit('REMOVE_TEAM', team.idTeamArray);
                commit('SET_SELECTED_FIRST');
            }
        }, response => {
            console.log("response.body.message");
        });
    },
    deleteMembership: ({ commit }, membership) => {
        Vue.http.post('http://localhost/api/deleteMembership', membership, { emulateJSON: true }).then(response => {
            commit('SET_LOADING', false);
            let r = response.body;
            if (r.success) {
                commit('REMOVE_PLAYER', {
                    player: membership.player,
                    idTeamArray: membership.idTeamArray,
                    idPlayerArray: membership.idPlayerArray
                });
            }
        }, response => {
            console.log("response.body.message");
        });
    },
    setSeenDateM: ({ commit }, membership) => {
        Vue.http.post('http://localhost/api/seenDateM', membership, { emulateJSON: true }).then(response => {
            let r = response.body;
            if (r.success) {
                //
            }
        }, response => {
            console.log("response.body.message");
        });
    },
    setSeenDateP: ({ commit }, message) => {
        Vue.http.post('http://localhost/api/seenDateP', message, { emulateJSON: true }).then(response => {

            let r = response.body;
            if (r.success) {
                //
            }
        }, response => {
            console.log("response.body.message");
        });
    },
    updateTeam: ({ commit }, team) => {
        Vue.http.post('http://localhost/api/updateTeam', team, { emulateJSON: true }).then(response => {
            commit('SET_LOADING', false);
            let r = response.body;
            if (r.success) {
                commit('SET_UPDATED_TEAM', team);
            }
        }, response => {
            console.log("response.body.message");
        });
    },
    setCoach: ({ commit }, membership) => {
        Vue.http.post('http://localhost/api/setCoach', membership, { emulateJSON: true }).then(response => {
            let r = response.body;
            if (r.success) {


            }
        }, response => {
            console.log("response.body.message");
        });
    },
    leaveTeam: ({ commit }, membership) => {
        Vue.http.post('http://localhost/api/leaveTeam', membership, { emulateJSON: true }).then(response => {
            commit('SET_LOADING', false);
            let r = response.body;
            if (r.success) {
                commit('REMOVE_TEAM', membership.idTeamArray);
                commit('SET_SELECTED_FIRST');
            }
        }, response => {
            console.log("response.body.message");
        });
    },
    SelectedTeam: ({ commit }, team) => {
        commit('SET_SELECTED_TEAM', team);
    }


};

let store = new Vuex.Store({
    state,
    getters,
    mutations,
    actions,
    strict: false
});

export default store;
