<template>
  <div class="mx-auto col-md-12 modified-continer">
    <div class="row" style="margin-top:50px;height:120px">
      <div class="col-xl-4 col-sm-6 mb-6">
        <div class="card text-white bg-warning o-hidden h-100">
          <div class="card-body">
            <div class="card-body-icon">
              <i class="fa fa-fw fa-list"></i>
            </div>
            <div class="mr-5">
              {{ pendingCount }} Pending Members Application
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-4 col-sm-6 mb-6">
        <div class="card text-white bg-success o-hidden h-100">
          <div class="card-body">
            <div class="card-body-icon">
              <i class="fa fa-fw fa-thumbs-up"></i>
            </div>
            <div class="mr-5">
              {{ approvedCount }} Approved Members Application
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-4 col-sm-6 mb-6">
        <div class="card text-white bg-danger o-hidden h-100">
          <div class="card-body">
            <div class="card-body-icon">
              <i class="fa fa-fw fa-support"></i>
            </div>
            <div class="mr-5">
              {{ rejectedCount }} Rejected Members Application
            </div>
          </div>
        </div>
      </div>
    </div>
    <br />
    <div class="panel-heading">
      <p class="elClr panel-title">
        Manage Applications
        <b-button
          type="button"
          class="btn btn-success btn-labeled pull-right"
          @click="exportTable('allApplications')"
          >Export</b-button
        >

        <!-- <b-button
          type="button"
          class="btn btn-warning btn-labeled pull-right"
          style="margin-right:10px"
          @click="testMail"
          >Test Email</b-button
        > -->
      </p>
    </div>

    <div class="elClr panel-body">
      <div>
        <b-row style="margin:10px;">
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
          id="allApplications"
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
      <div class="row" style="background-color:; padding:15px;">
        <div class="col-md-8" style="background-color:;">
          <span class="elClr">{{ totalRows }} item/s found.</span>
        </div>

        <div class="col-md-4" style="background-color:;">
          <b-pagination
            v-model="currentPage"
            :total-rows="totalRows"
            :per-page="perPage"
            class="my-0 pull-right"
          ></b-pagination>
        </div>
      </div>
    </div>

    <!-- <modal_application></modal_application> -->
    <modal_edit_application v-bind:data="member"></modal_edit_application>
  </div>
</template>
<script>
import { ModelListSelect } from "vue-search-select";
import modal_edit_application from "../../modal_vue/modal_edit_application.vue";
import modal_application from "../../modal_vue/modal_application.vue";
import swal from "sweetalert";

export default {
  components: {
    "model-list-select": ModelListSelect,
    modal_edit_application: modal_edit_application,
    modal_application: modal_application
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
          sortable: true
        },

        {
          key: "application_status",
          label: "Application Status",
          sortable: true
        },
        { key: "created_at", sortable: true },
        { key: "updated_at", sortable: true }
      ],
      items: [],
      tblFilter: null,
      totalRows: 1,
      currentPage: 2,
      perPage: 10,
      pageOptions: [10, 25, 50, 100],
      item_add: {
        name: "",
        description: ""
      },
      member: {},
      roles: [],
      branches: [],
      pendingCount: 0,
      approvedCount: 0,
      rejectedCount: 0,
      authenticatedUser: {}
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
    this.branches = this.$global.getBranch();
  },
  mounted() {
    this.load();
    this.setCount();

    this.$root.$on("Counter", () => {
      this.setCount();
    });
    this.$root.$on("Updated_list", () => {
      this.loadItems();
    });
  },
  updated() {},
  methods: {
    setAuthenticatedUser() {
      this.authenticatedUser = this.$global.getUser();
    },
    setCount() {
      var branch_id = this.authenticatedUser.employee.branch_id;
      this.$http
        .get("api/member/counter/" + branch_id)
        .then(function(response) {
          this.pendingCount = response.body.pending;
          this.approvedCount = response.body.approved;
          this.rejectedCount = response.body.rejected;
        });
    },
    loadItems() {
      var branch_id = this.authenticatedUser.employee.branch_id;
      this.$http
        .get("api/member/subIndex/" + branch_id)
        .then(function(response) {
          this.items = response.body;
          this.totalRows = this.items.length;
          this.tblisBusy = false;
          console.log(response.body);
        });
    },
    load() {
      this.$nextTick(function() {
        setTimeout(function() {}, 100);
      });
    },
    create() {
      this.$bvModal.show("ModalApplication");
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
      var id = item.id;
      this.$http.get("api/Member/" + id).then(response => {
        this.member = response.body;
        this.$bvModal.show("ModalEditApplication");
        console.log(this.member);
        // this.$bvModal.show("ModalPrintPreview");
      });
    },
    handleOk(bvModalEvt) {
      bvModalEvt.preventDefault();
    },
    exportTable(tbl) {
      this.$nextTick(function() {
        setTimeout(
          function() {
            var tab_text =
              "<table><tr><th colspan='2' style='font-size: large;'>All Applications</th></tr>" +
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
    testMail() {
      this.$http.get("api/test").then(response => {
        console.log(response.body);
      });
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
@media screen and (max-width: 640px) {
  .main-content {
    width: 90%;
  }
  .company__info {
    display: none;
  }
}
@media screen and (min-width: 642px) and (max-width: 800px) {
  .main-content {
    width: 70%;
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
