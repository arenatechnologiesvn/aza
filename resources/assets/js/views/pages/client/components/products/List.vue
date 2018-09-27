<template lang="pug">
  div.list-item
    div.list-item__title(v-if="control")
      h4.title
        router-link(to="/home/products") {{category}}
      span.controls
        el-button(size="mini" @click="next")
          svg-icon(icon-class="fa-solid angle-left")
        el-button(size="mini" @click="prev")
          svg-icon(icon-class="fa-solid angle-right")
    el-carousel(height="500px" :interval="1000000" :autoplay="false" ref="productCarousel" indicator-position="none" arrow="never")
      el-carousel-item(v-for="items in chunk(products, len)" :key="(items[0] && items[0].id) || items")
        el-row(:gutter="20")
          el-col(:span="span" v-for="item in items" :key="item.id")
            product-item(:product="item")
</template>

<script>
  import ProductItem from './Item'
  export default {
    name: 'ListProduct',
    data () {
      return {
        span: 6,
        len: 2
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
      category: {
        type: String,
        default: 'SẢN PHẨM MỚI'
      },
      products: {
        type: Array,
        default: () => []
      }
    },
    components: {
      ProductItem
    },
    methods: {
      next () {
        this.$refs.productCarousel.next()
      },
      prev () {
        this.$refs.productCarousel.prev()
      },
      chunk (array, size) {
        var results = [];
        var b = array.slice(0);
        while (b.length) {
          results.push(b.splice(0, size));
        }
        return results;
      },
      handleWindowResize () {
        this.$nextTick(()=> {
          if(window.outerWidth < 500) {
            this.span = 24
            this.len = 1
          } else if(window.outerWidth < 780) {
            this.span = 12
            this.len = 2
          } else if(window.outerWidth < 960){
            this.span = 8
            this.len = 3
          } else {
            this.span = 6
            this.len = 4
          }
        })
      }
    },
    mounted() {
      window.addEventListener('resize', this.handleWindowResize);
      this.handleWindowResize()
    }
  }
</script>

<style scoped>

</style>