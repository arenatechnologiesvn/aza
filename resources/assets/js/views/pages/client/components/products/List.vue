<template lang="pug">
  div.list-item
    div.list-item__title(v-if="control")
      h4.title
        router-link(to="/home/products") {{category}}
      span.controls
        el-button(size="mini")
          svg-icon(icon-class="fa-solid angle-left")
        el-button(size="mini")
          svg-icon(icon-class="fa-solid angle-right")
    el-row(:gutter="20")
      el-col(:span="6" v-for="item in products" :key="item.id")
        product-item(:product="item")
</template>

<script>
  import ProductItem from './Item'
  import p1 from '~/assets/products/p/p1.jpg'
  import p2 from '~/assets/products/p/p2.jpg'
  import p3 from '~/assets/products/p/p3.jpg'
  import p4 from '~/assets/products/p/p4.jpg'
  export default {
    name: 'ListProduct',
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
        default: () => [
          {
            id: 1,
            title: '[HOT] Thuốc bổ thận tráng dương tốt nhất hiện nay được TIN dùng 2018',
            img: p1,
            category: 'THỰC PHẨM',
            price: 30000,
            discount: 45000
          },
          {
            id: 2,
            title: '[HOT] Thuốc bổ thận tráng dương tốt nhất hiện nay được TIN dùng 2018',
            img: p2,
            category: 'THỰC PHẨM',
            price: 30000,
            discount: 45000
          },
          {
            id: 3,
            title: '[HOT] Thuốc bổ thận tráng dương tốt nhất hiện nay được TIN dùng 2018',
            img: p3,
            category: 'THỰC PHẨM',
            price: 30000,
            discount: 45000
          },
          {
            id: 4,
            title: '[HOT] Thuốc bổ thận tráng dương tốt nhất hiện nay được TIN dùng 2018',
            img: p4,
            category: 'THỰC PHẨM',
            price: 30000,
            discount: 45000
          }
        ]
      }
    },
    components: {
      ProductItem
    }
  }
</script>

<style scoped>

</style>