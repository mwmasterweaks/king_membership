<template>
  <div class="mx-auto col-md-10">
    <div class="elBG panel">
      <div class="panel-heading">
        <h6 class="elClr panel-title">My profile</h6>
      </div>

      <div class="elClr panel-body">
        <div class="rowFields mx-auto row">
          <div class="col-lg-3">First Name:</div>
          <div class="col-lg-9">
            <b>
              <span>{{ authenticatedUser.employee.first_name }}</span>
            </b>
          </div>
        </div>
        <br />
        <div class="rowFields mx-auto row">
          <div class="col-lg-3">Middle Name:</div>
          <div class="col-lg-9">
            <b>
              <span>{{ authenticatedUser.employee.middle_name }}</span>
            </b>
          </div>
        </div>
        <br />
        <div class="rowFields mx-auto row">
          <div class="col-lg-3">Last Name:</div>
          <div class="col-lg-9">
            <b>
              <span>{{ authenticatedUser.employee.last_name }}</span>
            </b>
          </div>
        </div>
        <br />
      </div>
      <div class="panel-footer">
        <div class="heading-elements"></div>
      </div>
    </div>
  </div>
</template>
<script>
import swal from "sweetalert";
export default {
  data() {
    return {
      authenticatedUser: {}
    };
  },
  beforeCreate() {
    this.$global.loadJS();
  },
  created() {
    this.authenticatedUser = this.$global.getUser();
    console.log(this.authenticatedUser);
  },
  mounted() {
    this.load();
  },
  updated() {},
  methods: {
    load() {
      // document.getElementById(
      //   "bgColor"
      // ).style.color = this.authenticatedUser.elBG;
    }
  }
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
