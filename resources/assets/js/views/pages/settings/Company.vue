<template lang="pug">
  el-tabs(type="border-card")
    el-tab-pane
      span(slot="label")
        svg-icon(icon-class="fa-solid building")
        span(style="margin-left: 10px;") THÔNG TIN CÔNG TY
      div
        el-form(v-model="company")
          el-row(:gutter="10")
            <!--el-col(:span="6")-->
              <!--el-form-item-->
                <!--img(:src="company.logo" width="100" height="100")-->
                <!--el-input(type="hidden" v-model="company.logo")-->
            el-col(:span="24")
              el-form-item(label="Địa chỉ công ty")
                el-input(v-model="company.address" placeholder="686/22/11/ Nguyễn Đình Chiểu, Phường 11, QUận 3, TPHCM")
              el-form-item(label="Điện thoại liên hệ")
                el-input(v-model="company.phone" placeholder="0987.346.126")
              el-form-item(label="Địa chỉ email")
                el-input(v-model="company.email" placeholder="info@azavn.com")
              el-form-item(label="Copyright")
                el-input(v-model="company.copyright" placeholder="Công Ty Cổ Phần Thịnh Thế, All right reversed. Powered by Arena App")
              el-form-item(label="Link facebook")
                el-input(v-model="company.fb" placeholder="https://www.facebook.com/")
              el-form-item(label="Link Youtube")
                el-input(v-model="company.youtube" placeholder="https://www.youtube.com/")
              el-form-item(style="text-align: right;")
                el-button(type="primary" @click="onSave") Lưu thông tin
                el-button Reset
    el-tab-pane
      span(slot="label")
        svg-icon(icon-class="fa-solid desktop")
        span(style="margin-left: 10px;") CẤU HÌNH MAIL GỬI
      div
        el-form(v-model="settingMail")
          el-row
            el-col(:span="12")
              el-form-item(label="Mail Driver")
                el-input(v-model="settingMail.driver" placeholder="smtp")
            el-col(:span="12")
              el-form-item(label="Mail Encryption")
                el-input(v-model="settingMail.encryption" placeholder="tls")
          el-row
            el-col(:span="12")
              el-form-item(label="Mail server host")
                el-input(v-model="settingMail.server" placeholder="mail.server.com")
            el-col(:span="12")
              el-form-item(label="Mail Port")
                el-input(v-model="settingMail.port" placeholder="578")
          el-row
            el-col(:span="12")
              el-form-item(label="Mail username")
                el-input(v-model="settingMail.username" placeholder="info@azavn.com")
            el-col(:span="12")
              el-form-item(label="Mail Password")
                el-input(v-model="settingMail .password" type="password" placeholder="******")
          el-form-item(label="Mail Sender Name")
            el-input(v-model="settingMail.companyName" placeholder="Công Ty Cổ Phần Thịnh Thế")

          el-form-item(style="text-align: right;")
            el-button(type="primary" @click="onSaveEmail") Lưu thông tin
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
        },
        settingMail: {
          server: '',
          port: '',
          username: '',
          password: '',
          companyName: '',
          driver: '',
          encryption: ''
        }
      }
    },
    methods: {
      onSave () {
        update('company', {
          company: this.company
        }).then(res => this.company = res.data.value)
          .then(() => this.$notify(
            {
              title: 'Thông báo',
              message: 'Đã cập nhật thành công thông tin',
              type: 'success'
            }))
      },
      onSaveEmail () {
        update('settingMail', {
          settingMail: this.settingMail
        }).then(res => this.settingMail = res.data.value)
          .then(() => this.$notify(
            {
              title: 'Thông báo',
              message: 'Đã cập nhật thành công thông tin',
              type: 'success'
            }))
      }
    },
    created () {
      get('company').then(res => {
        if(res.data) {
          this.company = res.data.value
        }
      })
      get('settingMail').then(res => {
        if(res.data) {
          this.settingMail = res.data.value
        }
      })
    }
  }
</script>

<style scoped>

</style>