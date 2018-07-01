<template lang="pug">
  el-card
    div.clearfix(slot="header")
      span
        svg-icon(icon-class="fa-solid store-alt")
        span(style="margin-left: 10px;") THÊM MỚI CỬA HÀNG
      span(style="float: right")
        svg-icon(icon-class="fa-solid arrow-alt-left")
    div.card-content
      shop-form
</template>

<script>
  import ShopForm from './components/Form'
  export default {
    name: 'CreateEmployee',
    components: {
      ShopForm
    }
  }
</script>

<style scoped>

</style>