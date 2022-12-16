<template>
  <div class="mx-auto col-md-12 modified-continer">
    <div class="elBG panel">
      <div class="panel-heading">
        <p class="elClr panel-title">
          Manage Users
          <b-button
            v-b-modal="'ModelAdd'"
            type="button"
            class="btn btn-success btn-labeled pull-right margin-right-10"
            v-if="roles.create_employee"
            >Add</b-button
          >
        </p>
      </div>

      <div class="elClr panel-body">
        <div>
          <b-row style="margin: 10px">
            <b-col md="5" class="my-1">
              <b-form-group label-cols-sm="2" label="Filter" class="mb-0">
                <b-input-group>
                  <b-form-input
                    v-model="tblFilter"
                    placeholder="Filter"
                  ></b-form-input>
                  <b-input-group-append>
                    <b-button :disabled="!tblFilter" @click="tblFilter = ''"
                      >Clear</b-button
                    >
                  </b-input-group-append>
                </b-input-group>
              </b-form-group>
            </b-col>
            <b-col md="5 " class="my-1"></b-col>

            <b-col md="2 " class="my-1">
              <b-form-group label-cols-sm="4" label="Show" class="mb-0">
                <b-form-select
                  v-model="perPage"
                  :options="pageOptions"
                ></b-form-select>
              </b-form-group>
            </b-col>
          </b-row>
          <b-table
            class="elClr"
            show-empty
            striped
            hover
            outlined
            :fields="fields"
            :items="items"
            :filter="tblFilter"
            :busy="tblisBusy"
            :current-page="currentPage"
            :per-page="perPage"
            :tbody-tr-class="tblRowClass"
            head-variant=" elClr"
            @filtered="onFiltered"
            @row-clicked="tblRowClicked"
          >
            <div slot="table-busy" class="text-center text-danger my-2">
              <b-spinner class="align-middle"></b-spinner>
              <strong>Loading...</strong>
            </div>
            <template slot="table-caption"></template>
          </b-table>
        </div>
      </div>
      <div class="elClr panel-footer">
        <div class="row" style="background-color: ; padding: 15px">
          <div class="col-md-8" style="background-color: ">
            <span class="elClr">{{ totalRows }} item/s found.</span>
          </div>

          <div class="col-md-4" style="background-color: ">
            <b-pagination
              v-model="currentPage"
              :total-rows="totalRows"
              :per-page="perPage"
              class="my-0 pull-right"
            ></b-pagination>
          </div>
        </div>
      </div>

      <!-- ModelAdd ---------------------------------------------------------------------------------------->
      <b-modal
        id="ModelAdd"
        :header-bg-variant="' elBG'"
        :header-text-variant="' elClr'"
        :body-bg-variant="' elBG'"
        :body-text-variant="' elClr'"
        :footer-bg-variant="' elBG'"
        :footer-text-variant="' elClr'"
        size="xl"
        title="Add Employee"
        @ok="handleOk"
      >
        <!-- form -->
        <div class="rowFields mx-auto row">
          <div class="col-lg-3">
            <p class="textLabel">Branch:</p>
          </div>
          <div class="col-lg-9">
            <model-list-select
              :list="branches"
              v-model="item_add.branch_id"
              option-value="id"
              option-text="name"
              placeholder="Select Branch"
              name="branches"
              v-validate="'required'"
            ></model-list-select>
            <small class="text-danger pull-left" v-show="errors.has('branches')"
              >Branch is required.</small
            >
          </div>
        </div>

        <div class="rowFields mx-auto row">
          <div class="col-lg-3">
            <p class="textLabel">First Name:</p>
          </div>
          <div class="col-lg-9">
            <input
              type="text"
              name="first_name"
              class="form-control"
              v-b-tooltip.hover
              title="First name of the employee"
              v-validate="'required'"
              v-model.trim="item_add.first_name"
              autocomplete="off"
            />
            <small
              class="text-danger pull-left"
              v-show="errors.has('first_name')"
              >First name is required.</small
            >
          </div>
        </div>
        <div class="rowFields mx-auto row">
          <div class="col-lg-3">
            <p class="textLabel">Middle Name:</p>
          </div>
          <div class="col-lg-9">
            <input
              type="text"
              name="middle_name"
              class="form-control"
              v-b-tooltip.hover
              title="Middle Name of the Employee"
              v-validate="'required'"
              v-model.trim="item_add.middle_name"
              autocomplete="off"
            />
            <small
              class="text-danger pull-left"
              v-show="errors.has('middle_name')"
              >Middle name is required.</small
            >
          </div>
        </div>
        <div class="rowFields mx-auto row">
          <div class="col-lg-3">
            <p class="textLabel">Last Name:</p>
          </div>
          <div class="col-lg-9">
            <input
              type="text"
              name="last_name"
              class="form-control"
              v-b-tooltip.hover
              title="Last name of the Employee"
              v-validate="'required'"
              v-model.trim="item_add.last_name"
              autocomplete="off"
            />
            <small
              class="text-danger pull-left"
              v-show="errors.has('last_name')"
              >Last name is required.</small
            >
          </div>
        </div>

        <!-- /form -->
        <template slot="modal-footer" slot-scope="{}">
          <b-button
            size="sm"
            variant="success"
            @click="btnAdd()"
            v-if="roles.create_employee"
            >Add</b-button
          >
        </template>
      </b-modal>
      <!-- End ModelAdd -->

      <!-- modalEdit ---------------------------------------------------------------------------------------->
      <b-modal
        id="modalEdit"
        :header-bg-variant="' elBG'"
        :header-text-variant="' elClr'"
        :body-bg-variant="' elBG'"
        :body-text-variant="' elClr'"
        :footer-bg-variant="' elBG'"
        :footer-text-variant="' elClr'"
        size="xl"
        title="Update Employee"
        @ok="handleOk"
      >
        <!-- form -->
        <div class="rowFields mx-auto row">
          <div class="col-lg-3">
            <p class="textLabel">Branch:</p>
          </div>
          <div class="col-lg-9">
            <model-list-select
              :list="branches"
              v-model="item_edit.branch_id"
              option-value="id"
              option-text="name"
              placeholder="Select Branch"
              name="branches"
              v-validate="'required'"
            ></model-list-select>
            <small class="text-danger pull-left" v-show="errors.has('branches')"
              >Branch is required.</small
            >
          </div>
        </div>

        <div class="rowFields mx-auto row">
          <div class="col-lg-3">
            <p class="textLabel">Username:</p>
          </div>
          <div class="col-lg-9">
            <input
              type="text"
              name="first_name"
              class="form-control"
              v-b-tooltip.hover
              title="First name of the employee"
              v-validate="'required'"
              v-model.trim="item_edit.email"
              autocomplete="off"
            />
            <small
              class="text-danger pull-left"
              v-show="errors.has('first_name')"
              >First name is required.</small
            >
          </div>
        </div>
        <div class="rowFields mx-auto row">
          <div class="col-lg-3">
            <p class="textLabel">First Name:</p>
          </div>
          <div class="col-lg-9">
            <input
              type="text"
              name="first_name"
              class="form-control"
              v-b-tooltip.hover
              title="First name of the employee"
              v-validate="'required'"
              v-model.trim="item_edit.first_name"
              autocomplete="off"
            />
            <small
              class="text-danger pull-left"
              v-show="errors.has('first_name')"
              >First name is required.</small
            >
          </div>
        </div>
        <div class="rowFields mx-auto row">
          <div class="col-lg-3">
            <p class="textLabel">Middle Name:</p>
          </div>
          <div class="col-lg-9">
            <input
              type="text"
              name="middle_name"
              class="form-control"
              v-b-tooltip.hover
              title="Middle Name of the Employee"
              v-validate="'required'"
              v-model.trim="item_edit.middle_name"
              autocomplete="off"
            />
            <small
              class="text-danger pull-left"
              v-show="errors.has('middle_name')"
              >Middle name is required.</small
            >
          </div>
        </div>
        <div class="rowFields mx-auto row">
          <div class="col-lg-3">
            <p class="textLabel">Last Name:</p>
          </div>
          <div class="col-lg-9">
            <input
              type="text"
              name="last_name"
              class="form-control"
              v-b-tooltip.hover
              title="Last name of the Employee"
              v-validate="'required'"
              v-model.trim="item_edit.last_name"
              autocomplete="off"
            />
            <small
              class="text-danger pull-left"
              v-show="errors.has('last_name')"
              >Last name is required.</small
            >
          </div>
        </div>

        <!-- /form -->
        <template slot="modal-footer" slot-scope="{}">
          <b-button
            size="sm"
            variant="warning"
            v-b-modal="'ModalRole'"
            v-if="roles.update_employee"
            >Role</b-button
          >
          <b-button
            size="sm"
            variant="warning"
            v-b-modal="'ModalResetPassword'"
            v-if="roles.update_employee"
            >Reset Password</b-button
          >

          <b-button
            size="sm"
            variant="success"
            @click="btnUpdate()"
            v-if="roles.update_employee"
            >Update</b-button
          >
          <b-button
            size="sm"
            variant="danger"
            @click="btnDelete()"
            v-if="roles.delete_employee"
            >Delete</b-button
          >
        </template>
      </b-modal>
      <!-- End modalEdit -->

      <!-- ModalResetPassword ---------------------------------------------------------------------------------------->
      <b-modal
        id="ModalResetPassword"
        :header-bg-variant="' elBG'"
        :header-text-variant="' elClr'"
        :body-bg-variant="' elBG'"
        :body-text-variant="' elClr'"
        :footer-bg-variant="' elBG'"
        :footer-text-variant="' elClr'"
        size="lg"
        ok-only
      >
        <div class="rowFields mx-auto row">
          <div class="col-lg-3">
            <p class="textLabel">New password:</p>
          </div>
          <div class="col-lg-9">
            <input
              type="password"
              class="form-control"
              v-b-tooltip.hover
              placeholder="New password"
              v-model.trim="item_edit.password"
            />
          </div>
        </div>

        <div class="rowFields mx-auto row">
          <div class="col-lg-3">
            <p class="textLabel">Re-type new password:</p>
          </div>
          <div class="col-lg-9">
            <input
              type="password"
              class="form-control"
              v-b-tooltip.hover
              placeholder="re-type new password"
              v-model.trim="item_edit.repassword"
            />
          </div>
        </div>

        <template slot="modal-footer" slot-scope="{}">
          <b-button
            size="sm"
            variant="success"
            @click="btnSubmitResetPassword()"
            v-if="roles.update_employee"
            >Update</b-button
          >
          <b-button
            size="sm"
            variant="danger"
            @click="$bvModal.hide('ModalResetPassword')"
            >Cancel</b-button
          >
        </template>
      </b-modal>
      <!-- End ModalResetPassword -->
      <!-- ModalRole ---------------------------------------------------------------------------------------->
      <b-modal
        id="ModalRole"
        :header-bg-variant="' elBG'"
        :header-text-variant="' elClr'"
        :body-bg-variant="' elBG'"
        :body-text-variant="' elClr'"
        :footer-bg-variant="' elBG'"
        :footer-text-variant="' elClr'"
        size="xl"
        ok-only
      >
        <template v-slot:modal-title> Manage Role </template>

        <!-- employee -->
        <div class="rowFields1 row role-container" style>
          <div class="col-lg-3">
            <b>Employee:</b>
          </div>

          <div class="col-lg-2">
            Create:
            <p-check
              class="checkboxStyle p-switch p-fill"
              color="success"
              v-model="editRoles.roles.create_employee"
            ></p-check>
          </div>

          <div class="col-lg-2">
            Update:
            <p-check
              class="checkboxStyle p-switch p-fill"
              color="success"
              v-model="editRoles.roles.update_employee"
            ></p-check>
          </div>
          <div class="col-lg-2">
            Delete:
            <p-check
              class="checkboxStyle p-switch p-fill"
              color="success"
              v-model="editRoles.roles.delete_employee"
            ></p-check>
          </div>

          <div class="col-lg-2"></div>
        </div>
        <hr />

        <!-- Branch -->
        <div class="rowFields1 row role-container" style>
          <div class="col-lg-3">
            <b>Branch:</b>
          </div>

          <div class="col-lg-2">
            Create:
            <p-check
              class="checkboxStyle p-switch p-fill"
              color="success"
              v-model="editRoles.roles.create_branch"
            ></p-check>
          </div>

          <div class="col-lg-2">
            Update:
            <p-check
              class="checkboxStyle p-switch p-fill"
              color="success"
              v-model="editRoles.roles.update_branch"
            ></p-check>
          </div>
          <div class="col-lg-2">
            Delete:
            <p-check
              class="checkboxStyle p-switch p-fill"
              color="success"
              v-model="editRoles.roles.delete_branch"
            ></p-check>
          </div>

          <div class="col-lg-2"></div>
        </div>
        <hr />

        <!-- Application -->
        <div class="rowFields1 row role-container" style>
          <div class="col-lg-3">
            <b>Application:</b>
          </div>

          <div class="col-lg-2">
            Update:
            <p-check
              class="checkboxStyle p-switch p-fill"
              color="success"
              v-model="editRoles.roles.update_application"
            ></p-check>
          </div>
          <div class="col-lg-2">
            Delete:
            <p-check
              class="checkboxStyle p-switch p-fill"
              color="success"
              v-model="editRoles.roles.delete_application"
            ></p-check>
          </div>
          <div class="col-lg-2">
            Approve:
            <p-check
              class="checkboxStyle p-switch p-fill"
              color="success"
              v-model="editRoles.roles.approve_application"
            ></p-check>
          </div>
          <div class="col-lg-2">
            Reject:
            <p-check
              class="checkboxStyle p-switch p-fill"
              color="success"
              v-model="editRoles.roles.reject_application"
            ></p-check>
          </div>
        </div>
        <hr />

        <!-- Admin -->
        <div class="rowFields1 row role-container" style>
          <div class="col-lg-3">
            <b>Admin:</b>
          </div>

          <div class="col-lg-2">
            <p-check
              class="checkboxStyle p-switch p-fill"
              color="success"
              v-model="editRoles.roles.admin"
            ></p-check>
          </div>
        </div>
        <br />
        <!-- Role -->
        <div class="rowFields1 row role-container" style>
          <div class="col-lg-3">
            <b>Sub-admin:</b>
          </div>

          <div class="col-lg-2">
            <p-check
              class="checkboxStyle p-switch p-fill"
              color="success"
              v-model="editRoles.roles.subadmin"
            ></p-check>
          </div>
        </div>

        <template slot="modal-footer" slot-scope="{}">
          <b-button
            size="sm"
            variant="success"
            @click="btnUpdateRoles()"
            v-if="roles.update_employee"
            >Update</b-button
          >
        </template>
      </b-modal>
      <!-- End ModalRole -->
    </div>
  </div>
