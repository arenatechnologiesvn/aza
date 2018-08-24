<template lang="pug">
  el-tabs(type="border-card")
    el-tab-pane
      span(slot="label")
        svg-icon(icon-class="fa-solid desktop")
        span Cài đặt giờ đặt hàng
      div
        el-form(v-model="apply")
          el-form-item(label="Giờ bắt đầu")
            el-time-select(:picker-options="steps" style="width: 100%;" v-model="apply.start" placeholder="Giờ bắt đàu đặt hàng")
          el-form-item(label="Giờ kết thúc")
            el-time-select(:picker-options="steps" style="width: 100%;" v-model="apply.end" placeholder="Giờ kết thúc đặt hàng")
          el-form-item
            el-button(type="primary" @click="save") Lưu thông tin
    el-tab-pane
      span(slot="label")
        svg-icon(icon-class="fa-solid desktop")
        span Cài đặt khung giờ
      div
        el-form(v-model="times")
          el-form-item(style="text-align: right;")
            el-button(type="primary" @click="save") Lưu thông tin
</template>

<script>
  import { get, update } from '~/api/setting'
  export default {
    name: 'TimeSetting',
    props: {
      steps: {
        type: Object,
        default: () => ({
          start: '00:00',
          step: '00:15',
          end: '23:00'
        })
      }
    },
    data () {
      return {
        apply: {
          start: '',
          end: ''
        },
        times: [
          '7h-9h'
        ]
      }
    },
    methods: {
      save () {
        update('apply', {apply: this.apply}).then(res=> this.apply = res.data.value )
          .then(() => this.$notify(
            {
              title: 'Thông báo',
              message: 'Đã cập nhật thành công thông tin',
              type: 'success'
            }))
      }
    },
    created () {
      get('apply').then(res => {
        (res.data) && (this.apply = res.data.value)
      } )
    }
  }
</script>

<style lang="scss" scoped>
  svg {
    margin-right: 10px;
  }
</style>