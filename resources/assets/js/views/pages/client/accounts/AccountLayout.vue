<template lang="pug">
  div.account__container
    div.container
      bread-crumb
      el-row.account-info(:gutter="20")
        el-col(:md="6" :xs="24")
          nav-account.account-info--column
        el-col(:md="18" :xs="24")
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
  @media only screen and (max-width: 992px) {
    .account-info--column {
      margin-top: 30px;
    }
  }
</style>