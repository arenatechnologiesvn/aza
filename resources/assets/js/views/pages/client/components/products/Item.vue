<template lang="pug">
  el-card.product-item(class="box-card")
    div.card__contain
      div.product-item__image
        div(v-if="product.added").label ĐÃ THÊM VÀO GIỎ HÀNG
        div(v-if="product.inventory <= 0").label.no HẾT HÀNG
        img(:src="product.img")
      div.product-item__des
        div.product-item__title
          router-link(:to="`/home/products/${product.id}`") {{product.title}}
        div.product-item__description(style="color: black;")
          router-link(to="/home/products" style="font-size: 1.1em;") {{product.category}}
          p.description {{product.description}}
        div.line
        div.product-item__control
          div.product-item__control--left
            span.product-item__price {{formatNumber(product.price) + ' VNĐ'}}
            span.product-item__price--discount {{formatNumber(product.discount) + ' VNĐ'}}
          div.product-item__control--right
            el-tooltip(effect="dark" :content="product.favorite ? 'Xóa khỏi danh sách yêu thích' : 'Thêm vào danh sách yêu thích'" placement="top")
              span.heart(@click="toggleFavorite(product)" :style="{color: product.favorite ? 'red': 'black'}")
                svg-icon( icon-class="fa-solid heart")
            el-tooltip(effect="dark" content="Thêm vào giỏ hàng" placement="top")
              span.shop(@click="addToCart(product)")
                svg-icon(icon-class="fa-solid cart-plus")
            el-tooltip(effect="dark" content="Xóa sản phẩm trong giỏ hàng" placement="top")
              span.shop-remove(@click="removeFromCart(product.id)" v-if="product.added")
                svg-icon(icon-class="fa-solid eraser")
</template>

<script>
  import { mapActions, mapGetters } from 'vuex'
  import { formatNumber } from '~/utils/util'
  import Vue from 'vue';
  import _ from 'lodash'

  export default {
    name: 'ItemProduct',
    props: {
      product: {
        type: Object,
        default: () => {}
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
      removeFromCart (id) {
        this.deletFromCart({id})
          .then(() => this.fetchProduct())
      },
      removeFromFavorite (id) {
        this.deletFavorite({id})
          .then(() =>{
            this.fetchProduct()
            this.fetchFavorite()
          } )
      },
      addToCart (product) {
        if (product.added) {
          const data = {
            product_id: product.id,
            quantity: this.$store.state.cart.entities[product.id].quantity + 1,
            customer_id: this.$store.getters.user_info.customer ? this.$store.getters.user_info.customer.id : 0
          }
          this.updateCart({
            id: product.id,
            data: data
          })
        } else {
          this.add2Cart({
            data: {
              product_id: product.id,
              quantity: 1,
              customer_id: this.$store.getters.user_info.customer ? this.$store.getters.user_info.customer.id : 0
            }
          }).then(res => {
            this.fetchCart()
            this.fetchProduct()
          } )
            .catch(err =>  console.log(err))
        }
      },
      toggleFavorite (product) {
        if (product.favorite) {
          this.removeFromFavorite(product.id)
        } else {
          this.addProductToFavorite(product.id)
        }
      },
      addProductToFavorite (id) {
        if(this.$store.state.favorite.list.length > 4) {
          this.$notify(
            {
              title: 'Cảnh báo',
              message: 'Số sản phẩm yêu thích vượt quá giới hạn',
              type: 'warning'
            })
        } else {
          this.addFavorite({
            data: {
              product_id: id,
              customer_id: this.$store.getters.user_info.customer ? this.$store.getters.user_info.customer.id : 0
            }
          }).then(() =>  {
            this.fetchProduct()
            this.fetchFavorite()
          })
        }
      },
      formatNumber (num) {
        return formatNumber(num)
      }
    }
  }
</script>
<style lang="scss" scoped>
  .product-item {
    position: relative;
  }
  .label {
    position: absolute;
    width: 100%;
    height: 40px;
    line-height: 40px;
    vertical-align: middle;
    font-size: 14px;
    background-color: rgba(255,255,255,0.7);
    box-shadow: 1px 1px 2px rgba(0,0,0,0.3);
    top: 0;
    left: 0;
    color: darkgreen;
    font-weight: bolder;
    text-align: left;
    padding-left: 5px;
    z-index: 999999;
    &.no {
      top: calc(50% - 20px);
      text-align: center;
      color: red;
    }
  }
  .description {
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
    max-width: 100%;
  }
</style>