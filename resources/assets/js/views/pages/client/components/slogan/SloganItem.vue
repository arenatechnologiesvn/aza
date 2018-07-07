<template lang="pug">
  div.slogan-item
    div.slogan-tem__image
      img(:src="background")
    div.slogan-item__mask
    div.slogan-item__content
      h4.slogan-item__title ĐẶT HÀNG
      div.line
      p.slogan-item__description 2:00AM - 9:00AM
</template>

<script>
  import background from '~/assets/404_images/404.png'
  export default {
    name: 'SloganItem',
    data () {
      return {
        background
      }
    }
  }
</script>

<style scoped>

</style>