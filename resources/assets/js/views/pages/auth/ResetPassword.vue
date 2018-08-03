<template lang="pug">
  div.login-content
    el-form(:model="form" ref="form" :rules="rules" status-icon)
      el-form-item.form-opacity(prop="password")
        span.icon-container
          svg-icon(icon-class="fa-solid lock")
        el-input(placeholder="Mật khẩu" type="password" v-model="form.password")
      el-form-item.form-opacity(prop="password_confirmation")
        span.icon-container
          svg-icon(icon-class="fa-solid lock")
        el-input(placeholder="Xác nhận mật khẩu" type="password" v-model="form.password_confirmation")
      el-form-item
        el-button(type="primary" style="width:100%" @click="resetPassword")
          svg-icon(icon-class="fa-solid sign-in-alt")
          span(style="margin-left: 10px;") RESET MẬT KHẨU
</template>

<script>
  import http from 'axios'
  export default {
    name: 'ResetPassword',
    data () {
      return {
        form: {
          password: '',
          password_confirmation: ''
        },
        rules: {
          password: [{required: true, message: 'Yêu cầu nhập mật khẩu'}],
          password_confirmation: [{required: true, message: 'Yêu cầu nhập mật khẩu'}]
        }
      }
    },
    methods: {
      resetPassword () {
        const email = this.$route.query.email
        const token = this.$route.query.token
        http.post('/api/password/reset', {
          email: email,
          token: token,
          ...this.form
        }).then(data => {
          this.$message({
            type: 'success',
            message: 'Reset mật khẩu thành công, Hãy đăng nhập để tiếp tục sử dụng'
          })
          this.$router.push({path: '/login'})
        }).catch(err => {
            this.$message({
              type: 'error',
              message: 'Không thể đổi mật khẩu, Hãy kiểm tra thông tin va thử lại vào lần sau'
            })
          })
      }
    }
  }
</script>

<style scoped>

</style>