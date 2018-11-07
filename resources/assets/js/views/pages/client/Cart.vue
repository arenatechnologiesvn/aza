<template lang="pug">
  div.container
    bread-crumb
    div.cart__contain(style="margin-top: 10px")
      el-row(:gutter="10")
        el-col(:xs="24" :sm="16" :md="16" :lg="16")
          div.grid-content.bg-puple
            el-table(border style="width: 100%" :data="products" size="mini" v-loading="isLoading")
              el-table-column(prop="name" label="SẢN PHẨM" min-width="200")
                template(slot-scope="scope")
                  div.detail
                    div.img
                      img(:src="scope.row.img")
                    h4 {{ scope.row.code }}
                    h4 {{ scope.row.title }}
                    el-button.button(type="danger" size="mini" @click="remove(scope.row.id)" :disabled="!enableCart()")
                      svg-icon(icon-class="fa-solid trash")
              el-table-column(prop="price" label="GIÁ (₫)")
                template(slot-scope="scope")
                  div {{formatNumber(scope.row.price)}}
                  div / {{`${scope.row.quantitative} ${scope.row.unit}`}}
              el-table-column(prop="quantity" label="SỐ LƯỢNG" width="130")
                template(slot-scope="scope")
                  el-input-number(v-model="scope.row.quantity" :min="0" size="mini" style="width: 110px;" :disabled="isChangingQuantity" @change="changeQuantity(scope.row)")
              el-table-column(prop="total" label="TỔNG (₫)" :formatter="row =>formatNumber(row.price * row.quantity)")
          el-row(:gutter="5")
            el-col(:xs="24" :sm="4" :md="4" :lg="4" style="margin-top: 10px")
              el-button(type="danger" size="small" @click="removeAll" :disabled="products.length === 0" style="width: 100%")
                svg-icon(icon-class="fa-solid trash")
                span  Xóa tất cả
            el-col.total(:xs="24" :sm="20" :md="20" :lg="20")
              p
                strong Tạm tính ({{ products ? products.length : 0 }} sản phẩm):
                template {{formatNumber(total)}} ₫
        el-col(:xs="24" :sm="8" :md="8" :lg="8")
          div.cart(style="background-color: #ffffff")
            h4.title__info
              span
                svg-icon(icon-class="fa-solid info-circle")
              template Thông tin đặt hàng
            el-form(ref="form" :model="form" status-icon :rules="rules" size="small")
              el-form-item(label="Cửa hàng" prop="shop_id")
                el-select(v-model="form.shop_id" clearable filterable placeholder="Chọn cửa hàng" style="width: 100%;" @change="onShopChange")
                  el-option(:label="shop.name" :value="shop.id" v-for="shop in shops" :key="shop.id")
              el-form-item(label="Địa chỉ nhận hàng" prop="delivery_address")
                el-input(v-model="form.delivery_address" type="textarea" rows="3" placeholder="Địa chỉ giao hàng")
              el-form-item(label="Ngày giao hàng" prop="delivery")
                el-date-picker(v-model="form.delivery" type="date" format="dd-MM-yyyy" placeholder="Ngày giao hàng" style="width: 100%;")
              el-form-item(label="Giờ giao hàng" prop="delivery_type")
                el-select(v-model="form.delivery_type" clearable placeholder="Chọn khung giờ" style="width: 100%;")
                  el-option(:label="item" :value="item" v-for="item in times" :key="item")
              el-form-item(label="Ghi chú và nhận xét" prop="title")
                el-input(v-model="form.title" placeholder="Ghi chú và nhận xét"  auto-complete="off")
              el-form-item(label="Sản phẩm ngoài danh mục" prop="description")
                el-input(v-model="form.description" type="textarea" rows="5" placeholder="Nhập mô tả chi tiết đơn hàng")
              el-form-item
                el-row(:gutter="5")
                  el-col(:xs="24" :sm="12" :md="12" :lg="12")
                    el-button(type="info" @click="resetForm('form')" style="width: 100%") Hủy bỏ
                  el-col(:xs="24" :sm="12" :md="12" :lg="12")
                    el-button(type="success" @click="openConfirmDialog" :disabled="!enableCart()" style="width: 100%") Đặt hàng
    order-confirm-dialog(ref="orderConfirmDialog" @on-order-cart="onOrderCart" :order="formCart" :user="user_info" :shops="shops" :products="products")
</template>

