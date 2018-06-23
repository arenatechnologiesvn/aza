<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid list")
        span(style="margin-left: 10px;") Danh sách nhân viên
      el-dropdown(style="float: right; padding-right: 5px; cursor: pointer;")
        span.el-dropdown-link
          svg-icon(icon-class="fa-solid cog")
          i(class="el-icon-arrow-down el-icon--right")
        el-dropdown-menu(slot="dropdown")
          el-dropdown-item
            router-link(to="/shop/create")
              svg-icon(icon-class="fa-solid shopping-basket")
              span(style="margin-left: 5px;") Thêm mới cửa hàng
          el-dropdown-item
            router-link(to="/shop/create")
              svg-icon(icon-class="fa-solid hand-pointer")
              span(style="margin-left: 5px;") Thêm mới loại khách hàng
    div.form-search__wrapper
      form-search
    div.control__wrapper
      control
    div.table__wrapper
      user-table
</template>

<script>
  import FormSearch from './SearchForm'
  import Control from './Control'
  import UserTable from './Table'

  export default {
    name: 'UserIndex',
    components: {
      FormSearch,
      UserTable,
      Control
    }
  }
</script>

<style scoped>
  .form-search__wrapper {
    margin: 0 0 30px;
  }
  .control__wrapper {
    margin: 10px 0;
  }
</style>