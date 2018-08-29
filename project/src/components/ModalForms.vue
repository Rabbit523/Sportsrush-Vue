<template>
    <div class="centeredContent">
        <h1>Modal Forms</h1>
        <sui-button @click.native="showNewTeamModal = true" class='basicBtn' >New Team</sui-button>

        <Modal v-if="showNewTeamModal" @close="showNewTeamModal = false">
            <div slot="header">
                <h3>New Team</h3>
            </div>
            <div slot="body">
                <form class="ui form">
                    <div class="field">
                        <label>Team Name</label>
                        <input type="text" name="team-name" placeholder="Team Name">
                    </div>
                    <div class="field">
                        <label>Sport</label>
                        <select class="ui dropdown">
                            <option value="s1">s1</option>
                            <option value="s2">s2</option>
                            <option value="s3">s3</option>
                            <option value="s4">s4</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>Description</label>
                        <input type="text" name="description" placeholder="Description">
                    </div>
                    <div class="field">
                        <label>Team Logo</label>
                        <input type="file" name="team-logo" placeholder="Team Logo">
                    </div>
                </form>
            </div>
            <div slot="footer">
                <sui-button @click.native="" class='basicBtn'>Submit</sui-button>
                <sui-button @click.native="" class='basicBtn'>Cancel</sui-button>
            </div>
        </Modal>

        <sui-button @click.native="showProfileModal = true" class='basicBtn' >Mod. Profile</sui-button>

        <Modal v-if="showProfileModal" @close="showProfileModal = false">
            <div slot="header">
                <h3>Modify Profile</h3>
            </div>
            <div slot="body">
                <form class="ui form">
                    <div class="field">
                        <label>First Name</label>
                        <input type="text" name="first-name" placeholder="First Name">
                    </div>
                    <div class="field">
                        <label>Last Name</label>
                        <input type="text" name="last-name" placeholder="Last Name">
                    </div>
                    <div class="field">
                        <label>Personal Image</label>
                        <input type="file" name="personal-image" placeholder="Personal Image">
                    </div>
                    <h3>Change password</h3>
                    <div class="field">
                        <label>Password</label>
                        <input type="text" name="password" placeholder="Password">
                    </div>
                    <div class="field">
                        <label>Repeat password</label>
                        <input type="text" name="rep-password" placeholder="Repeat Password">
                    </div>
                </form>
            </div>
            <div slot="footer">
                <sui-button @click.native="" class='basicBtn'>Submit</sui-button>
                <sui-button @click.native="" class='basicBtn'>Cancel</sui-button>
            </div>
        </Modal>

        <sui-button @click.native="showAddMembersModal = true" class='basicBtn' >Invite Members</sui-button>

        <Modal v-if="showAddMembersModal" @close="showAddMembersModal = false">
            <div slot="header">
                <h3>Invite New Members</h3>
                <h5>{Team Name}</h5>
            </div>
            <div slot="body">
                <form class="ui form">
                    <div class="fields">
                        <div class="field">
                            <label>Email</label>
                            <input type="text" name="first-name" placeholder="First Name">
                        </div>
                        <div class="field">
                            <div>
                                <input type="checkbox" tabindex="0" class="hidden">
                                    <label>As coach</label>
                            </div>
                        </div>
                    </div>
                    <h6>Add members from other teams</h6>
                </form>
            </div>
            <div slot="footer">
                <sui-button @click.native="" class='basicBtn'>Submit</sui-button>
                <sui-button @click.native="" class='basicBtn'>Cancel</sui-button>
            </div>
        </Modal>

        <sui-button @click.native="showTestModal = true" class='basicBtn' >Test</sui-button>

        <Modal v-if="showTestModal" @close="showTestModal = false">
            <div slot="header">
                <h3>Test</h3>
            </div>
            <div slot="body" class="ui form">
                <div class="ui form">
                    <div class="fields">
                        <div class="field">
                            <label>First name</label>
                            <input type="text" placeholder="First Name">
                        </div>
                        <div class="field">
                            <label>Middle name</label>
                            <input type="text" placeholder="Middle Name">
                        </div>
                        <div class="field">
                            <label>Last name</label>
                            <input type="text" placeholder="Last Name">
                        </div>
                    </div>
                </div>  
            </div>
        </Modal>
    </div>
</template>

<script>
    import Modal from './Modal.vue'

            export default {
                components: {Modal},
                data() {
                    return {
                        showNewTeamModal: false,
                        showProfileModal: false,
                        showAddMembersModal: false,
                        showTestModal: false,
                    }
                },
                methods: {
                }
            }
</script>

<style scoped>
</style>
