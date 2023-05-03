<template>
  <div>
    <!-- modal application -->
    <b-modal
      id="ModalApplication"
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
      <div id="email-body">
        <div class="row">
          <div class="col-md-9">
            <div class="rowFields mx-auto row">
              <div class="col-lg-2">
                <p class="msg text-success">
                  <b><span @click="autofill">P</span>lease select</b>
                </p>
              </div>
              <div class="col-lg-10">
                <div
                  class="pretty p-icon p-curve p-jelly"
                  style="margin-top: 15px"
                >
                  <input
                    type="radio"
                    name="membership_status"
                    value="New"
                    v-model.trim="member.membership_status"
                    v-validate="'required'"
                  />
                  <div class="state p-success">
                    <i class="icon mdi mdi-check"></i>
                    <label> New Member</label>
                  </div>
                </div>
                <div
                  class="pretty p-icon p-curve p-jelly"
                  style="margin-top: 15px"
                >
                  <input
                    type="radio"
                    name="membership_status"
                    value="Existing"
                    v-model.trim="member.membership_status"
                    v-validate="'required'"
                  />
                  <div class="state p-success">
                    <i class="icon mdi mdi-check"></i>
                    <label> Existing Member</label>
                  </div>
                </div>
                <div
                  class="pretty p-icon p-curve p-jelly"
                  style="margin-top: 15px"
                >
                  <small
                    class="text-danger pull-left"
                    v-show="errors.has('membership_status')"
                    >Membership status is required.</small
                  >
                </div>
              </div>
            </div>
            <br />
            <div
              class="rowFields mx-auto row"
              v-if="member.membership_status == 'Existing'"
            >
              <div class="col-lg-2">
                <p class="msg">Account No.:</p>
              </div>
              <div class="col-lg-9">
                <input
                  type="text"
                  v-model.trim="member.acc_no"
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
                  name="Email"
                  ref="email"
                  v-model.trim="member.email"
                  class="form-control"
                  v-b-tooltip.hover
                  placeholder="Please enter your email"
                  v-validate="'required'"
                  autocomplete="off"
                  autofocus="on"
                  style="margin-top: 5px"
                />
                <small
                  class="text-danger pull-left"
                  v-show="errors.has('Email')"
                  >Email is required.</small
                >
              </div>
            </div>
            <div class="rowFields mx-auto row">
              <div class="col-lg-2">
                <p class="msg">Branch:</p>
              </div>
              <div class="col-lg-9">
                <model-list-select
                  :list="branches"
                  option-value="id"
                  option-text="name"
                  v-model.trim="member.branch_id"
                  placeholder="Select Branch"
                  name="Branch"
                  v-validate="'required'"
                ></model-list-select>
                <small
                  class="text-danger pull-left"
                  v-show="errors.has('Branch')"
                  >Branch is required.</small
                >
              </div>
            </div>
          </div>
          <div
            class="col-md-3 image-preview"
            :hidden="
              member.membership_status == '' ||
              member.email == '' ||
              member.branch_id == ''
            "
          >
            <img class="preview img-thumbnail" :src="imageData" />
          </div>
        </div>
        <br />
        <div
          class="row"
          :hidden="
            member.membership_status == '' ||
            member.email == '' ||
            member.branch_id == ''
          "
        >
          <div class="col-md-9" style="color: red">
            *All Fields are required, put N/A if not applicable
            <ul>
              <li v-for="error in errors.all()">{{ error }}</li>
            </ul>
          </div>
          <div class="col-md-3">
            <input
              type="file"
              @change="previewImage"
              accept="image/*,application/pdf"
              class="image-input"
              name="ID_picture"
              v-validate="'required'"
              ref="image"
            />
            <small
              class="text-danger pull-left"
              v-show="this.picture_text == ''"
              >Please upload your 2x2 photo.</small
            >
          </div>
        </div>
        <div
          id="tabs"
          :hidden="
            member.membership_status == '' ||
            member.email == '' ||
            member.branch_id == ''
          "
        >
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
                      <p class="msg"><span class="red">*</span> Title:</p>
                    </div>
                    <div class="col-lg-9">
                      <b-form-select
                        name="title"
                        ref="title"
                        v-model="member.title"
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
                        v-model.trim="member.title"
                        @input="
                          member.title = $event.target.value.toUpperCase()
                        "
                        class="form-control"
                        v-validate="'required'"
                        autocomplete="off"
                        autofocus="on"

                      />
                      -->
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg"><span class="red">*</span> Nickname:</p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        type="text"
                        name="Nickname"
                        ref="Nickname"
                        v-model.trim="member.nickname"
                        class="form-control"
                        v-validate="'required'"
                        autocomplete="off"
                        autofocus="on"
                        @input="
                          member.nickname = $event.target.value.toUpperCase()
                        "
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('Nickname')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg"><span class="red">*</span> First Name:</p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        type="text"
                        name="First_Name"
                        ref="First_Name"
                        v-model.trim="member.first_name"
                        class="form-control"
                        @input="
                          member.first_name = $event.target.value.toUpperCase()
                        "
                        v-validate="'required'"
                        autocomplete="off"
                        autofocus="on"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('First_Name')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg"><span class="red">*</span> Middle Name:</p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        type="text"
                        name="Middle_Name"
                        ref="Middle_Name"
                        class="form-control"
                        v-model.trim="member.mid_name"
                        @input="
                          member.mid_name = $event.target.value.toUpperCase()
                        "
                        v-validate="'required'"
                        autocomplete="off"
                        autofocus="on"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('Middle_Name')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg"><span class="red">*</span> Last Name:</p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        type="text"
                        name="Last_Name"
                        ref="Last_Name"
                        class="form-control"
                        v-model.trim="member.last_name"
                        @input="
                          member.last_name = $event.target.value.toUpperCase()
                        "
                        v-validate="'required'"
                        autocomplete="off"
                        autofocus="on"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('Last_Name')"
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
                        v-model.trim="member.prev_last_name"
                        @input="
                          member.prev_last_name =
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
                        v-model.trim="member.suffix"
                        @input="
                          member.suffix = $event.target.value.toUpperCase()
                        "
                        placeholder="Suffix (e.g III, Jr)"
                        autocomplete="off"
                        autofocus="on"
                      />
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg"><span class="red">*</span> Age:</p>
                    </div>
                    <div class="col-lg-9">
                      <b-form-input
                        type="number"
                        name="age"
                        ref="age"
                        v-validate="'required'"
                        class="form-control"
                        v-model.trim="member.age"
                        @input="member.age = $event.target.value.toUpperCase()"
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
                      <p class="msg"><span class="red">*</span> Gender:</p>
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
                          value="Male"
                          v-model.trim="member.gender"
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
                          value="Female"
                          v-model.trim="member.gender"
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
                      <p class="msg">
                        <span class="red">*</span> Date of Birth:
                      </p>
                    </div>
                    <div class="col-lg-9">
                      <div class="input-group">
                        <date-picker
                          v-model.trim="member.birthdate"
                          :config="Dateoptions"
                          v-b-tooltip.hover
                          placeholder="Select Date"
                          autocomplete="off"
                          v-validate="'required'"
                          name="birthdate"
                          @input="calcuAge(member.birthdate)"
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
                      <p class="msg"><span class="red">*</span> Nationality:</p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        type="text"
                        name="nationality"
                        ref="nationality"
                        class="form-control"
                        v-model.trim="member.nationality"
                        @input="
                          member.nationality = $event.target.value.toUpperCase()
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
                      <p class="msg">
                        <span class="red">*</span> Country of Birth:
                      </p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        type="text"
                        name="birthcountry"
                        ref="birthcountry"
                        class="form-control"
                        v-model.trim="member.birthcountry"
                        @input="
                          member.birthcountry =
                            $event.target.value.toUpperCase()
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
                      <p class="msg">
                        <span class="red">*</span> Place of Birth:
                      </p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        type="text"
                        name="birthplace"
                        ref="birthplace"
                        class="form-control"
                        v-model.trim="member.birthplace"
                        @input="
                          member.birthplace = $event.target.value.toUpperCase()
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
                      <p class="msg"><span class="red">*</span> Resident:</p>
                    </div>
                    <div class="col-lg-2">
                      <div
                        class="pretty p-icon p-curve p-jelly"
                        style="margin-top: 15px"
                      >
                        <input
                          type="radio"
                          name="resident"
                          value="Yes"
                          v-model.trim="member.resident"
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
                          value="No"
                          v-model.trim="member.resident"
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
                    <div class="col-lg-4" v-if="member.resident == 'No'">
                      <input
                        type="text"
                        name="resident_citizenship"
                        ref="resident_citizenship"
                        v-model.trim="member.resident_citizenship"
                        @input="
                          member.Citizenship = $event.target.value.toUpperCase()
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
                          member.resident == 'No' &&
                          member.resident_citizenship == ''
                        "
                        >This field is required.</small
                      >
                    </div>
                  </div>

                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">
                        <span class="red">*</span> Civil Status:
                      </p>
                    </div>
                    <div class="col-lg-9">
                      <div
                        class="pretty p-icon p-curve p-jelly"
                        style="margin-top: 15px"
                      >
                        <input
                          type="radio"
                          name="Civil_status"
                          value="single"
                          v-model.trim="member.civil_stat"
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
                          name="Civil_status"
                          value="married"
                          v-model.trim="member.civil_stat"
                          v-validate="'required'"
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
                          name="Civil_status"
                          value="widowed"
                          v-model.trim="member.civil_stat"
                          v-validate="'required'"
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
                          name="Civil_status"
                          value="separated"
                          v-model.trim="member.civil_stat"
                          v-validate="'required'"
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
                          name="Civil_status"
                          value="live-in"
                          v-model.trim="member.civil_stat"
                          v-validate="'required'"
                        />
                        <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label> W/Live-in Partner</label>
                        </div>
                      </div>
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('Civil_status')"
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
                        v-model.trim="member.height"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                      />

                      <!-- <small
                        class="text-danger pull-left"
                        v-show="errors.has('height')"
                        >This field is required.</small
                      > -->
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
                        v-model.trim="member.weight"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                      />

                      <!-- <small
                        class="text-danger pull-left"
                        v-show="errors.has('weight')"
                        >This field is required.</small
                      > -->
                    </div>
                  </div>

                  <hr />

                  <div class="rowFields mx-auto row">
                    <div class="col-lg-3">
                      <p class="msg">
                        <span class="red">*</span> Total No. of Dependents:
                      </p>
                    </div>
                    <div class="col-lg-8">
                      <b-form-input
                        name="dependents_no"
                        ref="dependents_no"
                        v-validate="'required'"
                        type="number"
                        class="form-control"
                        v-model.trim="member.dependents_no"
                        @input="
                          member.dependents_no =
                            $event.target.value.toUpperCase()
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
                      <p class="msg">
                        <span class="red">*</span> No. of Children:
                      </p>
                    </div>
                    <div class="col-lg-9">
                      <b-form-input
                        name="Num_of_Children"
                        ref="Num_of_Children"
                        v-validate="'required'"
                        type="number"
                        class="form-control"
                        v-model.trim="member.children_no"
                        style="margin-top: 8px"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('Num_of_Children')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-3">
                      <p class="msg">
                        <span class="red">*</span> No. of Household Members:
                      </p>
                    </div>
                    <div class="col-lg-8">
                      <b-form-input
                        name="household_no"
                        ref="household_no"
                        type="number"
                        class="form-control"
                        v-model.trim="member.household_no"
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
                      <p class="msg">
                        <span class="red">*</span> No. of Real Estate Property
                        Owned:
                      </p>
                    </div>
                    <div class="col-lg-8">
                      <b-form-input
                        v-validate="'required'"
                        name="owned_properties"
                        ref="owned_properties"
                        type="number"
                        class="form-control"
                        v-model.trim="member.owned_properties"
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
                      <p class="msg">
                        <span class="red">*</span> Number of Car(s) owned:
                      </p>
                    </div>
                    <div class="col-lg-8">
                      <b-form-input
                        v-validate="'required'"
                        name="owned_cars"
                        ref="owned_cars"
                        type="number"
                        class="form-control"
                        v-model.trim="member.owned_cars"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('owned_cars')"
                        >Field is required.</small
                      >
                    </div>
                  </div>
                  <span
                    v-if="
                      member.civil_stat == 'live-in' ||
                      member.civil_stat == 'married'
                    "
                  >
                    <hr />
                    <div class="emp-heading" style="display: flex">
                      <label class="header text-success">
                        Spouse Information</label
                      >
                    </div>
                    <div class="rowFields mx-auto row">
                      <div class="col-lg-2">
                        <p class="msg"><span class="red">*</span> Name:</p>
                      </div>
                      <div class="col-lg-9">
                        <input
                          type="text"
                          name="spouse_name"
                          ref="spouse_name"
                          v-validate="'required'"
                          v-model.trim="member.spouse_name"
                          @input="
                            member.spouse_name =
                              $event.target.value.toUpperCase()
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
                        <p class="msg"><span class="red">*</span> Age:</p>
                      </div>
                      <div class="col-lg-9">
                        <b-form-input
                          name="spouse_age"
                          ref="spouse_age"
                          v-validate="'required'"
                          type="number"
                          class="form-control"
                          v-model.trim="member.spouse_age"
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
                        <p class="msg">
                          <span class="red">*</span> Occupation:
                        </p>
                      </div>
                      <div class="col-lg-9">
                        <input
                          type="text"
                          name="spouse_occupation"
                          ref="spouse_occupation"
                          v-validate="'required'"
                          v-model.trim="member.spouse_occupation"
                          @input="
                            member.spouse_occupation =
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
                        <p class="msg"><span class="red">*</span> Employer:</p>
                      </div>
                      <div class="col-lg-9">
                        <input
                          type="text"
                          name="spouse_employer"
                          ref="spouse_employer"
                          v-validate="'required'"
                          v-model.trim="member.spouse_employer"
                          @input="
                            member.spouse_employer =
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
                        <p class="msg"><span class="red">*</span> Address:</p>
                      </div>
                      <div class="col-lg-9">
                        <input
                          type="text"
                          name="spouse_address"
                          ref="spouse_address"
                          v-validate="'required'"
                          v-model.trim="member.spouse_address"
                          @input="
                            member.spouse_address =
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
                  </span>

                  <hr />
                  <div class="emp-heading" style="display: flex">
                    <label class="header text-success">
                      Mother's Information
                    </label>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg"><span class="red">*</span> Title:</p>
                    </div>
                    <div class="col-lg-9">
                      <b-form-select
                        name="title"
                        ref="title"
                        v-model="member.mother_title"
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
                        v-model.trim="member.mother_title"
                        @input="
                          member.mother_title = $event.target.value.toUpperCase()
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
                      <p class="msg"><span class="red">*</span> First Name:</p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        type="text"
                        name="mother_first_name"
                        ref="mother_first_name"
                        v-validate="'required'"
                        v-model.trim="member.mother_first_name"
                        @input="
                          member.mother_first_name =
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
                      <p class="msg">
                        <span class="red">*</span> Middle Name(Maiden):
                      </p>
                    </div>
                    <div class="col-lg-8">
                      <input
                        type="text"
                        name="mother_mid_name"
                        ref="mother_mid_name"
                        v-validate="'required'"
                        v-model.trim="member.mother_mid_name"
                        @input="
                          member.mother_mid_name =
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
                      <p class="msg">
                        <span class="red">*</span> Last Name(Maiden):
                      </p>
                    </div>
                    <div class="col-lg-8">
                      <input
                        type="text"
                        name="mother_last_name"
                        ref="mother_last_name"
                        v-validate="'required'"
                        v-model.trim="member.mother_last_name"
                        @input="
                          member.mother_last_name =
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
                      <p class="msg"><span class="red"></span> Suffix:</p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        type="text"
                        name="mother_suffix"
                        ref="mother_suffix"
                        v-model.trim="member.mother_suffix"
                        @input="
                          member.mother_suffix =
                            $event.target.value.toUpperCase()
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
                      <p class="msg"><span class="red">*</span> Title:</p>
                    </div>
                    <div class="col-lg-9">
                      <b-form-select
                        name="title"
                        ref="title"
                        v-model="member.father_title"
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
                        v-model.trim="member.father_title"
                        @input="
                          member.father_title = $event.target.value.toUpperCase()
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
                      <p class="msg"><span class="red">*</span> First Name:</p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        type="text"
                        name="father_first_name"
                        ref="father_first_name"
                        v-validate="'required'"
                        v-model.trim="member.father_first_name"
                        @input="
                          member.father_first_name =
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
                      <p class="msg"><span class="red">*</span> Middle Name:</p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        type="text"
                        name="father_mid_name"
                        ref="father_mid_name"
                        v-validate="'required'"
                        v-model.trim="member.father_mid_name"
                        @input="
                          member.father_mid_name =
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
                      <p class="msg"><span class="red">*</span> Last Name:</p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        type="text"
                        name="father_last_name"
                        ref="father_last_name"
                        v-validate="'required'"
                        v-model.trim="member.father_last_name"
                        @input="
                          member.father_last_name =
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
                      <p class="msg"><span class="red"></span> Suffix:</p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        type="text"
                        name="father_suffix"
                        ref="father_suffix"
                        v-model.trim="member.father_suffix"
                        @input="
                          member.father_suffix =
                            $event.target.value.toUpperCase()
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
                        v-model.trim="member.sss"
                        @input="member.sss = $event.target.value.toUpperCase()"
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                      />
                      <!-- <small
                        class="text-danger pull-left"
                        v-show="errors.has('sss')"
                        >This field is required.</small
                      > -->
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
                        v-model.trim="member.gsis"
                        @input="member.gsis = $event.target.value.toUpperCase()"
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                      />
                      <!-- <small
                        class="text-danger pull-left"
                        v-show="errors.has('gsis')"
                        >This field is required.</small
                      > -->
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">TIN ID No:</p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        type="text"
                        name="TIN"
                        v-model.trim="member.tin"
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        v-validate="'required'"
                        autofocus="on"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('TIN')"
                        >This field is required.</small
                      >
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
                        v-model.trim="member.otherID1_type"
                        @input="
                          member.otherID1_type =
                            $event.target.value.toUpperCase()
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
                        name="otherID1_number"
                        v-model.trim="member.otherID1_number"
                        @input="
                          member.otherID1_number =
                            $event.target.value.toUpperCase()
                        "
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                      />
                      <!-- <small
                        class="text-danger pull-left"
                        v-show="errors.has('otherID1_number')"
                        >This field is required.</small
                      > -->
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Issued Date:</p>
                    </div>
                    <div class="col-lg-4" style="margin-top: 8px">
                      <date-picker
                        name="otherID1_issued_date"
                        v-model.trim="member.otherID1_issued_date"
                        :config="Dateoptions"
                        v-b-tooltip.hover
                        placeholder="Select Date"
                        autocomplete="off"
                      ></date-picker>
                      <!-- <small
                        class="text-danger pull-left"
                        v-show="errors.has('otherID1_issued_date')"
                        >This field is required.</small
                      > -->
                    </div>
                    <div class="col-lg-2">
                      <p class="msg">Expiry Date:</p>
                    </div>
                    <div class="col-lg-4" style="margin-top: 8px">
                      <date-picker
                        v-model.trim="member.otherID1_expiry_date"
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
                        v-model.trim="member.otherID1_last_update"
                        :config="Dateoptions"
                        v-b-tooltip.hover
                        placeholder="Select Date"
                        autocomplete="off"
                      ></date-picker>
                      <!-- <small
                        class="text-danger pull-left"
                        v-show="errors.has('otherID1_last_update')"
                        >This field is required.</small
                      > -->
                    </div>
                    <div class="col-lg-2">
                      <p class="msg">Issue Country:</p>
                    </div>
                    <div class="col-lg-2" style="margin-top: 8px">
                      <input
                        type="text"
                        name="otherID1_issue_country"
                        v-model.trim="member.otherID1_issue_country"
                        @input="
                          member.otherID1_issue_country =
                            $event.target.value.toUpperCase()
                        "
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                      />
                      <!-- <small
                        class="text-danger pull-left"
                        v-show="errors.has('otherID1_issue_country')"
                        >This field is required.</small
                      > -->
                    </div>
                    <div class="col-lg-2">
                      <p class="msg">Issued By:</p>
                    </div>
                    <div class="col-lg-2" style="margin-top: 8px">
                      <input
                        type="text"
                        name="otherID1_issue_by"
                        v-model.trim="member.otherID1_issue_by"
                        @input="
                          member.otherID1_issue_by =
                            $event.target.value.toUpperCase()
                        "
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                      />
                      <!-- <small
                        class="text-danger pull-left"
                        v-show="errors.has('otherID1_issue_by')"
                        >This field is required.</small
                      > -->
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
                        v-model.trim="member.otherID2_type"
                        @input="
                          member.otherID2_type =
                            $event.target.value.toUpperCase()
                        "
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                      />
                      <!-- <small
                        class="text-danger pull-left"
                        v-show="errors.has('otherID2_type')"
                        >This field is required.</small
                      > -->
                    </div>
                    <div class="col-lg-2">
                      <p class="msg">ID Number :</p>
                    </div>
                    <div class="col-lg-4" style="margin-top: 8px">
                      <input
                        type="text"
                        name="otherID2_number"
                        v-model.trim="member.otherID2_number"
                        @input="
                          member.otherID2_number =
                            $event.target.value.toUpperCase()
                        "
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                      />
                      <!-- <small
                        class="text-danger pull-left"
                        v-show="errors.has('otherID2_number')"
                        >This field is required.</small
                      > -->
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Issued Date:</p>
                    </div>
                    <div class="col-lg-4" style="margin-top: 8px">
                      <date-picker
                        name="otherID2_issued_date"
                        v-model.trim="member.otherID2_issued_date"
                        :config="Dateoptions"
                        v-b-tooltip.hover
                        placeholder="Select Date"
                        autocomplete="off"
                      ></date-picker>
                      <!-- <small
                        class="text-danger pull-left"
                        v-show="errors.has('otherID2_issued_date')"
                        >This field is required.</small
                      > -->
                    </div>
                    <div class="col-lg-2">
                      <p class="msg">Expiry Date:</p>
                    </div>
                    <div class="col-lg-4" style="margin-top: 8px">
                      <date-picker
                        name="otherID2_expiry_date"
                        v-model.trim="member.otherID2_expiry_date"
                        :config="Dateoptions"
                        v-b-tooltip.hover
                        placeholder="Select Date"
                        autocomplete="off"
                      ></date-picker>
                      <!-- <small
                        class="text-danger pull-left"
                        v-show="errors.has('otherID2_expiry_date')"
                        >This field is required.</small
                      > -->
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">Last Update:</p>
                    </div>
                    <div class="col-lg-2" style="margin-top: 8px">
                      <date-picker
                        name="otherID2_last_update"
                        v-model.trim="member.otherID2_last_update"
                        :config="Dateoptions"
                        v-b-tooltip.hover
                        placeholder="Select Date"
                        autocomplete="off"
                      ></date-picker>
                      <!-- <small
                        class="text-danger pull-left"
                        v-show="errors.has('otherID2_last_update')"
                        >This field is required.</small
                      > -->
                    </div>
                    <div class="col-lg-2">
                      <p class="msg">Issue Country:</p>
                    </div>
                    <div class="col-lg-2" style="margin-top: 8px">
                      <input
                        type="text"
                        name="otherID2_issue_country"
                        v-model.trim="member.otherID2_issue_country"
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                      />
                      <!-- <small
                        class="text-danger pull-left"
                        v-show="errors.has('otherID2_issue_country')"
                        >This field is required.</small
                      > -->
                    </div>
                    <div class="col-lg-2">
                      <p class="msg">Issued By:</p>
                    </div>
                    <div class="col-lg-2" style="margin-top: 8px">
                      <input
                        type="text"
                        name="otherID2_issue_by"
                        v-model.trim="member.otherID2_issue_by"
                        @input="
                          member.otherID2_issue_by =
                            $event.target.value.toUpperCase()
                        "
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                      />
                      <!-- <small
                        class="text-danger pull-left"
                        v-show="errors.has('otherID2_issue_by')"
                        >This field is required.</small
                      > -->
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
                        v-model.trim="member.country"
                        placeholder="Select Country"
                        name="country"
                        v-validate="'required'"
                      ></model-list-select>
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('country')"
                        >Country is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">City:</p>
                    </div>
                    <div class="col-lg-9">
                      <model-list-select
                        :list="cities"
                        option-value="id"
                        option-text="name"
                        v-model.trim="member.city"
                        placeholder="Select City"
                        name="city"
                        v-validate="'required'"
                      ></model-list-select>
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('city')"
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
                        v-model.trim="member.barangay"
                        placeholder="Select Barangay"
                        name="barangay"
                        v-validate="'required'"
                      ></model-list-select>
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('barangay')"
                        >Barangay is required.</small
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
                        v-model.trim="member.postal_code"
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
                        <span class="red">*</span> Present Residential
                        Billing/Mailing Address:
                      </p>
                    </div>
                    <div class="col-lg-8">
                      <textarea
                        rows="4"
                        name="present_residential_address"
                        class="form-control"
                        v-validate="'required'"
                        v-model.trim="member.present_residential"
                        @input="
                          member.present_residential =
                            $event.target.value.toUpperCase()
                        "
                        placeholder="Full Address
                        (Unit No, Blk No. Lot No, Sitio/Subdvision/Village, Brgy, Municipality/City,
                        Province, Country)"
                      ></textarea>

                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('present_residential_address')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg"><span class="red">*</span> Ownership:</p>
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
                          v-model.trim="member.ownership_present"
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
                          v-model.trim="member.ownership_present"
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
                          v-model.trim="member.ownership_present"
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
                          v-model.trim="member.ownership_present"
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
                          v-model.trim="member.ownership_present"
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
                      <p class="msg">
                        <span class="red">*</span> Monthly Rate:
                      </p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        name="monthly_rate"
                        ref="monthly_rate"
                        v-validate="'required'"
                        type="text"
                        v-model.trim="member.monthly_present"
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('monthly_rate')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">
                        <span class="red">*</span> Occupied since:
                      </p>
                    </div>
                    <div class="col-lg-9">
                      <div class="input-group">
                        <date-picker
                          v-model.trim="member.occupied_present"
                          :config="Dateoptions"
                          v-b-tooltip.hover
                          placeholder="Select Date"
                          autocomplete="off"
                          v-validate="'required'"
                          name="occupied_since"
                          ref="occupied_since"
                        ></date-picker>
                      </div>
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('occupied_since')"
                        >Field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">
                        <span class="red">*</span> Last Update Date:
                      </p>
                    </div>
                    <div class="col-lg-9">
                      <div class="input-group">
                        <date-picker
                          v-model.trim="member.last_update_present"
                          :config="Dateoptions"
                          v-b-tooltip.hover
                          placeholder="Select Date"
                          autocomplete="off"
                          v-validate="'required'"
                          name="Present_address_last_update_date"
                          ref="Present_address_last_update_date"
                        ></date-picker>
                      </div>
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('Present_address_last_update_date')"
                        >Field is required.</small
                      >
                    </div>
                  </div>
                  <hr />
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">
                        <span class="red">*</span> Permanent / Provincial
                        Address:
                      </p>
                      <br />
                    </div>
                    <div class="col-lg-9">
                      <textarea
                        rows="4"
                        name="permanent_address"
                        class="form-control"
                        v-validate="'required'"
                        v-model.trim="member.permanent_address"
                        @input="
                          member.permanent_address =
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
                        value="copy"
                        unchecked-value="not_copy"
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
                      <p class="msg"><span class="red">*</span> Ownership:</p>
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
                          v-model.trim="member.ownership_permanent"
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
                          v-model.trim="member.ownership_permanent"
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
                          v-model.trim="member.ownership_permanent"
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
                          v-model.trim="member.ownership_permanent"
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
                          v-model.trim="member.ownership_permanent"
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
                      <p class="msg">
                        <span class="red">*</span> Monthly Rate:
                      </p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        name="Permanent_address_monthly_rate"
                        ref="Permanent_address_monthly_rate"
                        v-validate="'required'"
                        type="text"
                        v-model.trim="member.monthly_permanent"
                        class="form-control"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('Permanent_address_monthly_rate')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">
                        <span class="red">*</span> Occupied since:
                      </p>
                    </div>
                    <div class="col-lg-9">
                      <div class="input-group">
                        <date-picker
                          v-model.trim="member.occupied_permanent"
                          :config="Dateoptions"
                          v-b-tooltip.hover
                          placeholder="Select Date"
                          autocomplete="off"
                          v-validate="'required'"
                          name="Permanent_address_occupied_since"
                          ref="Permanent_address_occupied_since"
                        ></date-picker>
                      </div>
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('Permanent_address_occupied_since')"
                        >Field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">
                        <span class="red">*</span> Last Update Date:
                      </p>
                    </div>
                    <div class="col-lg-9">
                      <div class="input-group">
                        <date-picker
                          v-model.trim="member.last_update_permanent"
                          :config="Dateoptions"
                          v-b-tooltip.hover
                          placeholder="Select Date"
                          autocomplete="off"
                          v-validate="'required'"
                          name="Permanent_address_last_update_date"
                          ref="Permanent_address_last_update_date"
                        ></date-picker>
                      </div>
                      <small
                        class="text-danger pull-left"
                        v-show="
                          errors.has('Permanent_address_last_update_date')
                        "
                        >Field is required.</small
                      >
                    </div>
                  </div>
                  <hr />
                  <div class="emp-heading" style="display: flex">
                    <label class="header text-success"
                      ><span class="red">*</span> Contact Data
                    </label>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">
                        <span class="red">*</span> Primary Contact No.:
                      </p>
                    </div>
                    <div class="col-lg-9">
                      <input
                        type="text"
                        name="Primary_contact_no"
                        ref="Primary_contact_no"
                        class="form-control"
                        v-model.trim="member.contact_no"
                        v-validate="'required'"
                        maxlength="12"
                        placeholder="ex.:639123456789"
                        v-b-tooltip.hover
                        autocomplete="off"
                        autofocus="on"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="errors.has('Primary_contact_no')"
                        >This field is required.</small
                      >
                    </div>
                  </div>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg">
                        <span class="red">*</span> Last Update Date:
                      </p>
                    </div>
                    <div class="col-lg-9">
                      <div class="input-group">
                        <date-picker
                          v-model.trim="member.contact_last_update"
                          :config="Dateoptions"
                          v-b-tooltip.hover
                          placeholder="Select Date"
                          autocomplete="off"
                          v-validate="'required'"
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
                      <p class="msg">
                        <span class="red">*</span> Additional Contact Number:
                      </p>
                    </div>
                    <div class="col-lg-8">
                      <input
                        type="text"
                        name="contact2_no"
                        ref="contact2_no"
                        class="form-control"
                        v-model.trim="member.contact2_no"
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
                      <p class="msg">
                        <span class="red">*</span> Last Update Date:
                      </p>
                    </div>
                    <div class="col-lg-9">
                      <div class="input-group">
                        <date-picker
                          v-model.trim="member.contact2_last_update"
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
                        <span class="red">*</span> Source of Income:
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
                          v-model.trim="member.income_source"
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
                          v-model.trim="member.income_source"
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
                          v-model.trim="member.income_source"
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
                          v-model.trim="member.income_source"
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
                          v-model.trim="member.income_source"
                        />
                        <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label>Agri-Related </label>
                        </div>
                      </div>
                    </div>
                    <small
                      class="text-danger pull-left"
                      v-show="member.income_source.length == 0"
                      >This field is required.</small
                    >
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
                          type="checkbox"
                          name="income_via"
                          ref="income_via"
                          v-validate="'required'"
                          value="ATM"
                          v-model="member.income_via"
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
                          v-model="member.income_via"
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
                          v-model="member.income_via"
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
                          v-model="member.income_via"
                        />
                        <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label> Others</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-5" v-if="member.income_via == 'Others'">
                      <input
                        type="text"
                        v-model.trim="member.other_income_via"
                        @input="
                          member.other_income_via =
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
                  <span v-show="member.income_source.includes('Business')">
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
                            v-model.trim="member.bn_name"
                            v-validate="'required'"
                            @input="
                              member.bn_name = $event.target.value.toUpperCase()
                            "
                            class="form-control"
                            v-b-tooltip.hover
                            autocomplete="off"
                            autofocus="on"
                          />
                          <small
                            class="text-danger pull-left"
                            v-show="errors.has('bn_name')"
                            >This field is required.</small
                          >
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
                            v-model.trim="member.bn_nature"
                            v-validate="'required'"
                            @input="
                              member.bn_nature =
                                $event.target.value.toUpperCase()
                            "
                            class="form-control"
                            v-b-tooltip.hover
                            autocomplete="off"
                            autofocus="on"
                          />
                          <small
                            class="text-danger pull-left"
                            v-show="errors.has('bn_nature')"
                            >This field is required.</small
                          >
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
                              v-model.trim="member.bn_established"
                            v-validate="'required'"
                              :config="Dateoptions"
                              v-b-tooltip.hover
                              placeholder="Select Date"
                              autocomplete="off"
                            ></date-picker>
                            <br>
                            <small
                            class="text-danger pull-left"
                            v-show="errors.has('bn_established')"
                            >This field is required.</small
                          >
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
                            v-model.trim="member.bn_tin"
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
                            v-model.trim="member.bn_address"
                            v-validate="'required'"
                            @input="
                              member.bn_address =
                                $event.target.value.toUpperCase()
                            "
                            placeholder="Full Address
                        (Unit No, Blk No. Lot No, Sitio/Subdvision/Village, Brgy, Municipality/City,
                        Province, Country)"
                          ></textarea>
                          <small
                            class="text-danger pull-left"
                            v-show="errors.has('bn_address')"
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
                            name="bn_contact"
                            v-model.trim="member.bn_contact"
                            v-validate="'required'"
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
                  <span v-show="member.income_source.includes('Employment')">
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
                            v-model.trim="member.emp_employer"
                            @input="
                              member.emp_employer =
                                $event.target.value.toUpperCase()
                            "
                            class="form-control"
                            v-b-tooltip.hover
                            autocomplete="off"
                            autofocus="on"
                            name="Company_Trade_Name"
                            v-validate="'required'"
                          />
                          <small
                            class="text-danger pull-left"
                            v-show="errors.has('Company_Trade_Name')"
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
                            name="Nature_of_Company"
                            v-validate="'required'"
                            v-model.trim="member.emp_nature"
                            @input="
                              member.emp_nature =
                                $event.target.value.toUpperCase()
                            "
                            class="form-control"
                            v-b-tooltip.hover
                            autocomplete="off"
                            autofocus="on"
                          />
                          <small
                            class="text-danger pull-left"
                            v-show="errors.has('Nature_of_Company')"
                            >This field is required.</small
                          >
                        </div>
                      </div>
                      <div class="rowFields mx-auto row">
                        <div class="col-lg-2">
                          <p class="msg">
                            Company TIN:
                          </p>
                        </div>
                        <div class="col-lg-9">
                          <input
                            type="text"
                            name="Company_TIN"
                            v-model.trim="member.emp_tin"
                            @input="
                              member.emp_tin = $event.target.value.toUpperCase()
                            "
                            class="form-control"
                            v-b-tooltip.hover
                          />
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
                            name="Company_Contact_number"
                            v-validate="'required'"
                            v-model.trim="member.emp_tel_no"
                            class="form-control"
                            v-b-tooltip.hover
                            autocomplete="off"
                            autofocus="on"
                          />
                          <small
                            class="text-danger pull-left"
                            v-show="errors.has('Company_Contact_number')"
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
                            name="Company_Address"
                            class="form-control"
                            v-validate="'required'"
                            v-model.trim="member.emp_address"
                            @input="
                              member.emp_address =
                                $event.target.value.toUpperCase()
                            "
                            placeholder="Full Address
                      (Unit No, Blk No. Lot No, Sitio/Subdvision/Village, Brgy, Municipality/City,
                      Province, Country)"
                          ></textarea>

                          <small
                            class="text-danger pull-left"
                            v-show="errors.has('Company_Address')"
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
                            name="Employee_Position"
                            v-validate="'required'"
                            v-model.trim="member.emp_position"
                            @input="
                              member.emp_position =
                                $event.target.value.toUpperCase()
                            "
                            class="form-control"
                            v-b-tooltip.hover
                            autocomplete="off"
                            autofocus="on"
                          />
                          <small
                            class="text-danger pull-left"
                            v-show="errors.has('Employee_Position')"
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
                              name="Date_Employed"
                              v-validate="'required'"
                              v-model.trim="member.emp_date_employed"
                              :config="Dateoptions"
                              v-b-tooltip.hover
                              placeholder="Select Date"
                              autocomplete="off"
                            ></date-picker>
                            <small
                              class="text-danger pull-left"
                              v-show="errors.has('Date_Employed')"
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
                            name="Gross_Income"
                            v-validate="'required'"
                            v-model.trim="member.emp_gross"
                            class="form-control"
                            v-b-tooltip.hover
                            autocomplete="off"
                            autofocus="on"
                          />
                          <small
                            class="text-danger pull-left"
                            v-show="errors.has('Gross_Income')"
                            >This field is required.</small
                          >
                        </div>
                      </div>
                      <div class="rowFields mx-auto row">
                        <div class="col-lg-2">
                          <p class="msg">
                            <span class="red">*</span> Pay period:
                          </p>
                        </div>
                        <div class="col-lg-3">
                          <b-form-select
                            name="Pay_Period_type"
                            ref="Pay_Period_type"
                            v-validate="'required'"
                            v-model="member.emp_period"
                            :options="income_options"
                            size="sm"
                          ></b-form-select>
                          <small
                            class="text-danger pull-left"
                            v-show="errors.has('Pay_Period_type')"
                            >This field is required.</small
                          >
                        </div>
                        <div class="col-lg-6">
                          <input
                            type="text"
                            name="Pay_Period_Amount"
                            v-validate="'required'"
                            v-model.trim="member.emp_annual"
                            class="form-control"
                            placeholder="amount"
                            v-b-tooltip.hover
                            autocomplete="off"
                            autofocus="on"
                          />
                          <small
                            class="text-danger pull-left"
                            v-show="errors.has('Pay_Period_Amount')"
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
                            name="Pay_Period_Amount"
                            v-validate="'required'"
                            v-model.trim="member.emp_currency"
                            class="form-control"
                            v-b-tooltip.hover
                            autocomplete="off"
                            autofocus="on"
                          />
                          <small
                            class="text-danger pull-left"
                            v-show="errors.has('Pay_Period_Amount')"
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
                          <!-- <input
                            type="text"
                            name="emp_occ_status"
                            v-validate="'required'"
                            v-model.trim="member.emp_occ_status"
                            @input="
                              member.emp_occ_status =
                                $event.target.value.toUpperCase()
                            "
                            class="form-control"
                            v-b-tooltip.hover
                            autocomplete="off"
                            autofocus="on"
                          /> -->
                          <b-form-select
                            name="emp_occ_status"
                            ref="emp_occ_status"
                            v-validate="'required'"
                            v-model="member.emp_occ_status"
                            :options="emp_occ_status_list"
                            size="sm"
                          ></b-form-select>
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
                <label class="header text-success">
                  References (Beneficiary/ies)</label
                >
              </div>
              <div class="elClr panel-body">
                <form>
                  <label class="header"><b>Reference No.1</b></label>
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-2">
                      <p class="msg"><span class="red">*</span> Name:</p>
                    </div>
                    <div class="col-lg-9" style="margin-top: 8px">
                      <input
                        type="text"
                        name="ref1_name"
                        v-validate="'required'"
                        v-model.trim="member.ref1_name"
                        @input="
                          member.ref1_name = $event.target.value.toUpperCase()
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
                      <p class="msg">
                        <span class="red">*</span> Address/Company:
                      </p>
                    </div>
                    <div class="col-lg-9" style="margin-top: 8px">
                      <input
                        type="text"
                        name="ref1_address"
                        v-validate="'required'"
                        v-model.trim="member.ref1_address"
                        @input="
                          member.ref1_address =
                            $event.target.value.toUpperCase()
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
                      <p class="msg">
                        <span class="red">*</span> Contact Number:
                      </p>
                    </div>
                    <div class="col-lg-9" style="margin-top: 8px">
                      <input
                        type="text"
                        name="ref1_contact"
                        v-validate="'required'"
                        v-model.trim="member.ref1_contact"
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
                      <p class="msg"><span class="red">*</span> Name:</p>
                    </div>
                    <div class="col-lg-9" style="margin-top: 8px">
                      <input
                        type="text"
                        name="ref2_name"
                        v-validate="'required'"
                        v-model.trim="member.ref2_name"
                        @input="
                          member.ref2_name = $event.target.value.toUpperCase()
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
                      <p class="msg">
                        <span class="red">*</span> Address/Company:
                      </p>
                    </div>
                    <div class="col-lg-9" style="margin-top: 8px">
                      <input
                        type="text"
                        name="ref2_address"
                        v-validate="'required'"
                        v-model.trim="member.ref2_address"
                        @input="
                          member.ref2_address =
                            $event.target.value.toUpperCase()
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
                      <p class="msg">
                        <span class="red">*</span> Contact Number:
                      </p>
                    </div>
                    <div class="col-lg-9" style="margin-top: 8px">
                      <input
                        type="text"
                        name="ref2_contact"
                        v-validate="'required'"
                        v-model.trim="member.ref2_contact"
                        class="form-control"
                        maxlength="11"
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
                <label class="header text-success">Attachments</label>
              </div>
              <div class="elClr panel-body">
                <form>
                  <label class="header">
                    <b>2 Valid ID: (Maximum size of 10MB)</b>
                  </label>
                  <br />
                  <small
                    class="text-danger pull-left"
                    v-show="
                      this.valid_id_1_text == '' && this.valid_id_2_text == ''
                    "
                    >Please upload at least one(1) valid ID.</small
                  >

                  <div class="rowFields mx-auto row">
                    <div class="col-lg-4">
                      <img
                        class="preview-id img-thumbnail"
                        :src="imageDataValid1"
                      />
                      <br />
                      <input
                        type="file"
                        @change="previewImage($event, 'valid-id1')"
                        accept="image/*,application/pdf"
                        class="image-input"
                        v-validate="'required'"
                        name="Valid_ID_1"
                        ref="image"
                      />
                      <!-- <small
                        class="text-danger pull-left"
                        v-show="this.valid_id_1_text == ''"
                        >Please upload your photo.</small
                      > -->
                    </div>
                    <div class="col-lg-2"></div>
                    <div class="col-lg-4">
                      <img
                        class="preview-id img-thumbnail"
                        :src="imageDataValid2"
                      />
                      <br />
                      <input
                        type="file"
                        @change="previewImage($event, 'valid-id2')"
                        accept="image/*,application/pdf"
                        class="image-input"
                        name="Valid_ID_2"
                        ref="image"
                      />
                      <!-- <small
                        class="text-danger pull-left"
                        v-show="this.valid_id_2_text == ''"
                        >Please upload your photo.</small
                      > -->
                    </div>
                  </div>
                  <br />
                  <label class="header"
                    ><b>Home Address Sketch (Include Landmark):</b></label
                  >
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-10">
                      <img
                        class="preview-id img-thumbnail"
                        :src="imageDataSketch"
                      />
                      <br />
                      <input
                        type="file"
                        @change="previewImage($event, 'sketch')"
                        accept="image/*,application/pdf"
                        class="image-input"
                        v-validate="'required'"
                        name="Home_Address_Sketch"
                        ref="image"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="this.sketch_text == ''"
                        >Please upload your photo.</small
                      >
                    </div>

                    <div class="col-lg-2"></div>
                  </div>
                  <br />
                  <label class="header"
                    ><b
                      >Business/Employment Address Sketch (Include Landmark):</b
                    ></label
                  >
                  <div class="rowFields mx-auto row">
                    <div class="col-lg-10">
                      <img
                        class="preview-id img-thumbnail"
                        :src="imageDataSketch2"
                      />
                      <br />
                      <input
                        type="file"
                        @change="previewImage($event, 'sketch2')"
                        accept="image/*,application/pdf"
                        class="image-input"
                        name="image"
                        ref="image"
                      />
                      <small
                        class="text-danger pull-left"
                        v-show="this.sketch2_text == ''"
                        >Please upload your photo.</small
                      >
                    </div>
                    <div class="col-lg-2"></div>
                  </div>
                </form>
              </div>
              <div class="elClr panel-footer"></div>
            </div>
          </div>
        </div>
      </div>
      <template slot="modal-footer" slot-scope="{}">
        <b-button class="back-btn" size="sm" type="submit" @click="back()">
          <i class="fas fa-arrow-circle-left"></i> Exit
        </b-button>
        <b-button
          class="proceed-btn"
          size="sm"
          type="submit"
          @click="register()"
        >
          Register
        </b-button>
      </template>
    </b-modal>
  </div>
