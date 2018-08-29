<template>
    <div class="centeredContent">
        <div class='normalBtn'>
            <sui-button @click.native="showLoginModal = true" class='basicBtn'>{{ btn1 }}</sui-button>
            <sui-button @click.native="showRegisterModal = true" class='basicBtn'>{{ btn2 }}</sui-button>
        </div>
        <!--<div class='socialBtn'>
            <sui-button icon="google plus big"  />
            <sui-button icon="facebook big" />
        </div>-->

        <Modal v-if="showRegisterModal" @close="showRegisterModal = false">
            <h3 slot="header">Register</h3>
            <form slot="body" class="ui form">
              <sui-grid>
                <sui-grid-row>
                  <sui-grid-column :width="8">
                     <div class="field">
                        <label>Email</label>
                        <span class="errorMsg">{{errorEmailReg}}</span>
                        <input type="text" placeholder="Email" v-model="userEmailReg">
                    </div>
                    <div class="field">
                        <label>First Name</label>
                        <span class="errorMsg">{{errorFirstNameReg}}</span>
                        <input type="text" placeholder="First Name" v-model="firstName">
                    </div>
                    <div class="field">
                        <label>Last Name</label>
                        <span class="errorMsg">{{errorLastNameReg}}</span>
                        <input type="text" placeholder="Last Name" v-model="lastName">
                    </div>
                    <div class="field">
                        <label>Password</label>
                        <span class="errorMsg">{{errorPasswordReg}}</span>
                        <input type="password" placeholder="Password" v-model="passwordReg">
                    </div>
                    <div class="field">
                        <label>Repeat password</label>
                        <span class="errorMsg">{{errorPasswordRepeat}}</span>
                        <input type="password" placeholder="Repeat Password" v-model="passwordRepeat">
                    </div>
                  </sui-grid-column>
                  <sui-grid-column :width="8">
                    <div class="field">
                    <label>Street</label>
                        <input type="text" placeholder="Street" v-model="street">
                    </div>
                    <div class="field">
                        <label>City</label>
                        <input type="text" placeholder="City" v-model="city">
                    </div>
                    <div class="field">
                        <label>Country</label>
                        <input type="text" placeholder="Country" v-model="country">
                    </div>
                    <div class="field">
                        <label>ZipCode</label>
                        <input type="text" placeholder="ZipCode" v-model="zipcode">
                    </div>
                    <div class="field">
                        <label>Phonenumber</label>
                        <input type="text" placeholder="Phonenumber" v-model="phonenumber">
                    </div>
                  </sui-grid-column>
                </sui-grid-row>
                <sui-grid-row>
                  <sui-grid-column :width="8">
                    <div class="field">
                        <label>Birthday</label>
                        <date-picker lang="en" v-model="birthday" type="date" format="YYYY-MM-DD" :first-day-of-week="1"></date-picker>
                    </div>
                  </sui-grid-column>
                  <sui-grid-column :width="8">
                    <div class="field">
                      <label>Interests</label>
                      <sui-dropdown
                        placeholder="Sports"
                        selection
                        :options="options"
                        v-model="current"
                      />
                    </div>
                  </sui-grid-column>
                </sui-grid-row>
                <sui-grid-row>
                  <sui-grid-column :width="16">
                        <sui-checkbox label="Agree to our terms and policy"/>
                  </sui-grid-column>
                </sui-grid-row>
              </sui-grid>

            </form>
            <h3 slot="footer">
                <sui-button @click.native="register" class='basicBtn'>Register</sui-button>
                <sui-button @click.native="cancel" class='basicBtn'>Cancel</sui-button>
            </h3>
        </Modal>

        <Modal v-if="showLoginModal" @close="showLoginModal = false">
            <h3 slot="header">Login</h3>
            <form slot="body" class="ui form">
                <div class="field">
                    <label>Email</label>
                    <span class="errorMsg">{{errorEmailLogin}}</span>
                    <input type="text" name="email" placeholder="Email" v-model="userEmailLogin" lazy>
                </div>
                <div class="field">
                    <label>Password</label>
                    <span class="errorMsg">{{errorPasswordLogin}}</span>
                    <input type="password" name="passwordReg" placeholder="Password" v-model="passwordLogin">
                </div>
            </form>
            <h3 slot="footer">
              <div class="field">
                <div class="ui checkbox">
                <sui-button @click.native="connect" class='basicBtn'>Submit</sui-button>
                <sui-button @click.native="cancel" class='basicBtn'>Cancel</sui-button>
                </div>
                <div class="ui checkbox">
                <fb-signin-button class="loginBtn loginBtn--facebook"
                  :params="fbSignInParams"
                  @success="onFacebookSuccess"
                  @error="onSignInError">
                  Sign in with Facebook
                </fb-signin-button>
                <g-signin-button
                  class="loginBtn loginBtn--google"
                  :params="googleSignInParams"
                  @success="onSignInSuccess"
                  @error="onSignInError">
                  Sign in with Google
                </g-signin-button>
                </div>
              </div>
              <div class="ui checkbox">
                <input type="checkbox" name="example" @click="forgotPassword">
                <label>Forgot password?</label>
              </div>
            </h3>
        </Modal>

        <Modal v-if="showMailModal" @close="showMailModal = false">
            <h3 slot="header">Register</h3>
            <form slot="body" class="ui form">
                <div class="field" v-if="mailVerified == 1">
                    <p>Your email has been verified, click on the button below if you want to login</p>
                </div>
                <div v-else >
                    <p>
                        We have sent you an email with a link. Please click on the link found in the mail to verify that it belongs to you.
                    </p>
                </div>

            </form>
            <h3 slot="footer">
                <sui-button @click.native="connect" class='basicBtn'  v-if="mailVerified == 1" >Login</sui-button>
                <sui-button @click.native="cancel" class='basicBtn'>Cancel</sui-button>
            </h3>
        </Modal>

        <Modal v-if="showForgotModal">
          <h3 slot="header">Reset Password</h3>
            <form slot="body" class="ui form">
                <div class="field">
                    <label>Email</label>
                    <span class="errorMsg">{{errorEmailLogin}}</span>
                    <input type="text" name="email" placeholder="Email" v-model="userForgotLogin" lazy>
                </div>
            </form>
            <h3 slot="footer">
              <div class="field">
                <sui-button @click.native="submitForgotPassword" class='basicBtn'>Submit</sui-button>
                <sui-button @click.native="cancelForgotPassword" class='basicBtn'>Cancel</sui-button>
              </div>
            </h3>

        </Modal>

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
    </div>
