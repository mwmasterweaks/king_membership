<template>
  <div class="mx-auto col-md-12 modified-continer">
    <br />
    <div class="panel-heading">
      <p class="elClr panel-title">
        Manage Approved Applications

        <b-button
          type="button"
          class="btn btn-success btn-labeled pull-right margin-right-10"
          @click="exportTable('approvedApplications')"
          >Export</b-button
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
          id="approvedApplications"
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

    <!-- <modal_edit_application></modal_edit_application> -->
    <modal_edit_application v-bind:data="member"></modal_edit_application>
  </div>
</template>
<script>
import { ModelListSelect } from "vue-search-select";
import modal_edit_application from "../../modal_vue/modal_edit_application.vue";
import swal from "sweetalert";

export default {
  components: {
    "model-list-select": ModelListSelect,
    modal_edit_application: modal_edit_application,
  },
  data() {
    return {
      tblisBusy: true,
      fields: [
        { key: "id", sortable: true },
        { key: "membership_status", label: "Status", sortable: true },
        {
          key: "Name",
          label: "Full Name",
          formatter: (value, key, item) => {
            if (item.mid_name == null) item.mid_name = "";
            if (item.suffix == null) item.suffix = "";

            return (
              item.first_name +
              " " +
              item.mid_name +
              " " +
              item.last_name +
              " " +
              item.suffix
            );
          },
          sortable: true,
        },
        {
          key: "branch.name",
          label: "Branch",
          sortable: true,
        },
        {
          key: "application_status",
          label: "Application Status",
          sortable: true,
        },
        { key: "created_at", sortable: true },
        { key: "updated_at", sortable: true },
      ],
      items: [],
      tblFilter: null,
      totalRows: 1,
      currentPage: 2,
      perPage: 10,
      pageOptions: [10, 25, 50, 100],
      item_add: {
        name: "",
        description: "",
      },
      member: {},
      roles: [],
      branches: [],
      authenticatedUser: {},
    };
  },
  beforeCreate() {
    this.$global.loadJS();
  },
  created() {
    this.setAuthenticatedUser();
    this.roles = this.$global.getRoles();
    this.loadItems();
    this.tblisBusy = false;
    this.totalRows = this.items.length;
    this.user = this.$global.getUser();
    this.branches = this.$global.getBranch();
  },
  mounted() {
    this.load();

    this.$root.$on("Updated_list", () => {
      this.loadItems();
    });
  },
  updated() {},
  methods: {
    setAuthenticatedUser() {
      this.authenticatedUser = this.$global.getUser();
    },

    loadItems() {
      var branch_id = this.authenticatedUser.employee.branch_id;
      this.$http
        .get("api/member/getApprove/" + branch_id)
        .then(function (response) {
          this.items = response.body;
          this.totalRows = this.items.length;
          this.tblisBusy = false;
          console.log(response.body);
        });
    },
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
      // this.member = item;
      // this.member.member_details = item.member_details;
      // this.$bvModal.show("ModalEditApplication");

      var id = item.id;
      this.$http.get("api/Member/" + id).then((response) => {
        console.log(response.body);
        this.member = response.body;
        this.$bvModal.show("ModalEditApplication");
      });
    },
    handleOk(bvModalEvt) {
      bvModalEvt.preventDefault();
    },

    btnApprove() {
      this.$http
        .post("api/member/accept/" + this.member.id)
        .then((response) => {
          swal("Member Application #" + this.member.id + "has been approved!", {
            icon: "success",
          });

          this.loadItems();
          this.$bvModal.hide("modalEdit");
          this.$root.$emit("Counter");
        });
    },
    btnReject() {
      this.$http
        .post("api/member/reject/" + this.member.id)
        .then((response) => {
          swal("Member Application #" + this.member.id + "has been rejected!", {
            icon: "warning",
          });
          this.loadItems();
          this.$bvModal.hide("modalEdit");
          this.$root.$emit("Counter");
        });
    },

    btnUpdate() {
      this.$validator.validateAll().then((result) => {
        if (result) {
          this.tblisBusy = true;
          swal({
            title: "Are you sure?",
            text: "Do you want to Update this item?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          }).then((update) => {
            if (update) {
              var tempdata = {
                item_edit: this.item_edit,
                user_id: this.user.id,
                user_name: this.user.name,
                id: this.item_edit.id,
              };
              this.$http
                .post("api/UpdateBranch", tempdata)
                .then((response) => {
                  this.$global.setBranch(response.body);
                  this.items = response.body;
                  this.totalRows = this.items.length;
                  swal("Update!", "Update successfully", "success");
                  this.$bvModal.hide("modalEdit");
                  this.tblisBusy = false;
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
        }
      });
    },
    btnAdd() {
      this.$validator.validateAll().then((result) => {
        if (result) {
          var tempdata = {
            item_add: this.item_add,
            user_id: this.user.id,
            user_name: this.user.name,
          };
          this.$http
            .post("api/Branch", tempdata)
            .then((response) => {
              swal("Notification", "Added successfully", "success");
              this.$global.setBranch(response.body);
              this.items = response.body;
              this.totalRows = this.items.length;
              this.item_add = {
                name: "",
                desc: "",
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
    exportTable(tbl) {
      this.$nextTick(function () {
        setTimeout(
          function () {
            var tab_text =
              "<table><tr><th colspan='2' style='font-size: large;'>Approved Applications</th></tr>" +
              "<tr></tr><tr>" +
              "</td>" +
              "</tr>" +
              "<tr>" +
              "<td>" +
              "</td>" +
              "</tr>";
            var textRange;
            var j = 0;
            var tab = document.getElementById(tbl); // id of table
            // var tab1 = document.getElementById("summaryTable1");

            // for (j = 0; j < tab1.rows.length; j++) {
            //   tab_text = tab_text + tab1.rows[j].innerHTML + "</tr>";
            // }
            tab_text = tab_text + "<tr></tr> <tr></tr>";
            var j = 0;
            for (j = 0; j < tab.rows.length; j++) {
              tab_text = tab_text + tab.rows[j].innerHTML + "</tr>";
            }

            tab_text = tab_text + "</table>";
            tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, ""); //remove if u want links in your table
            tab_text = tab_text.replace(/<img[^>]*>/gi, ""); // remove if u want images in your table
            tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

            var ua = window.navigator.userAgent;
            var msie = ua.indexOf("MSIE ");

            if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
              // If Internet Explorer
              txtArea1.document.open("txt/html", "replace");
              txtArea1.document.write(tab_text);
              txtArea1.document.close();
              txtArea1.focus();
              var sa = txtArea1.document.execCommand(
                "SaveAs",
                true,
                "Say Thanks to Sumit.csv"
              );
            } //other browser not tested on IE 11
            else
              var sa = window.open(
                "data:application/vnd.ms-excel," + encodeURIComponent(tab_text)
              );
            return sa;
          }.bind(this),
          1000
        );
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
  margin-top: 12px;
}
.modal-content,
modal-header {
  border: 1px solid red;
}
/* widgetsss */

.o-hidden {
  overflow: hidden !important;
}

.z-0 {
  z-index: 0;
}

.z-1 {
  z-index: 1;
}

.content-wrapper {
  overflow-x: hidden;
  background: white;
}

@media (min-width: 992px) {
  .content-wrapper {
    margin-left: 250px;
  }
}

.card-body-icon {
  position: absolute;
  z-index: 0;
  top: -25px;
  right: -25px;
  font-size: 5rem;
  -webkit-transform: rotate(15deg);
  -ms-transform: rotate(15deg);
  transform: rotate(15deg);
}
</style>
