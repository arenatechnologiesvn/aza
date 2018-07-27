<template lang="pug">
  div.product__container
    div.product__wrapper(v-for="(item, key) in products" :key="key")
      div.container
        list-product.product__category(
        :control="control"
        :category="key"
        :products="item")
</template>

<script>
  import './product.scss'
  import ListProduct from './List'
  import { mapGetters } from 'vuex'

  export default {
    name: 'IndexProduct',
    props: {
      type: {
        type: String,
        default: 'block'
      },
      control: {
        type: Boolean,
        default: true
      },
      products: {
        type: Object,
        default: () => {}
      }
    },
    components: {
      ListProduct
    }
  }
</script>