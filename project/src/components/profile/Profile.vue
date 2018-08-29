<template>
  <sui-grid celled="internally">
    <sui-grid-row>
      <sui-grid-column class="avatar" :width="4">
      </sui-grid-column>
      <sui-grid-column class="avatar" :width="3">
        <img src="../../assets/bandmember.jpg" alt="Avatar">
        <sui-button @click="trigger" class="trigger">Choose file</sui-button>
        <input type="file" ref="fileInput" style ="display:none;"/>
      </sui-grid-column>
      <sui-grid-column :width="5">
        <sui-form>
          <sui-form-field>
            <label><span>Email</span></label>
            <input placeholder="Email"  v-model="email">
          </sui-form-field>
          <sui-form-field>
            <label><span>First Name</span></label>
            <input placeholder="First Name"  v-model="first_Name">
          </sui-form-field>
          <sui-form-field>
            <label><span>Last Name</span></label>
            <input placeholder="Last Name"  v-model="last_Name">
          </sui-form-field>
          <sui-form-field>
            <label><span>Password</span></label>
            <input v-if="getUserType" type="password" placeholder="Password" v-model="password">
            <input v-if="!getUserType" type="password" placeholder="Password" disabled="disabled" v-model="password">
          </sui-form-field>
          <sui-form-field>
            <label><span>Birthday</span></label>
            <date-picker v-if="getUserType" lang="en" v-model="birthday" :first-day-of-week="1"></date-picker>
            <date-picker v-if="!getUserType" lang="en" v-model="birthday" disabled="disabled" :first-day-of-week="1"></date-picker>
            <!-- <input placeholder="Birthday" > -->
          </sui-form-field>
          <!-- <sui-form-field>
            <label>Street</label>
            <input placeholder="Street" >
          </sui-form-field> -->
          <sui-form-field>
            <label><span>City</span></label>
            <input v-if="getUserType" placeholder="City"  v-model="city">
            <input v-if="!getUserType" placeholder="City" disabled="disabled"  v-model="city">
          </sui-form-field>
          <sui-form-field>
            <label><span>Country</span></label>
            <input v-if="getUserType" placeholder="country"  v-model="country">
            <input v-if="!getUserType" placeholder="country" disabled="disabled" v-model="country">
          </sui-form-field>
          <sui-form-field>
            <label><span>Interests</span></label>
                      <sui-dropdown
                        placeholder="Sports"
                        selection
                        :options="options"
                        v-model="current"
                      />
          </sui-form-field>
          <sui-button @click.prevent="update" >Update</sui-button>
        </sui-form>
      </sui-grid-column>
      <sui-grid-column class="avatar" :width="4">
      </sui-grid-column>
    </sui-grid-row>
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
  </sui-grid>
</template>
<style>

body {
  /* background-color: #af1945; */
}
.ui.celled.grid>.column:not(.row), .ui.celled.grid>.row>.column {
  box-shadow: unset;
}
</style>
<script>
import DatePicker from "vue2-datepicker";
import moment from 'moment';
import Modal from "../Modal.vue";

export default {
  components: { DatePicker, Modal },
  mounted: function () {
    this.email = this.$store.state.userInfo.email;
    this.first_Name = this.$store.state.userInfo.firstName;
    this.last_Name = this.$store.state.userInfo.lastName;
    this.birthday = this.$store.state.userInfo.birthday;
    this.country = this.$store.state.userInfo.country;
    this.city = this.$store.state.userInfo.city;
    if (this.$store.state.userInfo.interests == "Golf") {
      this.current = 2;
    } else {
      this.current = 1;
    }
  },
  computed: {
    getUserType() {
      return this.$store.getters.getUserType;
    },
    connected() {
      return this.$store.getters.connected;
    }
  },
  watch: {
    connected: function () {
      if (!this.$store.getters.connected) {
        this.$router.push("/");
      }
    }
  },
  methods: {
    update () {
      this.$store.commit("SET_LOADING", true);
      if (this.getUserType) {
        this.$store.dispatch("updateUser", {
          idUser: this.$store.state.userInfo.idUser,
          firstName: this.first_Name,
          lastName: this.last_Name,
          password: this.password,
          birthday: moment(this.birthday).format('YYYY-MM-DD'),
          country: this.country,
          city: this.city,
          interests: this.options[this.current - 1].text,
          result: {
            birthday: moment(this.birthday).format('YYYY-MM-DD'),
            country: this.country,
            city: this.city,
            interests: this.options[this.current - 1].text
          }
        });
      } else {
        this.$store.dispatch("updateUser", {
          idUser: this.$store.state.userInfo.idUser,
          firstName: this.first_Name,
          lastName: this.last_Name,
          password: "",
          birthday: "",
          country: "",
          city: "",
          interests: this.options[this.current - 1].text
        });
      }

    },
  	trigger () {
    	this.$refs.fileInput.click()
    }
  },
  data() {
    return {
      birthday: "",
      btn1: "Save",
      btn2: "Cancel",
      email: "",
      first_Name: "",
      last_Name: "",
      password: "",
      city: "",
      country: "",
      current: null,
      options: [
        {
          text: "Tennis",
          value: 1
        },
        {
          text: "Golf",
          value: 2
        }
      ],
    };
  }
};
</script>