</template>
<script>
import { ModelListSelect } from "vue-search-select";
import PrettyCheck from "pretty-checkbox-vue/check";

import swal from "sweetalert";

export default {
  components: {
    "model-list-select": ModelListSelect,
    "p-check": PrettyCheck,
  },
  data() {
    return {
      tblisBusy: true,
      fields: [
        { key: "user.id", label: "ID", sortable: true },
        { key: "user.email", label: "Username", sortable: true },
        {
          key: "Name",
          label: "Employee Name",
          formatter: (value, key, item) => {
            if (item.middle_name == null) item.middle_name = "";
            return (
              item.first_name + " " + item.middle_name + " " + item.last_name
            );
          },
          sortable: true,
        },
        { key: "branch.name", label: "Branch", sortable: true },
      ],
      items: [],
      tblFilter: null,
      totalRows: 1,
      currentPage: 2,
      perPage: 10,
      pageOptions: [10, 25, 50, 100],
      item_add: {
        branch_id: "",
        first_name: "",
        middle_name: "",
        last_name: "",
      },
      item_edit: {
        branch_id: "",
        first_name: "",
        middle_name: "",
        last_name: "",
        password: "",
        repassword: "",
      },
      editRoles: {
        roles: {
          create_employee: false,
          update_employee: false,
          delete_employee: false,

          create_branch: false,
          update_branch: false,
          delete_branch: false,

          view_application: false,
          update_application: false,
          delete_application: false,
          approve_application: false,
          reject_application: false,

          admin: false,
          subadmin: false,
        },
        user: {},
      },
      roles: [],
      branches: [],
    };
  },
  beforeCreate() {
    this.$global.loadJS();
  },
  created() {
    this.roles = this.$global.getRoles();
    this.branches = this.$global.getBranch();
    this.tblisBusy = false;
    this.totalRows = this.items.length;
    this.user = this.$global.getUser();
    this.loadEmployees();
  },
  mounted() {
    this.load();
  },
  updated() {},
  methods: {
    loadEmployees() {
      this.$http.get("api/Employee").then(function (response) {
        this.items = response.body;
        this.totalRows = this.items.length;
        this.tblisBusy = false;
      });
    },
    load() {
      this.$nextTick(function () {
        setTimeout(function () {}, 100);
      });

      this.$http.get("api/Branch").then(function (response) {
        this.branches = response.body;
        var temp = {
          id: 0,
          name: "All(can view all applications in all branches)",
        };
        this.branches.unshift(temp);
      });
    },
    tblRowClass(item, type) {
      if (!item) return;
      else return "elClr cursorPointer";
    },
    tblHeadClass(item, type) {
      if (!item) return;
      else {
        return "elClr";
      }
    },
    onFiltered(filteredItems) {
      this.totalRows = filteredItems.length;
      this.currentPage = 1;
    },
    tblRowClicked(item, index, event) {
      console.log(item);
      this.$bvModal.show("modalEdit");
      this.item_edit = item;
      this.editRoles.roles = item.roleList;
      this.item_edit.email = item.user.email;
    },
    handleOk(bvModalEvt) {
      bvModalEvt.preventDefault();
    },
    btnSubmitResetPassword() {
      if (this.item_edit.password == this.item_edit.repassword) {
        swal({
          title: "Are you sure?",
          text: "Do you really want to reset this password?",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        }).then((update) => {
          this.$root.$emit("pageLoading");
          this.tblisBusy = true;
          ModalResetPassword;
          this.$bvModal.hide("ModalResetPassword");
          this.$bvModal.hide("ModelAdd");
          if (update) {
            this.$http
              .post("api/user/ResetPassword", this.item_edit)
              .then((response) => {
                console.log(response.body);
                this.$root.$emit("pageLoaded");
                swal("Update!", "Update successfully", "success");
                this.tblisBusy = false;
              })
              .catch((response) => {
                this.$root.$emit("pageLoaded");
                swal({
                  title: "Error",
                  text: response.body.error,
                  icon: "error",
                  dangerMode: true,
                });
              });
          }
        });
      } else {
        swal("Password not match", "", "info");
      }
    },
    btnUpdateRoles() {
      // console.log(this.item_edit.user.user_id);
      swal({
        title: "Are you sure?",
        text: "",
        icon: "warning",
        buttons: ["No", "Yes"],
        dangerMode: true,
      }).then((update) => {
        if (update) {
          this.$root.$emit("pageLoading");
          this.editRoles.user = this.item_edit.user;

          this.$http
            .post("api/user/updateRoles", this.editRoles)
            .then((response) => {
              console.log(response.body);
              this.$root.$emit("pageLoaded");
              this.items = response.body;
              swal("Updated", "", "success");
              this.$bvModal.hide("ModalRole");
            })
            .catch((response) => {
              this.$root.$emit("pageLoaded");
              swal({
                title: "Error",
                text: response.body.error,
                icon: "error",
                dangerMode: true,
              });
            });
        }
      });
    },
    btnAdd() {
      this.$validator.validateAll().then((result) => {
        if (result) {
          this.$root.$emit("pageLoading");
          this.item_add.user_id = this.user.id;
          this.item_add.user_name = this.user.email;
          this.$http
            .post("api/Employee", this.item_add)
            .then((response) => {
              console.log(response.body);
              this.$root.$emit("pageLoaded");
              console.log(response.body);
              swal("Notification", "Added successfully", "success");

              this.$bvModal.hide("ModelAdd");
              this.items = response.body;
              this.totalRows = this.items.length;
              this.item_add = {
                branch_id: "",
                first_name: "",
                middle_name: "",
                last_name: "",
              };
            })
            .catch((response) => {
              this.$root.$emit("pageLoaded");
              swal({
                title: "Error",
                text: response.body.error,
                icon: "error",
                dangerMode: true,
              });
            });
        }
      });
    },
    btnUpdate() {
      console.log(this.item_edit);
      this.$validator.validateAll().then((result) => {
        if (result) {
          swal({
            title: "Are you sure?",
            text: "Do you want to Update this?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          }).then((update) => {
            if (update) {
              this.tblisBusy = true;
              // this.$root.$emit("pageLoading");
              this.item_edit.user_id = this.user.id;
              this.item_edit.user_name = this.user.email;
              console.log(this.item_edit);
              this.$http
                .post("api/UpdateEmployee", this.item_edit)
                .then((response) => {
                  console.log(response.body);
                  this.$root.$emit("pageLoaded");
                  this.items = response.body;
                  this.totalRows = this.items.length;
                  swal("Update!", "Update successfully", "success");
                  this.$bvModal.hide("modalEdit");
                  this.tblisBusy = false;
                })
                .catch((response) => {
                  console.log(response.body);
                  this.$root.$emit("pageLoaded");
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
    btnDelete() {
      swal({
        title: "Are you sure?",
        text: "Do you really want to delete this item permanently",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
          // this.$root.$emit("pageLoading");
          this.items = [];
          this.tblisBusy = true;
          this.$http
            .delete("api/Employee/" + this.item_edit.id)
            .then((response) => {
              // console.log(response.body);
              this.$root.$emit("pageLoaded");
              this.$bvModal.hide("modalEdit");
              swal("Deleted!", "Item has been deleted", "success").then(
                (value) => {
                  this.items = response.body;
                  this.totalRows = this.items.length;
                  this.tblisBusy = false;
                }
              );
            })
            .catch((response) => {
              this.$root.$emit("pageLoaded");
              swal({
                title: "Error",
                text: response.body.error,
                icon: "error",
                dangerMode: true,
              });
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
.modal-content,
modal-header {
  border: 1px solid red;
}
</style>
