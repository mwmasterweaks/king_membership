<template>
  <div>
     <b-modal
      id="modalCamera"
      :header-bg-variant="' elBG'"
      :header-text-variant="' elClr'"
      :body-bg-variant="' elBG'"
      :body-text-variant="' elClr'"
      :footer-bg-variant="' elBG'"
      :footer-text-variant="' elClr'"
      size="xl"
      title="Camera Capture"
      hide-footer
    >
      <div class="rowFields mx-auto row">
        <div class="col-lg-3">
          <p class="textLabel">Select Device:</p>
        </div>
        <div class="col-lg-8">
          <model-list-select
            :list="devices"
            v-model="camera"
            option-value="deviceId"
            option-text="label"
            placeholder="Select Device"
          ></model-list-select>
        </div>
      </div>
      <div class="rowFields mx-auto row">
        <center>
          <WebCam
            ref="webcam"
            :deviceId="deviceId"
            width="auto"
            height="100%"
            @cameras="onCameras"
            @camera-change="onCameraChange"
            @error="onError"
            :isFrontCam="frontCam"
            :debug="true"
            :googleKey="googleKey"
            >
          </WebCam>
        </center>

      </div>
      <div>
         <b-button
             class="proceed-btn"
          size="sm"
            @click="onCapture()"
            >Capture</b-button
          >
          <b-button
            size="sm"
            class="back-btn"
            @click="onStop()"
            >Close Camera</b-button
          >
          <b-button
            size="sm"
            class="back-btn"
            @click="onStart()"
            >Open Camera</b-button
          >
      </div>
    </b-modal>

  </div>

</template>

<script>
import { WebCam } from 'vue-cam-vision'
import { ModelListSelect } from "vue-search-select";
import { find, head } from 'lodash'
import swal from "sweetalert";


export default {
 props: {
    captured: {
      type: Function
    },
    field_name: {
      type: String
    }
  },
   components: {
    WebCam,
    "model-list-select": ModelListSelect,
  },
  data () {
    return {
      captures: [],
      imgReport: [],
      frontCam: false,
      webcam: null,
      img: null,
      camera: null,
      deviceId: null,
      devices: [],
      googleKey: ""
    }
  },
  computed: {
    device: function () {
      return find(this.devices, n => n.deviceId == this.deviceId)
    }
  },
   watch: {
    camera: function (id) {
      this.deviceId = id
    },
    devices: function () {
    console.log("window.orientation", window.orientation);
      if (typeof window.orientation === 'undefined') {
        // Once we have a list select the first one
        let first = head(this.devices)
        if (first) {
          this.camera = first.deviceId
          this.deviceId = first.deviceId
        }
      } else {
        this.frontCam = false
      }
    }
  },
   methods: {
    async sendGVision () {
      const res = await this.$refs.webcam.googleVision()
      console.log(res)
      this.report = res.labelAnnotations
    },
    async onCapture () {
      this.img = await this.$refs.webcam.capture()
      console.log(this.img);
      this.onStop();
      this.$bvModal.hide("modalCamera");
      this.captured(this.img, this.field_name);
    },
    onStarted (stream) {
      console.log('On Started Event', stream)
    },
    onStopped (stream) {
      console.log('On Stopped Event', stream)
    },
    onStop () {
      this.$refs.webcam.stop()
    },
    onStart () {
      this.$refs.webcam.start()
    },
    onError (error) {
      console.log('On Error Event', error)
      swal("Warning!", "Error: " + error.message, "warning");

    },
    onCameras (cameras) {
      this.devices = cameras
      console.log('On Cameras Event', cameras)
      if(this.devices.length <= 0)
      swal("Warning!", "No camera Detected", "warning");
    },
    onCameraChange (deviceId) {
      this.deviceId = deviceId
      this.camera = deviceId
      console.log('On Camera Change Event', deviceId)
    }
  },
}
</script>
