<template lang="pug">
  div.product__wrapper
    div.container
      bread-crumb
      div.product__container
        div.product__control
          el-row(type="flex")
            el-col(:span="12")
              h4 20 sản phẩm được tìm trong "SẢN PHẨM MỚI"
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
          products(:control="false")
</template>

<script>
  import BreadCrumb from './components/BreadCrumb'
  import Products from './components/products'
  export default {
    name: 'HomeProduct',
    components: {
      BreadCrumb,
      Products
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