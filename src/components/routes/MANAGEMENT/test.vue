<template>
  <div>

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
         <WebCam
            ref="webcam"
            :deviceId="deviceId"
            width="auto"
            height="100%"
            @cameras="onCameras"
            @camera-change="onCameraChange"
            @error="onError"
            :isFrontCam="frontCam"
            :googleKey="googleKey"
            >
        </WebCam>
        </div>
        <b-button
            size="sm"
            variant="success"
            @click="onCapture()"
            >Capture</b-button
          >
          <b-button
            size="sm"
            variant="danger"
            @click="onStop()"
            >Stop</b-button
          >
          <b-button
            size="sm"
            variant="success"
            @click="onStart()"
            >Start</b-button
          >

<div class="rowFields mx-auto row">
  <div class="col-lg-8">
 <img :src="img" />

  </div>
</div>

  </div>

</template>

<script>
import { WebCam } from 'vue-cam-vision'
import { ModelListSelect } from "vue-search-select";
import { find, head } from 'lodash'

export default {
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
    },
    onCameras (cameras) {
      this.devices = cameras
      console.log('On Cameras Event', cameras)
    },
    onCameraChange (deviceId) {
      this.deviceId = deviceId
      this.camera = deviceId
      console.log('On Camera Change Event', deviceId)
    }
  },
}
</script>
