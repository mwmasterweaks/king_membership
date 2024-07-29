<template>
  <div>
    <!-- modal application -->
    <b-modal
      id="ModalEditApplication"
      :header-bg-variant="' elBG'"
      :header-text-variant="' elClr'"
      :body-bg-variant="' elBG'"
      :body-text-variant="' elClr'"
      :footer-bg-variant="' elBG'"
      :footer-text-variant="' elClr'"
      size="xl"
      title="Membership Application Form"
      :no-close-on-backdrop="true"
    >
      <div id="not-printable">
        <div class="row" id="print1">
          <div class="col-md-9">
            <div class="rowFields mx-auto row">
              <div class="col-lg-2">
                <p class="msg text-success"><b> Status</b></p>
              </div>
              <div class="col-lg-9">

               <model-list-select
                  :list="status_list"
                  option-value="value"
                  option-text="name"
                  v-model.trim="data.membership_status"
                  placeholder="Select Status"
                  name="membership_status"
                  v-validate="'required'"
                ></model-list-select>
                <small
                  class="text-danger pull-left"
                  v-show="errors.has('membership_status')"
                  >Membership Status is required.</small
                >

              </div>
            </div>
            <br />
            <div
              class="rowFields mx-auto row"
              v-if="data.membership_status == 'A'"
            >
              <div class="col-lg-2">
                <p class="msg">Account No.:</p>
              </div>
              <div class="col-lg-9">
                <input
                  type="text"
                  v-model.trim="data.acc_no"
                  :disabled="!roles.update_application"
                  class="form-control"
                  v-b-tooltip.hover
                  placeholder="Please enter your account number"
                  autocomplete="off"
                  autofocus="on"
                  style="margin-top: 5px"
                />
              </div>
            </div>
            <div class="rowFields mx-auto row">
              <div class="col-lg-2">
                <p class="msg">Email:</p>
              </div>
              <div class="col-lg-9">
                <input
                  type="text"
                  name="email"
                  ref="email"
                  v-model.trim="data.email"
                  :disabled="!roles.update_application"
                  class="form-control"
                  v-b-tooltip.hover
                  placeholder="Please enter your email"
                  v-validate="'required'"
                  autocomplete="off"
                  autofocus="on"
                />
                <small
                  class="text-danger pull-left"
                  v-show="errors.has('email')"
                  >Email is required.</small
                >
              </div>
            </div>
            <div class="rowFields mx-auto row">
              <div class="col-lg-2">
                <p class="msg" style="margin-top: 5px">Branch:</p>
              </div>
              <div class="col-lg-9">
                <model-list-select
                  :list="branches"
                  option-value="id"
                  option-text="name"
                  v-model.trim="data.branch_id"
                  placeholder="Select Branch"
                  name="branch"
                  v-validate="'required'"
                ></model-list-select>
                <small
                  class="text-danger pull-left"
                  v-show="errors.has('branch')"
                  >Branch is required.</small
                >
              </div>
            </div>
            <div class="rowFields mx-auto row">
              <div class="col-lg-2">
                <p class="msg" style="margin-top: 5px">Membership Type:</p>
              </div>
              <div class="col-lg-9">
                <b-form-select
                  v-model="data.membership_type"
                  :options="membership_type_list"
                  size="sm"
                  class="mt-3"
                  value-field="id"
                  text-field="name"
                ></b-form-select>
              </div>
            </div>

          </div>
          <div class="col-md-3 image-preview" v-if="imageData == ''">
            <img
              class="preview"
              :src="$img_path + data.image"
              width="200"
              height="200"
              style="cursor: pointer"
              v-b-tooltip.hover
              title="View Image"
              @click="viewAttachment(data.image)"
            />
          </div>
          <div class="col-md-3 image-preview" v-else>
            <img class="preview" :src="imageData" />
          </div>
        </div>
        <br />
        <div class="row">
          <div class="col-md-9"></div>
          <div class="col-md-3">
            <input
              type="file"
              @change="previewImage"
              accept="image/*"
              class="image-input"
              name="image"
              ref="image"
            />
          </div>
        </div>
        <div id="tabs">
          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
              <a
                class="nav-link active"
                data-toggle="tab"
                href="#Info_1"
                role="tab"
              >
                <i class="fas fa-user-clock"></i> Part I
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#Info_2" role="tab">
                <i class="fas fa-id-badge"></i> Part II
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#Info_3" role="tab">
                <i class="fas fa-id-badge"></i> Part III
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#Info_4" role="tab">
                <i class="fas fa-id-badge"></i>Part IV
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#Info_5" role="tab">
                <i class="fas fa-id-badge"></i>Part V
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#Info_6" role="tab">
                <i class="fas fa-id-badge"></i>Part VI
              </a>
            </li>
          </ul>
          <div class="tab-content text-left">
            <div class="tab-pane active" id="Info_1" role="tabpanel">
              <div class="emp-heading" style="display: flex">
                <label class="header text-success">
                  Personal Information(Member)</label
                >
              </div>
              <div class="panel-body">
                <form>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Title:</p>
                    </div>
                    <div class="col-lg-9">
                      <b-form-select
                        name="title"
                        ref="title"
                        v-model="data.title"
                        :options="title_options"
                        size="sm"
                        class="mt-3"
                      ></b-form-select>
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('title')"
                        >This field is required.</small
                      >
                      <!-- <input
                        type="text"
                        name="title"
                        ref="title"
                        v-model.trim="data.title"
                        @input="data.title = $event.target.value.toUpperCase()"
                        :disabled="!roles.update_application"
                        class="form-control"
                        v-validate="'required'"
                        autocomplete="off"
                        autofocus="on"
                        placeholder="Ex.:Mr./Ms./Mrs."
                      />
                      -->
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Nickname:</p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        type="text"
                        name="nname"
                        ref="nname"
                        v-model.trim="data.nickname"
                        class="form-control"
                        v-validate="'required'"
                        autocomplete="off"
                        autofocus="on"
                        @input="
                          data.nickname = $event.target.value.toUpperCase()
                        "
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('nname')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">First Name:</p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        type="text"
                        name="fname"
                        ref="fname"
                        v-model.trim="data.first_name"
                        class="form-control"
                        @input="
                          data.first_name = $event.target.value.toUpperCase()
                        "
                        v-validate="'required'"
                        autocomplete="off"
                        autofocus="on"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('fname')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Middle Name:</p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        type="text"
                        name="mname"
                        ref="mname"
                        class="form-control"
                        v-model.trim="data.mid_name"
                        @input="
                          data.mid_name = $event.target.value.toUpperCase()
                        "
                        v-validate="'required'"
                        autocomplete="off"
                        autofocus="on"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('mname')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Last Name:</p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        type="text"
                        name="lname"
                        ref="lname"
                        class="form-control"
                        v-model.trim="data.last_name"
                        @input="
                          data.last_name = $event.target.value.toUpperCase()
                        "
                        v-validate="'required'"
                        autocomplete="off"
                        autofocus="on"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('lname')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Previous Last Name:</p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        name="prev_last_name"
                        ref="prev_last_name"
                        type="text"
                        class="form-control"
                        v-model.trim="data.prev_last_name"
                        @input="
                          data.prev_last_name =
                            $event.target.value.toUpperCase()
                        "
                        autocomplete="off"
                        autofocus="on"
                      />
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Suffix:</p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        type="text"
                        name="suffix"
                        ref="suffix"
                        class="form-control"
                        v-model.trim="data.suffix"
                        @input="data.suffix = $event.target.value.toUpperCase()"
                        placeholder="Suffix (e.g III, Jr)"
                        autocomplete="off"
                        autofocus="on"
                      />
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Age:</p>
                    </div>
                    <div class="col-lg-9">
                      <b-form-input
                        type="number"
                        name="age"
                        ref="age"
                        v-validate="'required'"
                        class="form-control"
                        v-model.trim="data.age"
                        @input="data.age = $event.target.value.toUpperCase()"
                        title="Age of the member"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('age')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Gender:</p>
                    </div>
                    <div class="col-lg-9">
                      <div
                        class="pretty p-icon p-curve p-jelly"
                        style="margin-top: 15px"
                      >
                        <input
                          type="radio"
                          name="gender"
                          ref="gender"
                          value="M"
                          v-model.trim="data.gender"
                          v-validate="'required'"
                        />

                        <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label> Male</label>
                        </div>
                      </div>
                      <div
                        class="pretty p-icon p-curve p-jelly"
                        style="margin-top: 15px"
                      >
                        <input
                          type="radio"
                          name="gender"
                          ref="gender"
                          value="F"
                          v-model.trim="data.gender"
                          v-validate="'required'"
                        />
                        <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label> Female</label>
                        </div>
                      </div>
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('gender')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Date of Birth:</p>
                    </div>
                    <div class="col-lg-9">
                      <div class="input-group">
                        <date-picker
                          v-model.trim="data.birthdate"
                          :config="Dateoptions"
                          v-b-tooltip.hover
                          placeholder="Select Date"
                          autocomplete="off"
                          v-validate="'required'"
                          name="birthdate"
                          @input="calcuAge(data.birthdate)"
                        ></date-picker>
                      </div>
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('birthdate')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Nationality:</p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        type="text"
                        name="nationality"
                        ref="nationality"
                        class="form-control"
                        v-model.trim="data.nationality"
                        @input="
                          data.nationality = $event.target.value.toUpperCase()
                        "
                        v-validate="'required'"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('nationality')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Country of Birth:</p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        type="text"
                        name="birthcountry"
                        ref="birthcountry"
                        class="form-control"
                        v-model.trim="data.birthcountry"
                        @input="
                          data.birthcountry = $event.target.value.toUpperCase()
                        "
                        v-validate="'required'"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                      />

                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('birthcountry')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Place of Birth:</p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        type="text"
                        name="birthplace"
                        ref="birthplace"
                        class="form-control"
                        v-model.trim="data.birthplace"
                        @input="
                          data.birthplace = $event.target.value.toUpperCase()
                        "
                        v-validate="'required'"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('birthplace')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Resident:</p>
                    </div>
                    <div class="col-lg-2">
                      <div
                        class="pretty p-icon p-curve p-jelly"
                        style="margin-top: 15px"
                      >
                        <input
                          type="radio"
                          name="resident"
                          value="1"
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
                        style="margin-top: 15px"
                      >
                        <input
                          type="radio"
                          name="resident"
                          value="2"
                          v-model.trim="data.resident"
                          v-validate="'required'"
                        />
                        <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label> No</label>
                        </div>
                      </div>

                      <div
                        class="pretty p-icon p-curve p-jelly"
                        style="margin-top: 15px"
                      >
                        <small
                          class="text-danger pull-left"
                          v-show="errors.has('resident')"
                          >This field is required.</small
                        >
                      </div>
                    </div>
                    <div class="col-lg-4" v-if="data.resident == '2'">
                      <input
                        type="text"
                        name="resident_citizenship"
                        ref="resident_citizenship"
                        v-model.trim="data.resident_citizenship"
                        @input="
                          data.Citizenship = $event.target.value.toUpperCase()
                        "
                        class="form-control"
                        v-validate="'required'"
                        autocomplete="off"
                        autofocus="on"
                        placeholder="Citizenship"
                        style="margin-top: 5px; margin-left: -20px"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="
                          data.resident == '2' &&
                          data.resident_citizenship == ''
                        "
                        >This field is required.</small
                      >
                    </div>
                  </div>

                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Civil Status:</p>
                    </div>
                    <div class="col-lg-9">
                      <div
                        class="pretty p-icon p-curve p-jelly"
                        style="margin-top: 15px"
                      >
                        <input
                          type="radio"
                          name="civil_stat"
                          value="Single"
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
                        style="margin-top: 15px"
                      >
                        <input
                          type="radio"
                          name="civil_stat"
                          value="MAR"
                          v-model.trim="data.civil_stat"
                        />
                        <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label> Married</label>
                        </div>
                      </div>
                      <div
                        class="pretty p-icon p-curve p-jelly"
                        style="margin-top: 15px"
                      >
                        <input
                          type="radio"
                          name="civil_stat"
                          value="WID"
                          v-model.trim="data.civil_stat"
                        />
                        <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label> Widowed</label>
                        </div>
                      </div>
                      <div
                        class="pretty p-icon p-curve p-jelly"
                        style="margin-top: 15px"
                      >
                        <input
                          type="radio"
                          name="civil_stat"
                          value="SEP"
                          v-model.trim="data.civil_stat"
                        />
                        <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label> Separated</label>
                        </div>
                      </div>
                      <div
                        class="pretty p-icon p-curve p-jelly"
                        style="margin-top: 15px"
                      >
                        <input
                          type="radio"
                          name="civil_stat"
                          value="WLIVE"
                          v-model.trim="data.civil_stat"
                        />
                        <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label> W/Live-in Partner</label>
                        </div>
                      </div>
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('civil_stat')"
                        >This field is required.</small
                      >
                    </div>
                  </div>

                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Height(feet & inches):</p>
                    </div>
                    <div class="col-lg-4">
                      <input
                        type="text"
                        name="height"
                        ref="height"
                        class="form-control"
                        v-model.trim="data.height"
                        v-validate="'required'"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                      />

                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('height')"
                        >This field is required.</small
                      >
                    </div>
                    <div class="col-lg-2">
                      <p class="msg">Weight(pounds/kilos):</p>
                    </div>
                    <div class="col-lg-4">
                      <input
                        type="text"
                        name="weight"
                        ref="weight"
                        class="form-control"
                        v-model.trim="data.weight"
                        v-validate="'required'"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                      />

                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('weight')"
                        >This field is required.</small
                      >
                    </div>
                  </div>

                  <hr />

                  <div class="rowFields mx-auto row">
                    <div class="col-lg-3">
                      <p class="msg">Total No. of Dependents:</p>
                    </div>
                    <div class="col-lg-8">
                      <b-form-input
                        name="dependents_no"
                        ref="dependents_no"
                        v-validate="'required'"
                        type="number"
                        class="form-control"
                        v-model.trim="data.dependents_no"
                        @input="
                          data.dependents_no = $event.target.value.toUpperCase()
                        "
                        style="margin-top: 8px"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('dependents_no')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">No. of Children:</p>
                    </div>
                    <div class="col-lg-9">
                      <b-form-input
                        name="children_no"
                        ref="children_no"
                        v-validate="'required'"
                        type="number"
                        class="form-control"
                        v-model.trim="data.children_no"
                        style="margin-top: 8px"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('children_no')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-3">
                      <p class="msg">No. of Household Members:</p>
                    </div>
                    <div class="col-lg-8">
                      <b-form-input
                        name="household_no"
                        ref="household_no"
                        type="number"
                        class="form-control"
                        v-model.trim="data.household_no"
                        style="margin-top: 8px"
                        v-validate="'required'"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('household_no')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-3">
                      <p class="msg">No. of Real Estate Property Owned:</p>
                    </div>
                    <div class="col-lg-8">
                      <b-form-input
                        v-validate="'required'"
                        name="owned_properties"
                        ref="owned_properties"
                        type="number"
                        class="form-control"
                        v-model.trim="data.owned_properties"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('owned_properties')"
                        >Field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-3">
                      <p class="msg">Number of Car(s) owned:</p>
                    </div>
                    <div class="col-lg-8">
                      <b-form-input
                        v-validate="'required'"
                        name="owned_cars"
                        ref="owned_cars"
                        type="number"
                        class="form-control"
                        v-model.trim="data.owned_cars"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('owned_cars')"
                        >Field is required.</small
                      >
                    </div>
                  </div>
                  <hr />
                  <div class="emp-heading" style="display: flex">
                    <label class="header text-success">
                      Spouse Information</label
                    >
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Name:</p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        type="text"
                        name="spouse_name"
                        ref="spouse_name"
                        v-validate="'required'"
                        v-model.trim="data.spouse_name"
                        @input="
                          data.spouse_name = $event.target.value.toUpperCase()
                        "
                        class="form-control"
                        autocomplete="off"
                        autofocus="on"
                        style="margin-top: 8px"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('spouse_name')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Age:</p>
                    </div>
                    <div class="col-lg-9">
                      <b-form-input
                        name="spouse_age"
                        ref="spouse_age"
                        v-validate="'required'"
                        type="number"
                        class="form-control"
                        v-model.trim="data.spouse_age"
                        style="margin-top: 8px"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('spouse_age')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Occupation:</p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        type="text"
                        name="spouse_occupation"
                        ref="spouse_occupation"
                        v-validate="'required'"
                        v-model.trim="data.spouse_occupation"
                        @input="
                          data.spouse_occupation =
                            $event.target.value.toUpperCase()
                        "
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                        style="margin-top: 8px"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('spouse_occupation')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Employer:</p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        type="text"
                        name="spouse_employer"
                        ref="spouse_employer"
                        v-validate="'required'"
                        v-model.trim="data.spouse_employer"
                        @input="
                          data.spouse_employer =
                            $event.target.value.toUpperCase()
                        "
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                        style="margin-top: 8px"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('spouse_employer')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Address:</p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        type="text"
                        name="spouse_address"
                        ref="spouse_address"
                        v-validate="'required'"
                        v-model.trim="data.spouse_address"
                        @input="
                          data.spouse_address =
                            $event.target.value.toUpperCase()
                        "
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                        style="margin-top: 8px"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('spouse_address')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <hr />
                  <div class="emp-heading" style="display: flex">
                    <label class="header text-success">
                      Mother's Information
                    </label>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Title:</p>
                    </div>
                    <div class="col-lg-9">
                      <b-form-select
                        name="mother_title"
                        ref="mother_title"
                        v-validate="'required'"
                        v-model="data.mother_title"
                        :options="title_options"
                        size="sm"
                        class="mt-3"
                      ></b-form-select>
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('mother_title')"
                        >This field is required.</small
                      >
                      <!-- <input
                        type="text"
                        name="mother_title"
                        ref="mother_title"
                        v-validate="'required'"
                        v-model.trim="data.mother_title"
                        @input="
                          data.mother_title = $event.target.value.toUpperCase()
                        "
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                        style="margin-top: 8px"
                      /> -->
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">First Name:</p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        type="text"
                        name="mother_first_name"
                        ref="mother_first_name"
                        v-validate="'required'"
                        v-model.trim="data.mother_first_name"
                        @input="
                          data.mother_first_name =
                            $event.target.value.toUpperCase()
                        "
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                        style="margin-top: 8px"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('mother_first_name')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-3">
                      <p class="msg">Middle Name(Maiden):</p>
                    </div>
                    <div class="col-lg-8">
                      <input
                        type="text"
                        name="mother_mid_name"
                        ref="mother_mid_name"
                        v-validate="'required'"
                        v-model.trim="data.mother_mid_name"
                        @input="
                          data.mother_mid_name =
                            $event.target.value.toUpperCase()
                        "
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                        style="margin-top: 8px"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('mother_mid_name')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-3">
                      <p class="msg">Last Name(Maiden):</p>
                    </div>
                    <div class="col-lg-8">
                      <input
                        type="text"
                        name="mother_last_name"
                        ref="mother_last_name"
                        v-validate="'required'"
                        v-model.trim="data.mother_last_name"
                        @input="
                          data.mother_last_name =
                            $event.target.value.toUpperCase()
                        "
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                        style="margin-top: 8px"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('mother_last_name')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Suffix:</p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        type="text"
                        name="mother_suffix"
                        ref="mother_suffix"
                        v-model.trim="data.mother_suffix"
                        @input="
                          data.mother_suffix = $event.target.value.toUpperCase()
                        "
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                        style="margin-top: 8px"
                      />
                    </div>
                  </div>
                  <hr />
                  <div class="emp-heading" style="display: flex">
                    <label class="header text-success">
                      Father's Information
                    </label>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Title:</p>
                    </div>
                    <div class="col-lg-9">
                      <b-form-select
                        name="father_title"
                        ref="father_title"
                        v-validate="'required'"
                        v-model="data.father_title"
                        :options="title_options"
                        size="sm"
                        class="mt-3"
                      ></b-form-select>
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('father_title')"
                        >This field is required.</small
                      >
                      <!-- <input
                        type="text"
                        name="father_title"
                        ref="father_title"
                        v-validate="'required'"
                        v-model.trim="data.father_title"
                        @input="
                          data.father_title = $event.target.value.toUpperCase()
                        "
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                        style="margin-top: 8px"
                      />
                      -->
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">First Name:</p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        type="text"
                        name="father_first_name"
                        ref="father_first_name"
                        v-validate="'required'"
                        v-model.trim="data.father_first_name"
                        @input="
                          data.father_first_name =
                            $event.target.value.toUpperCase()
                        "
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                        style="margin-top: 8px"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('father_first_name')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Middle Name:</p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        type="text"
                        name="father_mid_name"
                        ref="father_mid_name"
                        v-validate="'required'"
                        v-model.trim="data.father_mid_name"
                        @input="
                          data.father_mid_name =
                            $event.target.value.toUpperCase()
                        "
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                        style="margin-top: 8px"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('father_mid_name')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Last Name:</p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        type="text"
                        name="father_last_name"
                        ref="father_last_name"
                        v-validate="'required'"
                        v-model.trim="data.father_last_name"
                        @input="
                          data.father_last_name =
                            $event.target.value.toUpperCase()
                        "
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                        style="margin-top: 8px"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('father_last_name')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Suffix:</p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        type="text"
                        name="father_suffix"
                        ref="father_suffix"
                        v-model.trim="data.father_suffix"
                        @input="
                          data.father_suffix = $event.target.value.toUpperCase()
                        "
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                        style="margin-top: 8px"
                      />
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="tab-pane" id="Info_2" role="tabpanel">
              <div class="emp-heading" style="display: flex">
                <label class="header text-success"> Valid IDs</label>
              </div>
              <div class="elClr panel-body">
                <form>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">SSS ID No:</p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        type="text"
                        name="sss"
                        v-model.trim="data.sss"
                        @input="data.sss = $event.target.value.toUpperCase()"
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                      />
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">GSIS ID No:</p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        type="text"
                        name="gsis"
                        v-model.trim="data.gsis"
                        @input="data.gsis = $event.target.value.toUpperCase()"
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                      />
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">TIN ID No:</p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        type="text"
                        name="tin"
                        v-model.trim="data.tin"
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                      />
                    </div>
                  </div>
                  <br />
                  <label class="header"><b>Other Valid ID 1</b></label>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">ID Type:</p>
                    </div>
                    <div class="col-lg-4" style="margin-top: 8px">
                      <input
                        type="text"
                        name="otherID1_type"
                        v-model.trim="data.otherID1_type"
                        @input="
                          data.otherID1_type = $event.target.value.toUpperCase()
                        "
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                      />
                    </div>
                    <div class="col-lg-2">
                      <p class="msg">ID Number :</p>
                    </div>
                    <div class="col-lg-4" style="margin-top: 8px">
                      <input
                        type="text"
                        v-model.trim="data.otherID1_number"
                        @input="
                          data.otherID1_number =
                            $event.target.value.toUpperCase()
                        "
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                      />
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Issued Date:</p>
                    </div>
                    <div class="col-lg-4" style="margin-top: 8px">
                      <date-picker
                        name="otherID1_issued_date"
                        v-model.trim="data.otherID1_issued_date"
                        :config="Dateoptions"
                        v-b-tooltip.hover
                        placeholder="Select Date"
                        autocomplete="off"
                      ></date-picker>
                    </div>
                    <div class="col-lg-2">
                      <p class="msg">Expiry Date:</p>
                    </div>
                    <div class="col-lg-4" style="margin-top: 8px">
                      <date-picker
                        v-model.trim="data.otherID1_expiry_date"
                        :config="Dateoptions"
                        v-b-tooltip.hover
                        placeholder="Select Date"
                        autocomplete="off"
                      ></date-picker>
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Last Update:</p>
                    </div>
                    <div class="col-lg-2" style="margin-top: 8px">
                      <date-picker
                        name="otherID1_last_update"
                        v-model.trim="data.otherID1_last_update"
                        :config="Dateoptions"
                        v-b-tooltip.hover
                        placeholder="Select Date"
                        autocomplete="off"
                      ></date-picker>
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('otherID1_last_update')"
                        >This field is required.</small
                      >
                    </div>
                    <div class="col-lg-2">
                      <p class="msg">Issue Country:</p>
                    </div>
                    <div class="col-lg-2" style="margin-top: 8px">
                      <input
                        type="text"
                        name="otherID1_issue_country"
                        v-model.trim="data.otherID1_issue_country"
                        @input="
                          data.otherID1_issue_country =
                            $event.target.value.toUpperCase()
                        "
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                      />
                    </div>
                    <div class="col-lg-2">
                      <p class="msg">Issued By:</p>
                    </div>
                    <div class="col-lg-2" style="margin-top: 8px">
                      <input
                        type="text"
                        name="otherID1_issue_by"
                        v-model.trim="data.otherID1_issue_by"
                        @input="
                          data.otherID1_issue_by =
                            $event.target.value.toUpperCase()
                        "
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                      />
                    </div>
                  </div>
                  <br />
                  <label class="header"><b>Other Valid ID 2</b></label>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">ID Type:</p>
                    </div>
                    <div class="col-lg-4" style="margin-top: 8px">
                      <input
                        type="text"
                        name="otherID2_type"
                        v-model.trim="data.otherID2_type"
                        @input="
                          data.otherID2_type = $event.target.value.toUpperCase()
                        "
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                      />
                    </div>
                    <div class="col-lg-2">
                      <p class="msg">ID Number :</p>
                    </div>
                    <div class="col-lg-4" style="margin-top: 8px">
                      <input
                        type="text"
                        name="otherID2_number"
                        v-model.trim="data.otherID2_number"
                        @input="
                          data.otherID2_number =
                            $event.target.value.toUpperCase()
                        "
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                      />
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Issued Date:</p>
                    </div>
                    <div class="col-lg-4" style="margin-top: 8px">
                      <date-picker
                        name="otherID2_issued_date"
                        v-model.trim="data.otherID2_issued_date"
                        :config="Dateoptions"
                        v-b-tooltip.hover
                        placeholder="Select Date"
                        autocomplete="off"
                      ></date-picker>
                    </div>
                    <div class="col-lg-2">
                      <p class="msg">Expiry Date:</p>
                    </div>
                    <div class="col-lg-4" style="margin-top: 8px">
                      <date-picker
                        name="otherID2_expiry_date"
                        v-model.trim="data.otherID2_expiry_date"
                        :config="Dateoptions"
                        v-b-tooltip.hover
                        placeholder="Select Date"
                        autocomplete="off"
                      ></date-picker>
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('otherID2_expiry_date')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Last Update:</p>
                    </div>
                    <div class="col-lg-2" style="margin-top: 8px">
                      <date-picker
                        name="otherID2_last_update"
                        v-model.trim="data.otherID2_last_update"
                        :config="Dateoptions"
                        v-b-tooltip.hover
                        placeholder="Select Date"
                        autocomplete="off"
                      ></date-picker>
                    </div>
                    <div class="col-lg-2">
                      <p class="msg">Issue Country:</p>
                    </div>
                    <div class="col-lg-2" style="margin-top: 8px">
                      <input
                        type="text"
                        name="otherID2_issue_country"
                        v-model.trim="data.otherID2_issue_country"
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                      />
                    </div>
                    <div class="col-lg-2">
                      <p class="msg">Issued By:</p>
                    </div>
                    <div class="col-lg-2" style="margin-top: 8px">
                      <input
                        type="text"
                        name="otherID2_issue_by"
                        v-model.trim="data.otherID2_issue_by"
                        @input="
                          data.otherID2_issue_by =
                            $event.target.value.toUpperCase()
                        "
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                      />
                    </div>
                  </div>
                </form>
              </div>
              <div class="elClr panel-body">
                <form></form>
              </div>
            </div>
            <div class="tab-pane" id="Info_3" role="tabpanel">
              <div class="emp-heading" style="display: flex">
                <label class="header text-success"> Address </label>
              </div>
              <div class="elClr panel-body">
                <form>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Country:</p>
                    </div>
                    <div class="col-lg-9">
                      <model-list-select
                        :list="countries"
                        option-value="id"
                        option-text="name"
                        v-model.trim="data.country_object"
                        placeholder="Select Country"
                        name="country"
                        @input="onChangeCountry()"
                        autocomplete="off"
                        v-validate="'required'"
                      ></model-list-select>
                      <small
                        class="text-danger pull-left"
                        v-show="data.country_object.name == ''"
                        >Country is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Region:</p>
                    </div>
                    <div class="col-lg-9">
                      <model-list-select
                        :list="regions"
                        option-value="id"
                        option-text="name"
                        v-model.trim="data.region_object"
                        placeholder="Select Region"
                        name="region"
                        @input="onChangeRegion()"
                        autocomplete="off"
                        v-validate="'required'"
                      ></model-list-select>
                      <span v-if="data.region_object != null">
                         <small
                        class="text-danger pull-left"
                        v-show="data.region_object.name == ''"
                        >Region is required.</small
                      >
                      </span>

                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Province:</p>
                    </div>
                    <div class="col-lg-9">
                      <model-list-select
                        :list="provinces"
                        option-value="id"
                        option-text="name"
                        v-model.trim="data.province_object"
                        placeholder="Select Province"
                        name="province"
                        @input="onChangeProvince()"
                        autocomplete="off"
                        v-validate="'required'"
                      ></model-list-select>
                      <span v-if="data.province_object != null">
                      <small
                        class="text-danger pull-left"
                        v-show="data.province_object.name == ''"
                        >Province is required.</small
                      >
                      </span>
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Municipality/City:</p>
                    </div>
                    <div class="col-lg-9">
                      <model-list-select
                        :list="cities"
                        option-value="id"
                        option-text="name"
                        v-model.trim="data.city_object"
                        placeholder="Select City"
                        name="city"
                        @input="onChangeCity()"
                        autocomplete="off"
                        v-validate="'required'"
                      ></model-list-select>
                      <small
                        class="text-danger pull-left"
                        v-show="data.city_object.name == ''"
                        >City is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Barangay:</p>
                    </div>
                    <div class="col-lg-9">
                      <model-list-select
                        :list="barangays"
                        option-value="id"
                        option-text="name"
                        v-model.trim="data.barangay_object"
                        placeholder="Select Barangay"
                        name="barangay"
                        v-validate="'required'"
                      ></model-list-select>
                      <small
                        class="text-danger pull-left"
                        v-show="data.barangay_object.name == ''"
                        >Barangay is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Street/House No./Block No:</p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        name="street"
                        title="Street/House No./Block No./Subdivision"
                        placeholder="Street/House No./Block No./Subdivision"
                        v-validate="'required'"
                        type="text"
                        v-model.trim="data.street"
                        @input="
                          data.street =
                            $event.target.value.toUpperCase()
                        "
                        class="form-control"
                        v-b-tooltip.hover
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('street')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Postal Code:</p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        name="postal_code"
                        ref="postal_code"
                        v-validate="'required'"
                        type="text"
                        v-model.trim="data.postal_code"
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('postal_code')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-3">
                      <p class="msg">
                        Present Residential Billing/Mailing Address:
                      </p>
                    </div>
                    <div class="col-lg-8">
                      <textarea
                        disabled
                        rows="4"
                        name="present_residential"
                        class="form-control"
                        v-model.trim="present_residential"
                        placeholder="Full Address
                        (Unit No, Blk No. Lot No, Sitio/Subdvision/Village, Brgy, Municipality/City,
                        Province, Country)"
                      ></textarea>

                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('present_residential')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Ownership:</p>
                    </div>
                    <div class="col-lg-9">
                      <div
                        class="pretty p-icon p-curve p-jelly"
                        style="margin-top: 15px"
                      >
                        <input
                          type="radio"
                          name="ownership_present"
                          ref="ownership_present"
                          value="Owned"
                          v-model.trim="data.ownership_present"
                        />
                        <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label> Owned</label>
                        </div>
                      </div>
                      <div
                        class="pretty p-icon p-curve p-jelly"
                        style="margin-top: 15px"
                      >
                        <input
                          type="radio"
                          name="ownership_present"
                          ref="ownership_present"
                          value="Mortgaged"
                          v-model.trim="data.ownership_present"
                        />
                        <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label> Mortgaged</label>
                        </div>
                      </div>
                      <div
                        class="pretty p-icon p-curve p-jelly"
                        style="margin-top: 15px"
                      >
                        <input
                          type="radio"
                          name="ownership_present"
                          ref="ownership_present"
                          value="Rented"
                          v-model.trim="data.ownership_present"
                        />
                        <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label> Rented</label>
                        </div>
                      </div>
                      <div
                        class="pretty p-icon p-curve p-jelly"
                        style="margin-top: 15px"
                      >
                        <input
                          type="radio"
                          name="ownership_present"
                          ref="ownership_present"
                          value="Free"
                          v-model.trim="data.ownership_present"
                        />
                        <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label> Free Use</label>
                        </div>
                      </div>
                      <div
                        class="pretty p-icon p-curve p-jelly"
                        style="margin-top: 15px"
                      >
                        <input
                          type="radio"
                          name="ownership_present"
                          ref="ownership_present"
                          value="Parents"
                          v-model.trim="data.ownership_present"
                        />
                        <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label> Living w/ Parents or Relatives</label>
                        </div>
                      </div>
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('ownership_present')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Monthly Rate:</p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        name="monthly_present"
                        ref="monthly_present"
                        type="text"
                        v-model.trim="data.monthly_present"
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('monthly_present')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Occupied since:</p>
                    </div>
                    <div class="col-lg-9">
                      <div class="input-group">
                        <date-picker
                          v-model.trim="data.occupied_present"
                          :config="Dateoptions"
                          v-b-tooltip.hover
                          placeholder="Select Date"
                          autocomplete="off"
                          name="occupied_present"
                          ref="occupied_present"
                        ></date-picker>
                      </div>
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('occupied_present')"
                        >Field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Last Update Date:</p>
                    </div>
                    <div class="col-lg-9">
                      <div class="input-group">
                        <date-picker
                          v-model.trim="data.last_update_present"
                          :config="Dateoptions"
                          v-b-tooltip.hover
                          placeholder="Select Date"
                          autocomplete="off"
                          name="last_update_present"
                          ref="last_update_present"
                        ></date-picker>
                      </div>
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('last_update_present')"
                        >Field is required.</small
                      >
                    </div>
                  </div>
                  <hr />
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Permanent / Provincial Address:</p>
                    </div>
                    <div class="col-lg-9">
                      <textarea
                        :disabled="copyPresent"
                        rows="4"
                        name="permanent_address"
                        class="form-control"
                        v-model.trim="data.permanent_address"
                        @input="
                          data.permanent_address =
                            $event.target.value.toUpperCase()
                        "
                        placeholder="Full Address
                    (Unit No, Blk No. Lot No, Sitio/Subdvision/Village, Brgy, Municipality/City,
                    Province, Country)"
                      ></textarea>
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('permanent_address')"
                        >This field is required.</small
                      >
                      <br />
                      <b-form-checkbox
                        id="checkbox-1"
                        v-model="copyPresent"
                        name="checkbox-1"
                        :value="true"
                        :unchecked-value="false"
                        style="float: right"
                        @input="checkCopy"
                      >
                        <label style="margin-top: 5px"
                          >Copy Present Address</label
                        >
                      </b-form-checkbox>
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Ownership:</p>
                    </div>
                    <div class="col-lg-9">
                      <div
                        class="pretty p-icon p-curve p-jelly"
                        style="margin-top: 15px"
                      >
                        <input
                          type="radio"
                          name="ownership_permanent"
                          ref="ownership_permanent"
                          value="Owned"
                          v-model.trim="data.ownership_permanent"
                        />
                        <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label> Owned</label>
                        </div>
                      </div>
                      <div
                        class="pretty p-icon p-curve p-jelly"
                        style="margin-top: 15px"
                      >
                        <input
                          type="radio"
                          name="ownership_permanent"
                          ref="ownership_permanent"
                          value="Mortgaged"
                          v-model.trim="data.ownership_permanent"
                        />
                        <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label> Mortgaged</label>
                        </div>
                      </div>
                      <div
                        class="pretty p-icon p-curve p-jelly"
                        style="margin-top: 15px"
                      >
                        <input
                          type="radio"
                          name="ownership_permanent"
                          ref="ownership_permanent"
                          value="Rented"
                          v-model.trim="data.ownership_permanent"
                        />
                        <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label> Rented</label>
                        </div>
                      </div>
                      <div
                        class="pretty p-icon p-curve p-jelly"
                        style="margin-top: 15px"
                      >
                        <input
                          type="radio"
                          name="ownership_permanent"
                          ref="ownership_permanent"
                          value="Free"
                          v-model.trim="data.ownership_permanent"
                        />
                        <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label> Free Use</label>
                        </div>
                      </div>
                      <div
                        class="pretty p-icon p-curve p-jelly"
                        style="margin-top: 15px"
                      >
                        <input
                          type="radio"
                          name="ownership_permanent"
                          ref="ownership_permanent"
                          value="Parents"
                          v-model.trim="data.ownership_permanent"
                        />
                        <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label> Living w/ Parents or Relatives</label>
                        </div>
                      </div>
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('ownership_permanent')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Monthly Rate:</p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        name="monthly_permanent"
                        ref="monthly_permanent"
                        type="text"
                        v-model.trim="data.monthly_permanent"
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('monthly_permanent')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Occupied since:</p>
                    </div>
                    <div class="col-lg-9">
                      <div class="input-group">
                        <date-picker
                          v-model.trim="data.occupied_permanent"
                          :config="Dateoptions"
                          v-b-tooltip.hover
                          placeholder="Select Date"
                          autocomplete="off"
                          name="occupied_permanent"
                          ref="occupied_permanent"
                        ></date-picker>
                      </div>
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('occupied_permanent')"
                        >Field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Last Update Date:</p>
                    </div>
                    <div class="col-lg-9">
                      <div class="input-group">
                        <date-picker
                          v-model.trim="data.last_update_permanent"
                          :config="Dateoptions"
                          v-b-tooltip.hover
                          placeholder="Select Date"
                          autocomplete="off"
                          name="last_update_permanent"
                          ref="last_update_permanent"
                        ></date-picker>
                      </div>
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('last_update_permanent')"
                        >Field is required.</small
                      >
                    </div>
                  </div>
                  <hr />
                  <div class="emp-heading" style="display: flex">
                    <label class="header text-success"> Contact Data </label>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Primary Contact No.:</p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        type="text"
                        name="phone_no"
                        ref="phone_no"
                        class="form-control"
                        v-model.trim="data.contact_no"
                        maxlength="12"
                        placeholder="ex.:639123456789"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('phone_no')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Last Update Date:</p>
                    </div>
                    <div class="col-lg-9">
                      <div class="input-group">
                        <date-picker
                          v-model.trim="data.contact_last_update"
                          :config="Dateoptions"
                          v-b-tooltip.hover
                          placeholder="Select Date"
                          autocomplete="off"
                          name="contact_last_update"
                        ></date-picker>
                      </div>
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('contact_last_update')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-3">
                      <p class="msg">Additional Contact Number:</p>
                    </div>
                    <div class="col-lg-8">
                      <input
                        type="text"
                        name="contact2_no"
                        ref="contact2_no"
                        class="form-control"
                        v-model.trim="data.contact2_no"
                        maxlength="12"
                        placeholder="ex.:639123456789"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                      />
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Last Update Date:</p>
                    </div>
                    <div class="col-lg-9">
                      <div class="input-group">
                        <date-picker
                          v-model.trim="data.contact2_last_update"
                          :config="Dateoptions"
                          v-b-tooltip.hover
                          placeholder="Select Date"
                          autocomplete="off"
                          name="contact2_last_update"
                        ></date-picker>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="tab-pane" id="Info_4" role="tabpanel">
              <div class="emp-heading" style="display: flex">
                <label class="header text-success"> Source of Income</label>
              </div>
              <div class="elClr panel-body">
                <form>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">
                        <span class="red" @click="checker">*</span> Source of Income:
                      </p>
                    </div>
                    <div class="col-lg-9">
                      <div
                        class="pretty p-icon p-curve p-jelly"
                        style="margin-top: 15px"
                      >
                        <input
                          name="income_source"
                          ref="income_source"
                          type="checkbox"
                          value="Business"
                          v-model.trim="data.income_source_arr"
                        />
                        <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label> Business</label>
                        </div>
                      </div>
                      <div
                        class="pretty p-icon p-curve p-jelly"
                        style="margin-top: 15px"
                      >
                        <input
                          name="income_source"
                          ref="income_source"
                          type="checkbox"
                          value="Employment"
                          v-model.trim="data.income_source_arr"
                        />
                        <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label> Employment</label>
                        </div>
                      </div>
                      <div
                        class="pretty p-icon p-curve p-jelly"
                        style="margin-top: 15px"
                      >
                        <input
                          name="income_source"
                          ref="income_source"
                          type="checkbox"
                          value="Pension"
                          v-model.trim="data.income_source_arr"
                        />
                        <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label> Pension</label>
                        </div>
                      </div>
                      <div
                        class="pretty p-icon p-curve p-jelly"
                        style="margin-top: 15px"
                      >
                        <input
                          name="income_source"
                          ref="income_source"
                          type="checkbox"
                          value="Remittance"
                          v-model.trim="data.income_source_arr"
                        />
                        <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label> OFW Remittance</label>
                        </div>
                      </div>
                      <div
                        class="pretty p-icon p-curve p-jelly"
                        style="margin-top: 15px"
                      >
                        <input
                          name="income_source"
                          ref="income_source"
                          type="checkbox"
                          value="Agri"
                          v-model.trim="data.income_source_arr"
                        />
                        <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label>Agri-Related </label>
                        </div>
                      </div>
                    </div>
                    <!-- <small
                      class="text-danger pull-left"
                      v-show="data.income_source_arr"
                      >This field is required.</small
                    > -->
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">
                        <span class="red">*</span> Income Received Via:
                      </p>
                    </div>
                    <div class="col-lg-4">
                      <div
                        class="pretty p-icon p-curve p-jelly"
                        style="margin-top: 15px"
                      >
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
                      <div
                        class="pretty p-icon p-curve p-jelly"
                        style="margin-top: 15px"
                      >
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
                      <div
                        class="pretty p-icon p-curve p-jelly"
                        style="margin-top: 15px"
                      >
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
                      <div
                        class="pretty p-icon p-curve p-jelly"
                        style="margin-top: 15px"
                      >
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
                          data.other_income_via =
                            $event.target.value.toUpperCase()
                        "
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                        placeholder="Others"
                        style="margin-top: 5px; margin-left: -30px"
                      />
                    </div>
                    <small
                      class="text-danger pull-left"
                      v-show="errors.has('income_via')"
                      >This field is required.</small
                    >
                  </div>
                  <hr />

                  <!-- Business Data -->
                   <span v-if="data.income_source_arr.includes('Business')">
                    <div class="emp-heading" style="display: flex">
                      <label class="header text-success"> Business Data</label>
                    </div>
                    <!-- Business Data -->
                    <div>
                      <div class="rowFields mx-auto row">
                        <div class="col-lg-3">
                          <p class="msg">
                            <span class="red">*</span> Company Trade Name
                            (Employer)
                          </p>
                        </div>
                        <div class="col-lg-8">
                          <input
                            type="text"
                            name="bn_name"
                            v-model.trim="data.bn_name"
                            @input="
                              data.bn_name = $event.target.value.toUpperCase()
                            "
                            class="form-control"
                            v-b-tooltip.hover
                            autocomplete="off"
                            autofocus="on"
                          />
                        </div>
                      </div>
                      <div class="rowFields mx-auto row">
                        <div class="col-lg-3">
                          <p class="msg">
                            <span class="red">*</span> Nature of Business(PSIC):
                          </p>
                        </div>
                        <div class="col-lg-8">
                          <input
                            type="text"
                            name="bn_nature"
                            v-model.trim="data.bn_nature"
                            @input="
                              data.bn_nature = $event.target.value.toUpperCase()
                            "
                            class="form-control"
                            v-b-tooltip.hover
                            autocomplete="off"
                            autofocus="on"
                          />
                        </div>
                      </div>
                      <div class="rowFields mx-auto row">
                        <div class="col-lg-2">
                          <p class="msg">
                            <span class="red">*</span> Date Established:
                          </p>
                        </div>
                        <div class="col-lg-9">
                          <div class="input-group">
                            <date-picker
                              name="bn_established"
                              v-model.trim="data.bn_established"
                              :config="Dateoptions"
                              v-b-tooltip.hover
                              placeholder="Select Date"
                              autocomplete="off"
                            ></date-picker>
                          </div>
                        </div>
                      </div>
                      <div class="rowFields mx-auto row">
                        <div class="col-lg-2">
                          <p class="msg">Company TIN:</p>
                        </div>
                        <div class="col-lg-9">
                          <input
                            type="text"
                            name="bn_tin"
                            v-model.trim="data.bn_tin"
                            class="form-control"
                            v-b-tooltip.hover
                            autocomplete="off"
                            autofocus="on"
                          />
                        </div>
                      </div>
                      <div class="rowFields mx-auto row">
                        <div class="col-lg-2">
                          <p class="msg">
                            <span class="red">*</span> Full Address:
                          </p>
                        </div>
                        <div class="col-lg-9">
                          <textarea
                            rows="4"
                            name="bn_address"
                            class="form-control"
                            v-model.trim="data.bn_address"
                            @input="
                              data.bn_address =
                                $event.target.value.toUpperCase()
                            "
                            placeholder="Full Address
                        (Unit No, Blk No. Lot No, Sitio/Subdvision/Village, Brgy, Municipality/City,
                        Province, Country)"
                          ></textarea>
                        </div>
                      </div>
                      <div class="rowFields mx-auto row">
                        <div class="col-lg-2">
                          <p class="msg">
                            <span class="red">*</span> Contact Number:
                          </p>
                        </div>
                        <div class="col-lg-9">
                          <input
                            type="text"
                            name="bn_contact"
                            v-model.trim="data.bn_contact"
                            class="form-control"
                            maxlength="11"
                            v-b-tooltip.hover
                            autocomplete="off"
                            autofocus="on"
                          />
                          <small
                            class="text-danger pull-left"
                            v-show="errors.has('bn_contact')"
                            >This field is required.</small
                          >
                        </div>
                      </div>
                    </div>
                    <hr />
                  </span>

                  <!-- Employment Data -->
                   <span v-if="data.income_source_arr.includes('Employment')">
                    <div class="emp-heading" style="display: flex">
                      <label class="header text-success">
                        Employment Data</label
                      >
                    </div>
                    <div>
                      <div class="rowFields mx-auto row">
                        <div class="col-lg-3">
                          <p class="msg">
                            <span class="red">*</span> Company Trade Name (
                            Employer)
                          </p>
                        </div>
                        <div class="col-lg-8">
                          <input
                            type="text"
                            v-model.trim="data.emp_employer"
                            @input="
                              data.emp_employer =
                                $event.target.value.toUpperCase()
                            "
                            class="form-control"
                            v-b-tooltip.hover
                            autocomplete="off"
                            autofocus="on"
                            name="emp_employer"
                            v-validate="'required'"
                          />
                          <small
                            class="text-danger pull-left"
                            v-show="errors.has('emp_employer')"
                            >This field is required.</small
                          >
                        </div>
                      </div>
                      <div class="rowFields mx-auto row">
                        <div class="col-lg-3">
                          <p class="msg">
                            <span class="red">*</span> Nature of Company (PSIC):
                          </p>
                        </div>
                        <div class="col-lg-8">
                          <input
                            type="text"
                            name="emp_nature"
                            v-validate="'required'"
                            v-model.trim="data.emp_nature"
                            @input="
                              data.emp_nature =
                                $event.target.value.toUpperCase()
                            "
                            class="form-control"
                            v-b-tooltip.hover
                            autocomplete="off"
                            autofocus="on"
                          />
                          <small
                            class="text-danger pull-left"
                            v-show="errors.has('emp_nature')"
                            >This field is required.</small
                          >
                        </div>
                      </div>
                      <div class="rowFields mx-auto row">
                        <div class="col-lg-2">
                          <p class="msg">
                            <span class="red">*</span> Company TIN:
                          </p>
                        </div>
                        <div class="col-lg-9">
                          <input
                            type="text"
                            name="emp_tin"
                            v-validate="'required'"
                            v-model.trim="data.emp_tin"
                            @input="
                              data.emp_tin = $event.target.value.toUpperCase()
                            "
                            class="form-control"
                            v-b-tooltip.hover
                            autocomplete="off"
                            autofocus="on"
                          />
                          <small
                            class="text-danger pull-left"
                            v-show="errors.has('emp_tin')"
                            >This field is required.</small
                          >
                        </div>
                      </div>
                      <div class="rowFields mx-auto row">
                        <div class="col-lg-2">
                          <p class="msg">
                            <span class="red">*</span> Contact Number:
                          </p>
                        </div>
                        <div class="col-lg-9">
                          <input
                            type="text"
                            name="emp_tel_no"
                            v-validate="'required'"
                            v-model.trim="data.emp_tel_no"
                            class="form-control"
                            v-b-tooltip.hover
                            autocomplete="off"
                            autofocus="on"
                          />
                          <small
                            class="text-danger pull-left"
                            v-show="errors.has('emp_tel_no')"
                            >This field is required.</small
                          >
                        </div>
                      </div>
                      <div class="rowFields mx-auto row">
                        <div class="col-lg-2">
                          <p class="msg">
                            <span class="red">*</span> Full Address:
                          </p>
                        </div>
                        <div class="col-lg-9">
                          <textarea
                            rows="4"
                            name="emp_address"
                            class="form-control"
                            v-validate="'required'"
                            v-model.trim="data.emp_address"
                            @input="
                              data.emp_address =
                                $event.target.value.toUpperCase()
                            "
                            placeholder="Full Address
                      (Unit No, Blk No. Lot No, Sitio/Subdvision/Village, Brgy, Municipality/City,
                      Province, Country)"
                          ></textarea>

                          <small
                            class="text-danger pull-left"
                            v-show="errors.has('emp_address')"
                            >This field is required.</small
                          >
                        </div>
                      </div>
                      <div class="rowFields mx-auto row">
                        <div class="col-lg-2">
                          <p class="msg">
                            <span class="red">*</span> Position:
                          </p>
                        </div>
                        <div class="col-lg-9">
                          <input
                            type="text"
                            name="emp_position"
                            v-validate="'required'"
                            v-model.trim="data.emp_position"
                            @input="
                              data.emp_position =
                                $event.target.value.toUpperCase()
                            "
                            class="form-control"
                            v-b-tooltip.hover
                            autocomplete="off"
                            autofocus="on"
                          />
                          <small
                            class="text-danger pull-left"
                            v-show="errors.has('emp_position')"
                            >This field is required.</small
                          >
                        </div>
                      </div>
                      <div class="rowFields mx-auto row">
                        <div class="col-lg-2">
                          <p class="msg">
                            <span class="red">*</span> Date Employed:
                          </p>
                        </div>
                        <div class="col-lg-9">
                          <div class="input-group">
                            <date-picker
                              name="emp_date_employed"
                              v-validate="'required'"
                              v-model.trim="data.emp_date_employed"
                              :config="Dateoptions"
                              v-b-tooltip.hover
                              placeholder="Select Date"
                              autocomplete="off"
                            ></date-picker>
                            <small
                              class="text-danger pull-left"
                              v-show="errors.has('emp_date_employed')"
                              >This field is required.</small
                            >
                          </div>
                        </div>
                      </div>
                      <div class="rowFields mx-auto row">
                        <div class="col-lg-2">
                          <p class="msg">
                            <span class="red">*</span> Gross Income:
                          </p>
                        </div>
                        <div class="col-lg-9">
                          <input
                            type="text"
                            name="emp_gross"
                            v-validate="'required'"
                            v-model.trim="data.emp_gross"
                            class="form-control"
                            v-b-tooltip.hover
                            autocomplete="off"
                            autofocus="on"
                          />
                          <small
                            class="text-danger pull-left"
                            v-show="errors.has('emp_gross')"
                            >This field is required.</small
                          >
                        </div>
                      </div>
                      <div class="rowFields mx-auto row">
                        <div class="col-lg-2">
                          <p class="msg">
                            <span class="red">*</span>Pay period:
                          </p>
                        </div>
                        <div class="col-lg-3">
                          <b-form-select
                            name="emp_period"
                            ref="emp_period"
                            v-validate="'required'"
                            v-model="data.emp_period"
                            :options="income_options"
                            size="sm"
                          ></b-form-select>
                          <small
                            class="text-danger pull-left"
                            v-show="errors.has('emp_period')"
                            >This field is required.</small
                          >
                        </div>
                        <div class="col-lg-6">
                          <input
                            type="text"
                            name="emp_annual"
                            v-validate="'required'"
                            v-model.trim="data.emp_annual"
                            class="form-control"
                            v-b-tooltip.hover
                            autocomplete="off"
                            autofocus="on"
                          />
                          <small
                            class="text-danger pull-left"
                            v-show="errors.has('emp_annual')"
                            >This field is required.</small
                          >
                        </div>
                      </div>
                      <div class="rowFields mx-auto row">
                        <div class="col-lg-2">
                          <p class="msg">
                            <span class="red">*</span> Currency:
                          </p>
                        </div>
                        <div class="col-lg-9">
                          <input
                            type="text"
                            name="emp_currency"
                            v-validate="'required'"
                            v-model.trim="data.emp_currency"
                            class="form-control"
                            v-b-tooltip.hover
                            autocomplete="off"
                            autofocus="on"
                          />
                          <small
                            class="text-danger pull-left"
                            v-show="errors.has('emp_currency')"
                            >This field is required.</small
                          >
                        </div>
                      </div>
                      <div class="rowFields mx-auto row">
                        <div class="col-lg-2">
                          <p class="msg">
                            <span class="red">*</span> Occupational Status:
                          </p>
                        </div>
                        <div class="col-lg-9">
                          <input
                            type="text"
                            name="emp_occ_status"
                            v-validate="'required'"
                            v-model.trim="data.emp_occ_status"
                            @input="
                              data.emp_occ_status =
                                $event.target.value.toUpperCase()
                            "
                            class="form-control"
                            v-b-tooltip.hover
                            autocomplete="off"
                            autofocus="on"
                          />
                          <small
                            class="text-danger pull-left"
                            v-show="errors.has('emp_occ_status')"
                            >This field is required.</small
                          >
                        </div>
                      </div>
                    </div>
                  </span>

                </form>
              </div>
            </div>
            <div class="tab-pane" id="Info_5" role="tabpanel">
              <div class="emp-heading" style="display: flex">
                <label class="header"> References</label>
              </div>
              <div class="elClr panel-body">
                <form>
                  <label class="header"><b>Reference No.1</b></label>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Name:</p>
                    </div>
                    <div class="col-lg-9" style="margin-top: 8px">
                      <input
                        type="text"
                        name="ref1_name"
                        v-validate="'required'"
                        v-model.trim="data.ref1_name"
                        @input="
                          data.ref1_name = $event.target.value.toUpperCase()
                        "
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('ref1_name')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Address/Company:</p>
                    </div>
                    <div class="col-lg-9" style="margin-top: 8px">
                      <input
                        type="text"
                        name="ref1_address"
                        v-validate="'required'"
                        v-model.trim="data.ref1_address"
                        @input="
                          data.ref1_address = $event.target.value.toUpperCase()
                        "
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('ref1_address')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Contact Number:</p>
                    </div>
                    <div class="col-lg-9" style="margin-top: 8px">
                      <input
                        type="text"
                        name="ref1_contact"
                        v-validate="'required'"
                        v-model.trim="data.ref1_contact"
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('ref1_contact')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <br />
                  <label class="header"><b>Reference No.2</b></label>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Name:</p>
                    </div>
                    <div class="col-lg-9" style="margin-top: 8px">
                      <input
                        type="text"
                        name="ref2_name"
                        v-validate="'required'"
                        v-model.trim="data.ref2_name"
                        @input="
                          data.ref2_name = $event.target.value.toUpperCase()
                        "
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('ref2_name')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Address/Company:</p>
                    </div>
                    <div class="col-lg-9" style="margin-top: 8px">
                      <input
                        type="text"
                        name="ref2_address"
                        v-validate="'required'"
                        v-model.trim="data.ref2_address"
                        @input="
                          data.ref2_address = $event.target.value.toUpperCase()
                        "
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('ref2_address')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Contact Number:</p>
                    </div>
                    <div class="col-lg-9" style="margin-top: 8px">
                      <input
                        type="text"
                        name="ref2_contact"
                        v-validate="'required'"
                        v-model.trim="data.ref2_contact"
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('ref2_contact')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                </form>
              </div>
              <div class="elClr panel-footer"></div>
            </div>
            <div class="tab-pane" id="Info_6" role="tabpanel">
              <div class="emp-heading" style="display: flex">
                <label class="header">Attachments</label>
              </div>
              <div class="elClr panel-body">
                <form>
                  <label class="header"
                    ><b>2 Valid ID: (Maximum size of 10MB)</b></label
                  >
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-4" v-if="imageDataValid1 == ''">
                      <img
                        class="preview-id"
                        :src="$img_path + data.image_id_1"
                        width="400"
                        height="200"
                        style="cursor: pointer"
                        v-b-tooltip.hover
                        title="View Image"
                        @click="viewAttachment(data.image_id_1)"
                      />
                      <br />
                      <input
                        type="file"
                        @change="previewImage($event, 'valid-id1')"
                        accept="image/*"
                        class="image-input"
                        name="image"
                        ref="image"
                      />
                    </div>
                    <div class="col-lg-4" v-else>
                      <img class="preview-id" :src="imageDataValid1" />
                      <br />
                      <input
                        type="file"
                        @change="previewImage($event, 'valid-id1')"
                        accept="image/*"
                        class="image-input"
                        name="image"
                        ref="image"
                      />
                    </div>
                    <div class="col-lg-2"></div>
                    <div class="col-lg-4" v-if="imageDataValid2 == ''">
                      <img
                        class="preview-id"
                        :src="$img_path + data.image_id_2"
                        width="400"
                        height="200"
                        style="cursor: pointer"
                        v-b-tooltip.hover
                        title="View Image"
                        @click="viewAttachment(data.image_id_2)"
                      />
                      <br />
                      <input
                        type="file"
                        @change="previewImage($event, 'valid-id2')"
                        accept="image/*"
                        class="image-input"
                        name="image"
                        ref="image"
                      />
                    </div>
                    <div class="col-lg-4" v-else>
                      <img class="preview-id" :src="imageDataValid2" />
                      <br />
                      <input
                        type="file"
                        @change="previewImage($event, 'valid-id2')"
                        accept="image/*"
                        class="image-input"
                        name="image"
                        ref="image"
                      />
                    </div>
                  </div>
                  <br />
                  <label class="header"
                    ><b>Home Address Sketch (Include Landmark): </b></label
                  >
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-10" v-if="imageDataSketch == ''">
                      <img
                        class="preview-id"
                        :src="$img_path + data.image_sketch"
                        width="400"
                        height="200"
                        style="cursor: pointer"
                        v-b-tooltip.hover
                        title="View Image"
                        @click="viewAttachment(data.image_sketch)"
                      />
                      <br />
                      <input
                        type="file"
                        @change="previewImage($event, 'sketch')"
                        accept="image/*"
                        class="image-input"
                        name="image"
                        ref="image"
                      />
                    </div>

                    <div class="col-lg-10" v-else>
                      <img class="preview-id" :src="imageDataSketch" />
                      <br />
                      <input
                        type="file"
                        @change="previewImage($event, 'sketch')"
                        accept="image/*"
                        class="image-input"
                        name="image"
                        ref="image"
                      />
                    </div>

                    <div class="col-lg-2"></div>
                  </div>

                  <label class="header"
                    ><b
                      >Business/Employment Address Sketch (Include Landmark):
                    </b></label
                  >
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-10" v-if="imageDataSketch2 == ''">
                      <img
                        class="preview-id"
                        :src="$img_path + data.image_sketch_2"
                        width="400"
                        height="200"
                        style="cursor: pointer"
                        v-b-tooltip.hover
                        title="View Image"
                        @click="viewAttachment(data.image_sketch_2)"
                      />
                      <br />
                      <input
                        type="file"
                        @change="previewImage($event, 'sketch2')"
                        accept="image/*"
                        class="image-input"
                        name="image"
                        ref="image"
                      />
                    </div>

                    <div class="col-lg-10" v-else>
                      <img class="preview-id" :src="imageDataSketch2" />
                      <br />
                      <input
                        type="file"
                        @change="previewImage($event, 'sketch2')"
                        accept="image/*"
                        class="image-input"
                        name="image"
                        ref="image"
                      />
                    </div>

                    <div class="col-lg-2"></div>
                  </div>
                  <br />
                </form>
              </div>
              <div class="elClr panel-footer">
                <p>Signatories</p>
              </div>
            </div>
          </div>
        </div>
        <br />
        <hr />

        <div class="rowFields mx-auto row">
          <div class="col-lg-1">
            <p class="msg">Remarks:</p>
          </div>
          <div class="col-lg-11">
            <textarea
              rows="4"
              name="remarks"
              class="form-control"
              v-b-tooltip.hover
              title="Input Remarks"
              placeholder="Remarks"
              v-model.trim="data.remarks"
              :disabled="
                !roles.update_application &&
                data.application_status != 'Pending'
              "
            ></textarea>
          </div>
        </div>
      </div>

      <div style="display: none">
        <table class="parent printable" style="width: 100%" id="printable-app">
          <tr style="background-color: rgba(255, 255, 255, 0.8)">
            <td>
              <img
                src="../../img/1st_page.jpg"
                style="
                  width: 100%;
                  height: 100%;
                  max-height: 100%;
                  margin: 0;
                  padding: 0;
                  background-size: 100%;
                  background-repeat: no-repeat;
                "
              />
            </td>
          </tr>
          <br />
          <tr style="background-color: rgba(255, 255, 255, 0.8)">
            <td>
              <div
                style="
                  font-family: Arial, serif;
                  font-size: 9px;
                  color: rgb(0, 31, 95);
                "
              >
                <div class="rowFields mx-auto row">
                  <table
                    style="width: 100%; border-collapse: collapse"
                    class="normalTbl"
                  >
                    <tr class>
                      <td
                        class="normalTbl"
                        style="
                          vertical-align: top;
                          width: 30%;
                          float: right;
                          margin-right: -100px;
                        "
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
                  <p class="textLabel-2">
                    <b>PERSONAL INFORMATION</b>
                  </p>
                </div>
                <hr />
                <div class="rowFields mx-auto row">
                  <p class="data-print"><b>Title:</b> {{ data.title }}</p>
                </div>
                <div class="rowFields mx-auto row">
                  <p class="data-print"><b>Nickname:</b> {{ data.nickname }}</p>
                </div>
                <div class="rowFields mx-auto row">
                  <p class="data-print">
                    <b>First Name:</b> {{ data.first_name }}
                  </p>
                </div>
                <div class="rowFields mx-auto row">
                  <p class="data-print">
                    <b>Last Name:</b> {{ data.last_name }}
                  </p>
                </div>
                <div class="rowFields mx-auto row">
                  <p class="data-print">
                    <b>Middle Name:</b> {{ data.mid_name }}
                  </p>
                </div>
                <div class="rowFields mx-auto row">
                  <p class="data-print">
                    <b>Previous Last Name:</b> {{ data.prev_last_name }}
                  </p>
                </div>
                <div class="rowFields mx-auto row">
                  <p class="data-print"><b>Suffix:</b> {{ data.suffix }}</p>
                </div>
                <div class="rowFields mx-auto row">
                  <p class="data-print"><b>Age:</b> {{ data.age }}</p>
                </div>
                <div class="rowFields mx-auto row">
                  <p class="data-print"><b>Gender:</b> {{ data.gender }}</p>
                </div>
                <div class="rowFields mx-auto row">
                  <p class="data-print">
                    <b>Date of Birth:</b> {{ data.birthdate }}
                  </p>
                </div>
                <div class="rowFields mx-auto row">
                  <p class="data-print">
                    <b>Nationality:</b> {{ data.nationality }}
                  </p>
                </div>
                <div class="rowFields mx-auto row">
                  <p class="data-print">
                    <b>Country of Birth:</b> {{ data.birthcountry }}
                  </p>
                </div>
                <div class="rowFields mx-auto row">
                  <p class="data-print">
                    <b>Place of Birth:</b> {{ data.birthplace }}
                  </p>
                </div>
                <div class="rowFields mx-auto row">
                  <p class="data-print" v-if="data.resident == '2'">
                    <b>Resident:</b> {{ data.resident_citizenship }}
                  </p>
                  <p class="data-print" v-else>
                    <b>Resident:</b> {{ data.resident }}
                  </p>
                </div>
                <div class="rowFields mx-auto row">
                  <p class="data-print">
                    <b>Civil Status:</b> {{ data.civil_stat }}
                  </p>
                </div>
                <div class="rowFields mx-auto row">
                  <p class="data-print">
                    <b>Total No. of Dependents:</b> {{ data.dependents_no }}
                  </p>
                </div>
                <div class="rowFields mx-auto row">
                  <p class="data-print">
                    <b>No. of Children:</b> {{ data.children_no }}
                  </p>
                </div>
                <div class="rowFields mx-auto row">
                  <p class="data-print">
                    <b>No. of Household Members:</b> {{ data.household_no }}
                  </p>
                </div>
                <div class="rowFields mx-auto row">
                  <p class="data-print">
                    <b>No. of Real Estate Property Owned:</b>
                    {{ data.owned_properties }}
                  </p>
                </div>
                <div class="rowFields mx-auto row">
                  <p class="data-print">
                    <b>Number of Car(s) owned:</b> {{ data.owned_cars }}
                  </p>
                </div>
                <hr />
                <span
                  v-if="
                    data.civil_stat == 'live-in' || data.civil_stat == 'married'
                  "
                >
                  <!-- Spouse Information -->
                  <div class="rowFields mx-auto row">
                    <p class="data-print">
                      <b>Spouse Information</b>
                    </p>
                  </div>
                  <div class="rowFields mx-auto row">
                    <p class="data-print">
                      <b>Spouse Age:</b> {{ data.spouse_age }}
                    </p>
                  </div>
                  <div class="rowFields mx-auto row">
                    <p class="data-print">
                      <b>Spouse Occupation:</b> {{ data.spouse_occupation }}
                    </p>
                  </div>
                  <div class="rowFields mx-auto row">
                    <p class="data-print">
                      <b>Spouse Employer:</b> {{ data.spouse_employer }}
                    </p>
                  </div>
                  <div class="rowFields mx-auto row">
                    <p class="data-print">
                      <b>Spouse Address:</b> {{ data.spouse_address }}
                    </p>
                  </div>
                  <hr />
                </span>

                <div class="rowFields mx-auto row">
                  <p class="data-print">
                    <b>Mother's Information</b>
                  </p>
                </div>
                <div class="rowFields mx-auto row">
                  <p class="data-print">
                    <b>Mother's First Name:</b> {{ data.mother_first_name }}
                  </p>
                </div>
                <div class="rowFields mx-auto row">
                  <p class="data-print">
                    <b>Mother's Middle Name(Maiden):</b>
                    {{ data.mother_mid_name }}
                  </p>
                </div>
                <div class="rowFields mx-auto row">
                  <p class="data-print">
                    <b>Mother's Last Name(Maiden):</b>
                    {{ data.mother_last_name }}
                  </p>
                </div>
                <div class="rowFields mx-auto row">
                  <p class="data-print">
                    <b>Mother's Suffix:</b>
                    {{ data.mother_suffix }}
                  </p>
                </div>
                <hr />
                <div class="rowFields mx-auto row">
                  <p class="data-print">
                    <b>Father's Information</b>
                  </p>
                </div>
                <div class="rowFields mx-auto row">
                  <p class="data-print">
                    <b>Father's First Name:</b> {{ data.father_first_name }}
                  </p>
                </div>
                <div class="rowFields mx-auto row">
                  <p class="data-print">
                    <b>Father's Middle Name:</b>
                    {{ data.father_mid_name }}
                  </p>
                </div>
                <div class="rowFields mx-auto row">
                  <p class="data-print">
                    <b>Father's Last Name:</b>
                    {{ data.father_last_name }}
                  </p>
                </div>
                <div class="rowFields mx-auto row">
                  <p class="data-print">
                    <b>Father's Suffix:</b>
                    {{ data.father_suffix }}
                  </p>
                </div>
                <hr />
                <div class="rowFields mx-auto row">
                  <p class="data-print">
                    <b>Valid Identification Cards</b>
                  </p>
                </div>
                <div class="rowFields mx-auto row">
                  <p class="data-print">
                    <b>SSS ID No.:</b>
                    {{ data.sss }}
                  </p>
                </div>
                <div class="rowFields mx-auto row">
                  <p class="data-print">
                    <b>GSIS ID No.:</b>
                    {{ data.gsis }}
                  </p>
                </div>
                <div class="rowFields mx-auto row">
                  <p class="data-print">
                    <b> TIN ID No.:</b>
                    {{ data.tin }}
                  </p>
                </div>
                <hr />

                <div class="rowFields mx-auto row">
                  <p class="data-print">
                    <b>Other Valid ID</b>
                  </p>
                </div>
                <div class="rowFields mx-auto row">
                  <table class="table table-bordered">
                    <thead>
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
                    <tbody>
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
                <div class="rowFields mx-auto row">
                  <p class="data-print">
                    <b>Address</b>
                  </p>
                </div>
                <div class="rowFields mx-auto row">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">Address Type</th>
                        <th scope="col">Full Address</th>
                        <th scope="col">Ownership Type</th>
                        <th scope="col">Occupied Since</th>
                        <th scope="col">Last Update Date</th>
                      </tr>
                    </thead>
                    <tbody>
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
                <div class="rowFields mx-auto row">
                  <p class="data-print">
                    <b>Contact Data</b>
                  </p>
                </div>
                <div class="rowFields mx-auto row">
                  <table class="table table-bordered">
                    <tbody>
                      <tr>
                        <th scope="row">Primary Contact No.:</th>
                        <td>{{ data.contact_no }}</td>
                        <td>Last Update Date:</td>
                        <td>{{ data.contact_last_update }}</td>
                      </tr>
                      <tr>
                        <th scope="row">Additional Contact Number:</th>
                        <td>{{ data.contact2_no }}</td>
                        <td>Last Update Date:</td>
                        <td>{{ data.contact2_last_update }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="rowFields mx-auto row">
                  <p class="data-print">
                    <b>Employment Data</b>
                  </p>
                </div>
                <div class="rowFields mx-auto row">
                  <table class="table table-bordered">
                    <tbody>
                      <tr>
                        <th scope="row">Company Trade Name ( Employer):</th>
                        <td>{{ data.emp_employer }}</td>
                        <td>Company TIN:</td>
                        <td>{{ data.emp_tin }}</td>
                      </tr>
                      <tr>
                        <th scope="row">Nature of Company (PSIC):</th>
                        <td>{{ data.emp_nature }}</td>
                        <td>Contact Number:</td>
                        <td>{{ data.emp_tel_no }}</td>
                      </tr>
                      <tr>
                        <th scope="row">Gross Income:</th>
                        <td>{{ data.emp_gross }}</td>
                        <td>Annual/Monthly:</td>
                        <td>{{ data.emp_annual }}</td>
                      </tr>
                      <tr>
                        <th scope="row">Currency:</th>
                        <td>{{ data.emp_currency }}</td>
                        <td>Occupational Status:</td>
                        <td>{{ data.emp_occ_status }}</td>
                      </tr>
                      <tr>
                        <th scope="row">Date Employed:</th>
                        <td>{{ data.emp_date_employed }}</td>
                        <td>Position:</td>
                        <td>{{ data.emp_position }}</td>
                      </tr>
                      <tr>
                        <th scope="row">Full Address:</th>
                        <td>{{ data.emp_address }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="rowFields mx-auto row">
                  <p class="data-print">
                    <b>Business Data</b>
                  </p>
                </div>
                <div class="rowFields mx-auto row">
                  <table class="table table-bordered">
                    <tbody>
                      <tr>
                        <th scope="row">Company Trade Name (Employer):</th>
                        <td>{{ data.bn_name }}</td>
                        <td>Company TIN:</td>
                        <td>{{ data.bn_tin }}</td>
                      </tr>
                      <tr>
                        <th scope="row">Nature of Business (PSIC):</th>
                        <td>{{ data.bn_nature }}</td>
                        <td>Contact Number:</td>
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
                <br />
                <div class="rowFields mx-auto row">
                  <p class="data-print">
                    <b>Source of Income:</b>
                    {{ data.income_source_arr }}
                  </p>
                </div>
                <div class="rowFields mx-auto row">
                  <p
                    class="data-print"
                    v-if="data.other_income_via != 'Others'"
                  >
                    <b>Income Received Via:</b>
                    {{ data.income_via }}
                  </p>
                  <p class="data-print" v-else>
                    <b>Income Received Via:</b>
                    {{ data.income_via }}
                  </p>
                </div>
                <br />
                <div class="rowFields mx-auto row">
                  <p class="data-print">
                    <b>References</b>
                  </p>
                </div>
                <div class="rowFields mx-auto row">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Address/Company</th>
                        <th scope="col">Tel No.</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row">{{ data.ref1_name }}</th>
                        <td>{{ data.ref1_address }}</td>
                        <td>{{ data.ref1_contact }}</td>
                      </tr>
                      <tr>
                        <th scope="row">{{ data.ref2_name }}</th>
                        <td>{{ data.ref2_address }}</td>
                        <td>{{ data.ref2_contact }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <br />
                <div class="rowFields mx-auto row">
                  <table
                    style="width: 100%; border-collapse: collapse"
                    class="normalTbl"
                  >
                    <tr class>
                      <td class="normalTbl">
                        <center>
                          <img
                            class="preview"
                            :src="$img_path + data.image_sketch"
                            width="800"
                            height="300"
                          />
                        </center>
                      </td>
                    </tr>
                  </table>
                </div>
                <br />
                <br />
                <div class="rowFields mx-auto row">
                  <center>
                    <p class="text-justify lh-sm" style="line-height: 1.5em">
                      <strong class="king">
                        I hereby affirm that the information given by me is true
                        and correct. I authorized you to verify and i nvestigate
                        it from whatever sources you may consider appropriate. I
                        also confirm and acknowledge that the above information
                        and those which may arise as needed, is voluntary
                        provided to King Multipurpose Cooperative pursuant to RA
                        9510 otherwise known as Credit Information System Act
                        (CISA). I certify that I am fully informed and
                        understood the following: 1. That, King Multipurpose
                        Cooperative, is mandated to submit my basic credit data
                        to Credit Information Corporation (CIC) 2. That the said
                        credit data may be used by other lenders as authorized
                        by CIC and other accredited credit reporting agencies.
                        3. That the said credit data could be used in
                        establishing my future credit worthiness.</strong
                      >
                    </p>
                  </center>
                </div>
                <div
                  class="rowFields mx-auto row"
                  style="width:100%:display:flex"
                >
                  <div style="width: 10%"></div>
                  <div style="border-top: 1px solid black; width: 30%">
                    <center><b>Applicant's Complete Name</b></center>
                  </div>
                  <div style="width: 20%"></div>
                  <div style="border-top: 1px solid black; width: 30%">
                    <center>
                      <b>Signature</b>
                    </center>
                  </div>
                  <div style="width: 10%"></div>
                </div>
              </div>
            </td>
          </tr>
        </table>
      </div>

      <template slot="modal-footer" slot-scope="{}">
        <b-button
          size="sm"
          variant="info"
          @click="update"
          v-if="roles.update_application"
          >Save Changes</b-button
        >
        <b-button
          size="sm"
          variant="danger"
          @click="Delete"
          v-if="roles.delete_application"
          >Delete</b-button
        >
        <b-button
          size="sm"
          variant="success"
          @click="btnAddDate"
          v-if="
            data.application_status == 'Pending' && roles.approve_application
          "
          >Approve</b-button
        >
        <!-- <b-button
          size="sm"
          variant="success"
          @click="btnApprove"
          v-if="
            data.application_status == 'Pending' && roles.approve_application
          "
          >Approve</b-button
        > -->
        <b-button
          size="sm"
          variant="warning"
          @click="btnReject"
          v-if="
            data.application_status == 'Pending' && roles.reject_application
          "
          >Reject</b-button
        >
        <!-- <b-button size="sm" variant="info" @click="print"
          >Print Preview</b-button
        > -->
        <!-- <b-button size="sm" variant="info">
          <a
            :href="'/items/' + data.id + '/edit'"
            target="_blank"
            style="text-decoration: none; color: white"
          >
            Print a Copy</a
          ></b-button
        > -->

        <!-- <b-button size="sm" variant="info">
          <router-link tag="span" :to="'/printid/' + data.id + '/edit'">
            Print IDs
          </router-link>
        </b-button> -->

         <b-button size="sm" variant="info"  @click="printids()">
            Print IDs
        </b-button>
        <!-- <b-button size="sm" variant="info">
          <router-link tag="span" :to="'/items/' + data.id + '/edit'">
            Print Form
          </router-link>
        </b-button> -->
        <b-button size="sm" variant="info" @click="printform()">
            Print Form
        </b-button>
      </template>
    </b-modal>


    <b-modal id="ModalDate" title="Date of Membership">

      <div class="rowFields mx-auto row">
        <div class="col-lg-4">
          <p class="msg" style="margin-top: 5px">Date Membership:</p>
        </div>
         <div class="col-lg-2"></div>
        <div class="col-lg-6">
          <b-form-datepicker
            id="example-datepicker"
            v-model="data.enrollment_date"
            class="mb-2"
          ></b-form-datepicker>
        </div>
      </div>

      <div class="rowFields mx-auto row">
        <div class="col-lg-4">
          <p class="msg" style="margin-top: 5px">Membership Type:</p>
        </div>
         <div class="col-lg-2"></div>
        <div class="col-lg-6">
          <b-form-select
            v-model="data.membership_type"
            :options="membership_type_list"
            size="sm"
            class="mt-3"
            value-field="id"
            text-field="name"
          ></b-form-select>
        </div>
      </div>

      <template slot="modal-footer" slot-scope="{}">
        <b-button
          size="sm"
          variant="success"
          @click="btnApprove"
          v-if="
            data.application_status == 'Pending' && roles.approve_application
          "
          >Approve</b-button
        >
      </template>
    </b-modal>
     <print_preview
      v-bind:data="data">
    </print_preview>
     <print_ids
      v-bind:data="data">
    </print_ids>
  </div>
</template>

<script>
import { ModelListSelect } from "vue-search-select";
import swal from "sweetalert";
import PrettyCheck from "pretty-checkbox-vue/check";
import datePicker from "vue-bootstrap-datetimepicker";
import VueRangedatePicker from "vue-rangedate-picker";
import PrettyRadio from "pretty-checkbox-vue/radio";
import SingleDatePicker from "vue-single-date-picker";
import "pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css";
import Swal2 from "sweetalert2";

import print_preview from "../routes/APPLICATIONS/PrintPreview.vue";
import print_ids from "../routes/APPLICATIONS/PrintIDs.vue";

export default {
  props: ["data", "countries", "regions","provinces","cities","barangays"],
  components: {
    print_preview,
    print_ids,
    "model-list-select": ModelListSelect,
    "rangedate-picker": VueRangedatePicker,
    "p-check": PrettyCheck,
    "date-picker": datePicker,
    "p-radio": PrettyRadio,
    SingleDatePicker,
  },
  data() {
    return {
      branches: [],
      status_list: [
        { name: "Active", value: "A"},
        { name: "Inactive", value: "I"},
        { name: "Closed", value: "C"},
        { name: "Withdrawn", value: "W"},
        { name: "Deceased", value: "D"},
        { name: "Delisted", value: "L"},
      ],
      Dateoptions: {
        format: "YYYY-MM-DD",
        useCurrent: false,
      },
      imageData: "",
      imageDataValid1: "",
      imageDataValid2: "",
      imageDataSketch: "",
      imageDataSketch2: "",
      picture_text: "",
      valid_id_1_text: "",
      valid_id_2_text: "",
      sketch_text: "",
      sketch2_text: "",

      roles: [],
      branch_name: {},
      title_options: [
        { value: "", text: "Please select title" },
        { value: "10", text: "Mr." },
        { value: "11", text: "Ms." },
        { value: "12", text: "Miss" },
        { value: "13", text: "Mrs." },
        { value: "14", text: "Dr." },
        { value: "15", text: "Prof." },
        { value: "16", text: "Hon." },
        { value: "17", text: "Lady" },
        { value: "18", text: "Major" },
        { value: "19", text: "Sir" },
        { value: "20", text: "Madam" },
        { value: "21", text: "Rev." },
      ],
      income_options: [
        { value: "", text: "Please select period" },
        { value: "Weekly", text: "Weekly" },
        { value: "Monthly", text: "Monthly" },
        { value: "Annually", text: "Annually" },
      ],
      membership_type_list: [
         { id: "R", name: "Regular" },
         { id: "A", name: "Associate" },
         { id: "E", name: "Co-Maker" },
         { id: "K", name: "Kiddies" },
         { id: "Y", name: "Youth" },
         { id: "T", name: "Teen" },
      ],
      copyPresent: "not_copy",
      sms_switch: false,
      email_switch: false,
    };
  },
  mounted() {
    this.imageData = "";
    this.branch_name = this.data.branch;
  },
  computed: {
  present_residential() {
    return this.data.street +
      " " +
      this.data.barangay_object.name +
      ", " +
      this.data.city_object.name +
      ", " +
      this.data.country_object.name +
      ", " +
      this.data.postal_code;
  },
  },
  created() {
    this.user = this.$global.getUser();
    this.roles = this.$global.getRoles();
    this.branches = this.$global.getBranch();

    this.loadSettings();
  },
  methods: {
    loadSettings() {
      if (this.$sms_switch.includes("enabled")) {
        this.sms_switch = true;
      } else {
        this.sms_switch = false;
      }

      if (this.$email_switch.includes("enabled")) {
        this.email_switch = true;
      } else {
        this.email_switch = false;
      }

      // this.$http.get("api/getCities").then(function (response) {
      //   this.cities = response.body;
      // });
      // this.$http.get("api/getBarangays").then(function (response) {
      //   this.barangays = response.body;
      // });
    },
    previewImage: function (e, image) {
      var fileName = e.target.files[0].name;
      var file_ext = fileName.split(".").pop();

      var reader = new FileReader();
      reader.readAsDataURL(e.target.files[0]);
      reader.onload = (e) => {
        if (image == "valid-id1") {
          this.imageDataValid1 = e.target.result;
          this.valid_id_1_text = file_ext;
        } else if (image == "valid-id2") {
          this.imageDataValid2 = e.target.result;
          this.valid_id_2_text = file_ext;
        } else if (image == "sketch") {
          this.imageDataSketch = e.target.result;
          this.sketch_text = file_ext;
        } else if (image == "sketch2") {
          this.imageDataSketch2 = e.target.result;
          this.sketch2_text = file_ext;
        } else {
          this.imageData = e.target.result;
          this.picture_text = file_ext;
        }
      };
    },

    update() {
      var temp = JSON.parse(JSON.stringify(this.data));
      var list = this.data.income_source_arr;
      console.log(this.data);
      // if (this.imageData != "" || this.imageDataValid1) {
      temp.picture = this.imageData;
      temp.valid_id_1 = this.imageDataValid1;
      temp.valid_id_2 = this.imageDataValid2;
      temp.sketch = this.imageDataSketch;
      temp.sketch2 = this.imageDataSketch2;
      temp.picture_text = this.picture_text;
      temp.valid_id_1_text = this.valid_id_1_text;
      temp.valid_id_2_text = this.valid_id_2_text;
      temp.sketch_text = this.sketch_text;
      temp.sketch_text2 = this.sketch_text2;
      temp.present_residential = this.present_residential;
      temp.barangay = this.data.barangay_object.id;
      temp.city = this.data.city_object.id;
      temp.province = this.data.province_object.id;
      temp.region = this.data.region_object.id;
      temp.country = this.data.country_object.id;
      if(list.length > 0)
        temp.income_source = list.join(", ");

      if(this.data.barangay_object.id != '' && this.data.city_object.id != '' &&
      this.data.province_object.id != '' && this.data.region_object.id != '' && this.data.country_object.id != '' )
      {
        swal("Warning!", "Please complete the address", "warning");
      }
      else
      if (
        this.data.sss == "" &&
        this.data.gsis == "" &&
        this.data.tin == "" &&
        this.data.otherID1_number == "" &&
        this.data.otherID2_number == ""
      ) {
        swal("Warning!", "Input at least one valid ID", "warning");
      } else {
        this.$validator.validateAll().then((result) => {
          if (result) {
            this.$http
              .post("api/UpdateMember", temp)
              .then((response) => {
                console.log(response.body);
                swal("This application has been updated!", {
                  icon: "success",
                });
                this.imageData = "";
                this.$bvModal.hide("ModalEditApplication");
                this.$root.$emit("Updated_list");
              })
              .catch((response) => {
                swal({
                  title: "Error",
                  text: response.body.error,
                  icon: "error",
                  dangerMode: true,
                });
              });
          } else
            swal("Warning!", "Some data has invalid or no inputs.", "warning");
        });
      }
    },
    Delete() {
      swal({
        title: "Are you sure?",
        text: "Do you really want to delete this evaluation?",
        icon: "warning",
        buttons: ["No", "Yes"],
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
          this.tblisBusy = true;
          this.$http
            .delete("api/Member/" + this.data.id)
            .then((response) => {
              swal("Application has been deleted!", {
                icon: "success",
              });
              this.$bvModal.hide("ModalEditApplication");
              this.$root.$emit("Counter");
              this.$root.$emit("Updated_list");
            })
            .catch((response) => {
              swal({
                title: "Error",
                text: response.body.error,
                icon: "error",
                dangerMode: true,
              }).then((value) => {
                if (value) {
                  this.tblisBusy = false;
                }
              });
            });
        }
      });
    },
    btnAddDate() {
      this.$bvModal.show("ModalDate");
    },
    btnApprove() {
      if(this.data.enrollment_date != null )
      {
        if(this.data.membership_type != null )
        {
          var data = {
            id: this.data.id,
            enrollment_date: this.data.enrollment_date,
            membership_type: this.data.membership_type,
            sms_switch: this.sms_switch,
            email_switch: this.email_switch,
            branch_code: this.data.branch.code,
          };
          console.log(data);
          swal({
            title: "Are you sure?",
            text: "Do you really want to approve this application",
            icon: "info",
            buttons: ["No", "Yes"],
            dangerMode: true,
          }).then((approve) => {
            if (approve) {
              this.$root.$emit("pageLoading");
              this.$http.post("api/member/accept", data).then((response) => {
                console.log(response.body);
                this.$root.$emit("pageLoaded");
                swal("Member Application #" + this.data.id + "has been approved!", {
                  icon: "success",
                });

                this.$bvModal.hide("ModalEditApplication");
                this.$bvModal.hide("ModalDate");
                this.$root.$emit("Counter");
                this.$root.$emit("Updated_list");
              });
            }
          });
      }
      else
      swal("Please Select Membership Type");
    }
    else
      swal("Please Select Membership Date");
    },
    btnReject() {
      var data = {
        id: this.data.id,
        enrollment_date: this.data.enrollment_date,
        sms_switch: this.sms_switch,
        email_switch: this.email_switch,
      };

      this.$http.post("api/member/reject", data).then((response) => {
        swal("Member Application #" + this.data.id + "has been rejected!", {
          icon: "warning",
        });
        this.$bvModal.hide("ModalEditApplication");
        this.$root.$emit("Counter");
        this.$root.$emit("Updated_list");
      });
    },
    calcuAge(dateString) {
      console.log(dateString);

      var today = new Date();
      var birthDate = new Date(dateString);
      var age = today.getFullYear() - birthDate.getFullYear();
      var m = today.getMonth() - birthDate.getMonth();
      if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
      }
      this.data.age = age;
    },
    print() {
      // this.$htmlToPaper("printable-app");
      // this.$bvModal.hide("ModalEditApplication");
      // this.$bvModal.show("modalPrintPreview");
      // window.location.href = "/";
      window.print();
    },
    viewAttachment(file) {
      window.open(this.$img_path + file);
    },
    checkCopy() {
      if (this.copyPresent == true) {
        this.data.permanent_address = this.present_residential;
      } else {
        this.data.permanent_address = "";
      }
    },
    checker() {
      console.log(this.data.income_source_arr);
    },
    printform()
    {
      this.$bvModal.show("ModalPrintPreview");
    },
    printids()
    {
      this.$bvModal.show("ModalPrintIDs");
      // let route = this.$router.resolve({ path: "/printid/"+id+"/edit" });
      // window.open(route.href);
    },
    onChangeCountry()
    {
      console.log(this.data.country_object);
      this.regions = this.data.country_object.regions;
      this.provinces = [];
      this.cities = [];
      this.barangays = [];
      this.data.region_object = {
        name: "",
        id: ""
      };
      this.data.province_object = {
        name: "",
        id: ""
      };
      this.data.city_object = {
        name: "",
        id: ""
      };
      this.data.barangay_object = {
        name: "",
        id: ""
      };
    },
    onChangeRegion()
    {
      console.log(this.data.region_object);
      this.provinces = this.data.region_object.provinces;
      this.cities = [];
      this.barangays = [];
      this.data.province_object = {
        name: "",
        id: ""
      };
      this.data.city_object = {
        name: "",
        id: ""
      };
      this.data.barangay_object = {
        name: "",
        id: ""
      };
    },
    onChangeProvince()
    {
      console.log(this.data.province_object);
      this.cities = this.data.province_object.cities;
      this.barangays = [];
      this.data.city_object = {
        name: "",
        id: ""
      };
      this.data.barangay_object = {
        name: "",
        id: ""
      };
    },
    onChangeCity()
    {
      console.log(this.data.city_object);
      this.barangays = this.data.city_object.barangays;
      this.data.barangay_object = {
        name: "",
        id: ""
      };
    }
  },
};
</script>
<style scoped>
@media print {
  @page {
    size: 5.5in 8.5in;
    size: landscape;
    font: 10px;
    text-align: left;
    float: left;
    margin-left: 4px;
  }
  #printable-app {
    visibility: visible;
  }

  table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
    color: rgb(0, 31, 95);
  }

  td,
  th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
  }

  tr:nth-child(even) {
    background-color: #dddddd;
  }
}
@media screen {
  #printable-app {
    visibility: hidden;
  }
}

