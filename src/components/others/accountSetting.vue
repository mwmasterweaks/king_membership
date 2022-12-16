<template>
  <div class="mx-auto col-md-10">
    <div class="elBG panel">
      <div class="panel-heading">
        <h6 class="elClr panel-title">Account Settings</h6>
      </div>

      <div class="elClr panel-body">
        <div class="rowFields mx-auto row">
          <div class="col-lg-3">
            <p class="textLabel">Name:</p>
          </div>
          <div class="col-lg-9">
            {{ user.employee.first_name }} {{ user.employee.middle_name }}
            {{ user.employee.last_name }}
          </div>
        </div>

        <div class="rowFields mx-auto row">
          <div class="col-lg-3">
            <p class="textLabel">Username:</p>
          </div>
          <div class="col-lg-9">
            <input
              type="text"
              name="email"
              class="form-control"
              v-b-tooltip.hover
              title="Input the Email address of the user"
              placeholder="Email Address"
              v-validate="{ required: true }"
              v-model.trim="user.email"
              autocomplete="off"
            />
            <small class="text-danger pull-left" v-show="errors.has('email')"
              >Username is required.</small
            >
          </div>
        </div>

        <div class="rowFields mx-auto row">
          <div class="col-lg-3">
            <p class="textLabel">Password:</p>
          </div>
          <div class="col-lg-9">
            <input
              type="password"
              name="password"
              ref="password"
              class="form-control"
              v-b-tooltip.hover
              title="Input the password of the user"
              placeholder="Password"
              autocomplete="off"
              v-validate="{ min: 8 }"
              v-model.trim="user.password"
            />
            <small
              class="text-danger pull-left"
              v-show="errors.has('password')"
              >{{ errors.first("password") }}</small
            >
          </div>
        </div>
        <div class="rowFields mx-auto row">
          <div class="col-lg-3">
            <p class="textLabel">Re-type Password:</p>
          </div>
          <div class="col-lg-9">
            <input
              type="password"
              name="retype"
              class="form-control"
              v-b-tooltip.hover
              title="Please re-type the pasword of the user"
              placeholder="Re-type password"
              v-validate="'confirmed:password'"
              v-model.trim="user.password2"
            />
            <small class="text-danger pull-left" v-show="errors.has('retype')"
              >The password confirmation does not match.</small
            >
          </div>
        </div>
      </div>
      <div class="panel-footer">
        <div class="heading-elements">
          <button
            type="button"
            class="btn btn-success btn-labeled pull-right"
            v-on:click="updateUser"
          >
            Update
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import swal from "sweetalert";

export default {
  data() {
    return {
      user: {
        name: "",
        email: "",
        password: "",
        password2: "",
      },
    };
  },
  beforeCreate() {
    this.$global.loadJS();
  },
  created() {
    this.user = this.$global.getUser();
    console.log(this.user);
  },
  mounted() {
    this.load();
  },
  updated() {},
  methods: {
    load() {},
    updateUser() {
      this.$validator.validateAll().then((result) => {
        if (result) {
          swal({
            title: "Are you sure?",
            text: "Do you want to Update this user?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          }).then((update) => {
            if (update) {
              this.$http
                .post("api/UpdateUser", this.user)
                .then((response) => {
                  this.$global.setUser(this.user);

                  this.$global.elBG(this.user.elBG);
                  this.$global.elClr(this.user.elClr);
                  swal("Update!", "Update successfully", "success");
                  this.$bvModal.hide("modalEdit");
                })
                .catch((response) => {
                  swal({
                    title: "Error",
                    text: response.body.error,
                    icon: "error",
                    dangerMode: true,
                  });
                });
            }
          });
        }
      });
    },
  },
};
</script>
<style scoped>
.textLabel {
  margin-top: 9px;
  font-size: 15px;
}
.rowFields {
  margin-top: 15px;
}
</style>
