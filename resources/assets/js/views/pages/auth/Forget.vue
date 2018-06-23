<template lang="pug">
  div.login-content
    p.title__resetpassword.title--center Nhập Email để khôi phục mật khẩu
    el-form
      el-form-item.form-opacity
        span.icon-container
          svg-icon(icon-class="fa-solid envelope")
        el-input(placeholder="Email")
      el-form-item
        el-button(type="primary" style="width:100%") GỬI
      el-form-item
        router-link(to="/login")
          svg-icon(icon-class="fa-solid sign-in-alt")
          span(style="margin-left: 10px;") Quay lại login
</template>

<script>
  export default {
    name: 'Forget'
  }
</script>