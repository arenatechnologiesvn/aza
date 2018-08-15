<template lang="pug">
  el-dialog.detail(:title="`DANH SÁCH SẢN PHẨM`"
  width="60%"
    :visible.sync="show" style="text-align: left;")
    div.content
      h5.table-title(style="text-align: left;")
        svg-icon(icon-class="fa-solid list")
        span(style="margin-left: 10px;") DANH SÁCH SẢN PHẨM
      div.form-search
        el-input(v-model="search" placeholder="Tìm kiếm sản phẩm..." prefix-icon="el-icon-search" clearable)
      el-table(:data="products.slice((currentPage - 1)*pageSize, (currentPage - 1)*pageSize + pageSize)" border="border" size="mini")
        el-table-column(width="70")
          template(slot-scope="product")
            img.product-img(:src="product.row.img")
        el-table-column(prop="title" label="TÊN MẶT HÀNG" min-width="100")
        el-table-column(prop="price" label="GIÁ(VNĐ)" :formatter="(row, column, value) => formatNumber(value)")
        el-table-column(prop="unit" label="ĐƠN VỊ" width="70")
        el-table-column(width="70")
          template(slot-scope="scope")
            el-tooltip(class="item" effect="dark" content="Thêm vào đơn hàng" placement="top")
              el-button(size="mini" type="default" @click="addToOrder(scope.row)")
                svg-icon(icon-class="fa-solid calendar-plus")
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

  export default {
    name: 'DilaogList',
    data () {
      return {
        search: '',
        show: false,
        currentPage: 1,
        pageSize: 10,
      }
    },
    props: {
      black: {
        type: Array,
        default: () => []
      }
    },
    computed: {
      ...mapGetters('products', {
        listProducts: 'list'
      }),
      products () {
        return this.listProducts
          .filter(item => this.black.indexOf(item.id.toString()) < 0)
          .map(p => ({
            id: p.id,
            img: '/' + p.featured[0].directory + '/' + p.featured[0].filename + '.' + p.featured[0].extension,
            unit: p.unit,
            title: p.name,
            price: p.price
        }))
          .filter(item => item.title.toLowerCase().indexOf(this.search.toLowerCase()) > -1)
      }
    },
    methods: {
      detail () {
        this.show = true
      },
      formatNumber(num) {
        return formatNumber(num)
      },
      formatDate(num) {
        let date = new Date(1000 * num)
        const day = date.getDate() < 10 ? '0' + date.getDate() : date.getDate()
        const month = date.getMonth() < 9 ? '0' + (date.getMonth() + 1) : (date.getMonth() + 1)
        const year = date.getFullYear()
        return day + '-' + month + '-' + year
      },
      addToOrder (product) {
        this.$emit('addOrder', product)
      },
      handleSizeChange (size) {
        this.pageSize = size
      },
      handleCurrentChange (current) {
        this.currentPage = current
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
