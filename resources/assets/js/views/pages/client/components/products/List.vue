<template lang="pug">
  div.list-item
    div.list-item__title(v-if="control")
      h4.title
        router-link(to="/home/products") SẢN PHẨM MỚI
      span.controls
        el-button(size="mini")
          svg-icon(icon-class="fa-solid angle-left")
        el-button(size="mini")
          svg-icon(icon-class="fa-solid angle-right")
    el-row(:gutter="20")
      el-col(:span="6" v-for="item in 4" :key="item")
        product-item
</template>

<script>
  import ProductItem from './Item'
  export default {
    name: 'ListProduct',
    props: {
      type: {
        type: String,
        default: 'block'
      },
      control: {
        type: Boolean,
        default: true
      }
    },
    components: {
      ProductItem
    }
  }
</script>

<style scoped>

</style>