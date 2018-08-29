<template lang="html">
    <sui-dropdown
        class="labeled
        icon"
        icon="sidebar big"
        text=""
        >
        <sui-dropdown-menu>
            <sui-dropdown-item @click.native="profile"><sui-icon name="configure" />My profile</sui-dropdown-item>
            <sui-dropdown-item @click.native="logout"><sui-icon name="power" />Logout</sui-dropdown-item>
        </sui-dropdown-menu>
        <Modal v-if="showProfileModal" @close="showProfileModal = false">
            <div slot="header">
                <h3>Modify Profile</h3>
            </div>
            <div slot="body">
                <form class="ui form">
                    <div class="field">
                        <label>First Name: {{firstName}}</label>
                        <span class="errorMsg">{{errorFirstName}}</span>
                        <input type="text" name="first-name" placeholder="First Name" v-model="firstName">
                    </div>
                    <div class="field">
                        <label>Last Name</label>
                        <span class="errorMsg">{{errorLastName}}</span>
                        <input type="text" name="last-name" placeholder="Last Name" v-model="lastName">
                    </div>
                    <!--<div class="field">
                        <label>Personal Image</label>
                        <input type="file" name="personal-image" placeholder="Personal Image">
                    </div> -->
                    <!--<h3>Change password</h3>
                    <div class="field">
                        <label>Current password</label>
                        <input type="password" name="password" placeholder="Password" v-model="password">
                    </div>
                    <div class="field">
                        <label>New password</label>
                        <input type="password" name="password" placeholder="Password" v-model="newPassword">
                    </div>
                    <div class="field">
                        <label>Repeat new password</label>
                        <input type="password" name="rep-password" placeholder="Repeat Password" v-model="passwordRepeat">
                    </div>-->
                </form>
            </div>
            <div slot="footer">
                <sui-button @click.native="updateUser" class='basicBtn'>Save changes</sui-button>
                <sui-button @click.native="cancel" class='basicBtn'>Cancel</sui-button>
            </div>
        </Modal>
    </sui-dropdown>



</template>

<script>
    import Modal from './Modal.vue'
            export default {
                components: {Modal},
                name: 'UserMenu',
                data() {
                    return {
                        showProfileModal: false,
                        firstName: 'test',
                        lastName: '',
                        password: '',
                        newPassword: '',
                        passwordRepeat: '',
                        errorFirstName: '',
                        errorLastName: '',
                        errorNewPassword: '',
                        errorPasswordRepeat: '',
                        updateValid: true
                    };
                },
                methods: {
                    logout() {
                        this.$store.dispatch('logout');
                    },
                    profile() {
                        this.showProfileModal = true;
                    },
                    cancel() {
                        this.showProfileModal = false;
                    },
                    updateUser() {
                        if (this.firstName === ''){
                            this.errorFirstName = 'No first name entered';
                            this.updateValid = false;
                        } else {
                            this.errorFirstName = ''
                        }
                        if (this.lastName === ''){
                            this.errorLastName = 'No last name entered';
                            this.updateValid = false;
                        } else {
                            this.errorLastName = ''
                        }
                        if (this.updateValid){
                            this.$store.dispatch('updateUser', {
                                idUser: this.$store.state.userInfo.idUser,
                                firstName: this.firstName,
                                lastName: this.lastName
                            });
                            this.showProfileModal = false;
                        }
                        this.updateValid = true;
                    }
                },
                mounted() {
                    if (this.$store.state.userInfo) {
                        this.firstName = this.$store.state.userInfo.firstName;
                        this.lastName = this.$store.state.userInfo.lastName;
                    }
                }
            };
</script>

<style lang="css">
    .dropdown{
        width: 100%;
        align-self: center;
        text-align: center;
    }
    .errorMsg{
        color: red;
    }
</style>