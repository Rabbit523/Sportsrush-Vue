<template>
    <div class="container">
        <div class="contact-us">
            <h2>Contact Us</h2>
            <h4>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do tempor.</h4>
            <!-- <div class="alert alert-success hidden" id="contactSuccess">
                <strong>Success!</strong> Your message has been sent to us.
            </div>
            <div class="alert alert-error hidden" id="contactError">
                <strong>Error!</strong> There was an error sending your message.
            </div> -->
            <div class="contact-form">
                <div>
                    <div class="form-group has-feedback">
                        <label for="name">Name*</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="">
                        <i class="fa fa-user form-control-feedback"></i>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="email">Email*</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="">
                        <i class="fa fa-envelope form-control-feedback"></i>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="subject">Subject*</label>
                        <input type="text" class="form-control" id="subject" name="subject" placeholder="">
                        <i class="fa fa-navicon form-control-feedback"></i>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="message">Message*</label>
                        <textarea class="form-control" rows="6" id="message" name="message" placeholder=""></textarea>
                        <i class="fa fa-pencil form-control-feedback"></i>
                    </div>
                    <button @click="contactUs" class="btn btn-default">Submit</button>
                </div>
            </div>
        </div>
        <Modal v-if="showContactusModal">
            <div slot="header">
                <h3 style="text-align: center; color: black;">Contact US</h3>
            </div>
            <div slot="body">
                <div class="field">
                    <p>Thank you for contacting us</p>
                </div>            
            </div>
            <div slot="footer" style="    text-align: center;">
                <div class="ui checkbox">
                  <sui-button @click.native="confirm" class='basicBtn'  >OK</sui-button>
                </div>
            </div>
          
        </Modal>
    </div>
</template>
<script>
import Modal from "./Modal.vue";

export default {
  components: { Modal },
  data() {
    return {
      showContactusModal: ""
    };
  },
  methods: {
    contactUs: function() {
      this.showContactusModal = true;
    },
    confirm: function() {
      this.showContactusModal = false;
    }
  }
};
</script>

<style scoped>
h4,
h3,
h2 {
}
.container {
  margin-left: 280px;
  margin-right: 280px;
}
.contact-us {
  width: 60%;
  margin-left: auto;
  margin-right: auto;
  min-height: 600px;
  padding-top: 40px;
}
label {
  display: inline-block;
  margin-bottom: 5px;
  font-weight: 700;
}
.has-feedback .form-control {
  padding-right: 42.5px;
}
.has-feedback {
  position: relative;
}
textarea.form-control {
  height: auto;
}

.form-group {
  margin-bottom: 15px;
}
.form-control {
  display: block;
  width: 100%;
  height: 34px;
  padding: 6px 12px;
  font-size: 14px;
  line-height: 1.428571429;
  color: #555;
  background-color: #fff;
  background-image: none;
  border: 1px solid #ccc;
  border-radius: 4px;
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
  -webkit-transition: border-color ease-in-out 0.15s,
    box-shadow ease-in-out 0.15s;
  transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
}
input,
button,
select,
textarea {
  font-family: inherit;
  font-size: inherit;
  line-height: inherit;
}
input {
  line-height: normal;
}
button,
input,
optgroup,
select,
textarea {
  color: inherit;
  font: inherit;
  margin: 0;
}
button,
html input[type="button"],
input[type="reset"],
input[type="submit"] {
  -webkit-appearance: button;
  cursor: pointer;
}

.btn {
  text-align: center;
  background: #1891ec;
}
.btn-default {
  color: #333;
  background-color: #fff;
  border-color: #ccc;
}
.btn {
  display: inline-block;
  margin-bottom: 0;
  font-weight: 400;
  text-align: center;
  vertical-align: middle;
  cursor: pointer;
  background-image: none;
  border: 1px solid transparent;
  white-space: nowrap;
  padding: 6px 12px;
  font-size: 14px;
  line-height: 1.428571429;
  border-radius: 4px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  -o-user-select: none;
  user-select: none;
}
.basicBtn {
  width: 100px;
  height: 40px;
  font-size: 15px;
  margin-left: 25px !important;
  margin-right: 25px !important;
}
</style>
