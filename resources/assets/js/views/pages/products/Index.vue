<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid list")
        span(style="margin-left: 10px;") Danh sách sản phẩm
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
    product-table
</template>

<script>
  import ProductTable from './components/ProductTable'
  export default {
    name: 'ProductIndex',
    components: {
      ProductTable
    }
  }
</script>

<style scoped>

</style>