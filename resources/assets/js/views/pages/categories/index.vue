<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid list")
        span(style="margin-left: 10px;") Danh mục sản phẩm
    category-table
</template>

<script>
  import CategoryTable from './components/CategoryTable';

  export default {
    name: 'CategoryIndex',
    components: {
      CategoryTable
    }
  }
</script>