.centerText {
  text-align: center;
}
.cont-wrap {
  margin-bottom: 10px;
}
.textLabel {
  margin-top: 15px;
  float: left;
  font-size: 12px;
}

/* nav tabs */
.nav-tabs {
  border: 0;
  padding: 15px 0.7rem;
}

.nav-tabs:not(.nav-tabs-neutral) > .nav-item > .nav-link.active {
  box-shadow: 0px 5px 35px 0px rgba(0, 0, 0, 0.3);
}

.card .nav-tabs {
  border-top-right-radius: 0.1875rem;
  border-top-left-radius: 0.1875rem;
}

.nav-tabs > .nav-item > .nav-link {
  color: #888888;
  margin: 0;
  margin-right: 5px;
  background-color: transparent;
  border: 1px solid transparent;
  /* border-radius: 30px; */
  font-size: 14px;
  padding: 11px 23px;
  line-height: 1.5;
}

.nav-tabs > .nav-item > .nav-link:hover {
  background-color: transparent;
}

.nav-tabs > .nav-item > .nav-link.active {
  background-color: #0295da;
  /* border-radius: 30px; */
  color: #ffffff;
}

.nav-tabs > .nav-item > .nav-link i.now-ui-icons {
  font-size: 14px;
  position: relative;
  top: 1px;
  margin-right: 3px;
}

