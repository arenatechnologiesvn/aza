<template lang="pug">
  div.product__wrapper
    div.container
      bread-crumb
      div.product__container
        div.product__control
          el-row(type="flex")
            el-col(:span="12")
              h4 {{products.length}} sản phẩm được tìm trong {{$route.query.category}}
            el-col(:span="12" style="text-align: right")
              span.product--order
                span.order__title Sắp xếp theo
                el-select(v-model="value" placeholder="Sắp xếp theo" size="mini")
                  el-option(v-for="item in options" :key="item.value" :label="item.label" :value="item.value")
              span.product--type-sort
                el-button(size="mini")
                  svg-icon(icon-class="fa-solid th-large")
                el-button(size="mini")
                  svg-icon(icon-class="fa-solid th-list")
        div.list
          product-category(:products="products")
</template>

<script>
  import BreadCrumb from './components/BreadCrumb'
  import ProductCategory from './components/products/Category'
  import { mapGetters } from 'vuex'
  export default {
    name: 'HomeProduct',
    components: {
      BreadCrumb,
      ProductCategory
    },
    computed: {
      ...mapGetters('products', {
        'listProducts': 'list'
      }),
      products () {
        return this.listProducts
          .filter(item => item.category.name === this.$route.query.category)
          .map(item => ({
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
          }))
      }
    },
    data() {
      return {
        options: [{
          value: '1',
          label: 'Giá giảm dần'
        }, {
          value: '2',
          label: 'Giá tăng dần'
        }, {
          value: '4',
          label: 'Tên sản phẩm'
        }],
        value: ''
      }
    }
  }
</script>
<style lang="scss" scoped>
  .product__control {
    padding: 15px 0;
    h4 {
      margin: 0;
    }
    .product--order {
      margin-right: 10px;
    }
    .order__title {
      margin-right: 10px;
    }
  }
</style>