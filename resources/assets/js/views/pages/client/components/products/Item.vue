<template lang="pug">
  el-card.product-item(class="box-card")
    div.card__contain
      div.product-item__image
        img(:src="product")
      div.product-item__des
        div.product-item__title
          router-link(to="/home/products/2") [HOT] Thuốc bổ thận tráng dương tốt nhất hiện nay được TIN dùng 2018
        div.product-item__description
          router-link(to="/home/products") THỰC PHẨM
        div.line
        div.product-item__control
          div.product-item__control--left
            span.product-item__price 45.000(VNĐ)
            span.product-item__price--discount 85.000(VNĐ)
          div.product-item__control--right
            span.heart
              svg-icon(icon-class="fa-solid heart")
            span.shop
              svg-icon(icon-class="fa-solid cart-plus")
</template>

<script>
  import product from '~/assets/products/p1.jpg'
  export default {
    name: 'ItemProduct',
    data () {
      return {
        product
      }
    }
  }
</script>

<style scoped>

</style>