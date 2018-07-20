<template lang="pug">
  div.container
    bread-crumb
    div.cart__contain(style="margin-top: 10px")
      el-row(:gutter="10")
        el-col(:xs="24" :sm="16" :md="16" :lg="16")
          div.grid-content.bg-puple
            el-table(border style="width: 100%" :data="products" size="mini")
              el-table-column(prop="name" label="Sản phẩm" min-width="200")
                template(slot-scope="scope")
                  div.detail
                    div.img
                      img(:src="scope.row.img")
                    h4 {{scope.row.title}}
                    el-button.button(type="danger" size="mini")
                      svg-icon(icon-class="fa-solid trash")
              el-table-column(prop="price" label="GIÁ" :formatter="row => `${row.price} (VNĐ)`")
              el-table-column(prop="quantity" label="SỐ LƯỢNG" width="150")
                template(slot-scope="scope")
                  el-input(placeholder="1" style="width: 130px;" size="mini" v-model="scope.row.quantity")
                    template(slot="prepend")
                      el-button(size="mini" type="danger") -
                    template(slot="append")
                      el-button(size="mini" type="success") +
              el-table-column(prop="total" label="Tổng cộng" :formatter="row =>`${row.price * row.quantity} (VNĐ)`")
        el-col(:xs="24" :sm="8" :md="8" :lg="8")
          div.cart(style="background-color: #ffffff")
            div.cart__detail
              h4 ĐỊA ĐIỂM
              el-col(:span="18")
                el-input(v-model="cart.address" disabled placeholder="Địa chỉ giao hàng")
              el-col(:span="6" style="margin-top: 10px")
                span THAY ĐỔI
            div.line
            div.cart__detail
              h4 KHUNG GIỜ
              el-col(:span="10" style="margin-top: 10px")
                span 30/10/18
              el-col(:span="14")
                el-select(v-model="cart.hour" clearable placeholder="Chọn khung giờ" size="small" style="width: 100%")
                  el-option(label="Vip" :value="1")
                  el-option(label="Thường" :value="0")
            div.line
            div.cart__detail
              h4 THÔNG TIN ĐẶT HÀNG
              el-row(style="margin-bottom: 20px;")
                el-col(:span="12")
                  span Tạm tính
                el-col(:span="12" style="text-align: right;")
                  span 15,000,00 VNĐ
              div(style="margin-top: 10px;")
                el-input(placeholder="Please input" v-model="cart.discount" class="input-with-select")
                  el-button(slot="append") ÁP DỤNG
            div.line
            div.cart__detail
              el-button(type="success") CẬP NHẬT
              el-button(type="danger") HỦY BỎ
</template>

<script>
  import BreadCrumb from './components/BreadCrumb'
  import product from '~/assets/products/p1.jpg'
  import { mapGetters } from 'vuex'
  export default {
    name: 'CustomerCart',
    components: {
      BreadCrumb
    },
    computed: {
      ...mapGetters('cart', {
        products: 'cartProducts'
      })
    },
    props: {
      cart: {
        type: Object,
        default: () => ({
          hour: null,
          discount: 0,
          address: '3 CHU VAN AN - HCM',
          products: [
            {
              img: product,
              title: '[HOT] Thuốc bổ thận tráng dương tốt nhất hiện nay được TIN dùng 2018',
              price: 30000,
              quantity: 10,
              total: 300000
            },
            {
              img: product,
              title: '[HOT] Thuốc bổ thận tráng dương tốt nhất hiện nay được TIN dùng 2018',
              price: 30000,
              quantity: 10,
              total: 300000
            },
            {
              img: product,
              title: '[HOT] Thuốc bổ thận tráng dương tốt nhất hiện nay được TIN dùng 2018',
              price: 30000,
              quantity: 10,
              total: 300000
            },
            {
              img: product,
              title: '[HOT] Thuốc bổ thận tráng dương tốt nhất hiện nay được TIN dùng 2018',
              price: 30000,
              quantity: 10,
              total: 300000
            },
            {
              img: product,
              title: '[HOT] Thuốc bổ thận tráng dương tốt nhất hiện nay được TIN dùng 2018',
              price: 30000,
              quantity: 10,
              total: 300000
            },
            {
              img: product,
              title: '[HOT] Thuốc bổ thận tráng dương tốt nhất hiện nay được TIN dùng 2018',
              price: 30000,
              quantity: 10,
              total: 300000
            }
          ]
        })
      }
    }
  }
</script>

<style lang="scss" scoped>
  .detail {
    .img {
      float: left;
      width: 30%;
    }
    img {
      width: 100%;
      height: 100px;
      object-fit: cover;
    }
    .button {
      margin-left: 10px;
    }
    h4 {
      float: left;
      width: calc(70% - 10px);
      margin: 5px 0 5px 10px;
      word-break: keep-all;
      font-size: 13px;
      display: inline-block;
      line-height: 20px;
      &:after {
        clear: left;
      }
    }
  }
  .cart {
    padding: 10px 5px;
    margin-top: 2px;
  }
  .cart__detail {
    h4 {
      margin: 5px 3px 20px 3px;
    }
    padding-bottom: 20px;
  }
  .line {
    border: .5px solid #efefef;
  }
  .cart__contain {
    margin-bottom: 20px;
  }
</style>