<template lang="pug">
  div.profile-container
    el-tabs(type="border-card")
      el-tab-pane
        span(slot="label")
          svg-icon(icon-class="fa-solid user")
          span.pane--title Thông tin cá nhân
        div
          profile-info
      el-tab-pane
        span(slot="label")
          svg-icon(icon-class="fa-solid lock")
          span.pane--title Thay đổi mật khẩu
        div
          password-form
</template>

<script>
  import ProfileInfo from './components/Profile/Info'
  import PasswordForm from './components/Profile/Password'
  export default {
    components: {
      ProfileInfo,
      PasswordForm
    },
    name: 'Personal'
  }
</script>

<style scoped>
  span.pane--title {
    margin-left: 7px;
  }
</style>