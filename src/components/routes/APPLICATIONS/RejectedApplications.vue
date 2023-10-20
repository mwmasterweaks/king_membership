<template>
  <div class="mx-auto col-md-12 modified-continer">
    <br />
    <div class="panel-heading">
      <p class="elClr panel-title">
        Manage Rejected Applications

        <b-button
          type="button"
          class="btn btn-success btn-labeled pull-right margin-right-10"
          @click="exportTable('rejectedApplications')"
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
          id="rejectedApplications"
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
          <span slot="membership_status" slot-scope="data" v-html="data.value"></span>
          <template v-slot:cell(membership_status)="row">
            <span v-if="row.item.membership_status == 'A'">
             Active
            </span>
            <span v-if="row.item.membership_status == 'I'">
             Pending/Inactive
            </span>
            <span v-if="row.item.membership_status == 'C'">
             Closed
            </span>
            <span v-if="row.item.membership_status == 'W'">
             Withdrawn
            </span>
            <span v-if="row.item.membership_status == 'D'">
             Deceased
            </span>
            <span v-if="row.item.membership_status == 'L'">
             Delisted
            </span>
          </template>
          <template slot="table-caption"></template>
        </b-table>
      </div>
    </div>
    <div class="elClr panel-footer">
      <div class="row" style="background-color: ; padding: 15px">
        <div class="col-md-8" style="background-color: ">
          <span class="elClr">{{ totalRows }} application/s.</span>
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
    <modal_edit_application
      v-bind:data="member"
      v-bind:countries="countries"
      v-bind:regions="regions"
      v-bind:provinces="provinces"
      v-bind:cities="cities"
      v-bind:barangays="barangays"
      >
    </modal_edit_application>
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
      member: {
        branch_id: "",
        email: "",
        acc_no: "",
        title: "",
        nickname: "",
        first_name: "",
        mid_name: "",
        last_name: "",
        prev_last_name: "",
        suffix: "",
        resident: "",
        resident_citizenship: "",
        age: "",
        gender: "",
        contact_no: "",
        contact_last_update: "",
        contact2_no: "",
        contact2_last_update: "",
        birthdate: "",
        nationality: "",
        birthcountry: "",
        birthplace: "",
        civil_stat: "",
        membership_status: "",
        monthly_present: "",
        occupied_present: "",
        last_update_present: "",
        permanent_address: "",
        monthly_permanent: "",
        occupied_permanent: "",
        last_update_permanent: "",
        member_id: 0,
        dependents_no: 0,
        children_no: 0,
        household_no: 0,
        spouse_name: "",
        spouse_age: "",
        spouse_occupation: "",
        spouse_employer: "",
        spouse_address: "",
        mother_title: "",
        mother_first_name: "",
        mother_mid_name: "",
        mother_last_name: "",
        mother_suffix: "",
        father_title: "",
        father_first_name: "",
        father_mid_name: "",
        father_last_name: "",
        father_suffix: "",
        owned_properties: 0,
        owned_cars: 0,
        ownership_present: "",
        ownership_permanent: "",
        income_source: "",
        income_source_arr: [],
        income_via: "",
        other_income_via: "",
        emp_employer: "",
        emp_nature: "",
        emp_tin: "",
        emp_tel_no: "",
        emp_address: "",
        emp_position: "",
        emp_date_employed: "",
        emp_gross: "",
        emp_currency: "",
        emp_period: "",
        emp_annual: "",
        emp_occ_status: "",
        bn_name: "",
        bn_nature: "",
        bn_established: "",
        bn_tin: "",
        bn_address: "",
        bn_contact: "",
        sss: "",
        gsis: "",
        tin: "",
        otherID1_type: "",
        otherID1_number: "",
        otherID1_issued_date: "",
        otherID1_expiry_date: "",
        otherID1_issue_country: "",
        otherID1_issue_by: "",
        otherID1_last_update: "",
        otherID2_type: "",
        otherID2_number: "",
        otherID2_issued_date: "",
        otherID2_expiry_date: "",
        otherID2_issue_country: "",
        otherID2_issue_by: "",
        otherID2_last_update: "",
        ref1_name: "",
        ref1_address: "",
        ref1_contact: "",
        ref2_name: "",
        ref2_address: "",
        ref2_contact: "",
        height: "",
        weight: "",
        approval_date: "",
        enrollment_date: "",
        street: "",
        postal_code: "",
        benef_name_1: "",
        benef_age_1: "",
        benef_relation_1: "",
        benef_contact_1: "",
        benef_name_2: "",
        benef_age_2: "",
        benef_relation_2: "",
        benef_contact_2: "",
        barangay_object: { name: ""},
        city_object: { name: ""},
        country_object: { name: ""}
      },
      roles: [],
      branches: [],
      authenticatedUser: {},
      countries: [],
      regions: [],
      provinces: [],
      cities: [],
      barangays: [],
    };
  },
  beforeCreate() {
    this.$global.loadJS();
  },
  created() {
    this.setAuthenticatedUser();
    this.roles = this.$global.getRoles();
    this.loadItems();
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
        .get("api/member/getRejected/" + branch_id)
        .then(function (response) {
          this.items = response.body;
          this.totalRows = this.items.length;
          this.tblisBusy = false;
          console.log(response.body);
        });
    },
    load() {

       this.$http.get("api/getCountries").then(function (response) {
        this.countries = response.body;
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
      // this.member = item;
      // this.member.member_details = item.member_details;
      // this.$bvModal.show("ModalEditApplication");
      this.$root.$emit("pageLoading");
      var id = item.id;
      this.$http.get("api/Member/" + id).then((response) => {
         const {country, region, province, city } = this.getAddressesOptions(item.barangay_object.id);
        var temp = response.body
        const incomeSourceValue = temp.income_source;
        if (incomeSourceValue === "")
          temp.income_source_arr = [];
        else
          temp.income_source_arr = incomeSourceValue.split(", ");


        temp.country_object = country;
        temp.region_object = region;
        temp.province_object = province;
        temp.city_object = city;
        console.log(temp);
        this.member = temp;
        this.$bvModal.show("ModalEditApplication");
        this.$root.$emit("pageLoaded");
      });
    },
    getAddressesOptions(barangayID) {
      const result = {
        country: null,
        region: null,
        province: null,
        city: null,
        //barangay: null
      };

      for (const country of this.countries) {
        for (const region of country.regions) {
          for (const province of region.provinces) {
            for (const city of province.cities) {

              const foundBarangay = city.barangays.find((bar) => bar.id === barangayID);
              if (foundBarangay) {
                this.regions = country.regions;
                this.provinces = region.provinces;
                this.cities = province.cities;
                this.barangays = city.barangays;

                result.country= country;
                result.region= region;
                result.province= province;
                result.city= city;
                //result.barangay= foundBarangay;
                return result;
              }

            }
          }
        }
      }
      return result; // Return an empty result if province not found
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
              "<table><tr><th colspan='2' style='font-size: large;'>Rejected Applications</th></tr>" +
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
