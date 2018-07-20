<template lang="pug">
  div.product__container
    div.product__wrapper(v-for="item in products" :key="item.id")
      div.container
        list-product.product__category(
        :control="control"
        :category="item[0].category"
        :products="item")
</template>

<script>
  import './product.scss'
  import ListProduct from './List'
  import { mapGetters } from 'vuex'

  export default {
    name: 'IndexProduct',
    computed: {
      ...mapGetters('cproduct', {
        'listProducts': 'list'
      }),
      products () {
        return _.groupBy(this.listProducts, 'category')
      }
    },
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