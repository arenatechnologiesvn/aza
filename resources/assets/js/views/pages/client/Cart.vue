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
                el-input(v-model="iCart.address" size="small" disabled placeholder="Địa chỉ giao hàng")
              el-col(:span="6" style="margin-top: 10px")
                span(style="font-size: 13px; cursor: pointer;") THAY ĐỔI
            div.line
            div.cart__detail
              h4 KHUNG GIỜ
              el-row(type="flex")
                el-col(:span="12")
                  el-date-picker(v-model="iCart.delivery" type="date" size="small" placeholder="Ngày đặt hàng")
                el-col(:span="12")
                  el-select(v-model="iCart.delivery_type" clearable placeholder="Chọn khung giờ" size="small")
                    el-option(label="9h - 11h" :value="1")
                    el-option(label="11h - 13h" :value="2")
                    el-option(label="13h - 15h" :value="2")
                    el-option(label="15h - 17h" :value="2")
                    el-option(label="17h - 19h" :value="2")
            div.line
            div.cart__detail
              h4 THÔNG TIN ĐẶT HÀNG
              el-row(style="margin-bottom: 20px;")
                el-col(:span="12")
                  span Tạm tính
                el-col(:span="12" style="text-align: right;")
                  span 15,000,00 VNĐ
              div(style="margin-top: 10px;")
                el-input(placeholder="Mã giảm giá" size="small" v-model="iCart.discount" class="input-with-select")
                  el-button(slot="append") ÁP DỤNG
            div.line
            div.cart__detail
              el-button(type="success" @click="checkout") ĐẶT HÀNG
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
      }),
      ...mapGetters([
        'user_info'
      ]),
      iCart () {
        const user = this.user_info
        return {
          address: user.customer ? user.customer.address : '',
          delivery: '',
          customer_id: user.customer.id,
          delivery_type: 1,
          discount: '',
          title: 'Đơn Hàng ví dụ',
          product: this.products.map(item => ({
            product_id: item.id, 
            quantity: item.quantity, 
            tmp_price: item.tmp_price,
			      real_price: item.real_price}))
        }
      }
    },
    methods: {
      checkout () {
        this.$store.dispatch('cart/checkout', this.iCart).then(res => {
          console.log(res)
        }).catch(err => console.log(err))
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