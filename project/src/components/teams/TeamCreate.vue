<template>
  <sui-grid celled="internally" class="section">
    <sui-grid-row class="content">
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
            <label><span>Team Name</span></label>
            <input placeholder="Team Name"  v-model="t_name">
          </sui-form-field>
          <sui-form-field>
            <label><span>Team Property</span></label>
            <input placeholder="Team Property"  v-model="t_type">
          </sui-form-field>
          <sui-form-field>
            <label><span>Team Sport</span></label>
            <sui-dropdown placeholder="Team Sport" selection :options="options" v-model="current"/>
          </sui-form-field>
          <sui-form-field>
            <label><span>Description</span></label>
            <textarea placeholder="description"  v-model="t_description"></textarea>
          </sui-form-field>
          <sui-button @click.prevent="create" >Create</sui-button>
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
.section {
  min-height: 564px;
}
.content {
  margin-top: 20px !important;
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
  computed: {
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
    create () {
      this.$store.commit("SET_LOADING", true);      
      this.$store.dispatch("createTeam", {
        idUser: this.$store.state.userInfo.idUser,
        name: this.t_name,
        type: this.t_type,
        logo: this.t_logo,
        sport: this.current,
        description: this.t_description
      });
    },
  	trigger () {
    	this.$refs.fileInput.click()
    }
  },
  data() {
    return {
      t_name: "",
      t_type: "",
      t_logo: "",
      t_description: "",
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
      ]
    };
  }
};
</script>
