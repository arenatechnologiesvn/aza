<template lang="pug">
  div.product__wrapper
    div.container
      bread-crumb
      div.product__container
        div.product__control
          el-row(type="flex")
            el-col(:span="12")
              h4 20 sản phẩm được tìm trong "ÁO SƠ MI"
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
  import ElRow from "element-ui/packages/row/src/row";
  export default {
    name: 'HomeProduct',
    components: {
      ElRow,
      BreadCrumb,
      Products
    },
    data() {
      return {
        options: [{
          value: 'Option1',
          label: 'Option1'
        }, {
          value: 'Option2',
          label: 'Option2'
        }, {
          value: 'Option3',
          label: 'Option3'
        }, {
          value: 'Option4',
          label: 'Option4'
        }, {
          value: 'Option5',
          label: 'Option5'
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