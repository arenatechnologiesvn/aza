<template lang="pug">
  div.preview-image__container
    el-row
      el-col(:span="24" style="position: relative;")
        img.preview-image__main(:src="images[currentIndex].img")
        div.control__main
          el-button.control__main--prev(@click="prev" size="mini")
            svg-icon(icon-class="fa-solid angle-left")
          el-button.control__main--next(@click="next" size="mini")
            svg-icon(icon-class="fa-solid angle-right")
    el-row(type="flex" :gutter="5")
      el-col.control__images(v-for="(item, key, index) in images" :key="item.id" :span="6")
        a.item(@click="go(key)" :class="key===currentIndex ? 'active': ''")
          img.preview-image__control(:src="item.img")
</template>

<script>
  import avatar from '~/assets/products/p1.jpg'
  import avatar2 from '~/assets/products/p2.jpg'
  import avatar3 from '~/assets/products/p3.jpg'
  import avatar4 from '~/assets/products/p4.jpg'
  import './preview_image.scss'
  export default {
    name: 'PreviewImage',
    props: {
      images: {
        type: Array,
        default:() =>[
          {
            id: 1,
            img: avatar
          },
          {
            id: 2,
            img: avatar2
          },
          {
            id: 3,
            img: avatar3
          },
          {
            id: 4,
            img: avatar4
          },
        ]
      },
      delay: {
        type: Number,
        default: 4000
      }
    },
    data () {
      return {
        currentIndex: 0
      }
    },
    methods: {
      next () {
        if(this.currentIndex === 3)
          this.currentIndex = 0
        else
          this.currentIndex++
      },
      prev () {
        if(this.currentIndex === 0)
          this.currentIndex = 3
        else
          this.currentIndex--
      },
      go (index) {
        index !== 'undefined' && (this.currentIndex = index)
      }
    },
    created () {
      setInterval(()=> {
        this.next()
      }, 4000)
    }
  }
</script>

<style scoped>

</style>