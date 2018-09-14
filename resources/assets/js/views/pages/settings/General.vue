<template lang="pug">
  el-tabs(type="border-card")
    el-tab-pane
      span(slot="label")
        svg-icon(icon-class="fa-solid info")
        span(style="margin-left: 10px;") THÔNG TIN CHUNG
      div
        el-form(v-model="general")
          el-row(:gutter="10")
            el-col(:span="24")
              el-form-item(label="Hệ số tinh điểm (Số tiền (VNĐ)) = 1đ")
                el-input(v-model="general.score" type="number")
              el-form-item(style="text-align: right;")
                el-button(type="primary" @click="onSave") Lưu thông tin
</template>

<script>
  import { get, update } from '~/api/setting'
  export default {
    name: 'General',
    data () {
      return {
        general: {
          score: 0
        }
      }
    },
    methods: {
      onSave () {
        update('general', {
          general: this.general
        }).then(res => this.general = res.data.value)
          .then(() => this.$notify(
            {
              title: 'Thông báo',
              message: 'Đã cập nhật thành công thông tin',
              type: 'success'
            }))
      }
    },
    created () {
      get('general').then(res => {
        if(res.data && res.data.value) {
          this.general = res.data.value
        }
      })
    }
  }
</script>

<style scoped>

</style>