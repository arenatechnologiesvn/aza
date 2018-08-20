<template lang="pug">
  el-card
    template(slot="header")
      svg-icon(icon-class="fa-solid building")
      span(style="margin-left: 10px;") THÔNG TIN CÔNG TY
    div
      el-form(v-model="company")
        el-row(:gutter="10")
          el-col(:span="6")
            el-form-item
              img(:src="company.logo" width="100" height="100")
              el-input(type="hidden" v-model="company.logo")
          el-col(:span="18")
            el-form-item(label="Địa chỉ công ty")
              el-input(v-model="company.address" placeholder="686/22/11/ Nguyễn Đình Chiểu, Phường 11, QUận 3, TPHCM")
            el-form-item(label="Điện thoại liên hệ")
              el-input(v-model="company.phone" placeholder="0987.346.126")
            el-form-item(label="Địa chỉ email")
              el-input(v-model="company.email" placeholder="info@azavn.com")
            el-form-item(label="Copyright")
              el-input(v-model="company.copyright" placeholder="Công Ty Cổ Phần Thịn Thế, All right reversed. Powered by Arena App")
            el-form-item(label="Link facebook")
              el-input(v-model="company.fb" placeholder="https://www.facebook.com/")
            el-form-item(label="Link Youtube")
              el-input(v-model="company.youtube" placeholder="https://www.youtube.com/")
            el-form-item(style="text-align: right;")
              el-button(type="primary" @click="onSave") Lưu thông tin
              el-button Reset
</template>

<script>
  import { get, update } from '~/api/setting'
  export default {
    name: 'CompanySetting',
    data () {
      return {
        company: {
          logo: '',
          copyright: '',
          fb: '',
          youtube: '',
          address: '',
          phone: '',
          email: '',
        }
      }
    },
    methods: {
      onSave () {
        update('company', {
          company: this.company
        }).then(res => this.company = res.data.value)
      }
    },
    created () {
      get('company').then(res => {
        if(res.data) {
          this.company = res.data.value
        }
      })
    }
  }
</script>

<style scoped>

</style>