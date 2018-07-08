<template lang="pug">
  div.form-search
    span.form-group
      el-input(placeholder="Tìm kiếm danh mục, sản phẩm" prefix-icon="el-icon-search")
    span.shopcart(style="color: black;")
      el-badge(:value="12" class="item")
        svg-icon(icon-class="fa-solid shopping-cart")
</template>

<script>
  import ElBadge from "element-ui/packages/badge/src/main";

  export default {
    components: {ElBadge},
    name: 'FormSearch'
  }
</script>

<style scoped>

</style>