<script>
  import {mapGetters, mapActions} from 'vuex'
  import BreadCrumb from './components/BreadCrumb'
  import OrderConfirmDialog from './components/OrderConfirmDialog'
  import BaseMixin from '../mixin'
  import {formatNumber} from '~/utils/util'
  import moment from 'moment'

  export default {
    name: 'CustomerCart',
    mixins: [ BaseMixin ],
    components: {
      BreadCrumb,
      OrderConfirmDialog
    },
    data() {
      const validateDelivery = (rule, value, callback) => {
        const now = +(new Date())
        value = +value + 86400000
        if(value <= now) {
          callback(new Error('Ngày giao hàng không được trước hôm nay'))
        } else {
          callback()
        }
      }

      return {
        isChangingQuantity: false,
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
        this.form.delivery_address = value
      }
    },
    computed: {
      ...mapGetters('cart', {
        cartProducts: 'cartProducts',
        isLoading: 'isLoading'
      }),
      ...mapGetters([
        'user_info'
      ]),
      ...mapGetters('shops', {
        listShop: 'list'
      }),
      times () {
        return this.$store.getters.settings && this.$store.getters.settings.timeFrame && this.$store.getters.settings.timeFrame.map(item => item.start + ' - ' + item.end)
      },
      products() {
        return this.cartProducts()
      },
      shops () {
        return this.listShop.filter(item=> item.customer_id.toString().trim() === this.user_info.customer.id.toString().trim())
          .map(item => {
            if(!this.form.shop_id) {
              this.form.shop_id = item.id
              this.form.delivery_address = item.zone
            }
            return { id: item.id, name: item.name, phone: item.phone }
          })
      },
      total() {
        return (this.products && this.products.length > 1) ?
          this.products.reduce((a, b) => (parseFloat(a)  + parseFloat((parseFloat(b.price) * parseInt(b.quantity)))), 0) :
          this.products.length === 1 ? parseInt(this.products[0].quantity) * parseFloat(this.products[0].price) : 0
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
            quantity: parseInt(item.quantity),
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
        'removeAllItem': 'deleteAll'
      }),
      ...mapActions('orders', {
        createOrder: 'create'
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
      openConfirmDialog() {
        this.$refs['form'].validate(valid => {
          if (valid) {
            const all = this.formCart.product && this.formCart.product.filter(item => item.quantity > 0).length
            if (all < 1) {
              this.$message({
                title: 'Thông báo',
                message: 'Vui lòng chọn sản phẩm để tiếp tục đặt hàng!',
                type: 'error'
              })
            } else {
              this.$refs['orderConfirmDialog'].showConfirmDialog()
            }
          }
        })
      },
      onOrderCart() {
        this.formCart.product = this.formCart.product.filter(item => item.quantity > 0)
        this.createOrder({ data: this.formCart }).then(() => {
          this.$notify({
            title: 'Thông báo',
            message: 'Đặt hàng thành công',
            type: 'success'
          })
          this.$refs['orderConfirmDialog'].closeConfirmDialog()
          this.$router.push({'name': 'home_account_order'})
        }).catch(() => {
          this.$notify({
            title: 'Thông báo',
            message: 'Đặt hàng thất bại',
            type: 'danger'
          })
        })
      },
      resetForm (name) {
        this.$refs[name].resetFields();
      },
      remove(id) {
        this.removeItem({id}).then(res => {
          // Do nothing
        }).catch(err => {
          // Do nothing
        })
      },
      formatNumber(num) {
        return formatNumber(num)
      },
      changeQuantity(value) {
        this.isChangingQuantity = true;
        this.updateItem({
          id: value.id,
          data: {
            product_id: value.id,
            quantity: value.quantity,
            customer_id: this.$store.getters.user_info.customer ? this.$store.getters.user_info.customer.id : 0
          }
        }).then(() => {
          this.isChangingQuantity = false;
        }).catch(() => {
          this.isChangingQuantity = false;
        })
      },
      removeAll () {
        this.$confirm('Bạn có chắc chắn muốn xóa tất cả sản phẩm trong giỏ hàng?', 'Xác nhận', {
          confirmButtonText: 'OK',
          cancelButtonText: 'Hủy',
          type: 'warning'
        }).then(() => {
          this.loading()
          this.removeAllItem({ customUrl: 'remove_all' }).then(() => {
            this.loader && this.loader.close();
          }).catch(()=> {
            this.loader && this.loader.close();
          })
        }).catch(() => {
          // Do nothing
        });
      },
      onShopChange (value) {
        this.listShop.map(item => {
          if(item.id == value) {
            this.form.delivery_address = item.zone
          }
        })
      },
      enableCart () {
        const apply = this.$store.getters.settings && this.$store.getters.settings.apply
        if (apply) {
          const now = moment();
          const startTime = moment(apply.start, 'hh:mm');
          const endTime = moment(apply.end, 'hh:mm');

          if (apply.is_end_in_today) return startTime.isBefore(now) && now.isBefore(endTime)
          return !(endTime.isBefore(now) && now.isBefore(startTime))
        }
        return false;
      }
    },
    mounted () {
      if (!this.enableCart()) {
        const apply = this.$store.getters.settings && this.$store.getters.settings.apply
        apply && this.$message({
          type: 'warning',
          title: 'Thông báo',
          message: `Đơn hàng lưu không thành công. Chỉ được đặt hàng từ ${apply.start} - ${apply.end}`
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