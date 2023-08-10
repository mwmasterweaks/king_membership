<template>
  <div class="mx-auto col-md-12 modified-continer">
    <div class="elBG panel">
      <div class="panel-heading">
        <p class="elClr panel-title">
          Manage Membership Type
          <b-button
            v-b-modal="'ModelAdd'"
            type="button"
            class="btn btn-success btn-labeled pull-right margin-right-10"
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
        title="Add Membership Type"
        @ok="handleOk"
      >
        <!-- form -->
        <div class="rowFields mx-auto row">
          <div class="col-lg-3">
            <p class="textLabel">Membership Type Name:</p>
          </div>
          <div class="col-lg-9">
            <input
              type="text"
              name="name"
              ref="name"
              class="form-control"
              v-b-tooltip.hover
              title="Membership Type"
              placeholder="Membership Type name"
              v-validate="'required'"
              v-model.trim="item_add.name"
              autocomplete="off"
              autofocus="on"
            />
            <small class="text-danger pull-left" v-show="errors.has('name')"
              >Membership Type Name is required.</small
            >
          </div>
        </div>

        <div class="rowFields mx-auto row">
          <div class="col-lg-3">
            <p class="textLabel">Equivalent Code:</p>
          </div>
          <div class="col-lg-9">
            <input
              type="text"
              name="code"
              class="form-control"
              v-b-tooltip.hover
              title="Equivalent Code"
              v-validate="'required'"
              placeholder="Code"
              v-model.trim="item_add.code"
              autocomplete="off"
            />
            <small class="text-danger pull-left" v-show="errors.has('code')"
              >Code is required.</small
            >
          </div>
        </div>
        <!-- /form -->
        <template slot="modal-footer" slot-scope="{}">
          <b-button
            size="sm"
            variant="success"
            @click="btnAdd()"
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
        title="Update Membership Type"
        @ok="handleOk"
      >
        <!-- form -->
        <div class="rowFields mx-auto row">
          <div class="col-lg-3">
            <p class="textLabel">Membership Type Name:</p>
          </div>
          <div class="col-lg-9">
            <input
              type="text"
              name="name"
              ref="name"
              class="form-control"
              v-b-tooltip.hover
              title="Membership Type"
              placeholder="Membership Type name"
              v-validate="'required'"
              v-model.trim="item_edit.name"
              autocomplete="off"
            />
            <small class="text-danger pull-left" v-show="errors.has('name')"
              >Membership Type Name is required.</small
            >
          </div>
        </div>

        <div class="rowFields mx-auto row">
          <div class="col-lg-3">
            <p class="textLabel">Equivalent Code:</p>
          </div>
          <div class="col-lg-9">
            <input
              type="text"
              name="code"
              class="form-control"
              v-b-tooltip.hover
              title="Equivalent Code"
              v-validate="'required'"
              placeholder="Code"
              v-model.trim="item_edit.code"
              autocomplete="off"
            />
            <small class="text-danger pull-left" v-show="errors.has('code')"
              >Code is required.</small
            >
          </div>
        </div>
        <!-- /form -->
        <template slot="modal-footer" slot-scope="{}">
          <b-button
            size="sm"
            variant="success"
            @click="btnUpdate()"
            >Update</b-button
          >
          <b-button
            size="sm"
            variant="danger"
            @click="btnDelete()"
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
        { key: "code", label: "Code", sortable: true },
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
        code: "",
      },
      item_edit: {
        name: "",
        code: "",
      },
      user: null
    };
  },
  beforeCreate() {
    this.$global.loadJS();
  },
  created() {
    this.user = this.$global.getUser();
  },
  mounted() {
    this.load();
  },
  updated() {},
  methods: {
    load() {
      this.tblisBusy = true;
      this.$http.get("api/MembershipType").then(function(response) {
        console.log(response.body);
        this.items = response.body;
        this.totalRows = this.items.length;
        this.tblisBusy = false;
      });

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
              this.item_edit.user_id = this.user.id;
              this.$http
                .put("api/MembershipType/" + this.item_edit.id, this.item_edit)
                .then((response) => {
                  console.log(response.body);
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
            .post("api/MembershipType", this.item_add)
            .then((response) => {
              console.log(response.body);
              swal("Notification", "Added successfully", "success");
              this.items = response.body;
              this.totalRows = this.items.length;
              this.item_add = {
                name: "",
                code: ""
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
            .delete("api/MembershipType/" + this.item_edit.id)
            .then((response) => {
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
