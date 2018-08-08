<template lang="pug">
  el-dialog.detail(:title="`Thông tin đơn hàng ${order && order.order_code}`"
    width="60%"
    :visible.sync="show" style="text-align: left;")
    el-row.content-order(:gutter="20" v-if="order")
      el-col(:span="24")
        h4.body-title {{order && order.title}}
      el-col.body-item(:span="24")
        strong MÃ ĐƠN HÀNG:
        span {{order.order_code}}
      el-col.body-item(:span="12")
        strong CHỦ CỬA HÀNG:
        span {{order.customer && order.customer.user.full_name}}
      el-col.body-item(:span="12")
        strong SĐT:
        span {{order.customer && order.customer.user.phone}}
      el-col.body-item(:span="12")
        strong TÊN CỬA HÀNG:
        span {{order.shop && order.shop.name }}
      el-col.body-item(:span="12")
        strong SĐT CỬA HÀNG:
        span {{order.shop && order.shop.phone}}
      el-col.body-item(:span="24")
        strong ĐỊA CHỈ NHẬN HÀNG:
        span {{order.delivery_address}}
      el-col.body-item(:span="24")
        strong NGÀY ĐẶT HÀNG
        span {{formatDate(parseInt(order.apply_at))}}
      el-col.body-item(:span="12")
        strong NGÀY GIAO HÀNG:
        span {{formatDate(parseInt(order.delivery))}}
      el-col.body-item(:span="12")
        strong GIỜ GIAO HÀNG:
        span {{order.delivery_type}}
      div.status(:style="{color: 'white', backgroundColor: parseInt(order.status) === 0 ? 'green': parseInt(order.status) === 1 ? 'blue': 'red'}") {{parseInt(order.status) === 0 ? 'ĐÃ XỬ LÝ' : parseInt(order.status) === 1 ? 'ĐANG XƯ LÝ' : 'ĐÃ HỦY' }}
    div.content
      h5.table-title
        svg-icon(icon-class="fa-solid list")
        span(style="margin-left: 10px;") DANH SÁCH SẢN PHẨM
      el-table(:data="products" border="border" size="mini")
        el-table-column(width="70")
          template(slot-scope="product")
            img.product-img(:src="product.row.img")
        el-table-column(prop="title" label="TÊN MẶT HÀNG" min-width="200")
        el-table-column(prop="quantity" label="SL" width="40")
        el-table-column(prop="price" label="GIÁ(VNĐ)" :formatter="(row, column, value) => formatNumber(value)")
        el-table-column(prop="total" label="TỔNG(VNĐ)" :formatter="(row, column, value) => formatNumber(value)")
        el-table-column(prop="unit" label="ĐƠN VỊ TÍNH" width="100")
    div.footer
      el-button-group
        el-button(type="primary")
          svg-icon(icon-class="fa-solid print")
          span Xuất hóa đơn
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
        return (this.order && this.order.products.map(p => ({
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
          console.log(res.data)
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
