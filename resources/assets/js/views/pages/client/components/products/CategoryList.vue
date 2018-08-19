<template lang="pug">
  div.list-item.category(style="padding: 20px 0;")
    el-row
      el-col(:span="24" v-for="item in products" :key="item.id" style="padding-top: 10px; padding-bottom: 10px")
        product-item.item(:product="item")
</template>

<script>
  import ProductItem from './ItemList'
  import './category.scss'
  export default {
    name: 'CategoryProduct',
    components: {
      ProductItem
    },
    props: {
      products: {
        type: Array,
        default: () => []
      }
    }
  }
</script>

<style scoped>

</style>