.nav-tabs.nav-tabs-neutral > .nav-item > .nav-link {
  color: #ffffff;
}

.nav-tabs.nav-tabs-neutral > .nav-item > .nav-link.active {
  background-color: rgba(255, 255, 255, 0.2);
  color: #ffffff;
}

@media screen and (max-width: 768px) {
  .nav-tabs {
    display: inline-block;
    width: 100%;
    padding-left: 100px;
    padding-right: 100px;
    text-align: center;
  }

  .nav-tabs .nav-item > .nav-link {
    margin-bottom: 5px;
  }
  .emp-heading {
    background: #2c2c2c;
  }
  .txtRate {
    font-weight: bold;
  }
}

.application-content {
  width: 80%;
  border-radius: 20px;
  background-color: #fdfeff;
  box-shadow: 0 5px 5px rgba(0, 0, 0, 0.4);
  margin: 5em auto;
  display: flex;
}

.row > h5 {
  color: #777575;
  margin-top: 20px;
}
form {
  padding: 0 2em;
}
.form__input {
  width: 100%;
  border: 0px solid transparent;
  border-radius: 0;
  border-bottom: 1px solid #aaa;
  padding: 1em 0.5em 0.5em;
  padding-left: 2em;
  outline: none;
  margin: 1.5em auto;
  transition: all 0.5s ease;
}
.form__input:focus {
  border-bottom-color: #1cc470;
  box-shadow: 0 0 5px rgba(51, 212, 105, 0.4);
  border-radius: 4px;
}

