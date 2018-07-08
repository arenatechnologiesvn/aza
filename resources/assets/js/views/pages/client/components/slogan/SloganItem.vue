<template lang="pug">
  div.slogan-item
    div.slogan-tem__image
      img(:src="background")
    div.slogan-item__mask
    div.slogan-item__content
      h4.slogan-item__title {{title}}
      div.line
      p.slogan-item__description {{description}}
</template>

<script>
  import background from '~/assets/products/dh.png'
  export default {
    name: 'SloganItem',
    props: {
      title: {
        type: String,
        default: 'ĐẶT HÀNG'
      },
      description: {
        type: String,
        default: '2:00AM - 9:00AM'
      },
      // img: background
    },
    data () {
      return {
        background
      }
    }
  }
</script>