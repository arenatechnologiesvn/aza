<template lang="pug">
  el-card.product-item(class="box-card")
    div.card__contain
      div.product-item__image
        div(v-if="product.added").label ĐÃ THÊM VÀO GIỎ HÀNG
        div(v-if="product.inventory <= 0").label.no HẾT HÀNG
        img(:src="product.img")
      div.product-item__des
        div.product-item__title
          router-link(:to="`/products/${product.id}`") {{product.title}}
        div.product-item__description(style="color: black;height: 50px;")
          div.product-item__control--left(v-if="product.discount")
            div.product-item__price(style="color: red; font-size: 1.2em;") ₫{{formatNumber(product.discount)}} / {{`${product.quantitative} ${product.unit}`}}
            div(v-if="product.discount").product-item__price--discount
              span(style="text-decoration: line-through; margin-right: 10px;") ₫{{formatNumber(product.price)}}
              span(style="margin-left: 10px;") {{ ((1 - parseFloat((parseFloat(product.discount) / parseFloat(product.price)))) * 100).toFixed(2)}} %
          div(v-else)
            div.product-item__price(style="color: red; font-size: 1.2em;") ₫{{formatNumber(product.price)}} / {{`${product.quantitative} ${product.unit}`}}
          div(style="clear: both")
            router-link(:to="{name: 'home_product', query: {category: product.category}}" style="font-size: 1.1em;color: #999;")
              strong(style="color: #666; margin-right: 10px;") Danh mục:
              template {{product.category}}
        div.line
        div.product-item__control
          div.control--left(style="float: left;")
            span.score(v-for="item in 5" :key="item" :style="{color: item <= 5 ? '#F7CA51' : ''}")
              svg-icon(icon-class="fa-solid star")
          div.product-item__control--right
            el-tooltip(effect="dark" :content="product.favorite ? 'Xóa khỏi danh sách yêu thích' : 'Thêm vào danh sách yêu thích'" placement="top")
              span.heart(@click="toggleFavorite(product)" :style="{color: product.favorite ? 'red': 'black'}")
                svg-icon( icon-class="fa-solid heart")
            el-tooltip(effect="dark" content="Thêm vào giỏ hàng" placement="top")
              span.shop(@click="addToCart(product)" :disabled="!enableCart")
                svg-icon(icon-class="fa-solid cart-plus")
            el-tooltip(effect="dark" content="Xóa sản phẩm trong giỏ hàng" placement="top")
              span.shop-remove(@click="removeFromCart(product.id)" v-if="product.added")
                svg-icon(icon-class="fa-solid eraser")
</template>