</template>

<script>
import Modal from "./Modal.vue";
import { mapGetters } from "vuex";
import DatePicker from "vue2-datepicker";
import moment from 'moment';

export default {
  components: { Modal, DatePicker },
  data() {
    return {
      birthday: "",
      btn1: "Login",
      btn2: "Register",
      social1: "Facebook",
      social2: "Google+",
      showRegisterModal: false,
      showLoginModal: false,
      showMailModal: false,
      mailVerified: false,
      userEmailReg: "",
      firstName: "",
      lastName: "",
      passwordReg: "",
      userEmailLogin: "",
      passwordLogin: "",
      userForgotLogin: "",
      email: "",
      mailTimer: null,
      password: "",
      passwordRepeat: "",
      errorFirstNameReg: "",
      errorLastNameReg: "",
      errorPasswordReg: "",
      errorPasswordRepeat: "",
      street: "",
      city: "",
      country: "",
      zipcode: "",
      phonenumber: "",
      errorEmailReg: "",
      regValid: true,
      errorEmailLogin: "",
      errorPasswordLogin: "",
      logValid: true,
      showForgotModal: "",
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
      googleSignInParams: {
        client_id:
          "487900139768-15a5k3gi9i9gldbv193flk2ldk48or0p.apps.googleusercontent.com"          
      },
      fbSignInParams: {
        scope: 'email,user_likes',
        return_scopes: true
      }
    };
  },
  watch: {
    getRegistered() {
      if (this.$store.state.regSuccess) {
        this.registered();
      }
    },
    getEmail() {
      if (this.$store.getters.getEmail) {
        this.mailVerified = this.$store.state.email.verified;
        if (this.mailVerified) {
          clearTimeout(this.mailTimer);
          this.userEmailLogin = this.$store.state.email.email;
          this.passwordLogin = this.password;
        }
        this.$forceUpdate();
      }
    }
  },
  computed: {
    connected() {
      return this.$store.getters.connected;
    },
    ...mapGetters(["getRegistered", "getEmail"])
  },
  methods: {
    onFacebookSuccess(response) {
      let instance = this;
      FB.api('/me', { fields: 'first_name,last_name,picture, email' }, function (profile) {
        instance.$store.commit("SET_LOADING", true);
        instance.$store.dispatch("connectUser", {
          email: profile.email,
          password: instance.passwordLogin,
          firstName: profile.first_name,
          lastName: profile.last_name,
          personalImage: profile.picture.data.url,
          type: "social"
        });
        instance.showLoginModal = false;
      });

    },
    onSignInSuccess(googleUser) {
      // `googleUser` is the GoogleUser object that represents the just-signed-in user.
      // See https://developers.google.com/identity/sign-in/web/reference#users
      const profile = googleUser.getBasicProfile(); // etc etc
      var id_token = googleUser.getAuthResponse().id_token;
      this.$store.commit("SET_LOADING", true);

      this.$store.dispatch("connectUser", {
        email: profile.getEmail(),
        password: this.passwordLogin,
        firstName: profile.ofa,
        lastName: profile.wea,
        personalImage: profile.Paa,
        type: "social"
      });
      this.showLoginModal = false;
    },
    onSignInError(error) {
      // `error` contains any error occurred.
      console.log("OH NOES", error);
    },
    onSignIn(user) {
      const profile = user.getBasicProfile();
    },
    forgotPassword: function() {
      this.showLoginModal = false;
      this.showForgotModal = true;
    },
    submitForgotPassword: function() {
      console.log(this.userForgotLogin);
      this.$store.commit("SET_LOADING", true);
      this.$store.dispatch("resetPassword", {
        email: this.userForgotLogin
      });
      this.showForgotModal = false;
    },
    cancelForgotPassword: function() {
      this.showForgotModal = false;
    },
    connect: function(event) {
      if (this.userEmailLogin === "") {
        this.errorEmailLogin = "No email entered";
        this.logValid = false;
      } else {
        this.errorEmailLogin = "";
      }
      if (this.passwordLogin === "") {
        this.errorPasswordLogin = "No password entered";
        this.logValid = false;
      } else {
        this.errorPasswordLogin = "";
      }
      if (this.logValid) {
        this.$store.commit("SET_LOADING", true);
        this.$store.dispatch("connectUser", {
          email: this.userEmailLogin,
          password: this.passwordLogin,
          type: "normal"
        });
      }
      this.logValid = true;
      //
    },
    testApi: function(event) {
      this.$store.dispatch("test");
    },
    register() {
      if (this.userEmailReg === "") {
        this.errorEmailReg = "No email entered";
        this.regValid = false;
      } else {
        this.errorEmailReg = "";
      }
      if (this.firstName === "") {
        this.errorFirstNameReg = "No first name entered";
        this.regValid = false;
      } else {
        this.errorFirstNameReg = "";
      }
      if (this.lastName === "") {
        this.errorLastNameReg = "No last name entered";
        this.regValid = false;
      } else {
        this.errorLastNameReg = "";
      }
      if (this.passwordReg === "") {
        this.errorPasswordReg = "No password entered";
        this.regValid = false;
      } else {
        this.errporPasswordReg = "";
      }
      if (this.passwordReg !== this.passwordRepeat) {
        this.errorPasswordRepeat = "You must enter the same password";
        this.regValid = false;
      } else {
        this.errorPasswordRepeat = "";
      }
      if (this.regValid) {
        this.$store.commit("SET_LOADING", true);
        this.$store.dispatch("createUser", {
          email: this.userEmailReg,
          firstName: this.firstName,
          lastName: this.lastName,
          password: this.passwordReg,
          birthday: moment(this.birthday).format('YYYY-MM-DD'),
          street: this.street,
          country: this.country,
          zipcode: this.zipcode,
          city: this.city,
          phone: this.phonenumber,
          interests: this.options[this.current - 1].text
        });
        this.password = this.passwordReg;
        this.registered();
      }
      this.regValid = true;
    },
    cancel() {
      this.showLoginModal = false;
      this.showRegisterModal = false;
      this.showMailModal = false;
    },
    registered() {
      this.userEmailLogin = this.userEmailReg;
      this.email = this.userEmailReg;
      this.passwordLogin = this.passwordReg;

      this.userEmailReg = "";
      this.firstName = "";
      this.lastName = "";
      this.passwordReg = "";
      this.$store.commit("SET_REGSUCCESS", false);
      this.showRegisterModal = false;
      this.showMailModal = true;
      this.mailVerification(this.email);
      return true;
    },
    mailVerification(emailInput) {
      let s = this;
      this.$store.dispatch("getEmail", { email: emailInput });
      this.mailTimer = setTimeout(s.mailVerification, 5000, emailInput);
    }
  },
  created: function() {
    console.log('created main');
    window.fbAsyncInit = function() {
      FB.init({
        appId      : '1769705819764557',
        xfbml      : true,
        version    : 'v2.7'
      });

      //This function should be here, inside window.fbAsyncInit
      FB.getLoginStatus(function(response) {
        console.log(response);
      });
    };
    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
  }
};
</script>

