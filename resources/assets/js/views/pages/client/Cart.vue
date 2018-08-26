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
                    el-button.button(type="danger" size="mini" @click="remove(scope.row.id)" :disabled="!enableCart()")
                      svg-icon(icon-class="fa-solid trash")
              el-table-column(prop="price" label="GIÁ (VNĐ)")
                template(slot-scope="scope")
                  div {{formatNumber(scope.row.price)}}
                  div / {{`${scope.row.quantitative} ${scope.row.unit}`}}
              el-table-column(prop="quantity" label="SỐ LƯỢNG" width="130")
                template(slot-scope="scope")
                  el-input-number(v-model="scope.row.quantity" :min="0" size="mini" style="width: 110px;" :disabled="!enableCart()" @change="changeQuantity(scope.row)")
              el-table-column(prop="total" label="TỔNG CỘNG (VNĐ)" :formatter="row =>formatNumber(row.price * row.quantity)")
          div.total
            p
              strong Tạm tính:
              template {{formatNumber(total)}} (VNĐ)
        el-col(:xs="24" :sm="8" :md="8" :lg="8")
          div.cart(style="background-color: #ffffff")
            h4.title__info
              span
                svg-icon(icon-class="fa-solid info-circle")
              template Thông tin đặt hàng
            el-form(ref="form" :model="form" status-icon :rules="rules")
              el-form-item(label="Ghi chú và nhận xét" prop="title")
                el-input(v-model="form.title" size="small" placeholder="Ghi chú và nhận xét"  auto-complete="off")
              el-form-item(label="Sản phẩm ngoài danh mục" prop="description")
                el-input(v-model="form.description" type="textarea" rows="5" size="small" placeholder="Nhập mô tả chi tiết đơn hàng")
              el-form-item(label="Cửa hàng" prop="shop_id")
                el-select(v-model="form.shop_id" clearable filterable placeholder="Chọn cửa hàng" size="small" style="width: 100%;" @change="onShopChange")
                  el-option(:label="shop.name" :value="shop.id" v-for="shop in shops" :key="shop.id")
              el-form-item(label="Địa chỉ nhận hàng" prop="delivery_address")
                el-input(v-model="form.delivery_address" type="textarea" rows="3" size="small" placeholder="Địa chỉ giao hàng")
              el-row(:gutter="5" type="flex")
                el-col(:span="14")
                  el-form-item(label="Ngày giao hàng" prop="delivery")
                    el-date-picker(v-model="form.delivery" type="date" size="small" placeholder="Ngày đặt hàng")
                el-col(:span="10")
                  el-form-item(label="Giờ giao hàng" prop="delivery_type")
                    el-select(v-model="form.delivery_type" clearable placeholder="Chọn khung giờ" size="small")
                      el-option(:label="item" :value="item" v-for="item in times" :key="item")
            div.cart__detail
              el-button(type="success" @click="checkout" :disabled="!enableCart()") ĐẶT HÀNG
              el-button(type="danger" @click="resetForm('form')") HỦY BỎ
</template>

