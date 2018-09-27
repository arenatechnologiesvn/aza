<template lang="pug">
  div
    el-form(ref="form" :model="password" status-icon label-width="150px" :rules="rules" size="small")
      el-form-item(label="MẬT KHẨU CỦ" prop="current")
        el-input(v-model="password.current" type="password" placeholder="**********")
      el-form-item(label="MẬT KHẨU MỚI" prop="new_pass")
        el-input(v-model="password.new_pass" type="password" placeholder="**********")
      el-form-item(label="XÁC NHẬN MẬT KHẨU" prop="pass_confirm")
        el-input(v-model="password.pass_confirm" type="password" placeholder="**********")
      el-form-item(style="text-align: right")
        el-button(type="success" @click="onChangePassword") CẬP NHẬT
</template>
<script>
  import request from '~/utils/request'
  export default {
    name: 'Password',
    data() {
      const validateEquals = (rule, value, callback) => {
        const current = this.password.new_pass
        if(value === '') {
          callback(new Error('Mật khẩu xác nhận là bắt buộc'))
        }
        if(value !== current) {
          callback(new Error('Mật khẩu xác nhận không đúng'))
        } else {
          callback()
        }
      }
      const validateLength = (rule, value, callback) => {
        if(value.length < 6) {
          callback(new Error('Mật khẩu phải dài hơn 6 ký tự'))
        } else {
          callback()
        }
      }

      return {
        password: {
          current: '',
          new_pass: '',
          pass_confirm: ''
        },
        rules: {
          current: [
            { required: true, message: 'Mật khẩu củ là bắt buộc', trigger: 'blur' }
          ],
          new_pass: [
            { required: true, message: 'Mật khẩu mới là bắt buộc' },
            { validator: validateLength, trigger: 'blur' }
          ],
          pass_confirm: [
            { required: true, message: 'Xác nhận mật khẩu mới là bắt buộc' },
            { validator: validateEquals, trigger: 'blur' }
          ]
        }
      }
    },
    methods: {
      onChangePassword () {
        request({
          url: `/api/users/change-password`,
          method: 'post',
          data: {
            current: this.password.current,
            new_pass: this.password.new_pass
          }
        }).then(err => {
           this.$message(
          {
            message: 'Đổi mật khẩu thành công',
            type: 'success'
          })
          this.$store.dispatch('user/LogOut').then(() => {
            this.$router.push({path: '/'})
            location.reload()
          })
        }).catch(err => {
          this.$message({
            message: 'Không thể đổi mật khẩu, Đã có lỗi xảy ra',
            type: 'error'
          })
        })
      }
    }
  }
</script>