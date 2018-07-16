<template lang="pug">
  el-card.product-item(class="box-card")
    div.card__contain
      div.product-item__image
        img(:src="product.img")
      div.product-item__des
        div.product-item__title
          router-link(to="/home/products/2") {{product.title}}
        div.product-item__description
          router-link(to="/home/products") {{product.category}}
        div.line
        div.product-item__control
          div.product-item__control--left
            span.product-item__price {{product.price + 'VNĐ'}}
            span.product-item__price--discount {{product.discount + 'VNĐ'}}
          div.product-item__control--right
            span.heart
              svg-icon(icon-class="fa-solid heart")
            span.shop
              svg-icon(icon-class="fa-solid cart-plus")
</template>

<script>
  export default {
    name: 'ItemProduct',
    props: {
      product: {
        type: Object,
        default: () => {}
      }
    }
  }
</script>