<script>
  import {mapActions, mapGetters} from 'vuex'
  import {formatNumber} from '~/utils/util'
  export default {
    name: 'ItemProduct',
    props: {
      product: {
        type: Object,
        default: () => {
        }
      }
    },
    computed: {
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
    methods: {
      ...mapActions('cart', {
        add2Cart: 'create',
        updateCart: 'update',
        deletFromCart: 'destroy',
        fetchCart: 'fetchList'
      }),
      ...mapActions('favorite', {
        addFavorite: 'create',
        deletFavorite: 'destroy',
        fetchFavorite: 'fetchList'
      }),
      ...mapActions('products', {
        fetchProduct: 'fetchList'
      }),
      removeFromCart(id) {
        this.canExecute('Bạn muốn xóa sản phẩm này khỏi giỏ hàng?')
          .then(() => this.deletFromCart({id})
            .then(() => this.fetchProduct()))
          .then(() => this.$notify(
            {
              title: 'Thông báo',
              message: 'Xóa thành công sản phầm khỏi giỏ hàng',
              type: 'success'
            }))
      },
      removeFromFavorite(id) {
        this.canExecuteF('Bạn muốn xóa sản phẩm khỏi danh sách yêu thích?')
          .then(() => this.deletFavorite({id})
            .then(() => {
              this.fetchProduct()
              this.fetchFavorite()
            })).then(() => this.$notify(
          {
            title: 'Thông báo',
            message: 'Xóa thành công sản phầm khỏi danh sách yêu thích',
            type: 'success'
          }))
      },
      enableCartF () {
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
      },
      addToCart(product) {
        if (product.added) {
          this.canExecute('Bạn muốn thêm sản phẩm này vào giỏ hàng?')
            .then(() => {
              const data = {
                product_id: product.id,
                quantity: parseInt(this.$store.state.cart.entities[product.id].quantity) + 1,
                customer_id: this.$store.getters.user_info.customer ? this.$store.getters.user_info.customer.id : 0
              }
              this.updateCart({
                id: product.id,
                data: data
              })
            }).then(() => this.$notify(
            {
              title: 'Thông báo',
              message: 'Đã thêm thành công sản phẩm vào giỏ hàng',
              type: 'success'
            }))
        } else {
          const customer_id = this.$store.getters.user_info.customer ? this.$store.getters.user_info.customer.id : 0
          this.canExecute('Bạn muốn thêm sản phẩm này vào giỏ hàng?')
            .then(() => {
              this.add2Cart({
                data: {
                  product_id: product.id,
                  quantity: 0,
                  customer_id
                }
              }).then(() => {
                this.fetchCart()
                this.fetchProduct()
              }).then(() => this.$notify(
                {
                  title: 'Thông báo',
                  message: 'Đã thêm thành công sản phẩm vào giỏ hàng',
                  type: 'success'
                }))
                .catch(err => console.log(err))
            })
        }
      },
      toggleFavorite(product) {
        if (product.favorite) {
          this.removeFromFavorite(product.id)
        } else {
          this.addProductToFavorite(product.id)
        }
      },
      addProductToFavorite(id) {
        const customer_id = this.$store.getters.user_info.customer ? this.$store.getters.user_info.customer.id : 0
        this.canExecuteF('Bạn muốn thêm vào sản phẩm yêu thích')
          .then(() => this.addFavorite({
            data: {
              product_id: id,
              customer_id
            }
          }).then(() => {
            this.fetchProduct()
            this.fetchFavorite()
          }).then(() => this.$notify(
            {
              title: 'Thông báo',
              message: 'Đã thêm thành công sản phẩm vào danh sách yêu thích',
              type: 'success'
            })))
      },
      formatNumber(num) {
        return formatNumber(num)
      },
      canExecute(message) {
        return new Promise(resolve =>{
          if(this.enableCartF()) {
            this.$confirm(message, 'Xác nhận', {
              confirmButtonText: 'Đồng ý',
              cancelButtonText: 'Hủy',
              type: 'success'
            }).then(() => {
              resolve(true);
            }).catch(err => err)
          } else {
            const apply = this.$store.getters.settings && this.$store.getters.settings.apply
            this.$message({
              type: 'warning',
              title: 'Thông báo',
              message: `Thêm vào giỏ hàng không thành công. Chỉ được đặt hàng từ ${apply.start} - ${apply.end}`
            })
          }
        });
      },
      canExecuteF (message) {
        return new Promise(resolve => this.$confirm(message, 'Xác nhận', {
          confirmButtonText: 'Đồng ý',
          cancelButtonText: 'Hủy',
          type: 'success'
        }).then(() => {
          resolve(true);
        }).catch(err => err))
      }
    }
  }
</script>
<style lang="scss" scoped>
  .product-item {
    position: relative;
  }
  $font-size: 16px;
  $line-height: 1.1;
  $lines-to-show: 2;

  .product-item__title {
    display: block; /* Fallback for non-webkit */
    display: -webkit-box;
    height: $font-size*$line-height*$lines-to-show; /* Fallback for non-webkit */
    margin: 0 auto;
    font-size: $font-size;
    line-height: $line-height;
    -webkit-line-clamp: $lines-to-show;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    text-transform: uppercase;
  }

  .label {
    position: absolute;
    width: 100%;
    height: 40px;
    line-height: 40px;
    vertical-align: middle;
    font-size: 14px;
    background-color: rgba(255, 255, 255, 0.7);
    box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
    top: 0;
    left: 0;
    color: darkgreen;
    font-weight: bolder;
    text-align: left;
    padding-left: 5px;
    z-index: 2;
    &.no {
      top: calc(50% - 20px);
      text-align: center;
      color: red;
    }
  }
  .product-item__image {
    img {
      height: 300px;
      width: 100%;
    }
  }
  .description {
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
    max-width: 100%;
  }
  .product-item__control--right {
    float: right;
    span {
      cursor: pointer;
      display: inline-block;
      padding: 5px;
    }
  }
  .product-item__control {
    padding: 5px !important;
  }
  .product-item__des {
    padding: 5px !important;
  }
</style>