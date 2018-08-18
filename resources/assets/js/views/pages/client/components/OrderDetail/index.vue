<template lang="pug">
  el-dialog.detail(:title="`Thông tin đơn hàng ${order && order.order_code}`"
    width="60%"
    :visible.sync="show" style="text-align: left;")
    el-row.content-order(:gutter="20" v-if="order")
      el-col(:span="24")
        h4.body-title ĐƠN HÀNG {{order.order_code}}
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
      el-col.body-item(:span="24" v-show="order.description && order.description.length > 0")
        strong SẢN PHẨM NGOÀI DANH MỤC:
        span {{order.description}}
      el-col.body-item(:span="24" v-show="order.status.toString() === '2'")
        strong LÝ DO HỦY ĐƠN HÀNG:
        span {{order.approve_note}}
      div.status(:style="{ color: 'white', backgroundColor: orderStatusConst[parseInt(order.status)].color }") {{ orderStatusConst[parseInt(order.status)].status }}
    div.content
      h5.table-title(style="text-align: left;")
        svg-icon(icon-class="fa-solid list")
        span(style="margin-left: 10px;") DANH SÁCH SẢN PHẨM
      el-table(:data="products" border="border" size="mini")
        el-table-column(width="70")
          template(slot-scope="product")
            img.product-img(:src="product.row.img")
        el-table-column(prop="title" label="TÊN MẶT HÀNG" min-width="200")
        el-table-column(prop="quantity" label="SL" width="40")
        el-table-column(prop="price" label="GIÁ (VNĐ)" :formatter="(row, column, value) => currencyFormat(value)")
        el-table-column(prop="total" label="TỔNG (VNĐ)" :formatter="(row, column, value) => currencyFormat(value)")
        el-table-column(prop="unit" label="ĐƠN VỊ TÍNH" width="100")
    div.total(v-if="order" v-show="order && order.status.toString() !== '2' ")
      div.item
        strong TỔNG ĐƠN HÀNG:
        span {{ currencyFormat(order.total_money) }} VNĐ
      div.item
        strong VAT:
        span {{ currencyFormat(order.total_money * 0.1) }} VNĐ
      div.item
        strong TỔNG TIỀN:
        span {{ currencyFormat(+order.total_money + Number(+order.total_money * 0.1)) }} VNĐ

    div.footer
      el-button-group(v-show="(order && order.status.toString() === '0') || (order && order.status.toString() === '3')")
        el-button(type="primary" @click="print")
          svg-icon(icon-class="fa-solid print")
          span Xuất hóa đơn
</template>

<script>
  import { mapActions } from 'vuex'
  import { currencyFormat } from '~/utils/util'
  import { Printd } from 'printd'
  import dummyImage from '~/assets/login_images/dummy-image.jpg'

  const d = new Printd();
  const ORDER_STATUS = [
    { status: 'ĐÃ HOÀN THÀNH', color: 'green' },
    { status: 'CHỜ XÁC NHẬN', color: '#E6A23C' },
    { status: 'ĐÃ HỦY', color: 'red' },
    { status: 'ĐANG XỬ LÝ', color: '#303133' }
  ]

  export default {
    name: 'OrderDetail',
    data () {
      return {
        show: false,
        order: null,
        cssText: `
          button: {
            display: none;
          }
          .item {
            padding: 10px;
          }
        `,
        orderStatusConst: ORDER_STATUS
      }
    },
    computed: {
      products () {
        return (this.order && this.order.products.map(p => ({
          id: p.id,
          img: p.featured && p.featured.length ? p.featured[0].url : dummyImage,
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
      currencyFormat(value) {
        return currencyFormat(value)
      },
      formatDate(num) {
        let date = new Date(1000 * num)
        const day = date.getDate() < 10 ? '0' + date.getDate() : date.getDate()
        const month = date.getMonth() < 9 ? '0' + (date.getMonth() + 1) : (date.getMonth() + 1)
        const year = date.getFullYear()
        return day + '-' + month + '-' + year
      },
      print () {
        console.log(this.$el)
        d.print( this.$el , `
          body, .el-dialog {
            width: 100% !important;
            font-size: 13px;
          }
           .el-dialog {
             margin-top: 0 !important;
           }
          .el-dialog__header {
            display: none;
          }
          .el-dialog__body {
            margin: 0;
            padding: 5px;
            width: 100%;
          }
          .el-dialog__body h4 {
            margin: 0;
          }
          .body-item {
            padding: 10px;
          }
          .body-title {
           text-align: center;
          }
          button, svg {
            display: none;
          }
          table, td, th {
            border: 1px solid #eee;
            padding: 5px;
          }
          .status, .el-dialog__header {
            display: none;
          }
          .table-title, h5 {
            font-size: 1.1em;
            text-align: left !important;
            display: block;
            width: 100%;
            float: left;
            margin-left: 0 !important;
            font-weight: bolder;
          }
          .content {
            text-align: left;
            margin-top: 10px;
            margin-bottom: 0;
          }
          .total {
            float: right;
            margin-top: 10px;
          }
        `)
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

  @media print {
    button {
      display: none;
    }
    table, tr, th, td {
      border: 1px solid #dddddd;

    }
    td {
      padding: 5px;
    }
  }
</style>
