<template lang="pug">
  div.account-order
    h4.account-order__title
      svg-icon(icon-class="fa-solid cart-arrow-down")
      template LỊCH SỬ ĐƠN HÀNG
    div.h-line
    div.main-control
      div(style="margin-bottom: 10px;")
        el-input(placeholder="Tìm kiếm đơn hàng" size="small")
          i(slot="prefix" class="el-input__icon el-icon-search")
      div
        el-radio-group(size="small" v-model="delivery")
          el-radio-button(label="today") Hôm nay
          el-radio-button(label="7days") 7 Ngày qua
          el-radio-button(label="30days") 30 Ngày qua
        el-select(size="small" style="margin-left: 10px;" v-model="status" placeholder="Trạng thái đơn hàng")
          el-option(:value="1" label="Đang xử lý")
          el-option(:value="0" label="Đang hoàn thành")
        el-date-picker(type="date" v-model="delivery_date" style="margin-left: 10px;" size="small" placeholder="Ngày đặt hàng")
    div.account-order__content(style="padding: 10px;")
      el-table(:data="orders.slice((currentPage - 1)*pageSize, (currentPage - 1)*pageSize + pageSize)" style="width: 100%" border size="small" v-loading="loading")
        el-table-column(type="expand")
          template(slot-scope="props")
            el-table.product(:data="props.row.products" border="border" size="mini")
              el-table-column
                template(slot-scope="product")
                  img.product-img(:src="product.row.img")
              el-table-column(prop="title" label="TÊN MẶT HÀNG" min-width="200")
              el-table-column(prop="quantity" label="SL" width="40")
              el-table-column(prop="price" label="GIÁ (VNĐ)" :formatter="(row, column, value) => formatNumber(value)")
              el-table-column(prop="total" label="TỔNG (VNĐ)" :formatter="(row, column, value) => formatNumber(value)")
              el-table-column(prop="unit" label="Đơn vị tính" width="100")
        el-table-column(prop="code" label="MÃ ĐƠN HÀNG")
        el-table-column(label="TRẠNG THÁI")
          template(slot-scope="scope")
            el-tag(:type="scope.row.status === 0 ? 'success': scope.row.status === 0 ? 'info' : 'danger'") {{scope.row.status === 0 ? 'Đã hoàn thành': scope.row.status === 1 ? 'Đang xử lý' : 'Đã hủy'}}
        el-table-column(prop="total" label="TỔNG TIỀN (VNĐ)" :formatter="(row, column, value) => formatNumber(value)")
        el-table-column(prop="date" label="NGÀY ĐẶT HÀNG" :formatter="(row, column, value) => formatDate(value)" )
        el-table-column(prop="delivery" label="NGÀY GIAO HÀNG" :formatter="(row, column, value) => formatDate(value)" )
        el-table-column(prop="delivery_type" label="GIỜ GIAO HÀNG")
      div.pagination__wrapper(style="padding: 10px 0;")
        el-pagination(@size-change="handleSizeChange"
          @current-change="handleCurrentChange"
            :current-page.sync="currentPage"
            :page-sizes="[10, 20, 40]"
            :page-size="pageSize"
        layout="total, sizes, prev, pager, next"
          :total="orders.length")
</template>

<script>
  import avatar from '~/assets/products/p1.jpg'
  import { mapGetters, mapActions} from 'vuex'
  import {formatNumber} from '~/utils/util'
  import ElSelectDropdown from "element-ui/packages/select/src/select-dropdown";

  export default {
    components: {ElSelectDropdown},
    name: 'AccountOrder',
    computed: {
      ...mapGetters('orders', {
        order: 'list',
        loading: 'isLoading'
      }),
      orders () {
        return this.order.map(item => ({
          id: item.id,
          discount: item.discount,
          code: '#' + item.order_code,
          date: item.apply_at,
          total: item.total_money,
          status: item.status,
          title: item.title,
          delivery: item.delivery,
          delivery_type: item.delivery_type,
          products: item.products.map(p => ({
            id: p.id,
            img: avatar,
            quantity: p.pivot.quantity,
            unit: p.unit,
            title: p.name,
            price: p.pivot.real_price,
            total: p.pivot.real_price ? p.pivot.real_price * p.pivot.quantity : 0
          }))
        }))
      }
    },
    watch: {
      $route : 'fetchData'
    },
    methods: {
      ...mapActions('orders', {
        fetchOrder: 'fetchList'
      }),
      fetchData () {
        this.fetchOrder()
      },
      formatNumber(num) {
        return formatNumber(num)
      },
      formatDate(num) {
        let date = new Date(1000*num)
        const day = date.getDate() < 10 ? '0'+  date.getDate() : date.getDate()
        const month = date.getMonth() < 9 ? '0'+ (date.getMonth() + 1) : (date.getMonth() + 1)
        const year = date.getFullYear()
        return day + '-' + month + '-' +year
      },
      handleSizeChange (size) {
        this.pageSize = size
      },
      handleCurrentChange (current) {
        this.currentPage = current
      }
    },
    data () {
      return {
        currentPage: 1,
        pageSize: 10,
        delivery: 'today',
        status: null,
        delivery_date: null
      }
    },
    created () {
      this.fetchData()
    }
  }
</script>

<style lang="scss" scoped>
  .main-control {
    padding: 10px;
    text-align: left;
  }
  .account-order {
    background-color: white;
    .h-line {
      display: block;
      margin: 5px 0;
      height: 1px;
      background-color: #eee;
    }
    .product {
      text-align: left;
      word-break: keep-all;
    }
    .product-img {
      height: 70px;
      width: 100%;
      object-fit: cover;
      border-radius: unset;
    }
    .account-order__title {
      margin: 0;
      text-align: left;
      padding: 10px 15px;
      svg {
        margin-right: 10px;
      }
    }
  }
</style>