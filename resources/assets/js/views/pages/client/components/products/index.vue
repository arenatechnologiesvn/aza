<template lang="pug">
  div.product__container
    div.product__wrapper(v-for="item in items" :key="item")
      div.container
        list-product.product__category(:control="control" :type="type")
</template>

<script>
  import './product.scss'
  import ListProduct from './List'
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
      items: {
        type: Number,
        default: 6
      }
    },
    components: {
      ListProduct
    }
  }
</script>