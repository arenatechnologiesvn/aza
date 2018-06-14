<template lang='pug'>
  section.el-container.login-container.is-vertical
    header.el-header
    main.el-main(style="position: relative; padding: 0")
      div(style="position: absolute; top: 50%; transform: translateY(-50%); width: 100%;")
        el-row.logo-container(type="flex" justify="center")
          img(:src="logo_img")
        el-row(type="flex" justify="center")
          el-col(:md="5")
            el-form.login-form(autoComplete="on" :model="loginForm" :rules="loginRules" ref="loginForm" label-position="left")
              el-form-item.el-form-item__input(prop="email")
                span.svg-container.svg-container_login
                  svg-icon(icon-class="user")
                el-input(name="email" type="text" v-model="loginForm.email" autoComplete="on" placeholder="Email")
              el-form-item.el-form-item__input(prop="password")
                span.svg-container.svg-container_login
                  svg-icon(icon-class="password")
                el-input(name="password" :type="pwdType" @keyup.enter.native="handleLogin" v-model="loginForm.password" autoComplete="on" placeholder="Mật khẩu")
                  span(class="showPwd")
              el-form-item.el-row
                el-col(:span="12")
                  el-checkbox Nhớ mật khẩu
                el-col(:span="12")
                  el-button(type="text" style="color: #242256; float: right;") Quên mật khẩu?
              el-form-item
                el-button(type="success" style="width:100%" :loading="loading" @click.native.prevent="handleLogin") ĐĂNG NHẬP
    footer.el-footer
      el-row(type="flex" justify="center")
        span(style="color: #242256") Copyright © Công Ty Cổ Phần Thịnh Thế. All right reserved.
      el-row(type="flex" justify="center")
        span(style="color: #242256") Powered by Arena App
</template>

<script>
import { isValidateEmail } from '~/utils/validate'
import logo_img from '~/assets/login_images/logo-login-page.png'

export default {
  name: 'login',
  data() {
    const validateEmail = (rule, value, callback) => {
      if (value && !isValidateEmail(value)) {
        callback(new Error('Vui lòng nhập email chính xác'))
      } else {
        callback()
      }
    }
    const validatePass = (rule, value, callback) => {
      if (value && value.length < 5) {
        callback(new Error('Mật khẩu không được nhỏ hơn 5 ký tự'))
      } else {
        callback()
      }
    }
    return {
      loginForm: {
        email: '',
        password: ''
      },
      loginRules: {
        email: [{ required: true, trigger: 'blur', validator: validateEmail }],
        password: [{ required: true, trigger: 'blur', validator: validatePass }]
      },
      loading: false,
      pwdType: 'password',
      logo_img
    }
  },
  methods: {
    showPwd() {
      if (this.loginForm.password) return ''
      return 'show-pwd'
    },
    handleLogin() {
      this.$refs.loginForm.validate(valid => {
        if (valid) {
          this.loading = true
          this.$store.dispatch('Login', this.loginForm).then(() => {
            this.loading = false
            this.$router.push({ path: '/' })
          }).catch(() => {
            this.loading = false
          })
        } else {
          console.log('error submit!!')
          return false
        }
      })
    }
  }
}
</script>

<style rel="stylesheet/scss" lang="scss">
$bg:#2d3a4b;
$aza_color:#242256;

/* reset element-ui css */
.login-container {
  .el-input {
    display: inline-block;
    height: 47px;
    width: 85%;
    input {
      background: transparent;
      border: 0px;
      -webkit-appearance: none;
      border-radius: 0px;
      padding: 12px 5px 12px 15px;
      color: $aza_color;
      height: 47px;
      &:-webkit-autofill {
        -webkit-box-shadow: 0 0 0px 1000px none inset !important;
        -webkit-text-fill-color: #242256 !important;
        background-color: rgba(255, 255, 255, 0.6) !important;
      }
    }
  }
  .el-form-item {
    border-radius: 5px;
    color: $aza_color;
    &__input {
      background: rgba(255, 255, 255, 0.6);
    }
  }
}

</style>

<style rel="stylesheet/scss" lang="scss" scoped>
$bg:#2d3a4b;
$aza_color:#242256;
.login-container {
  height: 100%;
  width: 100%;
  background: url('../../assets/login_images/background.png') no-repeat center center;
  background-size: cover;
  .login-form {
    padding: 35px 35px 15px 35px;
    margin: 35px 0;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 10px;
  }
  .tips {
    font-size: 14px;
    color: #fff;
    margin-bottom: 10px;
    span {
      &:first-of-type {
        margin-right: 16px;
      }
    }
  }
  .svg-container {
    padding: 6px 5px 6px 15px;
    color: $aza_color;
    vertical-align: middle;
    width: 30px;
    display: inline-block;
    &_login {
      font-size: 20px;
    }
  }
  .title {
    font-size: 26px;
    font-weight: 400;
    color: $aza_color;
    margin: 0px auto 40px auto;
    text-align: center;
    font-weight: bold;
  }
  .show-pwd {
    position: absolute;
    right: 10px;
    top: 7px;
    font-size: 16px;
    color: $aza_color;
    cursor: pointer;
    user-select: none;
  }
}
</style>
