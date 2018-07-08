<template lang="pug">
  div.account__container
    div.container
      bread-crumb
      el-row.account-info(:gutter="20")
        el-col(:span="6")
          nav-account.account-info--column
        el-col(:span="18")
          div.account-info--column
            router-view
</template>

<script>
  import NavAccount from './nav'
  import BreadCrumb from '../components/BreadCrumb'
  export default {
    components: {
      NavAccount,
      BreadCrumb
    },
    name: 'AccountLayout'
  }
</script>

<style lang="scss" scoped>
  .account__container {
    padding: 0 0 20px;
    min-height: 500px;
    .account-info {
      padding: 20px 0;
      .account-info--column {
        background-color: white;
      }
    }
  }
</style>