<style>
.mx-calendar-icon {
  height: auto;
}
</style>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.mx-calendar-icon {
  height: auto;
}
.centeredContent {
  margin: 0 auto;
  /*
        display: flex;
        justify-content: center;
        align-items: center;
        */
}

h1,
h2 {
  font-weight: normal;
}

ul {
  list-style-type: none;
  padding: 0;
}

.socialBtn {
  margin-top: 10px;
}

.basicBtn {
  width: 100px;
  height: 40px;
  font-size: 15px;
  margin-left: 25px !important;
  margin-right: 25px !important;
}
.errorMsg {
  color: red;
}
.ui.checkbox {
  margin-top: 20px;
}
/* Shared */
.loginBtn {
  color: white;
  box-sizing: border-box;
  position: relative;
  /* width: 13em;  - apply for fixed size */
  margin: 0.2em;
  padding: 0 15px 0 46px;
  border: none;
  text-align: left;
  line-height: 34px;
  white-space: nowrap;
  border-radius: 0.2em;
  font-size: 16px;
  display: inline-block;
  font-weight: 400;
  font-family: sans-serif;
  cursor: pointer;
}
.loginBtn:before {
  content: "";
  box-sizing: border-box;
  position: absolute;
  top: 0;
  left: 0;
  width: 34px;
  height: 100%;
}
.loginBtn:focus {
  outline: none;
}
.loginBtn:active {
  box-shadow: inset 0 0 0 32px rgba(0, 0, 0, 0.1);
}

/* Facebook */
.loginBtn--facebook {
  background-color: #4c69ba;
  background-image: linear-gradient(#4c69ba, #3b55a0);
  /*font-family: "Helvetica neue", Helvetica Neue, Helvetica, Arial, sans-serif;*/
  text-shadow: 0 -1px 0 #354c8c;
}
.loginBtn--facebook:before {
  border-right: #364e92 1px solid;
  background: url("https://s3-us-west-2.amazonaws.com/s.cdpn.io/14082/icon_facebook.png")
    6px 6px no-repeat;
}
.loginBtn--facebook:hover,
.loginBtn--facebook:focus {
  background-color: #5b7bd5;
  background-image: linear-gradient(#5b7bd5, #4864b1);
}

/* Google */
.loginBtn--google {
  /*font-family: "Roboto", Roboto, arial, sans-serif;*/
  background: #dd4b39;
}
.loginBtn--google:before {
  border-right: #bb3f30 1px solid;
  background: url("https://s3-us-west-2.amazonaws.com/s.cdpn.io/14082/icon_google.png")
    6px 6px no-repeat;
}
.loginBtn--google:hover,
.loginBtn--google:focus {
  background: #e74b37;
}
</style>
