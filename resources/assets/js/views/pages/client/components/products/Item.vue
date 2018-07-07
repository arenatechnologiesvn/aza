<template lang="pug">
  el-card.product-item(class="box-card")
    div.card__contain
      div.product-item__image
        img(:src="product")
      div.product-item__des
        div.product-item__title Bikini Hàn Quốc, độn ngực, thun co giản, sôi động mùa hè
        div.product-item__description BIKINI
        div.line
        div.product-item__control
          div.product-item__control--left
            span.product-item__price 45.000(VNĐ)
            span.product-item__price--discount 35.000(VNĐ)
          div.product-item__control--right
            span.heart
              svg-icon(icon-class="fa-solid heart")
            span.shop
              svg-icon(icon-class="fa-solid cart-plus")
</template>

<script>
  import product from '~/assets/products/linh-nguyen.jpg'
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