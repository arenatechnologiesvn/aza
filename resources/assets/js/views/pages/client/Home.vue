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
  export default {
    name: 'Home',
    components: {
      Slogon,
      Product,
      Slider
    }
  }
</script>

<style scoped>

</style>