.field-div {
  margin-bottom: 12px;
}
.span-click {
  cursor: pointer;
  border-radius: 0;
  background: #6b6868 !important;
  padding-left: 8px !important;
  padding-right: 8px !important;
}
.span-append {
  border-radius: 0;
  background: #6b6868 !important;
  padding-right: 0;
  padding-left: 0;
}
.input-icon {
  color: #ffffff !important;
  margin-left: 8px;
  margin-right: 8px;
}

.fields {
  background-color: #ffffff;
  font-size: small;
  color: #1b1b1b;
  border-radius: 0 0 0 0;
  border: 0;
  padding-right: 35px;
  padding-left: 12px !important;
}
.error-span,
.error-span2 {
  display: block;
  /* text-align: right; */
  color: red;
  margin-bottom: 12px;
  margin-top: -10px;
}
.error-span2 {
  margin-top: -19px;
}
.center-align {
  font-weight: bold;
  display: block;
  text-align: center;
  margin-top: 10px;
  margin-bottom: -18px;
}
.proceed-btn {
  background-color: #1cc470;
  margin-right: 2em;
  float: right;
  width: 10%;
  border: none;
  color: #ffffff;
}
.back-btn {
  background-color: #588bad;
  margin-left: 2em;
  width: 10%;
  float: left;
  border: none;
  color: #ffffff;
}
.login-btn {
  transition: all 0.5s ease;
  color: #ffffff;
  font-weight: bold;
  background-color: #588bad;
  border: 0;
  padding: 7px;
  border-radius: 0 0 0 0;
  width: 60%;
  margin-top: 10px;
}
.login-btn:hover,
.login-btn:focus {
  background-color: #286994;
  padding: 7px;
  border: 0;
  /* color: #19b45f; */
  color: #ffffff;
}
.signup-btn {
  transition: all 0.5s ease;
  color: #0c0a0a;
  font-weight: bold;
  background-color: #ffffff;
  border: 0;
  padding: 7px;
  border-radius: 0 0 0 0;
  width: 60%;
  margin-top: 10px;
}
.signup-btn:hover,
.signup-btn:focus {
  background-color: #f80606;
  padding: 7px;
  border: 0;
  color: #ffffff;
}
/* To align the label due to the float's effect */
.enhancements label {
  margin-top: 8px;
  float: right;
}

/* To put the form element to the left of the label */
.enhancements input {
  margin-right: 0.5rem;
  background: #1cc470;
  float: right;
}
.msg {
  margin-top: 15px;
}
.rowFields {
  margin-top: 15px;
}

.rowFields1 {
  margin: 20px;
  font-size: 12px;
}
.bolded {
  font-weight: bold;
}

.modal-header .close {
  display: none;
}
.file-upload-form,
.image-preview {
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  padding: 20px;
}
img.preview {
  min-width: 200px;
  min-height: 200px;
  max-width: 200px !important;
  max-height: 200px !important;
  background-color: white;
  border: 1px solid #ddd;
  padding: 5px;
}

img.preview-id {
  min-width: 500px;
  min-height: 200px;
  max-width: 500px !important;
  max-height: 200px !important;
  background-color: white;
  border: 1px solid #ddd;
  padding: 5px;
}

.text-upper {
  text-transform: uppercase;
}

.data-print {
  font: 10px;
  text-align: left;
  float: left;
  margin-top: 1px;
}

.swal2-overflow {
  overflow-x: visible;
  overflow-y: visible;
}
</style>
<style lang="css">
@import "~vue-single-date-picker/dist/vue-single-date-picker.css";
</style>
