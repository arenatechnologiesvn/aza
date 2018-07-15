<template lang="pug">
  el-carousel(:interval="4000" height="500px")
    el-carousel-item.slider-item(v-for="item in sliders" :key="item.id")
      div.overlay
        div.content
          h4.content__title {{item.title}}
          p.content__description {{item.description}}
          div
            el-button.content__button(size="small" type="success" round) {{item.button}}
      img(:src="item.img")
</template>

<script>
  import './slider.scss'
  import slider1 from '~/assets/slider/s1.jpg'
  import slider2 from '~/assets/slider/s2.jpg'
  import slider3 from '~/assets/slider/s3.jpg'
  export default {
    name: 'HomeSlider',
    props: {
      sliders: {
        type: Array,
        default: () => [
          {
            id: 1,
            img: slider1,
            title: 'Welcome to',
            description: 'Azavn.com',
            button: 'Mua ngay'
          },
          {
            id: 2,
            img: slider2,
            title: 'Welcome to',
            description: 'Azavn.com',
            button: 'Mua ngay'
          },
          {
            id: 3,
            img: slider3,
            title: 'Welcome to',
            description: 'Azavn.com',
            button: 'Mua ngay'
          }
        ]
      }
    }
  }
</script>