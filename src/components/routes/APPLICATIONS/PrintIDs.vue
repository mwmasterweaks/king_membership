<template>
  <div>
     <b-modal id="ModalPrintIDs"
      size="xl">
    <div id="printIDs" class="printIDs" style="color: black">
      <table class="parent printable" style="width: 100%" id="printable-app">
        <tr style="background-color: rgba(255, 255, 255, 0.8)">
          <td>
            <img
              v-if="data.image_id_1 != null"
              :src="$img_path + data.image_id_1"
              style="
                width: 60%;
                max-height: 40%;
                padding: 0;
                background-size: 100%;
                background-repeat: no-repeat;
              "
            />
          </td>
        </tr>
        <tr style="background-color: rgba(255, 255, 255, 0.8)">
          <td>
            <img
              v-if="data.image_id_2 != null"
              :src="$img_path + data.image_id_2"
              style="
                width: 60%;
                max-height: 40%;
                padding: 0;
                background-size: 100%;
                background-repeat: no-repeat;
              "
            />
          </td>
        </tr>
      </table>

      <b-button class="proceed-btn" size="sm" @click="printElement('printIDs')">
        <i class="fas fa-solid fa-print"></i> Print
      </b-button>
    </div>
    </b-modal>
  </div>
</template>
<script>
import { ModelListSelect } from "vue-search-select";
import datePicker from "vue-bootstrap-datetimepicker";
import PrettyCheck from "pretty-checkbox-vue/check";
import PrettyRadio from "pretty-checkbox-vue/radio";

export default {
  props:[
    "data"
  ],
  components: {
    "model-list-select": ModelListSelect,
    "date-picker": datePicker,
    "p-check": PrettyCheck,
    "p-radio": PrettyRadio,
  },
  data() {
    return {
      user: {},
      roles: [],
      branch: "",
    };
  },
  beforeCreate() {
    this.$global.loadJS();
  },
  created() {
    this.roles = this.$global.getRoles();
    this.user = this.$global.getUser();
  },
  // watch: {
  //   $route(to, from) {
  //     $(".page-loader-wrapper").fadeIn();

  //     this.getItem();
  //     this.printPreview();
  //   }
  // },

  beforeMount() {
    //this.getItem();
  },
  mounted() {},
  methods: {
    printElement(id) {
      // window.print();
      // this.$htmlToPaper("printIDs");
      var elem = document.getElementById(id);
      var domClone = elem.cloneNode(true);
      var $printSection = document.getElementById("printSection");
      if (!$printSection) {
        var $printSection = document.createElement("div");
        $printSection.id = "printSection";
        document.body.appendChild($printSection);
      }
      $printSection.innerHTML = "";
      $printSection.appendChild(domClone);
      window.print();
    },

    getItem() {
      this.$http
        .get("api/Member/" + this.$route.params.item)
        .then((response) => {
          // console.log(response.body.branch.name);
          this.data = response.body;
          this.branch = response.body.branch.name;

          $(".page-loader-wrapper").fadeOut();
        });
    },
    printPreview() {
      window.print();
      // this.$htmlToPaper("printable");
    },
  },
};
</script>

<style scoped>
@media print {
  @page {
    size: 8.5in 13in;
    orientation: portrait;
  }

  .proceed-btn {
    visibility: hidden;
  }

  .printIDs {
    width: 100%;
  }
  #leftsidebar {
    visibility: hidden;
  }

  .col-lg-1,
  .col-lg-2,
  .col-lg-3,
  .col-lg-4,
  .col-lg-5,
  .col-lg-6,
  .col-lg-7,
  .col-lg-8,
  .col-lg-9,
  .col-lg-10,
  .col-lg-11,
  .col-lg-12 {
    float: right;
  }

  .col-lg-1 {
    width: 8%;
  }
  .col-lg-2 {
    width: 16%;
  }
  .col-lg-3 {
    width: 25%;
  }
  .col-lg-4 {
    width: 33%;
  }
  .col-lg-5 {
    width: 42%;
  }
  .col-lg-6 {
    width: 50%;
  }
  .col-lg-7 {
    width: 58%;
  }
  .col-lg-8 {
    width: 66%;
  }
  .col-lg-9 {
    width: 75%;
  }
  .col-lg-10 {
    width: 83%;
  }
  .col-lg-11 {
    width: 92%;
  }
  .col-lg-12 {
    width: 100%;
  }

  .marginized-row {
    width: 100%;
    display: flex;
    margin-top: -25px;
  }

  .marginized {
    width: 100%;
    display: flex;
  }
}
.proceed-btn {
  background-color: #1cc470;
  margin-right: 2em;
  float: right;
  width: 10%;
  border: none;
  color: #ffffff;
  margin-top: 20px;
  margin-bottom: 20px;
}

.marginized-row {
  width: 100%;
  display: flex;
}

.marginized {
  width: 100%;
  display: flex;
}

.tbl-head > tr > th {
  padding: 5px;
}

.tbl-body > tr > td,
.tbl-body > tr > th {
  padding: 3px;
}

.preview {
  border: 2px solid black;
}

.divider {
  border-bottom: 3px solid black;
  margin-bottom: 10px;
}

.label-name {
  border-bottom: 1px solid black;
  width: 100%;
  text-align: center;
}
.label-name {
  border-bottom: 1px solid black;
  width: 100%;
  text-align: center;
}
</style>
