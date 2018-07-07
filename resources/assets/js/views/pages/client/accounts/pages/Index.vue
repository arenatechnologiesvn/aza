<template lang="pug">
  div.page-acount__container
    el-tabs(type="border-card")
      el-tab-pane(label="Thông tin tài khoản")
        account
      el-tab-pane(label="Thay đổi mật khẩu")
        account-password
</template>

<script>
  import Account from './account_form'
  import AccountPassword from './account_form/Password'
  export default {
    components: {
      AccountPassword,
      Account
    },
    name: 'AccountIndex'
  }
</script>

<style scoped>

</style>