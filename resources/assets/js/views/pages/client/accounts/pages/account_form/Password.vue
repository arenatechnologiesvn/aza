<template lang="pug">
  div
    el-form(ref="form" :model="password" label-width="150px")
      el-form-item(label="MẬT KHẨU CỦ")
        el-input(v-model="password.current" type="password" placeholder="**********")
      el-form-item(label="MẬT KHẨU MỚI")
        el-input(v-model="password.new_pass" type="password" placeholder="**********")
      el-form-item(label="XÁC NHẬN MẬT KHẨU")
        el-input(v-model="password.pass_confirm" type="password" placeholder="**********")
      el-form-item
        el-button(type="success") CẬP NHẬT
</template>
<script>
  export default {
    name: 'Password',
    data() {
      return {
        password: {
          current: '',
          new_pass: '',
          pass_confirm: ''
        }
      }
    }
  }
</script>