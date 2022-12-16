<template>
  <div class="container-fluid">
    <div class="container-div">
      <!-- login form  -->
      <div
        class="row main-content text-center"
        style="min-width: 55%; min-height: 40%"
        id="login-form"
      >
        <div class="col-md-4 text-center company__info">
          <div class="image">
            <img src="../../img/logo.png" width="220" alt="User" />
          </div>
        </div>
        <div class="col-md-8 col-xs-12 col-sm-12 login_form">
          <form @submit.prevent="login" class="form-signin">
            <div>
              <div class="body">
                <h1 class="h3 mb-3 font-weight-bold" style="margin-top: 20px">
                  Membership Application<br />
                </h1>
                <div class="msg">Sign in to start your session</div>

                <hr />

                <div class="input-group field-div">
                  <span class="input-group-addon span-append" id="basic-addon1">
                    <i class="material-icons input-icon">email</i>
                  </span>
                  <input
                    type="text"
                    ref="email"
                    name="email"
                    class="form-control fields"
                    placeholder="Email"
                    v-model.trim="email"
                    v-validate="'required'"
                    autocomplete="off"
                    aria-describedby="basic-addon1"
                    autofocus
                    @keyup.enter="login"
                  />
                </div>
                <small
                  class="text-danger error-span"
                  v-show="errors.has('email')"
                >
                  {{ errors.first("email") }}
                </small>
                <div v-if="!passwordHidden" class="field-div">
                  <div class="input-group">
                    <span class="input-group-addon span-append">
                      <i class="material-icons input-icon" style="color: #fff"
                        >vpn_key
                      </i>
                    </span>
                    <input
                      type="text"
                      name="password"
                      class="form-control fields"
                      placeholder="Password"
                      aria-label="Password"
                      aria-describedby="basic-addon2"
                      v-model="password"
                      v-validate="'required'"
                      @keyup.enter="login"
                    />
                    <span
                      @click="hidePassword"
                      class="input-group-addon span-click"
                    >
                      <i class="material-icons">visibility_off</i>
                    </span>
                  </div>
                  <small
                    class="text-danger error-span error-span2"
                    v-show="errors.has('password')"
                  >
                    {{ errors.first("password") }}
                  </small>
                </div>
                <div v-if="passwordHidden" class="field-div">
                  <div class="input-group">
                    <span class="input-group-addon span-append">
                      <i class="material-icons input-icon">vpn_key</i>
                    </span>
                    <input
                      type="password"
                      name="password"
                      class="form-control fields"
                      placeholder="Password"
                      aria-label="Password"
                      aria-describedby="basic-addon2"
                      v-model="password"
                      v-validate="'required'"
                      @keyup.enter="login"
                    />
                    <span
                      @click="showPassword"
                      class="input-group-addon span-click"
                    >
                      <i class="material-icons">visibility</i>
                    </span>
                  </div>
                  <small
                    class="text-danger error-span error-span2"
                    v-show="errors.has('password')"
                  >
                    {{ errors.first("password") }}
                  </small>
                </div>

                <div class="row">
                  <b-button
                    class="login-btn"
                    size="sm"
                    type="submit"
                    @click="login"
                  >
                    L O G I N
                  </b-button>
                  <small class="text-danger center-align" v-show="login_failed"
                    >Incorrect credentials.</small
                  >
                </div>

                <div class="row">
                  <p>
                    Not yet a member?
                    <a href="javascript:void(0);" @click="show_note()"
                      >Register here</a
                    >
                  </p>
                  <!-- <b-button class="signup-btn" size="sm" @click="show_note()">
                    S I G N - U P
                  </b-button> -->
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- modal  Data Privacy Notice -->
    <b-modal
      id="ModalDataPrivacy"
      :header-bg-variant="' elBG'"
      :header-text-variant="' elClr'"
      :body-bg-variant="' elBG'"
      :body-text-variant="' elClr'"
      :footer-bg-variant="' elBG'"
      :footer-text-variant="' elClr'"
      size="lg"
      title=" DATA PROTECTION CONSENT"
      :no-close-on-backdrop="true"
    >
      <center>
        <p class="text-justify lh-sm" style="line-height: 1.5em">
          <strong class="king">KING MULTIPURPOSE COOPERATIVE </strong>
          (King MPC), the cooperative, shall protect the data that you provided
          in compliance with the Data Privacy Law of 2012 and its Implementing
          Rules and Regulations. The Cooperative will not collect, disclose or
          process personal data, including data that may be classified as
          personal information and/ or sensitive personal information unless you
          voluntarily choose to provide us with it and give your consent
          thereto, or unless such disclosure is required by applicable laws and
          regulations. Personal or sensitive personal information is information
          pertaining to racial or ethnic origin, religious belief, political
          affiliations, education, health or information provided by government
          agencies which are peculiar to individuals and such other data
          declared to be sensitive. <br />
          <br />
          By signing above your name below, you confirm that you freely and
          voluntarily give full consent to the collection of data, which may
          include personal information and/ or sensitive information set out in
          this form and/ or otherwise provided by you or possessed by the
          Cooperative for one or more purpose as stated below. The Cooperative
          shall use the Data for the following purpose: <br />
          <br />

          (a) Processing of opening of membership, share capital, regular,
          special savings, time deposit, loan account/ credit facility, and
          availing other cooperative services; <br />
          <br />

          (b) In compliance with Credit Information System Act, should you have
          any loan or credit facility with the Cooperative, the Cooperative is
          mandated to share your basic credit data including related updates/
          corrections to the Credit Information Corporation (CIC) and other
          entities authorized under the law, even without your consent; and
          <br />
          <br />

          (c) Share information to any third parties, affiliates, partners and
          service providers for any legitimate business purpose and to give you
          quality services. You are assured that security systems are employed
          to protect your information. <br />
          <br />

          The Cooperative shall keep the Data throughout the term of the
          engagement between you and the Cooperative. The Cooperative shall take
          appropriate measures to ensure the requisite data security to protect
          the Data against unauthorized disclosure or unauthorized access.
          <br />
          <br />

          You understand that you are given certain rights under the Data
          Privacy Act, including the right to object to processing of your data,
          the right to access your data, the right to correct any inaccurate
          data, and the right to erasure or blocking of data. <br />
          <br />
          <br />
        </p>

        <small>
          Please contact our Data Privacy Officer at
          <strong class="king">kingmpcooperative@gmail.com </strong>
          or call us at (082)-226-4636/(082) 227-1127 (Head Office) or your
          respective Branch Manager in your Branch. You may visit us from Monday
          to Friday from 9:00 A.M. to 4:00 P.M.
        </small>
        <br />
        <br />
      </center>

      <!-- <p class="enhancements">
        <label for="agreement">I agree to the terms of agreement.</label>
        <input
          id="accept"
          type="checkbox"
          v-model="accept"
          style="cursor:pointer"
        />
      </p> -->
      <template slot="modal-footer" slot-scope="{}">
        <b-button class="back-btn" type="submit" @click="back">
          <i class="fas fa-arrow-circle-left"></i> Admin Login
        </b-button>
        <b-button class="proceed-btn" @click="proceed"> Proceed </b-button>
      </template>
    </b-modal>

    <modal_application></modal_application>
  </div>
