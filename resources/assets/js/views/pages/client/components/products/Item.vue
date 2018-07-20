<template lang="pug">
  el-card.product-item(class="box-card")
    div.card__contain
      div.product-item__image
        img(:src="product.img")
      div.product-item__des
        div.product-item__title
          router-link(:to="`/home/products/${product.id}`") {{product.title}}
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
            span.shop(@click="addToCart(product)")
              svg-icon(icon-class="fa-solid cart-plus")
</template>

<script>
  import { mapActions } from 'vuex'
  export default {
    name: 'ItemProduct',
    props: {
      product: {
        type: Object,
        default: () => {}
      }
    },
    methods: {
      ...mapActions('cart', {
        addProductToCart: 'addProductToCart'
      }),
      addToCart (product) {
        this.addProductToCart(product)
      }
    }
  }
</script>