<script>
  import BreadCrumb from './components/BreadCrumb'
  import product from '~/assets/products/p1.jpg'
  import {mapGetters, mapActions} from 'vuex'
  import _ from 'lodash'
  import {formatNumber} from '~/utils/util'
  import ElRow from "element-ui/packages/row/src/row";

  export default {
    name: 'CustomerCart',
    components: {
      ElRow,
      BreadCrumb
    },
    data() {
      const validateDelivery = (rule, value, callback) => {
        const now = +(new Date())
        value = +value + 86400000
        if(value <= now) {
          callback(new Error('Ngày giao hàng không hợp lệ'))
        } else {
          callback()
        }
      }

      return {
        form: {
          delivery_type: '',
          delivery: '',
          title: '',
          delivery_address: '',
          shop_id: null,
          description: null
        },
        rules: {
          // title: [{ required: true, message: 'Nội dung đơn hàng là bắt buộc', trigger: 'blur' }],
          // description: [{required: true, message: 'Mô tả chi tiết là bắt buộc'}],
          shop_id: [{required: true, message: 'Cửa hàng là bắt buộc'}],
          delivery_address: [{required: true, message: 'Địa chỉ nhận hàng là bắt buộc'}],
          delivery: [
            {required: true, message: 'Ngày giao hàng là bắt buộc'},
            {validator: validateDelivery, trigger: 'blur' }
          ],
          delivery_type: [{required: true, message: 'Giờ giao hàng là bắt buộc'}]
        }
      }
    },
    watch: {
      user_info: (value) => {
        console.log(value)
        this.form.delivery_address = value
      }
    },
    computed: {
      ...mapGetters('cart', {
        data: 'cartProducts'
      }),
      ...mapGetters([
        'user_info'
      ]),
      ...mapGetters('shops', {
        listShop: 'list'
      }),
      times () {
        return this.$store.getters.settings && this.$store.getters.settings.timeFrame.map(item => item.start + ' - ' + item.end)
      },
      products() {
        return this.data()
      },
      shops () {
        return this.listShop.filter(item=> item.customer_id.toString().trim() === this.user_info.customer.id.toString().trim())
          .map(item => {
            if(!this.form.shop_id) {
              this.form.shop_id = item.id
              this.form.delivery_address = item.zone
            }
            return {id: item.id, name: item.name}
          })
      },
      total() {
        return (this.products && this.products.length > 1) ?
          this.products.reduce((a, b) => (parseFloat(a)  + parseFloat((parseFloat(b.price) * parseInt(b.quantity)))), 0) :
          this.products.length === 1 ? parseInt(this.products[0].quantity) * parseFloat(this.products[0].price) :
            0
      },
      formCart() {
        const user = this.user_info
        return {
          delivery_address: this.form.delivery_address,
          delivery: this.form.delivery,
          customer_id: user.customer.id,
          delivery_type: this.form.delivery_type,
          discount: '',
          description: this.form.description,
          shop_id: this.form.shop_id,
          title: this.form.title,
          total_money: this.total,
          product: this.products.map(item => ({
            product_id: item.id,
            quantity: item.quantity,
            tmp_price: item.tmp_price,
            real_price: item.real_price
          }))
        }
      }
    },
    methods: {
      ...mapActions('cart', {
        'removeItem': 'destroy',
        'updateItem': 'update',
        fetchCart: 'fetchList'
      }),
      ...mapActions('orders', {
        createOrder: 'create'
      }),
      ...mapActions('products', {
        fetchProduct: 'fetchList'
      }),
      ...mapActions('shops', {
        fetchShops: 'fetchList'
      }),
      canExecute(message) {
        return new Promise(resolve => this.$confirm(message, 'Xác nhận', {
          confirmButtonText: 'Đồng ý',
          cancelButtonText: 'Hủy',
          type: 'success'
        }).then(() => {
          resolve(true);
        }));
      },
      checkout() {
        this.$refs['form'].validate(valid => {
          if (valid) {
            this.canExecute('Bạn muốn gửi đơn hàng nay?')
              .then(() => this.createOrder({
                data: this.formCart
              }).then(() => {
                this.fetchCart()
              })).then(() => this.$notify(
              {
                title: 'Thông báo',
                message: 'Đã đặt hàng thành công',
                type: 'success'
              })).then(() => this.$router.push({'name': 'home_account_order'}))
              .catch(err => {
                console.log(err)
                this.$notify(
                  {
                    title: 'Cảnh báo báo',
                    message: 'Đơn hàng đã không được lưu thành công',
                    type: 'danger'
                  })
              })
          } else {
            return false
          }
        })
      },
      resetForm (name) {
        this.$refs[name].resetFields();
      },
      remove(id) {
        this.removeItem({id})
          .then(res => console.log(res))
          .catch(err => console.log(err))
      },
      formatNumber(num) {
        return formatNumber(num)
      },
      changeQuantity(value) {
        this.updateItem({
          id: value.id,
          data: {
            product_id: value.id,
            quantity: value.quantity,
            customer_id: this.$store.getters.user_info.customer ? this.$store.getters.user_info.customer.id : 0
          }
        })
      },
      onShopChange (value) {
        this.listShop.map(item => {
         if(item.customer_id == value) {
           this.form.delivery_address = item.zone
         }
        } )
      },
      enableCart () {
        const apply = this.$store.getters.settings && this.$store.getters.settings.apply
        if(apply) {
          const start = apply.start
          const end = apply.end

          let now = new Date
          let hour = now.getHours() < 10 ? '0' + now.getHours().toString() : now.getHours().toString()
          let minute = now.getMinutes() < 10 ? '0' + now.getMinutes().toString() : now.getMinutes().toString()
          const time = hour+ ':'+ minute
          if (time > start && time < end) return true;
        }
        return false;
      }
    },
    mounted () {
      if (!this.enableCart()) {
        const apply = this.$store.getters.settings && this.$store.getters.settings.apply
        this.$message({
          type: 'warning',
          title: 'Thông báo',
          message: `Chỉ được đặt hàng từ ${apply.start} - ${apply.end}`
        })
      };
      this.fetchShops()
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

  .title__info {
    margin: 5px 0 10px;
    position: relative;
    padding-bottom: 10px;
    border-bottom: 1px solid gray;
    svg {
      margin-right: 10px;
    }
  }

  .total {
    margin: 10px 0;
    text-align: right;
    p {
      font-size: 1.2em;
      font-weight: bolder;
      color: firebrick;
      strong {
        margin-right: 10px;
      }
    }
  }
</style>