</template>

<script>
import { ModelListSelect } from "vue-search-select";
import PrettyCheck from "pretty-checkbox-vue/check";
import modal_application from "../modal_vue/modal_application.vue";
import datePicker from "vue-bootstrap-datetimepicker";
export default {
  components: {
    "date-picker": datePicker,
    "model-list-select": ModelListSelect,
    "p-check": PrettyCheck,
    modal_application: modal_application,
    "date-picker": datePicker,
  },
  data() {
    return {
      email: "",
      password: "",
      password2: "",
      login_failed: false,
      passwordHidden: {
        default: false,
        type: Boolean,
      },
      accept: false,

      data: [],
    };
  },
  mounted() {
    this.email = "";
    this.password = "";
    // this.$bvModal.show("ModalApplication");
    this.show_note();
  },
  methods: {
    show_note() {
      $("#login-form").css("display", "none");
      this.$bvModal.show("ModalDataPrivacy");
    },
    proceed() {
      this.$bvModal.hide("ModalDataPrivacy");
      this.$bvModal.show("ModalApplication");
    },

    login() {
      var data = {
        client_id: 2,
        client_secret: "p12BgfjKL8E0WYn9mtUQCOCPc4wWaYkWGTS0mFoU",
        grant_type: "password",
        username: this.email,
        password: this.password,
      };

      this.$http
        .post("oauth/token", data)
        .then(function (response) {
          this.$auth.setToken(
            response.body.access_token,
            response.body.expires_in + Date.now()
          );
          this.$global.setEmail(this.email);
          window.location.href = "/";
        })
        .catch((response) => {
          this.$refs.email.focus();
          swal("Error", "You have entered incorrect credentials.", "error");
        });
    },
    test() {
      this.$http
        .get("http://localhost:8000/api/test")
        .then(function (response) {
          console.log(response.body);
        });
    },

    hidePassword() {
      this.passwordHidden = true;
    },
    showPassword() {
      this.passwordHidden = false;
    },
    back() {
      $("#login-form").css("display", "");
      this.$bvModal.hide("ModalDataPrivacy");
      //window.location.href = "/login";
    },
  },
};
</script>
<style>
.container {
  background-color: #fff;
  padding: 2em;
}
.container-div {
  display: flex;
  justify-content: center;
  flex-direction: column;
  width: 100%;
  height: 100%;
  align-items: center;
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);

  /* background-image: linear-gradient(#ce7171, #a50303); */
  background-image: linear-gradient(#fdfeff, #3681b3);
}
.application-content {
  width: 80%;
  border-radius: 20px;
  background-color: #fdfeff;
  box-shadow: 0 5px 5px rgba(0, 0, 0, 0.4);
  margin: 5em auto;
  display: flex;
}
.main-content {
  width: 50%;
  border-radius: 20px;
  box-shadow: 0 5px 5px rgba(0, 0, 0, 0.4);
  margin: 5em auto;
  display: flex;
}
.company__info {
  background-color: #ffffff66;
  border-top-left-radius: 20px;
  border-bottom-left-radius: 20px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  color: #fff;
  width: 100%;
}
.fa-android {
  font-size: 3em;
}
@media screen and (max-width: 640px) {
  .main-content {
    width: 90%;
  }
  .company__info {
    display: none;
  }
  .login_form {
    border-top-left-radius: 20px;
    border-bottom-left-radius: 20px;
  }
}
@media screen and (min-width: 642px) and (max-width: 800px) {
  .main-content {
    width: 70%;
  }
}
.row > h5 {
  color: #777575;
  margin-top: 20px;
}
.login_form {
  background-color: #fff;
  border-top-right-radius: 20px;
  border-bottom-right-radius: 20px;
  border-top: 1px solid #ccc;
  border-right: 1px solid #ccc;
}
form {
  padding: 0 2em;
}
.form__input {
  width: 100%;
  border: 0px solid transparent;
  border-radius: 0;
  border-bottom: 1px solid #aaa;
  padding: 1em 0.5em 0.5em;
  padding-left: 2em;
  outline: none;
  margin: 1.5em auto;
  transition: all 0.5s ease;
}
.form__input:focus {
  border-bottom-color: #1cc470;
  box-shadow: 0 0 5px rgba(51, 212, 105, 0.4);
  border-radius: 4px;
}
.btn {
  transition: all 0.5s ease;
  width: 50%;
  border-radius: 30px;
  color: #666363;
  font-weight: 600;
  background-color: #fff;
  border: 1px solid #1cc470;
  margin-top: 1.5em;
  margin-bottom: 1em;
  margin-left: 100px;
}
.btn:hover,
.btn:focus {
  background-color: #f30000;
  color: #fff;
}
.field-div {
  margin-bottom: 12px;
}
.span-click {
  cursor: pointer;
  border-radius: 0;
  background: #6b6868 !important;
  padding-left: 8px !important;
  padding-right: 8px !important;
}
.span-append {
  border-radius: 0;
  background: #6b6868 !important;
  padding-right: 0;
  padding-left: 0;
}
.input-icon {
  color: #ffffff !important;
  margin-left: 8px;
  margin-right: 8px;
}

