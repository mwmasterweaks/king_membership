<template>
  <div>
    <b-modal
      id="modalPrintPreview"
      :header-bg-variant="' elBG'"
      :header-text-variant="' elClr'"
      :body-bg-variant="' elBG'"
      :body-text-variant="' elClr'"
      :footer-bg-variant="' elBG'"
      :footer-text-variant="' elClr'"
      size="xl"
    >
      <template v-slot:modal-title>
        <label>
          Print Preview
        </label>
      </template>
      <div id="printFSR" class="printFSR" style="color: black;width:100%">
        <table class="parent printable">
          <tr style="background-color: rgba(255, 255, 255, 0.8)">
            <td>
              <div>
                <div class="rowFields mx-auto row">
                  <table
                    style="width: 100%; border-collapse: collapse"
                    class="normalTbl"
                  >
                    <tr class>
                      <td class="normalTbl" style="width: 30%">
                        <img
                          src="https://i.ibb.co/MPWTwTJ/logo.png"
                          style="width: 50%"
                        />
                      </td>
                      <td
                        class="normalTbl"
                        style="vertical-align: center; width: 40%"
                      >
                        <center>
                          <h4>
                            <strong>MEMBERSHIP APPLICATION FORM</strong>
                          </h4>
                        </center>
                      </td>
                      <td
                        class="normalTbl"
                        style="vertical-align: top; width: 30%;float:right;margin-right:150px"
                      >
                        <img
                          class="preview"
                          :src="$img_path + data.image"
                          width="200"
                          height="200"
                        />
                      </td>
                    </tr>
                  </table>
                </div>
                <br />
                <div class="rowFields mx-auto row">
                  <b-card bg-variant="light" style="width:100%">
                    <center>
                      <div class="rowFields2 mx-auto row">
                        <div style="width:20%">
                          <p class="textLabel-1">Account No.:</p>
                        </div>
                        <div style="width:80%">
                          <div class="input-group">
                            {{ data.acc_no }}
                          </div>
                        </div>
                      </div>
                      <div class="rowFields2 mx-auto row">
                        <div style="width:20%">
                          <p class="textLabel-1">Email:</p>
                        </div>
                        <div style="width:80%">
                          <div class="input-group">
                            {{ data.email }}
                          </div>
                        </div>
                      </div>

                      <div class="rowFields2 mx-auto row">
                        <div style="width:20%">
                          <p class="textLabel-1">Branch:</p>
                        </div>
                        <div style="width:80%">
                          <div class="input-group">
                            {{ data.branch }}
                          </div>
                        </div>
                      </div>
                    </center>
                  </b-card>
                </div>
                <br />
                <div class="rowFields mx-auto row">
                  <b-card bg-variant="light" style="width:100%">
                    <center>
                      <div class="rowFields2 mx-auto row">
                        <div>
                          <p class="textLabel-2">PERSONAL INFORMATION</p>
                        </div>
                      </div>

                      <div class="rowFields2 mx-auto row">
                        <div style="width:20%">
                          <p class="textLabel-1">First Name:</p>
                        </div>
                        <div style="width:80%">
                          <div class="input-group">
                            {{ data.first_name }}
                          </div>
                        </div>
                      </div>
                      <div class="rowFields2 mx-auto row">
                        <div style="width:20%">
                          <p class="textLabel-1">Middle Name:</p>
                        </div>
                        <div style="width:80%">
                          <div class="input-group">{{ data.mid_name }}</div>
                        </div>
                      </div>
                      <div class="rowFields2 mx-auto row">
                        <div style="width:20%">
                          <p class="textLabel-1">Last Name:</p>
                        </div>
                        <div style="width:80%">
                          <div class="input-group">{{ data.last_name }}</div>
                        </div>
                      </div>
                      <div class="rowFields2 mx-auto row">
                        <div style="width:20%">
                          <p class="textLabel-1">Previous Last Name:</p>
                        </div>
                        <div style="width:80%">
                          <div class="input-group">
                            {{ data.prev_last_name }}
                          </div>
                        </div>
                      </div>
                      <div class="rowFields2 mx-auto row">
                        <div style="width:20%">
                          <p class="textLabel-1">Suffix</p>
                        </div>
                        <div style="width:80%">
                          <div class="input-group">{{ data.suffix }}</div>
                        </div>
                      </div>
                      <div class="rowFields2 mx-auto row">
                        <div style="width:20%">
                          <p class="textLabel-1">Age:</p>
                        </div>
                        <div style="width:80%">
                          <div class="input-group">{{ data.age }}</div>
                        </div>
                      </div>
                      <div class="rowFields2 mx-auto row">
                        <div style="width:20%">
                          <p class="textLabel-1">Gender:</p>
                        </div>
                        <div style="width:80%">
                          <div class="input-group">{{ data.gender }}</div>
                        </div>
                      </div>
                      <div class="rowFields2 mx-auto row">
                        <div style="width:20%">
                          <p class="textLabel-1">Contact No.:</p>
                        </div>
                        <div style="width:80%">
                          <div class="input-group">{{ data.contact_no }}</div>
                        </div>
                      </div>
                      <div class="rowFields2 mx-auto row">
                        <div style="width:20%">
                          <p class="textLabel-1">Date of Birth:</p>
                        </div>
                        <div style="width:80%">
                          <div class="input-group">{{ data.birthdate }}</div>
                        </div>
                      </div>
                      <div class="rowFields2 mx-auto row">
                        <div style="width:20%">
                          <p class="textLabel-1">Nationality:</p>
                        </div>
                        <div style="width:80%">
                          <div class="input-group">{{ data.nationality }}</div>
                        </div>
                      </div>
                      <div class="rowFields2 mx-auto row">
                        <div style="width:20%">
                          <p class="textLabel-1">Country of Birth:</p>
                        </div>
                        <div style="width:80%">
                          <div class="input-group">{{ data.birthcountry }}</div>
                        </div>
                      </div>
                      <div class="rowFields2 mx-auto row">
                        <div style="width:20%">
                          <p class="textLabel-1">Place of Birth:</p>
                        </div>
                        <div style="width:80%">
                          <div class="input-group">{{ data.birthplace }}</div>
                        </div>
                      </div>
                    </center>
                  </b-card>
                </div>
              </div>
            </td>
          </tr>
        </table>
      </div>
      <template slot="modal-footer" slot-scope="{}">
        <b-button size="sm" variant="success" @click="printElement('printFSR')"
          >Print</b-button
        >
      </template>
    </b-modal>
  </div>
