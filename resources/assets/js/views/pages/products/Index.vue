<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid list")
        span(style="margin-left: 10px;") Danh sách sản phẩm
    product-table
</template>

<script>
  import ProductTable from './components/ProductTable';

  export default {
    name: 'ProductIndex',
    components: {
      ProductTable
    }
  }
</script>