.fields {
  background-color: #ffffff;
  font-size: small;
  color: #1b1b1b;
  border-radius: 0 0 0 0;
  border: 0;
  padding-right: 35px;
  padding-left: 12px !important;
}
.error-span,
.error-span2 {
  display: block;
  /* text-align: right; */
  color: red;
  margin-bottom: 12px;
  margin-top: -10px;
}
.error-span2 {
  margin-top: -19px;
}
.center-align {
  font-weight: bold;
  display: block;
  text-align: center;
  margin-top: 10px;
  margin-bottom: -18px;
}
.proceed-btn {
  background-color: #1cc470;
  width: 100px;
  border: none;
  color: #ffffff;
}
.back-btn {
  background-color: #588bad;
  width: 100px;
  border: none;
  color: #ffffff;
}
.login-btn {
  transition: all 0.5s ease;
  color: #ffffff;
  font-weight: bold;
  background-color: #588bad;
  border: 0;
  padding: 7px;
  border-radius: 0 0 0 0;
  width: 60%;
  margin-top: 10px;
}
.login-btn:hover,
.login-btn:focus {
  background-color: #286994;
  padding: 7px;
  border: 0;
  /* color: #19b45f; */
  color: #ffffff;
}
.signup-btn {
  transition: all 0.5s ease;
  color: #0c0a0a;
  font-weight: bold;
  background-color: #ffffff;
  border: 0;
  padding: 7px;
  border-radius: 0 0 0 0;
  width: 60%;
  margin-top: 10px;
}
.signup-btn:hover,
.signup-btn:focus {
  background-color: #f80606;
  padding: 7px;
  border: 0;
  color: #ffffff;
}
/* To align the label due to the float's effect */
.enhancements label {
  margin-top: 8px;
  float: right;
}

/* To put the form element to the left of the label */
.enhancements input {
  margin-right: 0.5rem;
  background: #1cc470;
  float: right;
}
.msg {
  margin-top: 15px;
}
.rowFields {
  margin-top: 15px;
}

.rowFields1 {
  margin: 20px;
  font-size: 12px;
}
.bolded {
  font-weight: bold;
}

.modal-header .close {
  display: none;
}
.file-upload-form,
.image-preview {
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  padding: 20px;
}
img.preview {
  min-width: 200px;
  min-height: 200px;
  max-width: 200px !important;
  max-height: 200px !important;
  background-color: white;
  border: 1px solid #ddd;
  padding: 5px;
}
.image-input {
}

.king {
  color: #048de9d8;
}
</style>
