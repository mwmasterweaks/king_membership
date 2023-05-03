<template>
  <div>
     <b-modal id="ModalPrintPreview"
      size="xl">
    <div id="printFSR" class="printFSR" style="color: black;">
      <table class="parent printable" style="width:100%" id="printable-app">
        <tr style="background-color: rgba(255, 255, 255, 0.8)">
          <td>
            <img
              src="../../../img/1st_page.png"
              style="  width: 97%;
                max-height: 95%;
                padding: 0;
                background-size: 100% ;
                background-repeat: no-repeat;
                margin-top:-25px"
              class="firstPage"
            />
          </td>
        </tr>

        <tr style="background-color: rgba(255, 255, 255, 0.8);">
          <td>
            <div
              style="font-family:   Arial;
              font-size: 11px;margin-top:20px"
            >
              <div class="rowFields mx-auto row">
                <p class="textLabel-2">
                  <b>PERSONAL INFORMATION(Member)</b>
                </p>
              </div>
              <div style="width:100%;display:flex">
                <div style="width:75%">
                  <div class="rowFields mx-auto row marginized">
                    <div style="width:8%">
                      <p class="data-print">
                        <b style="margin-left:15px"> Name:</b>
                      </p>
                    </div>
                    <div style="width:5%">
                      <label class="label-name">{{ data.title }}</label>
                      <center>Title</center>
                    </div>
                    <div style="width:18%">
                      <label class="label-name">{{ data.last_name }},</label>
                      <center>(Last Name,</center>
                    </div>
                    <div style="width:18%">
                      <label class="label-name">{{ data.first_name }},</label>
                      <center>First Name,</center>
                    </div>
                    <div style="width:18%">
                      <label class="label-name">{{ data.mid_name }},</label>
                      <center>Middle Name,</center>
                    </div>
                    <div style="width:18%">
                      <label class="label-name"
                        >{{ data.prev_last_name }},</label
                      >
                      <center>Previous Last Name,</center>
                    </div>
                    <div style="width:15%">
                      <label class="label-name">{{ data.suffix }}</label>
                      <center>Suffix (e.g. III, Jr.)</center>
                    </div>
                  </div>
                  <br />
                  <div class="rowFields mx-auto row marginized">
                    <div class="col-lg-3">
                      <b>Nickname:</b>
                      <label style="border-bottom:1px solid black;">
                        {{ data.nickname }}</label
                      >
                    </div>
                    <div class="col-lg-4">
                      <b>Gender:</b>
                      <div class="pretty p-icon p-curve p-jelly">
                        <input
                          type="radio"
                          name="gender"
                          ref="gender"
                          value="Male"
                          v-model.trim="data.gender"
                          v-validate="'required'"
                        />

                        <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label> Male</label>
                        </div>
                      </div>
                      <div class="pretty p-icon p-curve p-jelly">
                        <input
                          type="radio"
                          name="gender"
                          ref="gender"
                          value="Female"
                          v-model.trim="data.gender"
                          v-validate="'required'"
                        />
                        <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label> Female</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <b>Age:</b>
                      <label style="border-bottom:1px solid black;">
                        {{ data.age }}</label
                      >
                    </div>
                    <div class="col-lg-3">
                      <b>Date of Birth:</b>
                      <label style="border-bottom:1px solid black;">
                        {{ data.birthdate }}</label
                      >
                    </div>
                  </div>
                  <br />
                  <div class="rowFields mx-auto row marginized">
                    <div class="col-lg-3">
                      <b>Nationality: </b>
                      <label style="border-bottom:1px solid black;">
                        {{ data.nationality }}</label
                      >
                    </div>
                    <div class="col-lg-4">
                      <b>Country of Birth: </b>
                      <label style="border-bottom:1px solid black;">{{
                        data.birthcountry
                      }}</label>
                    </div>
                    <div class="col-lg-5">
                      <b>Place of Birth:</b>
                      <label style="border-bottom:1px solid black;">{{
                        data.birthplace
                      }}</label>
                    </div>
                  </div>
                  <br />
                  <div class="rowFields mx-auto row marginized">
                    <div style="width:35%">
                      <b style="margin-left:15px">Resident:</b>
                      <div class="pretty p-icon p-curve p-jelly">
                        <input
                          type="radio"
                          name="resident"
                          value="Yes"
                          v-model.trim="data.resident"
                          v-validate="'required'"
                        />
                        <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label> Yes</label>
                        </div>
                      </div>
                      <div
                        class="pretty p-icon p-curve p-jelly"
                        style="margin-left:-10px"
                      >
                        <input
                          type="radio"
                          name="resident"
                          value="No"
                          v-model.trim="data.resident"
                          v-validate="'required'"
                        />
                        <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label> No </label>
                        </div>
                      </div>
                      <label
                        style="border-bottom:1px solid black;margin-left:-10px"
                      >
                        {{ data.resident_citizenship }}</label
                      >(Citizenship)
                    </div>
                    <div style="width:65%">
                      <b>Civil Status:</b>
                      <div class="pretty p-icon p-curve p-jelly">
                        <input
                          type="radio"
                          name="civil_stat"
                          value="single"
                          v-model.trim="data.civil_stat"
                          v-validate="'required'"
                        />
                        <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label> Single</label>
                        </div>
                      </div>
                      <div
                        class="pretty p-icon p-curve p-jelly"
                        style="margin-left:-10px"
                      >
                        <input
                          type="radio"
                          name="civil_stat"
                          value="married"
                          v-model.trim="data.civil_stat"
                          v-validate="'required'"
                        />
                        <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label> Married</label>
                        </div>
                      </div>
                      <div
                        class="pretty p-icon p-curve p-jelly"
                        style="margin-left:-10px"
                      >
                        <input
                          type="radio"
                          name="civil_stat"
                          value="widowed"
                          v-model.trim="data.civil_stat"
                          v-validate="'required'"
                        />
                        <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label> Widowed</label>
                        </div>
                      </div>
                      <div
                        class="pretty p-icon p-curve p-jelly"
                        style="margin-left:-10px"
                      >
                        <input
                          type="radio"
                          name="civil_stat"
                          value="separated"
                          v-model.trim="data.civil_stat"
                          v-validate="'required'"
                        />
                        <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label> Separated</label>
                        </div>
                      </div>
                      <div
                        class="pretty p-icon p-curve p-jelly"
                        style="margin-left:-10px"
                      >
                        <input
                          type="radio"
                          name="civil_stat"
                          value="live-in"
                          v-model.trim="data.civil_stat"
                          v-validate="'required'"
                        />
                        <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label> W/Live-in Partner</label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <br />
                  <div class="rowFields mx-auto row marginized">
                    <div style="width:30%;">
                      <b style="margin-left:15px">Spouse’s Name: </b>
                      <label style="border-bottom:1px solid black;">
                        {{ data.spouse_name }}</label
                      >
                    </div>
                    <div style="width:7%">
                      <b>Age: </b>
                      <label style="border-bottom:1px solid black;">{{
                        data.spouse_age
                      }}</label>
                    </div>
                    <div style="width:15%">
                      <b>Occupation:</b>
                      <label style="border-bottom:1px solid black">{{
                        data.spouse_occupation
                      }}</label>
                    </div>
                    <div style="width:25%">
                      <b>Employer: </b>
                      <label style="border-bottom:1px solid black;">{{
                        data.spouse_employer
                      }}</label>
                    </div>
                    <div style="width:23%">
                      <b>Address: </b>
                      <label style="border-bottom:1px solid black;">{{
                        data.spouse_address
                      }}</label>
                    </div>
                  </div>
                  <br />
                </div>
                <div style="width:25%">
                  <table class="normalTbl" style="margin-top:-30px">
                    <tr class>
                      <td
                        class="normalTbl"
                        style="vertical-align: top; float:right;margin-left:50px"
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
              </div>

              <div class="rowFields mx-auto row marginized">
                <div style="width:20%">
                  <b style="margin-left:15px">Total No. of Dependents: </b>
                  <label style="border-bottom:1px solid black">{{
                    data.dependents_no
                  }}</label>
                </div>
                <div style="width:12%">
                  <b>No. of Children: </b>
                  <label style="border-bottom:1px solid black">{{
                    data.children_no
                  }}</label>
                </div>
                <div style="width:20%">
                  <b>No. of Household Members: </b>
                  <label style="border-bottom:1px solid black">{{
                    data.household_no
                  }}</label>
                </div>
                <div style="width:25%">
                  <b>No. of Real Estate Property Owned: </b>
                  <label style="border-bottom:1px solid black">{{
                    data.owned_properties
                  }}</label>
                </div>
                <div style="width:20%">
                  <b>Number of Car(s) owned: </b>
                  <label style="border-bottom:1px solid black">{{
                    data.owned_cars
                  }}</label>
                </div>
              </div>
              <br />
              <div class="rowFields mx-auto row ">
                <div style="width:20%">
                  <p class="data-print">
                    <b style="margin-left:15px"> Mother's Maiden Name:</b>
                  </p>
                </div>
                <div style="width:5%">
                  <label class="label-name">{{ data.mother_title }}</label>
                  <center>Title</center>
                </div>
                <div style="width:20%">
                  <label class="label-name">{{ data.mother_last_name }},</label>
                  <center>(Last Name,</center>
                </div>
                <div style="width:20%">
                  <label class="label-name"
                    >{{ data.mother_first_name }},</label
                  >
                  <center>First Name,</center>
                </div>
                <div style="width:20%">
                  <label class="label-name">{{ data.mother_mid_name }},</label>
                  <center>Middle Name,</center>
                </div>
                <div style="width:15%">
                  <label class="label-name">{{ data.mother_suffix }}</label>
                  <center>Suffix (e.g. III, Jr.)</center>
                </div>
              </div>
              <br />
              <div class="rowFields mx-auto row ">
                <div style="width:20%">
                  <p class="data-print">
                    <b style="margin-left:15px"> Father's Name:</b>
                  </p>
                </div>
                <div style="width:5%">
                  <label class="label-name">{{ data.father_title }}</label>
                  <center>Title</center>
                </div>
                <div style="width:20%">
                  <label class="label-name">{{ data.father_last_name }},</label>
                  <center>(Last Name,</center>
                </div>
                <div style="width:20%">
                  <label class="label-name"
                    >{{ data.father_first_name }},</label
                  >
                  <center>First Name,</center>
                </div>
                <div style="width:20%">
                  <label class="label-name">{{ data.father_mid_name }},</label>
                  <center>Middle Name,</center>
                </div>
                <div style="width:15%">
                  <label class="label-name">{{ data.father_suffix }}</label>
                  <center>Suffix (e.g. III, Jr.)</center>
                </div>
              </div>
              <br />
              <div class="divider"></div>
              <div class="rowFields mx-auto row">
                <div class="col-lg-3">
                  <p class="data-print">
                    <b>Valid Identification Cards:</b>
                  </p>
                </div>
                <div class="col-lg-3">
                  <b>SSS ID No.: </b>
                  <label style="border-bottom:1px solid black">{{
                    data.sss
                  }}</label>
                </div>
                <div class="col-lg-3">
                  <b>GSIS ID No.:</b>
                  <label style="border-bottom:1px solid black">
                    {{ data.gsis }}</label
                  >
                </div>
                <div class="col-lg-3">
                  <b> TIN ID No.:</b>
                  <label style="border-bottom:1px solid black">
                    {{ data.tin }}</label
                  >
                </div>
              </div>
              <br />

              <div class="rowFields mx-auto row" style="margin-top:-10px">
                <p class="data-print">
                  <b>Other Valid ID</b>
                </p>
              </div>
              <div class="rowFields mx-auto row" style="margin-top:-10px">
                <table
                  class="table table-bordered "
                  style="font-family:   Arial;  font-size: 11px;color:; "
                >
                  <thead class="tbl-head">
                    <tr>
                      <th scope="col">ID Type</th>
                      <th scope="col">ID Number</th>
                      <th scope="col">ID Issued Date</th>
                      <th scope="col">ID Expiry Date</th>
                      <th scope="col">ID Issue Country</th>
                      <th scope="col">Issued By</th>
                      <th scope="col">Last Update Date</th>
                    </tr>
                  </thead>
                  <tbody class="tbl-body">
                    <tr>
                      <th scope="row">{{ data.otherID1_type }}</th>
                      <td>{{ data.otherID1_number }}</td>
                      <td>{{ data.otherID1_issued_date }}</td>
                      <td>{{ data.otherID1_expiry_date }}</td>
                      <td>{{ data.otherID1_issue_country }}</td>
                      <td>{{ data.otherID1_issue_by }}</td>
                      <td>{{ data.otherID1_last_update }}</td>
                    </tr>
                    <tr>
                      <th scope="row">{{ data.otherID2_type }}</th>
                      <td>{{ data.otherID2_number }}</td>
                      <td>{{ data.otherID2_issued_date }}</td>
                      <td>{{ data.otherID2_expiry_date }}</td>
                      <td>{{ data.otherID2_issue_country }}</td>
                      <td>{{ data.otherID2_issue_by }}</td>
                      <td>{{ data.otherID2_last_update }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="divider"></div>
              <div class="rowFields mx-auto row">
                <p class="data-print">
                  <b>Address</b>
                </p>
              </div>
              <div class="rowFields mx-auto row" style="margin-top:-10px">
                <table
                  class="table table-bordered"
                  style="font-family:   Arial;
                  font-size: 11px;color:"
                >
                  <thead class="tbl-head">
                    <tr>
                      <th scope="col">
                        <center>Address Type</center>
                        <br />
                        <center></center>
                      </th>
                      <th scope="col">
                        <center>Full Address</center>
                        <br />
                        <center>
                          (Unit No, Blk No. Lot No, Sitio/Subdvision/Village,
                          Brgy, Municipality/City, Province, Country)
                        </center>
                      </th>
                      <th scope="col">
                        <center>Ownership Type</center>
                        <br />
                        <center>
                          (Owned/ Mortgaged/ Rented/Living with Parents, Free of
                          Use)
                        </center>
                      </th>
                      <th scope="col">
                        <center>Occupied Since</center>
                        <br />
                        <center></center>
                      </th>
                      <th scope="col">
                        <center>Last Update Date</center>
                        <br />
                        <center></center>
                      </th>
                    </tr>
                  </thead>
                  <tbody class="tbl-body">
                    <tr>
                      <th scope="row">
                        Present Residential Billing/Mailing Address
                      </th>
                      <td>{{ data.present_residential }}</td>
                      <td>
                        {{ data.ownership_present }} <br />
                        <b>Monthly Rate: </b> {{ data.monthly_present }}
                      </td>
                      <td>{{ data.occupied_present }}</td>
                      <td>{{ data.last_update_present }}</td>
                    </tr>
                    <tr>
                      <th scope="row">Permanent / Provincial Address</th>
                      <td>{{ data.permanent_address }}</td>
                      <td>
                        {{ data.ownership_permanent }} <br />
                        <b>Monthly Rate: </b> {{ data.monthly_permanent }}
                      </td>
                      <td>{{ data.occupied_permanent }}</td>
                      <td>{{ data.last_update_permanent }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="divider"></div>
              <div class="rowFields mx-auto row">
                <p class="data-print">
                  <b>Contact Data</b>
                </p>
              </div>
              <br />
              <div class="rowFields mx-auto row" style="margin-top:-10px">
                <table
                  class="table table-bordered"
                  style="font-family:   Arial;
                  font-size: 11px;color:"
                >
                  <tbody class="tbl-body">
                    <tr>
                      <th scope="row">Primary Contact No.:</th>
                      <td>{{ data.contact_no }}</td>
                      <td><b>Last Update Date:</b></td>
                      <td>{{ data.contact_last_update }}</td>
                    </tr>
                    <tr>
                      <th scope="row">Additional Contact Number:</th>
                      <td>{{ data.contact2_no }}</td>
                      <td><b>Last Update Date:</b></td>
                      <td>{{ data.contact2_last_update }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <br />
              <div class="rowFields mx-auto row">
                <p class="data-print">
                  <b>Employment Data</b>
                </p>
              </div>
              <br />
              <div class="rowFields mx-auto row" style="margin-top:-10px">
                <table
                  class="table table-bordered"
                  style="font-family:   Arial;
                  font-size: 11px;color:"
                >
                  <tbody class="tbl-body">
                    <tr>
                      <th scope="row">Company Trade Name ( Employer):</th>
                      <td>{{ data.emp_employer }}</td>
                      <td><b>Company TIN:</b></td>
                      <td>{{ data.emp_tin }}</td>
                    </tr>
                    <tr>
                      <th scope="row">Nature of Company (PSIC):</th>
                      <td>{{ data.emp_nature }}</td>
                      <td><b>Contact Number:</b></td>
                      <td>{{ data.emp_tel_no }}</td>
                    </tr>
                    <tr>
                      <th scope="row">Gross Income:</th>
                      <td>{{ data.emp_gross }}</td>
                      <td><b>Annual/Monthly:</b></td>
                      <td>{{ data.emp_annual }}</td>
                    </tr>
                    <tr>
                      <th scope="row">Currency:</th>
                      <td>{{ data.emp_currency }}</td>
                      <td><b>Occupational Status:</b></td>
                      <td>{{ data.emp_occ_status }}</td>
                    </tr>
                    <tr>
                      <th scope="row">Date Employed:</th>
                      <td>{{ data.emp_date_employed }}</td>
                      <td><b>Position:</b></td>
                      <td>{{ data.emp_position }}</td>
                    </tr>
                    <tr>
                      <th scope="row">Full Address:</th>
                      <td colspan="3">{{ data.emp_address }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <br />
              <div class="rowFields mx-auto row">
                <p class="data-print">
                  <b>Business Data</b>
                </p>
              </div>
              <div class="rowFields mx-auto row" style="margin-top:-10px">
                <table
                  class="table table-bordered"
                  style="font-family:   Arial;
                  font-size: 11px;color:"
                >
                  <tbody class="tbl-body">
                    <tr>
                      <th scope="row">Company Trade Name ( Employer):</th>
                      <td>{{ data.bn_name }}</td>
                      <td><b>Company TIN:</b></td>
                      <td>{{ data.bn_tin }}</td>
                    </tr>
                    <tr>
                      <th scope="row">Nature of Business (PSIC):</th>
                      <td>{{ data.bn_nature }}</td>
                      <td><b>Contact Number:</b></td>
                      <td>{{ data.bn_contact }}</td>
                    </tr>

                    <tr>
                      <th scope="row">Full Address:</th>
                      <td>{{ data.bn_address }}</td>
                      <th scope="row">Date Established:</th>
                      <td>{{ data.bn_established }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <div class="rowFields mx-auto row">
                <div class="col-lg-2">
                  <p class="msg">Source of Income:</p>
                </div>
                <div class="col-lg-9">
                  <div class="pretty p-icon p-curve p-jelly">
                    <input
                      type="radio"
                      name="income_source"
                      ref="income_source"
                      v-validate="'required'"
                      value="Business"
                      v-model.trim="data.income_source"
                    />
                    <div class="state p-success">
                      <i class="icon mdi mdi-check"></i>
                      <label> Business</label>
                    </div>
                  </div>
                  <div class="pretty p-icon p-curve p-jelly">
                    <input
                      type="radio"
                      name="income_source"
                      ref="income_source"
                      v-validate="'required'"
                      value="Employment"
                      v-model.trim="data.income_source"
                    />
                    <div class="state p-success">
                      <i class="icon mdi mdi-check"></i>
                      <label> Employment</label>
                    </div>
                  </div>
                  <div class="pretty p-icon p-curve p-jelly">
                    <input
                      type="radio"
                      name="income_source"
                      ref="income_source"
                      v-validate="'required'"
                      value="Pension"
                      v-model.trim="data.income_source"
                    />
                    <div class="state p-success">
                      <i class="icon mdi mdi-check"></i>
                      <label> Pension</label>
                    </div>
                  </div>
                  <div class="pretty p-icon p-curve p-jelly">
                    <input
                      type="radio"
                      name="income_source"
                      ref="income_source"
                      v-validate="'required'"
                      value="Remittance"
                      v-model.trim="data.income_source"
                    />
                    <div class="state p-success">
                      <i class="icon mdi mdi-check"></i>
                      <label> OFW Remittance</label>
                    </div>
                  </div>
                  <div class="pretty p-icon p-curve p-jelly">
                    <input
                      type="radio"
                      name="income_source"
                      ref="income_source"
                      v-validate="'required'"
                      value="Agri"
                      v-model.trim="data.income_source"
                    />
                    <div class="state p-success">
                      <i class="icon mdi mdi-check"></i>
                      <label>Agri-Related </label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="rowFields mx-auto row">
                <div class="col-lg-2">
                  <p class="msg">Income Received Via:</p>
                </div>
                <div class="col-lg-4">
                  <div class="pretty p-icon p-curve p-jelly">
                    <input
                      type="radio"
                      name="income_via"
                      ref="income_via"
                      v-validate="'required'"
                      value="ATM"
                      v-model="data.income_via"
                    />
                    <div class="state p-success">
                      <i class="icon mdi mdi-check"></i>
                      <label> ATM</label>
                    </div>
                  </div>
                  <div class="pretty p-icon p-curve p-jelly">
                    <input
                      type="radio"
                      name="income_via"
                      ref="income_via"
                      v-validate="'required'"
                      value="Cash"
                      v-model="data.income_via"
                    />
                    <div class="state p-success">
                      <i class="icon mdi mdi-check"></i>
                      <label>Cash</label>
                    </div>
                  </div>
                  <div class="pretty p-icon p-curve p-jelly">
                    <input
                      type="radio"
                      name="income_via"
                      ref="income_via"
                      v-validate="'required'"
                      value="Check"
                      v-model="data.income_via"
                    />
                    <div class="state p-success">
                      <i class="icon mdi mdi-check"></i>
                      <label> Check</label>
                    </div>
                  </div>
                  <div class="pretty p-icon p-curve p-jelly">
                    <input
                      type="radio"
                      name="income_via"
                      ref="income_via"
                      value="Others"
                      v-model="data.income_via"
                    />
                    <div class="state p-success">
                      <i class="icon mdi mdi-check"></i>
                      <label> Others</label>
                    </div>
                  </div>
                </div>
                <div class="col-lg-5" v-if="data.income_via == 'Others'">
                  <input
                    type="text"
                    v-model.trim="data.other_income_via"
                    @input="
                      data.other_income_via = $event.target.value.toUpperCase()
                    "
                    class="form-control"
                    v-b-tooltip.hover
                    autocomplete="off"
                    autofocus="on"
                    placeholder="Others"
                    style="margin-top:5px;margin-left:-30px"
                  />
                </div>
                <small
                  class="text-danger pull-left"
                  v-show="errors.has('income_via')"
                  >This field is required.</small
                >
              </div>
              <div class="divider"></div>
              <div class="rowFields mx-auto row">
                <p class="data-print">
                  <b>References</b>
                </p>
              </div>
              <div class="rowFields mx-auto row" style="margin-top:-10px">
                <table
                  class="table"
                  style="font-family:   Arial;
                  font-size: 11px;color:"
                >
                  <thead class="tbl-head">
                    <tr>
                      <th scope="col"><center>Name</center></th>
                      <th scope="col"><center>Address/Company</center></th>
                      <th scope="col"><center>Tel No.</center></th>
                    </tr>
                  </thead>
                  <tbody class="tbl-body">
                    <tr>
                      <th scope="row">
                        <center>{{ data.ref1_name }}</center>
                      </th>
                      <td>
                        <center>{{ data.ref1_address }}</center>
                      </td>
                      <td>
                        <center>{{ data.ref1_contact }}</center>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">
                        <center>{{ data.ref2_name }}</center>
                      </th>
                      <td>
                        <center>{{ data.ref2_address }}</center>
                      </td>
                      <td>
                        <center>{{ data.ref2_contact }}</center>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div
                class="rowFields mx-auto row"
                style="width:100%;display:flex"
              >
                <div style="width:50%">
                  <center><b>Home Address:</b></center>
                  <br />
                  <center>
                    <img
                      class="preview"
                      :src="$img_path + data.image_sketch"
                      width="320"
                      height="200"
                    />
                  </center>
                </div>
                <div style="width:50%">
                  <center><b>Business Address:</b></center>
                  <br />
                  <center>
                    <img
                      class="preview"
                      :src="$img_path + data.image_sketch_2"
                      width="320"
                      height="200"
                    />
                  </center>
                </div>
              </div>
              <br />
              <br />
              <div class="rowFields mx-auto row">
                <center>
                  <p class="text-justify lh-sm" style="line-height:1.5em">
                    <strong class="king">
                      I hereby affirm that the information given by me is true
                      and correct. I authorized you to verify and i nvestigate
                      it from whatever sources you may consider appropriate. I
                      also confirm and acknowledge that the above information
                      and those which may arise as needed, is voluntary provided
                      to King Multipurpose Cooperative pursuant to RA 9510
                      otherwise known as Credit Information System Act (CISA). I
                      certify that I am fully informed and understood the
                      following: 1. That, King Multipurpose Cooperative, is
                      mandated to submit my basic credit data to Credit
                      Information Corporation (CIC) 2. That the said credit data
                      may be used by other lenders as authorized by CIC and
                      other accredited credit reporting agencies. 3. That the
                      said credit data could be used in establishing my future
                      credit worthiness.</strong
                    >
                  </p>
                </center>
              </div>
              <br />
              <br />
              <div
                class="rowFields mx-auto row"
                style="width:100%:display:flex"
              >
                <div style="width:10%"></div>
                <div style="border-top:1px solid black;width:30%">
                  <center><b>Applicant's Complete Name</b></center>
                </div>
                <div style="width:20%"></div>
                <div style="border-top:1px solid black;width:30%">
                  <center>
                    <b>Signature</b>
                  </center>
                </div>
                <div style="width:10%"></div>
              </div>
            </div>
          </td>
        </tr>
      </table>

      <b-button class="proceed-btn" size="sm" @click="printElement('printFSR')">
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
  props: [
    "data"
  ],
  components: {
    "model-list-select": ModelListSelect,
    "date-picker": datePicker,
    "p-check": PrettyCheck,
    "p-radio": PrettyRadio
  },
  data() {
    return {
      user: {},
      roles: [],
      data: [],
      branch: ""
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
      // this.$htmlToPaper("printFSR");
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
      this.$http.get("api/Member/" + this.id).then(response => {
        // console.log(response.body.branch.name);
        this.data = response.body;
        this.branch = response.body.branch.name;

        $(".page-loader-wrapper").fadeOut();
      });
    }
    // printPreview() {
    //   window.print();
    //   // this.$htmlToPaper("printable");
    // }
  }
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

  .printFSR {
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
