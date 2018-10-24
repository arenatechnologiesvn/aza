<template lang="pug">
  div.container
    bread-crumb
    dialog-products(ref="dialogProduct" @addOrder="onAddProduct" :addable-products="addableProducts")
    div.cart__contain(style="margin-top: 10px")
      el-row(:gutter="10")
        el-col(:span="24")
          div.grid-content.bg-puple
            div(style="background-color: white; border-bottom: 1px solid #d6d6d;padding: 15px;")
              h4(style="margin: 0;") ĐƠN HÀNG {{order && order.order_code}}
            el-table(border style="width: 100%" :data="orderProducts" size="mini" v-loading="loading")
              el-table-column(prop="name" label="SẢN PHẨM" min-width="200")
                template(slot-scope="scope")
                  div.detail
                    div.img
                      img(:src="scope.row.img")
                    h4 {{ scope.row.product_code }}
                    h4 {{ scope.row.title }}
                    el-button.button(type="danger" size="mini" @click="remove(scope.row.id)")
                      svg-icon(icon-class="fa-solid trash")
              el-table-column(prop="price" label="GIÁ (VNĐ)")
                template(slot-scope="scope")
                  div {{formatNumber(scope.row.price)}}
                  div / {{`${scope.row.quantitative} ${scope.row.unit}`}}
              el-table-column(prop="quantity" label="SỐ LƯỢNG" width="130")
                template(slot-scope="scope")
                  el-input-number(v-model="scope.row.quantity" :min="1" size="mini" style="width: 110px;")
              el-table-column(prop="total" label="TỔNG CỘNG (VNĐ)" :formatter="row =>formatNumber(row.price * row.quantity)")
          div(style="margin-top: 10px")
            el-row
              el-col(:span="12" style="text-align: left;")
                el-button(type="primary" size="small" @click="onShowProducts" style="margin-left: 5px")
                  svg-icon(icon-class="fa-solid plus-circle")
                  span  Thêm mới sản phẩm
                el-button(type="success" size="small" @click="update")
                  svg-icon(icon-class="fa-solid paint-brush")
                  span  Lưu đơn hàng
              el-col.total(:span="12" style="float: right;")
                strong Tạm tính:
                template  {{formatNumber(total)}} (VNĐ)
</template>

<script>
  import BreadCrumb from './components/BreadCrumb'
  import {mapGetters, mapActions} from 'vuex'
  import {formatNumber} from '~/utils/util'
  import DialogProducts from './components/products/DialogList'
  import dummyImage from '~/assets/login_images/dummy-image.jpg'

  export default {
    name: 'OrderUpdate',
    components: {
      DialogProducts,
      BreadCrumb
    },
    watch: {
      $router: 'fetchProductInOrder'
    },
    computed: {
      ...mapGetters('products', {
        products: 'list'
      }),
      ...mapGetters('orders', {
        orderById: 'byId'
      }),
      order () {
        return this.orderById(this.$route.params.id)
      },
      addableProducts () {
        if (!this.products) return [];
        const orderProductIds = this.orderProducts.map(item => item.id);
        return this.products.filter((item) => {
          return !orderProductIds.includes(item.id);
        });
      },
      total() {
        let sum = 0;
        this.orderProducts.forEach((item) => {
          sum = sum + (item.price * item.quantity);
        });

        return sum;
      },
    },
    data() {
      return {
        orderProducts: [],
        loading: false
      }
    },
    methods: {
      ...mapActions('products', {
        fetchProduct: 'fetchList'
      }),
      ...mapActions('orders', {
        fetchOrder: 'fetchSingle',
        updateOrder: 'update'
      }),
      onShowProducts () {
        this.$refs['dialogProduct'].detail()
      },
      canExecute(message) {
        return new Promise(resolve => this.$confirm(message, 'Xác nhận', {
          confirmButtonText: 'Đồng ý',
          cancelButtonText: 'Hủy',
          type: 'success'
        }).then(() => {
          resolve(true);
        }));
      },
      remove(orderId) {
        this.orderProducts = this.orderProducts.filter((item) => {
          return item.id !== orderId;
        });
      },
      formatNumber(num) {
        return formatNumber(num)
      },
      fetchProductInOrder () {
        this.loading = true;
        this.fetchOrder({ id: this.$route.params.id }).then(() => {
          if (this.order && this.order.products && this.order.products.length) {
            this.orderProducts = this.order.products.map((item) => {
              return {
                id: item.id,
                product_code: item.product_code,
                title: item.name,
                price: item.price,
                img: item.featured && item.featured[0] ? item.featured[0].url : dummyImage,
                provider: item.provider && item.provider.name,
                quantity: item.pivot.quantity,
                unit: item.unit,
                order_id: item.pivot.order_id,
                quantitative: item.quantitative,
                real_price: item.price,
                tmp_price: item.price
              }
            });
          }

          this.loading = false;
        }).catch(() => {
          this.loading = false;
        });
      },
      update() {
        this.canExecute('Bạn có muốn cập nhật đơn hàng?').then(res => {
          this.loading = true;
          this.updateOrder({
            id: this.order.id,
            data: {
              product: this.orderProducts.map((item) => {
                return {
                  product_id: item.id,
                  quantity: item.quantity,
                  tmp_price: item.tmp_price,
                  real_price: item.real_price
                }
              })
            }
          }).then(() => {
            this.loading = false;
          }).catch(() => {
            this.loading = false;
          })
        }).catch(err => {
          // Do nothing
        })
      },
      onAddProduct (item) {
        this.orderProducts.push({
          id: item.id,
          product_code: item.product_code,
          title: item.name,
          price: item.price,
          img: item.featured && item.featured[0] ? item.featured[0].url : dummyImage,
          provider: item.provider && item.provider.name,
          quantity: 1,
          unit: item.unit,
          order_id: this.order.id,
          quantitative: item.quantitative,
          real_price: item.price,
          tmp_price: item.price
        })
        this.$notify({
          message: `Đã thêm ${item.name} vào giỏ hàng`,
          type: 'success'
        })
      }
    },
    mounted () {
      this.fetchProduct()
      this.fetchProductInOrder()
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