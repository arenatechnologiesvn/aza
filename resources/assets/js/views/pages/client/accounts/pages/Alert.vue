<template lang="pug">
  div.account-alert
    h4.account-alert__title
      svg-icon(icon-class="fa-solid bell")
      template THÔNG BÁO
    div.h-line
    div.account-alert__content
      ul
        li(v-for="item in 6" :key="item")
          el-row.alert-list(type="flex")
            el-col.account-alert__date(:span="4")
              label 28
              label 08
            el-col(:span="16")
              span Thông báo về tin tức khuyến mãi ngày 28/08 khuyến mãi về sản phẩm mới
            el-col(:span="4")
              el-button(type="danger" size="mini" icon="el-icon-delete" round)
</template>

<script>
  export default {
    name: 'AccountAlert'
  }
</script>

<style lang="scss" scoped>
  .alert-list {
    vertical-align: middle;
  }
  .account-alert {
    background-color: white;
    .h-line {
      display: block;
      margin: 5px 0;
      height: 1px;
      background-color: #eee;
    }
    .account-alert__date {
      text-align: center;
      label {
        margin: 0 auto;
        font-size: 25px;
        display: block;
        line-height: 25px;
        width: 35px;
        background-color: #d6d6d6;
        &:first-child {
          border-bottom: 2px solid black;
        }
      }
    }
    .account-alert__title {
      margin: 0;
      text-align: left;
      padding: 10px 15px;
      svg {
        margin-right: 10px;
      }
    }
    ul {
      margin: 0;
      line-height: 30px;
      list-style: none;
      padding: 20px 0;
      background-color: #eeeeee;
      li {
        min-height: 70px;
        padding: 10px 0;
        width: 100%;
        vertical-align: middle;
        background-color: white;
        margin: 10px 0;
        &:first-child {
          margin-top: -20px;
        }
      }
    }
  }
</style>