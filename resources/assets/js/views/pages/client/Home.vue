<template lang="pug">
  div(style="margin: 0 auto;")
    slider.slider__container
    slogon.container
    product
</template>

<script>
  import Slider from './components/Slider'
  import Slogon from './components/slogan'
  import Product from './components/products'
  import { mapGetters, mapActions } from 'vuex'
  import _ from 'lodash'

  export default {
    name: 'Home',
    components: {
      Slogon,
      Product,
      Slider
    },
    computed: {
      ...mapGetters('cproduct', {
        'listProducts': 'list'
      }),
      products () {
        return _.groupBy(this.listProducts, 'category')
      }
    },
    methods: {
      ...mapActions('cproduct', {
        'getProducts': 'getAllProducts'
      })
    },
    created () {
      this.getProducts()
    }
  }
</script>

<style scoped>

</style>