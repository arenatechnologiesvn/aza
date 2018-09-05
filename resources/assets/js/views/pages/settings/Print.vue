<template lang="pug">
  el-tabs(type="border-card")
    el-tab-pane
      span(slot="label")
        svg-icon(icon-class="fa-solid print")
        span(style="margin-left: 10px;") THÔNG TIN MÁY IN
      div
        el-form(v-model="print")
          el-row(:gutter="10")
            el-col(:span="24")
              el-form-item(label="Chiều ngang (mm)")
                el-input(v-model="print.width" placeholder="80")
              el-form-item(label="Chiều dài (mm)")
                el-input(v-model="print.height" placeholder="500")
              el-form-item(label="Font size (pixel)")
                el-input(v-model="print.fontSize" placeholder="12")
              el-form-item(label="Padding (pixel)")
                el-input(v-model="print.padding" placeholder="5")
              el-form-item(label="Ghi chú")
                el-input(v-model="print.note" placeholder="Cảm ơn quý khách")
              el-form-item(style="text-align: right;")
                el-button(type="primary" @click="onSave") Lưu thông tin
</template>

<script>
  import { get, update } from '~/api/setting'
  export default {
    name: 'PrintSetting',
    data () {
      return {
        print: {
          width: '',
          height: '',
          fontSize: '',
          padding: '',
          note: ''
        }
      }
    },
    methods: {
      onSave () {
        update('print', {
          print: this.print
        }).then(res => this.print = res.data.value)
          .then(() => this.$notify(
            {
              title: 'Thông báo',
              message: 'Đã cập nhật thành công thông tin',
              type: 'success'
            }))
      }
    },
    created () {
      get('print').then(res => {
        if(res.data) {
          this.print = res.data.value
        }
      })
    }
  }
</script>

<style scoped>

</style>