</template>
<script>
import { ModelListSelect } from "vue-search-select";
import datePicker from "vue-bootstrap-datetimepicker";
import PrettyCheck from "pretty-checkbox-vue/check";
import PrettyRadio from "pretty-checkbox-vue/radio";

export default {
  props: ["data"],
  components: {
    "model-list-select": ModelListSelect,
    "date-picker": datePicker,
    "p-check": PrettyCheck,
    "p-radio": PrettyRadio
  },
  data() {
    return {
      user: {},
      roles: []
    };
  },
  created() {
    this.user = this.$global.getUser();
    this.roles = this.$global.getRoles();
  },

  mounted() {},
  methods: {
    printElement(id) {
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
    }
  }
};
</script>
<style scoped>
@media print {
  @page {
    size: A4;
    size: portrait;
  }
}
.trouble-bcard > .card-body {
  padding: 10px;
  padding-left: 13px;
  max-width: 100%;
  background: rgb(255, 255, 255);
  border: none;
  margin-top: 10px;
  margin-bottom: 20px;
}
.trouble-bcard2 {
  background: none;
  margin-top: -20px;
  border: none;
}
.rowFields2 {
  margin-top: 1px;
  font-size: 12px;
  text-align: left;
  display: flex;
  width: 100%;
}
.rowFields3 {
  margin-top: 18px;
  font-size: 12px;
  text-align: left;
  flex: 1;
}
.textLabel {
  margin-top: 1px;
  font-size: 14px;
}
.textLabel-2 {
  margin-top: 2px;
  font-weight: bold;
  font-size: 16px;
  color: darkgreen;
}
.textLabel-1 {
  margin-top: 6px;
  font-weight: bold;
  font-size: 12px;
}
.text-area {
  /* flex-grow: 1; */
  width: 25%;
  font-size: 13px;
  text-align: center;
  justify-content: left;
}
.troubleCheckbox {
  display: flex;
  width: 17%;
  float: left;
  margin-top: 7px;
  font-size: 12px;
  float: left;
}
.recommendation {
  display: flex;
  width: auto;
  float: left;
  margin-top: 7px;
  font-size: 12px;
  float: left;
}
.textLabel {
  margin-top: 6px;
  float: left;
}
.font-header {
  font-family: Arial, Helvetica, sans-serif;

  line-height: 20px;
}
.bold {
  font-weight: bold;
}
.ticketInputLine {
  box-shadow: none;
  border: none;
  border-bottom: 1px solid black;
  margin-top: -5px;
  width: 100%;
  float: left;
  margin-left: -50px;
  background: none;
  border-radius: 0 0 0 0;
  font-family: "Montserrat", "Helvetica Neue", Arial, sans-serif;
  font-size: 12px;
}
.ticketInputLine:focus {
  box-shadow: none;
  outline: none;
}
.ticketInputLine2 {
  box-shadow: none;
  border: none;
  border-bottom: 1px solid black;
  margin-top: -5px;
  width: 150px;
  float: right;
  background: none;
  border-radius: 0 0 0 0;
  font-family: "Montserrat", "Helvetica Neue", Arial, sans-serif;
  font-size: 12px;
}
.ticketInputLine2:focus {
  box-shadow: none;
  outline: none;
}
.body-font {
  font-family: "Montserrat", "Helvetica Neue", Arial, sans-serif;
  font-size: 13px;
  line-height: 1.5em;
  font-weight: bold;
}
</style>
