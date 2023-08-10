<template>
  <div class="mx-auto col-md-12 modified-continer">
    <div class="elBG panel">
      <div class="panel-heading">
        <p class="elClr panel-title">
          Manage Branch
          <b-button
            v-b-modal="'ModelAdd'"
            type="button"
            class="btn btn-success btn-labeled pull-right margin-right-10"
            v-if="roles.create_branch"
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
        title="Add Branch"
        @ok="handleOk"
      >
        <!-- form -->
        <div class="rowFields mx-auto row">
          <div class="col-lg-3">
            <p class="textLabel">Branch Name:</p>
          </div>
          <div class="col-lg-9">
            <input
              type="text"
              name="name"
              ref="name"
              class="form-control"
              v-b-tooltip.hover
              title="Name of Branch"
              placeholder="Branch name"
              v-validate="'required'"
              v-model.trim="item_add.name"
              autocomplete="off"
              autofocus="on"
            />
            <small class="text-danger pull-left" v-show="errors.has('name')"
              >Branch Name is required.</small
            >
          </div>
        </div>

        <div class="rowFields mx-auto row">
          <div class="col-lg-3">
            <p class="textLabel">Branch Description:</p>
          </div>
          <div class="col-lg-9">
            <input
              type="text"
              name="desc"
              class="form-control"
              v-b-tooltip.hover
              title="Description of the Branch"
              v-validate="'required'"
              placeholder="Description"
              v-model.trim="item_add.description"
              autocomplete="off"
            />
            <small class="text-danger pull-left" v-show="errors.has('desc')"
              >Branch Description is required.</small
            >
          </div>
        </div>
        <div class="rowFields mx-auto row">
          <div class="col-lg-3">
            <p class="textLabel">Branch Code:</p>
          </div>
          <div class="col-lg-9">
            <input
              type="text"
              name="branchCode"
              class="form-control"
              v-b-tooltip.hover
              title="Branch Code for identity of the account"
              v-validate="'required'"
              placeholder="Branch Code"
              v-model.trim="item_add.code"
              autocomplete="off"
            />
            <small class="text-danger pull-left" v-show="errors.has('branchCode')"
              >Branch Code is required.</small
            >
          </div>
        </div>

        <div class="rowFields mx-auto row">
          <div class="col-lg-3">
            <p class="textLabel">Branch Email Address:</p>
          </div>
          <div class="col-lg-9">
            <input
              type="text"
              name="email"
              class="form-control"
              v-b-tooltip.hover
              title="Email of the Branch"
              v-validate="'required'"
              placeholder="Email Address"
              v-model.trim="item_add.email"
              autocomplete="off"
            />
            <small class="text-danger pull-left" v-show="errors.has('email')"
              >Email Address is required.</small
            >
          </div>
        </div>

        <div class="rowFields mx-auto row">
          <div class="col-lg-3">
            <p class="textLabel">Branch Contact Number:</p>
          </div>
          <div class="col-lg-9">
            <input
              type="text"
              name="contact"
              class="form-control"
              v-b-tooltip.hover
              title="Contact Number of the Branch"
              v-validate="'required'"
              placeholder="Contact Number"
              v-model.trim="item_add.contact"
              autocomplete="off"
            />
            <small class="text-danger pull-left" v-show="errors.has('contact')"
              >Branch Contact Number is required.</small
            >
          </div>
        </div>

        <!-- /form -->
        <template slot="modal-footer" slot-scope="{}">
          <b-button
            size="sm"
            variant="success"
            @click="btnAdd()"
            v-if="roles.create_branch"
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
        title="Update Branch"
        @ok="handleOk"
      >
        <!-- form -->
        <div class="rowFields mx-auto row">
          <div class="col-lg-3">
            <p class="textLabel">Name:</p>
          </div>
          <div class="col-lg-9">
            <input
              type="text"
              name="name"
              ref="name"
              class="form-control"
              v-b-tooltip.hover
              title="Name of Branch"
              placeholder="Branch name"
              v-validate="'required'"
              v-model.trim="item_edit.name"
              autocomplete="off"
              autofocus="on"
            />
            <small class="text-danger pull-left" v-show="errors.has('name')"
              >Branch Name is required.</small
            >
          </div>
        </div>

        <div class="rowFields mx-auto row">
          <div class="col-lg-3">
            <p class="textLabel">Description:</p>
          </div>
          <div class="col-lg-9">
            <input
              type="text"
              name="desc"
              class="form-control"
              v-b-tooltip.hover
              title="Description of the Branch"
              v-validate="'required'"
              placeholder="Description"
              v-model.trim="item_edit.description"
              autocomplete="off"
            />
            <small class="text-danger pull-left" v-show="errors.has('desc')"
              >Description is required.</small
            >
          </div>
        </div>
        <div class="rowFields mx-auto row">
          <div class="col-lg-3">
            <p class="textLabel">Branch Code:</p>
          </div>
          <div class="col-lg-9">
            <input
              type="text"
              name="branchCode"
              class="form-control"
              v-b-tooltip.hover
              title="Branch Code for identity of the account"
              v-validate="'required'"
              placeholder="Branch Code"
              v-model.trim="item_edit.code"
              autocomplete="off"
            />
            <small class="text-danger pull-left" v-show="errors.has('branchCode')"
              >Branch Code is required.</small
            >
          </div>
        </div>
        <div class="rowFields mx-auto row">
          <div class="col-lg-3">
            <p class="textLabel">Branch Email Address:</p>
          </div>
          <div class="col-lg-9">
            <input
              type="text"
              name="email"
              class="form-control"
              v-b-tooltip.hover
              title="Email of the Branch"
              v-validate="'required'"
              placeholder="Email Address"
              v-model.trim="item_edit.email"
              autocomplete="off"
            />
            <small class="text-danger pull-left" v-show="errors.has('email')"
              >Email Address is required.</small
            >
          </div>
        </div>

        <div class="rowFields mx-auto row">
          <div class="col-lg-3">
            <p class="textLabel">Branch Contact Number:</p>
          </div>
          <div class="col-lg-9">
            <input
              type="text"
              name="contact"
              class="form-control"
              v-b-tooltip.hover
              title="Contact Number of the Branch"
              v-validate="'required'"
              placeholder="Contact Number"
              v-model.trim="item_edit.contact"
              autocomplete="off"
            />
            <small class="text-danger pull-left" v-show="errors.has('contact')"
              >Branch Contact Number is required.</small
            >
          </div>
        </div>
        <!-- /form -->
        <template slot="modal-footer" slot-scope="{}">
          <b-button
            size="sm"
            variant="success"
            @click="btnUpdate()"
            v-if="roles.update_branch"
            >Update</b-button
          >
          <b-button
            size="sm"
            variant="danger"
            @click="btnDelete()"
            v-if="roles.delete_branch"
            >Delete</b-button
          >
        </template>
      </b-modal>
      <!-- End modalEdit -->
    </div>
  </div>
