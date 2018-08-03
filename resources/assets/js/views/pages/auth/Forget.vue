<template lang="pug">
  div.login-content
    p.title__resetpassword.title--center Nhập Email để khôi phục mật khẩu
    el-form(:model="form" ref="form" :rules="rules" status-icon)
      el-form-item.form-opacity(prop="email")
        span.icon-container
          svg-icon(icon-class="fa-solid envelope")
        el-input(placeholder="Email" v-model="form.email")
      el-form-item
        el-button(type="primary" style="width:100%" @click="sendMail") GỬI
      el-form-item
        router-link(to="/login")
          svg-icon(icon-class="fa-solid sign-in-alt")
          span(style="margin-left: 10px;") Quay lại login
</template>

<script>
  import http from 'axios'
  export default {
    name: 'Forget',
    data () {
      return {
        form: {
          email: ''
        },
        rules: {
          email: [{ required: true, message: 'Email không được để trống' }],
        }
      }
    },
    methods: {

      sendMail () {
        http.post('/api/password/email', {
          ...this.form
        }).then(data => {
          this.$message({
            type: 'success',
            message: 'Đã gửi email reset mật khẩu đến emil, Hãy kiểm tra mail của bạn.'
          })
          this.$router.push({path: '/login'})
        }).catch(err => {
          this.$message({
            type: 'error',
            message: 'Không thể gửi email reset mật khẩu.'
          })
        })
      }
    }
  }
</script>