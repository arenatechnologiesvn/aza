<template lang="pug">
  div.list-item(style="padding: 20px 0;")
    el-row(:gutter="20")
      el-col(:md="6" :sm="12" :xs="24" :lg="6" v-for="item in products" :key="item.id")
        product-item(:product="item")
</template>

<script>
  import ProductItem from './Item'
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