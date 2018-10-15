<template lang="pug">
  el-dialog.detail(:title="`DANH SÁCH SẢN PHẨM`" width="60%" :visible.sync="show" style="text-align: left;")
    div.content
      div.form-search
        el-input(v-model="search" placeholder="Tìm kiếm sản phẩm..." prefix-icon="el-icon-search" clearable)
      el-table(:data="products.slice((currentPage - 1)*pageSize, (currentPage - 1)*pageSize + pageSize)" border="border" size="mini")
        el-table-column(width="70")
          template(slot-scope="product")
            img.product-img(:src="imageUrl(product.row)")
        el-table-column(prop="product_code" label="MÃ SẢN PHẨM" min-width="70")
        el-table-column(prop="name" label="TÊN SẢN PHẨM" min-width="130")
        el-table-column(prop="price" label="GIÁ (VNĐ)" :formatter="(row, column, value) => formatNumber(value)")
        el-table-column(prop="unit" label="ĐƠN VỊ" width="70")
        el-table-column(width="70")
          template(slot-scope="scope")
            el-tooltip(class="item" effect="dark" content="Thêm vào đơn hàng" placement="top")
              el-button(size="mini" type="success" @click="addToOrder(scope.row)")
                svg-icon(icon-class="fa-solid plus")
      div.pagination__wrapper(style="padding: 10px 0;")
        el-pagination(@size-change="handleSizeChange"
          @current-change="handleCurrentChange"
            :current-page.sync="currentPage"
            :page-sizes="[5, 10, 20, 40]"
            :page-size="pageSize"
        layout="total, sizes, prev, pager, next"
          :total="products.length")
</template>

<script>
  import { mapGetters } from 'vuex'
  import {formatNumber} from '~/utils/util'
  import dummyImage from '~/assets/login_images/dummy-image.jpg'

  export default {
    name: 'DialogList',
    data () {
      return {
        search: '',
        show: false,
        currentPage: 1,
        pageSize: 10,
      }
    },
    props: {
      addableProducts: {
        type: Array,
        default: () => []
      }
    },
    computed: {
      products () {
        return this.addableProducts.filter(item => {
          return item.name.toLowerCase().indexOf(this.search.toLowerCase()) > -1
        })
      }
    },
    methods: {
      detail () {
        this.show = true
      },
      formatNumber(num) {
        return formatNumber(num)
      },
      addToOrder (product) {
        this.$emit('addOrder', product)
      },
      handleSizeChange (size) {
        this.pageSize = size
      },
      handleCurrentChange (current) {
        this.currentPage = current
      },
      imageUrl(product) {
        return product.featured && product.featured[0] && product.featured[0].url ? product.featured[0].url : dummyImage;
      }
    }
  }
</script>

<style lang="scss" scoped>
  .product-img {
    height: 50px;
    width: 50px;
    object-fit: cover;
  }
  h4 {
    text-transform: uppercase;
    text-align: center;
    font-weight: bolder;
  }
  strong {
    margin-right: 10px;
  }
  .table-title {
    border-top: 1px solid #eeeeee;
    padding-top: 10px;
  }
  .detail {
    .el-col {
      padding: 5px 10px;
    }
  }
  .body-title {
    margin-top: 0;
    margin-bottom: 10px;
  }
  .body-item {
    font-size: .8em;
  }
  .footer {
    margin-top: 20px;
    padding-top: 10px;
    text-align: right;
    border-top: 1px solid #eeeeee;
    svg {
      margin-right: 10px;
    }
  }
  .content-order {
    position: relative;
    .status {
      position: absolute;
      top: 20px;
      right: 5px;
      transform: rotate(45deg);
      padding: 5px 15px;
      border-radius: 5px;
      font-size: 1em;
      font-weight: bolder;
      opacity: .6;
    }
  }
  .total {
    text-align: right;
    .item {
      padding: 10px 0;
    }
  }
</style>
<style lang="scss">
  .el-dialog__header {
    background-color: #2d3a4b;
    color: white;
    font-weight: bolder;
    span {
      color: white;
      font-weight: bolder;
      text-transform: uppercase;
    }
  }
  .el-dialog__body {
    padding: 15px;
  }
</style>
