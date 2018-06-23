<template lang="pug">
  div.login-content
    el-form(:model="loginForm" :rules="loginRules" ref="loginForm" )
      el-form-item.form-opacity
        span.icon-container
          svg-icon(icon-class="fa-solid user")
        el-input(name="email" type="email" v-model="loginForm.email" autoComplete="off" placeholder="Email")
      el-form-item.form-opacity
        span.icon-container
          svg-icon(icon-class="fa-solid lock")
        el-input(name="password" type="password" @keyup.enter.native="handleLogin" v-model="loginForm.password" placeholder="Mật khẩu")
      el-form-item
        el-row
          el-col(:span=12)
            el-checkbox(v-model="loginForm.remember") Nhớ mật khẩu
          el-col(:span=12)
            router-link(to="/forget" style="float: right;")
              svg-icon(icon-class="fa-solid question-circle")
              span(style="margin-left: 5px;") Quên mật khẩu?
      el-form-item
        el-button(type="success" style="width:100%" :loading="loading" @click.native.prevent="handleLogin") ĐĂNG NHẬP
</template>

<script>
  import { isValidateEmail } from '~/utils/validate'

  export default {
    name: 'Login',
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
          password: '',
          remember: false
        },
        loginRules: {
          email: [{ required: true, trigger: 'blur', validator: validateEmail }],
          password: [{ required: true, trigger: 'blur', validator: validatePass }]
        },
        loading: false
      }
    },
    methods: {
      handleLogin() {
        this.$refs.loginForm.validate(valid => {
          if (valid) {
            this.loading = true
            this.$store.dispatch('Login', this.loginForm).then(() => {
              this.loading = false
              this.$router.push({path: '/'})
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
