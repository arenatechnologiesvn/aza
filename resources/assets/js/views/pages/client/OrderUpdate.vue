<template lang="pug">
  div.container
    bread-crumb
    dialog-products(ref="dialogProduct" @addOrder="onAddProduct" :black="products.map(item => item.product_id)")
    div.cart__contain(style="margin-top: 10px")
      el-row(:gutter="10")
        el-col(:span="24")
          div.grid-content.bg-puple
            el-table(border style="width: 100%" :data="products" size="mini")
              el-table-column(prop="name" label="Sản phẩm" min-width="200")
                template(slot-scope="scope")
                  div.detail
                    div.img
                      img(:src="scope.row.img")
                    h4 {{scope.row.title}}
                    el-button.button(type="danger" size="mini" @click="remove(scope.row)")
                      svg-icon(icon-class="fa-solid trash")
              el-table-column(prop="price" label="GIÁ (VNĐ)")
                template(slot-scope="scope")
                  div {{formatNumber(scope.row.price)}}
                  div / {{`${scope.row.quantitative} ${scope.row.unit}`}}
              el-table-column(prop="quantity" label="SỐ LƯỢNG" width="130")
                template(slot-scope="scope")
                  el-input-number(v-model="scope.row.quantity" :min="1" size="mini" style="width: 110px;" @change="changeQuantity(scope.row)")
              el-table-column(prop="total" label="TỔNG CỘNG (VNĐ)" :formatter="row =>formatNumber(row.price * row.quantity)")
          div
            el-row
              el-col(:span="12" style="text-align: left;")
                el-button(type="primary" size="small" @click="onShowProducts")
                  svg-icon(icon-class="fa-solid plus-square")
                  span(style="margin-left: 10px;") Thêm mới sản phẩm
              el-col.total(:span="12" style="float: right;")
                strong Tạm tính:
                template {{formatNumber(total)}} (VNĐ)
</template>

<script>
  import BreadCrumb from './components/BreadCrumb'
  import {mapGetters, mapActions} from 'vuex'
  import {formatNumber} from '~/utils/util'
  import DialogProducts from './components/products/DialogList'

  export default {
    name: 'CustomerCart',
    components: {
      DialogProducts,
      BreadCrumb
    },
    watch: {
      $router: 'fetchProductInOrder'
    },
    computed: {
      ...mapGetters('products', {
        listProducts: 'list'
      }),
      ...mapGetters('update_orders', {
        listProducts: 'products'
      }),
      products () {
        return this.listProducts()
      },
      total() {
        return (this.products && this.products.length > 1) ?
          this.products.reduce((a, b) => (parseFloat(a)  + parseFloat((parseFloat(b.price) * parseInt(b.quantity)))), 0) :
          this.products.length === 1 ? parseInt(this.products[0].quantity) * parseFloat(this.products[0].price) :
            0
      },
    },
    methods: {
      ...mapActions('products', {
        fetchProduct: 'fetchList'
      }),
      ...mapActions('update_orders', {
        fetchProductByOrderId: 'fetchByOrderId',
        destroyProduct: 'destroy',
        updateQuantity: 'update',
        deleteProduct: 'delete',
        addProduct: 'add'
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
      remove(order) {
        this.canExecute('Bạn Muốn xóa sản phẩm khỏi đơn hàng?')
          .then(res => {
            this.deleteProduct({
              id: order.order_id,
              item: {
                product_id: order.product_id,
                action: 'delete'
              }
            })
          })
          .catch(err => console.log(err))
      },
      formatNumber(num) {
        return formatNumber(num)
      },
      changeQuantity(order) {
        this.updateQuantity({
          id: order.order_id,
          item: {
            product_id: order.product_id,
            quantity: order.quantity,
            order_id: order.order_id,
            action: 'update'
          }
        })
      },
      fetchProductInOrder () {
        const id = this.$route.params.id
        this.fetchProductByOrderId(id)
      },
      onAddProduct (product) {
        this.addProduct({
          item: {
            product_id: product.id,
            tmp_price: product.price,
            real_price: product.price,
            order_id: this.$route.params.id,
            quantity: 1
          }
        })
      }
    },
    mounted () {
      this.fetchProduct()
      this.fetchProductInOrder()
    },
    beforeDestroy () {
      this.destroyProduct()
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