</template>
<script>
import { ModelListSelect } from "vue-search-select";
import swal from "sweetalert";

export default {
  components: {
    "model-list-select": ModelListSelect,
  },
  data() {
    return {
      tblisBusy: true,
      fields: [
        { key: "name", sortable: true },
        { key: "description", label: "Description", sortable: true },
        { key: "code", label: "Code", sortable: true },
        { key: "email", label: "Email", sortable: true },
        { key: "contact", label: "Contact", sortable: true },
        { key: "created_at", sortable: true },
        { key: "updated_at", sortable: true },
      ],
      items: [],
      tblFilter: null,
      totalRows: 1,
      currentPage: 1,
      perPage: 10,
      pageOptions: [10, 25, 50, 100],
      item_add: {
        name: "",
        description: "",
        code: "",
        email: "",
        contact: "",
      },
      item_edit: {
        name: "",
        description: "",
        code: "",
        email: "",
        contact: "",
      },
      roles: [],
      user: null
    };
  },
  beforeCreate() {
    this.$global.loadJS();
  },
  created() {
    this.roles = this.$global.getRoles();
    this.items = this.$global.getBranch();
    this.tblisBusy = false;
    this.totalRows = this.items.length;
    this.user = this.$global.getUser();
  },
  mounted() {
    this.load();
  },
  updated() {},
  methods: {
    load() {
      this.$nextTick(function () {
        setTimeout(function () {}, 100);
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
      this.$bvModal.show("modalEdit");
      this.item_edit = item;
    },
    handleOk(bvModalEvt) {
      bvModalEvt.preventDefault();
    },
    btnUpdate() {
      this.$validator.validateAll().then((result) => {
        if (result) {
          swal({
            title: "Are you sure?",
            text: "Do you want to Update this item?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          }).then((update) => {
            this.tblisBusy = true;
            if (update) {
              // var tempdata = {
              //   name: this.item_edit.name,
              //   description: this.item_edit.description,
              //   email: this.item_edit.email,
              //   contact: this.item_edit.contact,
              //   user_id: this.user.id,
              //   id: this.item_edit.id,
              // };
              this.item_edit.user_id = this.user.id;
              console.log(this.item_edit);
              this.$http
                .post("api/UpdateBranch", this.item_edit)
                .then((response) => {
                  console.log(response.body);
                  this.$global.setBranch(response.body);
                  this.items = response.body;
                  this.totalRows = this.items.length;
                  swal("Update!", "Update successfully", "success");
                  this.$bvModal.hide("modalEdit");
                  this.tblisBusy = false;
                })
                .catch((response) => {
                  console.log(response.body);
                  swal({
                    title: "Error",
                    text: response.body.error,
                    icon: "error",
                    dangerMode: true,
                  }).then((value) => {
                    if (value) {
                    }
                  });
                });
            }
          });
        }
      });
    },
    btnAdd() {
      this.$validator.validateAll().then((result) => {
        if (result) {
          this.item_add.user_id = this.user.id;
          this.$http
            .post("api/Branch", this.item_add)
            .then((response) => {
              console.log(response.body);
              swal("Notification", "Added successfully", "success");
              this.$global.setBranch(response.body);
              this.items = response.body;
              this.totalRows = this.items.length;
              this.item_add = {
                name: "",
                description: "",
                email: "",
                contact: "",
              };

              this.$bvModal.hide("ModelAdd");
            })
            .catch((response) => {
              swal({
                title: "Error",
                text: response.body.error,
                icon: "error",
                dangerMode: true,
              }).then((value) => {
                if (value) {
                  this.$refs.name.focus();
                }
              });
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
          this.items = [];
          this.tblisBusy = true;
          this.$http
            .delete("api/Branch/" + this.item_edit.id)
            .then((response) => {
              this.$bvModal.hide("modalEdit");
              swal("Deleted!", "Item has been deleted", "success").then(
                (value) => {
                  this.$global.setBranch(response.body);
                  this.items = response.body;
                  this.totalRows = this.items.length;
                  this.tblisBusy = false;
                }
              );
            })
            .catch((response) => {
              swal({
                title: "Error",
                text: response.body.error,
                icon: "error",
                dangerMode: true,
              }).then((value) => {
                if (value) {
                }
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
