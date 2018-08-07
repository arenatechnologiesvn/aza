<template lang="pug">
  el-dialog.detail(:title="`Thông tin đơn hàng ${order.order_code}`" :visible.sync="show" style="text-align: left;")
    el-row(:gutter="20")
      el-col(:span="24")
        h4 {{order.title}}
      el-col(:span="24")
        strong MÃ ĐƠN HÀNG:
        span {{order.order_code}}
      el-col(:span="12")
        strong CHỦ CỬA HÀNG:
        span {{order.customer && order.customer.user.full_name}}
      el-col(:span="12")
        strong SĐT:
        span {{order.customer && order.customer.user.full_name}}
      el-col(:span="12")
        strong TÊN CỬA HÀNG:
        span {{order.shop && order.shop.name }}
      el-col(:span="12")
        strong SĐT CỬA HÀNG:
        span {{order.shop && order.shop.phone}}
      el-col(:span="24")
        strong ĐỊA CHỈ NHẬN HÀNG:
        span {{order.delivery_address}}
      el-col(:span="24")
        strong NGÀY ĐẶT HÀNG
        span {{formatDate(parseInt(order.apply_at))}}
      el-col(:span="12")
        strong NGÀY GIAO HÀNG:
        span {{formatDate(parseInt(order.delivery))}}
      el-col(:span="12")
        strong GIỜ GIAO HÀNG:
        span {{order.delivery_type}}
    el-row
      el-col(:span="24")
        el-table(:data="products" border="border" size="mini")
          el-table-column
            template(slot-scope="product")
              img.product-img(:src="product.row.img")
          el-table-column(prop="title" label="TÊN MẶT HÀNG" min-width="200")
          el-table-column(prop="quantity" label="SL" width="40")
          el-table-column(prop="price" label="GIÁ(VNĐ)" :formatter="(row, column, value) => formatNumber(value)")
          el-table-column(prop="total" label="TỔNG(VNĐ)" :formatter="(row, column, value) => formatNumber(value)")
          el-table-column(prop="unit" label="ĐƠN VỊ TÍNH" width="100")
</template>

<script>
  import { mapActions } from 'vuex'
  import {formatNumber} from '~/utils/util'
  export default {
    name: 'OrderDetail',
    data () {
      return {
        show: false,
        order: null
      }
    },
    computed: {
      products () {
        return (order && this.order.products.map(p => ({
          id: p.id,
          img: '/' + p.featured[0].directory + '/' + p.featured[0].filename + '.' + p.featured[0].extension,
          quantity: p.pivot.quantity,
          unit: p.unit,
          title: p.name,
          price: p.pivot.real_price,
          total: p.pivot.real_price ? p.pivot.real_price * p.pivot.quantity : 0
        }))) || []
      }
    },
    methods: {
      ...mapActions('orders', {
        fetchOrder: 'fetchSingle'
      }),
      detail (id) {
        this.fetchOrder({id}).then(res => {
          this.show = true
          this.order = res.data
        } )
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
      }
    }
  }
</script>

<style lang="scss" scoped>
  .product-img {
    height: 40px;
    width: 100%;
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
  .detail {
    .el-col {
      padding: 10px 15px;
    }
  }
</style>