</template>
<script>
import { ModelListSelect } from "vue-search-select";
import swal from "sweetalert";
import PrettyCheck from "pretty-checkbox-vue/check";
import datePicker from "vue-bootstrap-datetimepicker";
import SingleDatePicker from "vue-single-date-picker";
import VueRangedatePicker from "vue-rangedate-picker";
import PrettyRadio from "pretty-checkbox-vue/radio";
import "pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css";
export default {
  components: {
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
        present_residential: "",
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
        income_source: [],
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
        barangay: "",
        city: "",
        country: "",
        postal_code: "",
        benef_name_1: "",
        benef_age_1: "",
        benef_relation_1: "",
        benef_contact_1: "",
        benef_name_2: "",
        benef_age_2: "",
        benef_relation_2: "",
        benef_contact_2: "",
      },
      data: [],
      Dateoptions: {
        format: "YYYY-MM-DD",
        useCurrent: false,
      },
      title_options: [
        { value: "", text: "Please select title" },
        { value: "MS.", text: "MS." },
        { value: "MRS.", text: "MRS." },
        { value: "MR.", text: "MR." },
      ],
      income_options: [
        { value: "", text: "Please select period" },
        { value: "Weekly", text: "Weekly" },
        { value: "Monthly", text: "Monthly" },
        { value: "Annually", text: "Annually" },
      ],
      emp_occ_status_list: [
        "Regular",
        "Probitional",
        "Contractual",
        "Casual",
        "Project-based",
        "Job Order",
        "Self-employed"
      ],
      imageData: require("../../img/upload.jpg"),
      imageDataValid1: require("../../img/upload-id.jpg"),
      imageDataValid2: require("../../img/upload-id.jpg"),
      imageDataSketch: require("../../img/upload-id.jpg"),
      imageDataSketch2: require("../../img/upload-id.jpg"),
      picture_text: "",
      valid_id_1_text: "",
      valid_id_2_text: "",
      sketch_text: "",
      sketch2_text: "",
      copyPresent: "not_copy",
      sms_switch: false,
      email_switch: false,
      countries: [],
      cities: [],
      barangays: [],
    };
  },
  created() {
    this.loadBranches();
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
    },
    loadBranches() {
      this.$http.get("api/Branch").then(function (response) {
        this.branches = response.body;
      });
      this.$http.get("api/getCountries").then(function (response) {
        this.countries = response.body;
      });
      this.$http.get("api/getCities").then(function (response) {
        this.cities = response.body;
      });
      this.$http.get("api/getBarangays").then(function (response) {
        this.barangays = response.body;
      });
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
    back() {
      this.$bvModal.hide("ModalApplication");
      window.location.href = this.$sys_path + "/login";
    },

    register() {
      this.member.email_body = document.getElementById("email-body").innerHTML;

      this.member.picture = this.imageData;
      this.member.valid_id_1 = this.imageDataValid1;
      this.member.valid_id_2 = this.imageDataValid2;
      this.member.sketch = this.imageDataSketch;
      this.member.sketch2 = this.imageDataSketch2;
      this.member.picture_text = this.picture_text;
      this.member.valid_id_1_text = this.valid_id_1_text;
      this.member.valid_id_2_text = this.valid_id_2_text;
      this.member.sketch_text = this.sketch_text;
      this.member.sketch2_text = this.sketch2_text;
      this.member.sms_switch = this.sms_switch;
      this.member.email_switch = this.email_switch;
      console.log(this.member);
      console.log(this.$validator.validate());
      if (
        this.member.sss == "" &&
        this.member.gsis == "" &&
        this.member.otherID1_number == "" &&
        this.member.otherID2_number == ""
      ) {
        swal("Warning!", "Input at least one valid ID", "warning");
      } else {
        this.$validator.validateAll().then((result) => {
          if (result) {
            this.$root.$emit("pageLoading");
            this.$http
              .post("api/Member", this.member)
              .then((response) => {
                this.$root.$emit("pageLoaded");
                console.log(response.body);
                swal(
                  "Application",
                  "Submitted successfully! Please check your email for more info.",
                  "success"
                ).then((value) => {
                  window.location.href = this.$sys_path + "/login";
                });
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
          } else
            swal("Warning!", "Some data has invalid or no inputs.", "warning");
        });
      }
      // }
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
      this.member.age = age;
    },
    autofill() {
      this.member = {
        branch_id: 1,
        email: "bismontepeter@gmail.com",
        acc_no: "",
        title: "MS.",
        nickname: "TEST",
        first_name: "TEST",
        mid_name: "TEST",
        last_name: "TEST",
        prev_last_name: "TEST",
        suffix: "",
        resident: "No",
        resident_citizenship: "filipino",
        age: "23",
        gender: "Female",
        contact_no: "09092104014",
        contact_last_update: "2021-06-01",
        contact2_no: "09109726319",
        contact2_last_update: "2021-06-01",
        birthdate: "1998-06-01",
        nationality: "Filipino",
        birthcountry: "PH",
        birthplace: "14",
        civil_stat: "single",
        membership_status: "New",
        present_residential: "Dli makita St. Davao City",
        monthly_present: "10,000",
        occupied_present: "2000-01-01",
        last_update_present: "2000-01-01",
        permanent_address: "Dli makita St. Davao City",
        monthly_permanent: "10,000",
        occupied_permanent: "2000-01-01",
        last_update_permanent: "2000-01-01",
        member_id: 0,
        dependents_no: 3,
        children_no: 0,
        household_no: 4,
        spouse_name: "Song Kang",
        spouse_age: "24",
        spouse_occupation: "Korean Superstar",
        spouse_employer: "Wa ko Kabalo",
        spouse_address: "South Korea",
        mother_title: "MRS.",
        mother_first_name: "Lolet",
        mother_mid_name: "Polbo",
        mother_last_name: "Monte",
        mother_suffix: "II",
        father_title: "MR.",
        father_first_name: "Realito",
        father_mid_name: "Resurreccion",
        father_last_name: "Morta",
        father_suffix: "Jr.",
        owned_properties: "2",
        owned_cars: "2",
        ownership_present: "Test",
        ownership_permanent: "Test",
        income_source: [],
        income_via: "ATM",
        other_income_via: "",
        emp_employer: "TEST",
        emp_nature: "TEST",
        emp_tin: "123-456",
        emp_tel_no: "888-888",
        emp_address: "TEST",
        emp_position: "TEST",
        emp_date_employed: "2000-01-01",
        emp_gross: "100,000",
        emp_currency: "TEST",
        emp_period: "Annually",
        emp_annual: "150,000",
        emp_occ_status: "Regular",
        bn_name: "TEST",
        bn_nature: "TEST",
        bn_established: "2000-12-12",
        bn_tin: "123-456",
        bn_address: "TEST",
        bn_contact: "888-8888",
        sss: "123456",
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
        ref1_name: "Peter B",
        ref1_address: "Davao City",
        ref1_contact: "09123456789",
        ref2_name: "Daryl G",
        ref2_address: "Davao City",
        ref2_contact: "09123456789",
        height: "5'3",
        weight: "60",
        approval_date: "",
        enrollment_date: "",
        barangay: 1,
        city: 1,
        country: 1,
        postal_code: "8000",
        benef_name_1: "",
        benef_age_1: "",
        benef_relation_1: "",
        benef_contact_1: "",
        benef_name_2: "",
        benef_age_2: "",
        benef_relation_2: "",
        benef_contact_2: "",
      };
    },
    checkCopy() {
      console.log(this.copyPresent);
      if (this.copyPresent == "copy") {
        this.member.permanent_address = this.member.present_residential;
      } else {
        this.member.permanent_address = "";
      }
    },
  },
};
</script>
<style scoped>
.red {
  color: red;
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

.preview-id {
  min-width: 300px;
  min-height: 200px;
  max-width: 300px !important;
  max-height: 200px !important;
  background-color: white;
  border: 1px solid #ddd;
}
</style>
<style lang="css">
@import "~vue-single-date-picker/dist/vue-single-date-picker.css";
</style>
