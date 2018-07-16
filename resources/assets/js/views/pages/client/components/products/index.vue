<template lang="pug">
  div.product__container
    div.product__wrapper(v-for="item in productByCategory" :key="item.id")
      div.container
        list-product.product__category(
        :control="control"
        :category="item.category"
        :products="item.products")
</template>

<script>
  import './product.scss'
  import ListProduct from './List'
  import p1 from '~/assets/products/p/p1.jpg'
  import p2 from '~/assets/products/p/p2.jpg'
  import p3 from '~/assets/products/p/p3.jpg'
  import p4 from '~/assets/products/p/p4.jpg'
  import n1 from '~/assets/products/n/n1.jpg'
  import n2 from '~/assets/products/n/n2.jpg'
  import n3 from '~/assets/products/n/n3.jpg'
  import n4 from '~/assets/products/n/n4.jpg'
  import c1 from '~/assets/products/c/c1.jpg'
  import c2 from '~/assets/products/c/c2.jpg'
  import c3 from '~/assets/products/c/c3.jpg'
  import c4 from '~/assets/products/c/c4.jpg'

  export default {
    name: 'IndexProduct',
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
      },
      productByCategory: {
        type: Array,
        default: () => [
          {
            id: 1,
            category: 'TRÁI CÂY',
            products: [
              {
                id: 1,
                title: 'Cà chua thượng hạng Nhật Bản, tự nhiên không chất bảo quản',
                img: p1,
                category: 'TRÁI CÂY',
                price: 30000,
                discount: 45000
              },
              {
                id: 2,
                title: 'Cà chua thượng hạng Nhật Bản, tự nhiên không chất bảo quản',
                img: p2,
                category: 'TRÁI CÂY',
                price: 30000,
                discount: 45000
              },
              {
                id: 3,
                title: 'Cà chua thượng hạng Nhật Bản, tự nhiên không chất bảo quản',
                img: p3,
                category: 'TRÁI CÂY',
                price: 30000,
                discount: 45000
              },
              {
                id: 4,
                title: 'Cà chua thượng hạng Nhật Bản, tự nhiên không chất bảo quản',
                img: p4,
                category: 'TRÁI CÂY',
                price: 30000,
                discount: 45000
              }
            ]
          },
          {
            id: 2,
            category: 'NƯỚC UỐNG',
            products: [
              {
                id: 1,
                title: '[HOT] Thuốc bổ thận tráng dương tốt nhất hiện nay được TIN dùng 2018',
                img: n1,
                category: 'NƯỚC UỐNG',
                price: 30000,
                discount: 45000
              },
              {
                id: 2,
                title: '[HOT] Thuốc bổ thận tráng dương tốt nhất hiện nay được TIN dùng 2018',
                img: n2,
                category: 'NƯỚC UỐNG',
                price: 30000,
                discount: 45000
              },
              {
                id: 3,
                title: '[HOT] Thuốc bổ thận tráng dương tốt nhất hiện nay được TIN dùng 2018',
                img: n3,
                category: 'NƯỚC UỐNG',
                price: 30000,
                discount: 45000
              },
              {
                id: 4,
                title: '[HOT] Thuốc bổ thận tráng dương tốt nhất hiện nay được TIN dùng 2018',
                img: n4,
                category: 'NƯỚC UỐNG',
                price: 30000,
                discount: 45000
              }
            ]
          },
          {
            id: 3,
            category: 'ĐỒ CHƠI TRẺ EM',
            products: [
              {
                id: 1,
                title: '[HOT] Thuốc bổ thận tráng dương tốt nhất hiện nay được TIN dùng 2018',
                img: c1,
                category: 'NĐỒ CHƠI TRẺ EM',
                price: 30000,
                discount: 45000
              },
              {
                id: 2,
                title: '[HOT] Thuốc bổ thận tráng dương tốt nhất hiện nay được TIN dùng 2018',
                img: c2,
                category: 'ĐỒ CHƠI TRẺ EM',
                price: 30000,
                discount: 45000
              },
              {
                id: 3,
                title: '[HOT] Thuốc bổ thận tráng dương tốt nhất hiện nay được TIN dùng 2018',
                img: c3,
                category: 'ĐỒ CHƠI TRẺ EM',
                price: 30000,
                discount: 45000
              },
              {
                id: 4,
                title: '[HOT] Thuốc bổ thận tráng dương tốt nhất hiện nay được TIN dùng 2018',
                img: c4,
                category: 'ĐỒ CHƠI TRẺ EM',
                price: 30000,
                discount: 45000
              }
            ]
          }
        ]
      }
    },
    components: {
      ListProduct
    }
  }
</script>