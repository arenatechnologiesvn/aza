<template lang="pug">
  div(style="margin: 0 auto;")
    slider.slider__container
    slogon.container
    product(:products="products")
</template>

<script>
  import Slider from './components/Slider'
  import Slogon from './components/slogan'
  import Product from './components/products'
  import { mapGetters, mapActions } from 'vuex'
  import _ from 'lodash'
  import BaseMixin from '../mixin'

  export default {
    name: 'Home',
    mixins: [BaseMixin],
    components: {
      Slogon,
      Product,
      Slider
    },
    data () {
      return {
        loader: null
      }
    },
    watch: {
      $route: 'fetchData',

    },
    computed: {
      ...mapGetters('products', {
        'data': 'list',
        isLoading: 'isLoading'
      }),
      products () {
        /*
        * Mapping dat with server */
        const products = this.data.map(item => ({
          id: item.id,
          title: item.name,
          img: item.featured && `/${item.featured[0].directory}/${item.featured[0].filename}.${item.featured[0].extension}` ,
          category: item.category ? item.category.name : 'Chưa xác định',
          price: item.price,
          discount: item.discount_price,
          inventory: 10,
          added: item.customer_carts && item.customer_carts.length > 0,
          favorite: item.customer_favorites && item.customer_favorites.length > 0,
          description: item.description,
          quantity: (item.customer_carts && item.customer_carts.pivot && item.customer_carts.pivot.quantity) || 0
        }));
        return (products.length > 0 && _.groupBy(products, 'category')) || {}
      }
    },
    methods: {
      ...mapActions('products', {
        fetchProducts: 'fetchList'
      }),
      fetchData () {
        this.fetchProducts();
      }
    }
  }
</script>

<style scoped>

</style>